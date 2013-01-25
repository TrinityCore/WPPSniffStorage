<?php
$buildVersions = array(0 => "Zero",
                       5875 => "1.12.1 5875",
                       6180 => "2.0.1 6180", 6299 => "2.0.3 6299", 6337 => "2.0.6 6337",
                       6692 => "2.1.0 6692", 6739 => "2.1.1 6739", 6803 => "2.1.2 6803", 6898 => "2.1.3 6898",
                       7272 => "2.2.0 7272", 7318 => "2.2.2 7318", 7359 => "2.2.3 7359",
                       7561 => "2.3.0 7561", 7741 => "2.3.2 7741", 7799 => "2.3.3 7799",
                       8089 => "2.4.0 8089", 8125 => "2.4.1 8125", 8209 => "2.4.2 8209", 8606 => "2.4.3 8606",
                       9056 => "3.0.2 9056", 9183 => "3.0.3 9183", 9464 => "3.0.8 9464", 9506 => "3.0.8a 9506", 9551 => "3.0.9 9551",
                       9767 => "3.1.0 9767", 9806 => "3.1.1 9806", 9835 => "3.1.1a 9835", 9901 => "3.1.2 9901", 9947 => "3.1.3 9947",
                       10192 => "3.2.0 10192", 10314 => "3.2.0a 10314", 10482 => "3.2.2 10482", 10505 => "3.2.2a 10505",
                       10958 => "3.3.0 10958", 11159 => "3.3.0a 11159", 11685 => "3.3.3 11685", 11723 => "3.3.3a 11723", 12213 => "3.3.5 12213", 12340 => "3.3.5a 12340",
                       13164 => "4.0.1 13164",13205 => "4.0.1a 13205", 13329 => "4.0.3 13329", 13596 => "4.0.6 13596", 13623 => "4.0.6a 13623",
                       13914 => "4.1.0 13914",14007 => "4.1.0a 14007",
                       14333 => "4.2.0 14333",14480 => "4.2.0a 14480", 14545 => "4.2.2 14545",
                       15005 => "4.3.0 15005",15050 => "4.3.0 15050", 15211 => "4.3.2 15211", 15354 => "4.3.3 15354", 15595 => "4.3.4 15595");

require_once('includes/header.php');

if (!isset($pagenum))
    $pagenum = 1;

$builds = "";
if ($result = $mysqlCon->query("SELECT DISTINCT(Build) as b FROM SniffData")) {
    while ($row = $result->fetch_object()) {
        $builds .= '<li><input type="checkbox" name="builds" value="' . $row->b . '"';
        if (isset($_POST['builds']) && in_array($row->b, explode(",", $_POST["builds"])))
            $builds .= ' checked';
        $builds .= '> &nbsp; ' . $buildVersions[$row->b] . '</li>';
    }
}

$searchQuantity = isset($_POST['searches']) ? $_POST['searches'] : 1;
?>
<form name="search" method="post">
    <fieldset>
        <legend>Sniff Search</legend>
        <input type="hidden" name="searches" value="<?php echo $searchQuantity; ?>" id="searches" />
        <div id="entryContainer">
            <p style="float:right; margin-top: -10px;">
                <a id="addSearch">Add New Search</a> | <a id="removeSearch">Remove Last Search</a>
            </p>
            <?php
            for ($l = 0; $l < $searchQuantity; $l++)
            {
            ?>
            <div id="entries<?php echo $l; ?>" style="clear:left;">
                <label for="entryType<?php echo $l; ?>">Entry Type: </label>
                <select name="entryType<?php echo $l; ?>" onchange="filterSelect(this)">
                <?php
                    for ($i = 0, $m = count($types); $i < $m; ++$i)
                    {
                        echo "<option value=\"" . $types[$i] . "\"";
                        if (isset($_POST['entryType'.$l]) && $_POST['entryType' . $l] == $types[$i])
                            echo ' selected';
                        echo ">" . $types[$i] . "</option>";
                    }
                ?>
                </select>
                <label for="entry<?php echo $l; ?>">Entry: </label>
                <input type="text" name="entry<?php echo $l; ?>" class="searchInput" value="<?php echo isset($_POST['entry' . $l]) ? $_POST['entry' . $l] : ""; ?>" />
                <p style="display:none;clear:both;" id="likesentries<?php echo $l; ?>">
                    <input type="checkbox" name="likes<?php echo $l; ?>" value="1" <?php if (isset($_POST['likes' . $l])) echo 'checked '; ?>/>
                    Use like instead of equals for opcode name.
                </p>
            </div>
            <?php
            }
            ?>
        </div>
        <fieldset class="innerfieldset">
            <legend>Client Version</legend>
            <ul class="buildList" name="buildList"><?php echo $builds; ?></ul>
        </fieldset>
        <input type="submit" name="submit" class="submit" value="Submit" />
    </fieldset>
</form>

<?php
if (isset($_POST['submit'])) {
    $sql = "SELECT Build, SniffName, ObjectType, Id, Data, name from (";
    $tmpsql = "SELECT a.Build,a.SniffName,a.ObjectType,a.Id,a.Data,b.name as name FROM SniffData as a LEFT OUTER JOIN objectnames as b on a.id = b.id and a.objecttype = b.objecttype";
    $wherearr = array();
    $likes = isset($_POST['likes']) ? $_POST['likes'] : array();
    $wheres = array();
    for ($i = 0; $i < $_POST['searches'];$i++) {
        $type = $_POST['entryType'.$i];
        $value = $_POST['entry'.$i];
        if (empty($value) || $type == 'None')
            continue;
        if ($type == 'Opcode Number')
            $type = 'Opcode';
        if (!isset($wheres[$type]))
            $wheres[$type] = array();
        if ($type == 'Opcode Name') {
            if (!empty($_POST['likes'.$i])) {
                if (!in_array(array( 'Like' => true, 'opcode' => '%'.$value.'%'),$wheres[$type]))
                    array_push($wheres[$type], array('opcode' => '%'.$value.'%',  'Like' => true));
            } else {
                if (!in_array(array( 'Like' => false, 'opcode' => $value),$wheres[$type]))
                    array_push($wheres[$type], array('opcode' => $value,  'Like' => false));
            }
        } else {
            if (in_array($value, $wheres[$type]))
                continue;
            array_push($wheres[$type],$value);
        }
    }
    // Build all the WHERE conditions
    foreach ($wheres as $key => $value) {
        $where = '';
        $type = $key;
        if ($type == 'Opcode Name' || $type == 'Opcode Number') $type = 'Opcode';
        for ($i = 0; $i < count($value);$i++)
        {
            $valValue = $value[$i];
            if ($key == 'Opcode Name') {
                if ($where) $where .= ' OR ';
                if ($valValue['Like']) $where .= "data LIKE '".$mysqlCon->escape_string($valValue['opcode'])."'";
                else $where .= "data = '".$valValue['opcode']."'";
            } else {
                if ($where)
                    $where .= ' OR ';
                if (is_numeric($valValue))
                    $where .= ' a.Id = '.$valValue;
                else
                    $where .= " b.name LIKE '%".$mysqlCon->escape_string($valValue)."%'";
            }
        }
        $where = "a.ObjectType = '".$type."' AND (".$where.")";
        array_push($wherearr, $where);
    }

    if (!empty($wherearr)) {
        // Build the SQL query
        for ($i = 0; $i < count($wherearr); ++$i) {
            if ($i)
                $sql.=' UNION ALL ';
            $sql .= $tmpsql." WHERE ".$wherearr[$i];
            if (isset($_POST['builds']))
                $where .= ' AND build in ('.$_POST['builds'].')';
        }
        $sql .= ') as SniffsData GROUP BY SniffName, Id, Data, ObjectType ORDER BY SniffName, ObjectType ASC';

        if ($result = $mysqlCon->query($sql)) {
            if ($result->num_rows) {
                echo '<table id="resultSet"><tr><th style="width:90px">Build</th><th style="width:183px">Sniff Name</th><th>Opcode Name</th><th style="width:70px">Opcode ID</th><th>Name</th></tr>';
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo '<tr><td>' . $buildVersions[$row["Build"]] . '</td>';
                    echo '<td>' . (strlen($row["SniffName"]) > 25 ? substr($row["SniffName"], 0, 20) . "..." : $row["SniffName"]) . '</td>';
                    echo '<td>' . $row["Data"] . '</td>';
                    echo '<td>' . $row["Id"] . '</td>';
                    echo '<td>' . $row["name"] . '</td></tr>';
                }
                echo '</table>';
            } else
                echo 'No Results Found';
        } else
            echo 'No Results Found';
        echo '<div id="sqlQueryContainer"><u>SQL Request:</u><br/>' .$sql . '</div>';
    } else
        echo "Nothing to Search For";
}
?>
<script src="./includes/jquery.js"></script>
<script>
$(function() {
    function filterSelect(select) {
        var searchIndex = $(select).attr('name');
        searchIndex = searchIndex.replace('entryType','');
        if ($(select).children('option:selected').val() == 'Opcode Name')
            $('#likesentries'+searchIndex).show();
        else
            $('#likesentries'+searchIndex).hide();
    }


    $("#removeSearch").click(function() {
        var entriesCount = parseInt($('#searches').val());
        if (entriesCount > 1)
        {
            $('#entries'+(entriesCount-1)).remove();
            $('#searches').val(entriesCount-1);
        }
    });

    $("#addSearch").click(function() {
        var types = <?php echo json_encode($types); ?>,
            entriesCount = parseInt($('#searches').val()),
            entriesDiv = $(document.createElement('div')).attr('id','entries' + entriesCount);
        $(entriesDiv).append($(document.createElement('hr'))).css({
            'clear': 'both',
            'margin-bottom': '4px'
        });
        $(entriesDiv).append($(document.createElement('p')).css('clear','both').append($(document.createElement('input')).attr('type','checkbox').attr('name','andor'+entriesCount)).append(' Previous search OR new search (Defaults as AND)'));
        $(entriesDiv).append($(document.createElement('label')).attr('for','entryType'+entriesCount).text('Entry Type: '));
        var entriesSel = $(document.createElement('select')).attr('name','entryType'+entriesCount);
        for (type in types)
            $(entriesSel).append($(document.createElement('option')).val(types[type]).text(types[type]));
        $(entriesDiv).append($(entriesSel));
        $(entriesDiv).append($(document.createElement('label')).attr('for','entry'+entriesCount).text('Entry: '));
        $(entriesDiv).append($(document.createElement('input')).attr('type','text').attr('name','entry'+entriesCount).addClass('searchInput'));
        $(entriesDiv).append($(document.createElement('p')).css('display','none').css('clear','both').attr('id','likesentries'+entriesCount).append($(document.createElement('input')).attr('type','checkbox').attr('name','likes'+entriesCount).val(1)).append(' Use like instead of equals for opcode name.'));
        $(entriesDiv).append($(document.createElement('input')).attr('type','hidden').attr('name','existingEntries').val(entriesCount));
        $('#searches').val(entriesCount + 1);
        $('#entryContainer').append(entriesDiv);
        $('#entries'+entriesCount+' select').change(function(i) { filterSelect(this); });
    });
});
</script>
<?php
include('includes/footer.php');
?>
