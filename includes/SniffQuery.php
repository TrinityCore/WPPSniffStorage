<?php

class SniffQuery {
    private $conditionStore = array();

    const CONDITION_NONE  = -1;
    const CONDITION_LIKE  = 0;
    const CONDITION_EQUAL = 1;
    const CONDITION_IN    = 2;

    const ERROR_SILENT = 0;
    const ERROR_FATAL  = 1;

    const DATABASE_SNIFFDATA = "sd`.`";
    const DATABASE_OBJECTNAMES = "obn`.`";

    private $errorsLog = array();
    private $andGroups = array();
    private $conditionGroupIdx = 0;
    private $offset    = 0;

    public function __construct($builds, $off) { $this->buildList = $builds; $this->offset = intval($off); }
    // public function __destruct() { }

    public function SetAndGroup($toggle) { if ($toggle) $this->andGroups[] = $this->conditionGroupIdx; }

    public function AddCondition($field, $value, $conditionType = self::CONDITION_NONE) {
        if ($conditionType == self::CONDITION_NONE) {
            // Try to guess based on type
            $conditionType = self::CONDITION_LIKE;
            if (ctype_digit($value))
                $conditionType = self::CONDITION_EQUAL;
        }

        if ($conditionType == self::CONDITION_LIKE) {
            $this->conditionStore[$this->conditionGroupIdx][] = array("fieldName" => $field, "fieldValue" => "%" . $value . "%", "type" => $conditionType);
            // $this->DeleteCondition($field, self::CONDITION_EQUAL);
        } else if ($conditionType == self::CONDITION_EQUAL) {
            $this->conditionStore[$this->conditionGroupIdx][] = array("fieldName" => $field, "fieldValue" => ((string)(float)($value) === (string)$value) ? intval($value) : $value, "type" => $conditionType);
        } else if ($conditionType == self::CONDITION_IN) {
            $this->conditionStore[$this->conditionGroupIdx][] = array("fieldName" => $field, "fieldValue" => implode(",", $value), "type" => $conditionType);
        } else // Can never happen
            return SetLastError("Condition for field `{$field}` is not of a valid type!", self::ERROR_FATAL);

        return $this;
    }

    public function CreateNewConditionGroup() { ++$this->conditionGroupIdx; }

    public function GetConditionCountInGroup($groupId) {
        if ($this->conditionGroupIdx > $groupId)
            return 0;
        return count($this->conditionStore[$groupId]);
    }

    public function Generate($offset = 0) {
        global $mysqlCon;
        global $buildVersions;

        if (empty($this->conditionStore))
            return false;

        $query = "SELECT sd.Build, sd.SniffName, sd.ObjectType, sd.Id, sd.Data, obn.name FROM SniffData sd LEFT JOIN ObjectNames obn ON obn.Id=sd.Id AND obn.ObjectType=sd.ObjectType WHERE (";

        $paramsArray = array("");

        foreach ($this->conditionStore as $groupId => &$groupConditionStore) {
            $queryString = array(); // Group query string
            foreach ($groupConditionStore as &$conditionData) {
                $paramsArray[0] .= (is_numeric($conditionData['fieldValue']) ? "i" : "s");
                $paramsArray[]   = &$conditionData['fieldValue'];

                switch ($conditionData['type'])
                {
                    case self::CONDITION_EQUAL:
                        $queryString[] = "`" . $conditionData['fieldName'] . "` = ?";
                        break;
                    case self::CONDITION_LIKE:
                        $queryString[] = "`" . $conditionData['fieldName'] . "` LIKE ?";
                        break;
                    case self::CONDITION_IN: // NYI
                        break;
                }
            }
            $query .= "(" . implode(" AND ", $queryString) . ")";
            if ($groupId + 1 != $this->conditionGroupIdx)
                $query .= in_array($groupId, $this->andGroups) ? " AND " : " OR ";
        }

        // Add $this->buildList if any - Kinda hacky, but does the job
        if (!empty($this->buildList) && !in_array(0, $this->buildList)) {
            $query .= ") AND `" . self::DATABASE_SNIFFDATA . "Build` IN (";
            $l = count($this->buildList);
            $paramsArray[0] .= str_repeat("i", $l);
            foreach ($this->buildList as $i => &$build) {
                $query .= "?";
                if ($i + 1 != $l)
                    $query .= ",";
                $paramsArray[] = &$build;
            }
            $query .= ")";
        }
        else $query .= ")";

        $query .= " LIMIT ?, 50;"; // Prepares paginating

        $paramsArray[0] .= "i";
        $paramsArray[]  = &$this->offset;

        $retString = $this->DebugQuery($query, $paramsArray);//var_dump($retString);

        $stmt = $mysqlCon->prepare($query);
        if (!$stmt)
            echo $mysqlCon->error;
        else {
            call_user_func_array(array($stmt, 'bind_param'), $paramsArray);
            $stmt->execute();
            $stmt->bind_result($buildId, $sniffName, $objectType, $id, $data, $name);

            $resultSet = array();
            while ($stmt->fetch())
                $resultSet[] = array($buildVersions[$buildId], $sniffName, $data, $id, $name);
            $stmt->close();
            return array($resultSet, $retString);
        }
    }

    private function SetLastError($errorString, $errorLevel = self::ERROR_SILENT) {
        $this->errorsLog[] = $errorString;
        if ($errorLevel == self::ERROR_FATAL)
            die("Fatal error in `SniffQuery`, aborting script.");
        return false;
    }

    public function GetLastError() { return end($this->errorsLog); }

    public function DebugQuery($stmt, $paramsArray) {
        for ($i = 1, $l = count($paramsArray); $i < $l; ++$i)
        {
            $position = strpos($stmt, "?");
            if ($position!== false)
                $stmt = substr_replace($stmt, '"'.$paramsArray[$i].'"', $position, strlen("?"));
        }
        return $stmt;
    }
}
