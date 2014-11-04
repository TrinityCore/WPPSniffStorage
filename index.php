<?php
$buildVersions = array(0 => "All Builds",
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
                       15005 => "4.3.0 15005",15050 => "4.3.0 15050", 15211 => "4.3.2 15211", 15354 => "4.3.3 15354", 15595 => "4.3.4 15595",
                       19034 => "6.0.2.19034", 19103 => "6.0.3.19103", 19116 => "6.0.3.19116");

require_once('./includes/header.php');
require_once('./includes/SniffQuery.php');

$builds = '<li><input type="checkbox" name="builds[]" value="0"> &nbsp; All Builds</li>';
if ($result = $mysqlCon->query("SELECT DISTINCT(Build) AS b FROM SniffData WHERE Build <> 0 ORDER BY Build DESC")) {
    while ($row = $result->fetch_object()) {
        $builds .= '<li><input type="checkbox" name="builds[]" value="' . $row->b . '"';
        if (isset($_POST['builds']) && in_array($row->b, $_POST["builds"]))
            $builds .= ' checked';
        $builds .= '> &nbsp; ' . $buildVersions[$row->b] . '</li>';
    }
}

$searchQuantity = isset($_GET['entryType']) ? count($_GET['entryType']) : 1;
$startOffset    = isset($_GET['startOffset']) ? intval($_GET['startOffset']) : 0;
?>
<form action="?startOffset=<?php echo $startOffset; ?>" name="search" method="get">
  <table><tr><td>
    <fieldset>
        <legend>Sniff Search</legend>
        <div id="entryContainer">
            <p style="float:right; margin-top: -10px;">
                <a href="#" id="addSearch">Add New Search</a> | <a id="removeSearch">Remove Last Search</a>
            </p>
            <?php
            for ($i = 0; $i < $searchQuantity; ++$i) {
            ?>
            <div class="entry" style="clear: left;" class="searchFilter">
                <label>Entry Type: </label>
                <select name="entryType[]" onchange="filterSelect(this)">
                <?php
                    for ($j = 0, $m = count($types); $j < $m; ++$j) {
                        echo '<option value="' . $types[$j] . '"';
                        if (isset($_GET['entryType'][$i]) && $_GET['entryType'][$i] == $types[$j])
                            echo ' selected';
                        echo ">" . $types[$j] . "</option>";
                    }
                ?>
                </select>
                <label>Entry: </label>
                <input type="text" name="entry[]" class="searchInput" value="<?php echo isset($_POST['entry'][$i]) ? $_POST['entry'][$i] : ""; ?>" />
                <p style="display:none;clear:both;" id="likesentries[]">
                    <input type="checkbox" name="likeBehavior[]" value="1" <?php if (isset($_POST['likeBehavior'][$i])) echo 'checked '; ?>/>
                    Use like instead of equals for opcode name.
                </p>
                <?php if ($searchQuantity != 1 && $i+1 != $searchQuantity) { ?>
                <hr />
                <p style="clear: both">
                    <input type="checkbox" name="isAndGroup[]" <?php
                        if (isset($_GET['isAndGroup'][$i]) && $_GET['isAndGroup'][$i] == true)
                            echo "checked ";
                    ?>/> Previous search OR new search (Defaults to AND).
                </p>
                <?php } ?>
            </div>
            <?php
            }
            ?>
        </div>
        <input type="submit" name="exec" class="submit" value="Submit" />
    </fieldset>
  </td><td>
    <fieldset class="clientBuildSelector">
        <legend>Client Version</legend>
        <ul class="buildList" name="buildList"><?php echo $builds; ?></ul>
    </fieldset>
  </td></tr></table>
</form>

<?php
if (isset($_GET['exec'])) {
    $sqlQuery = new SniffQuery(isset($_GET['builds']) ? $_GET['builds'] : array(), $startOffset);

    $likes        = isset($_GET['likes']) ? $_GET['likes'] : array();
    $patternCount = count($_GET['entryType']);
    for ($i = 0; $i < $patternCount; ++$i) {
        $type  = $_GET['entryType'][$i];
        $value = $_GET['entry'][$i];

        if ($type == "None")
            continue;

        if ($type == "Opcode Number") {
            $sqlQuery->AddCondition(SniffQuery::DATABASE_SNIFFDATA."ObjectType", "Opcode", SniffQuery::CONDITION_EQUAL);
            $sqlQuery->AddCondition(SniffQuery::DATABASE_SNIFFDATA."Id", $value, SniffQuery::CONDITION_EQUAL);
        } else if ($type == "Opcode Name") {
            $sqlQuery->AddCondition(SniffQuery::DATABASE_SNIFFDATA."ObjectType", "Opcode", SniffQuery::CONDITION_EQUAL);
            if (@isset($_GET['likeBehavior'][$i]) && $_GET['likeBehavior'][$i] == 1)
                $sqlQuery->AddCondition(SniffQuery::DATABASE_SNIFFDATA."Data", $value, SniffQuery::CONDITION_LIKE);
            else
                $sqlQuery->AddCondition(SniffQuery::DATABASE_SNIFFDATA."Data", $value, SniffQuery::CONDITION_EQUAL);
        } else {
            $sqlQuery->AddCondition(SniffQuery::DATABASE_SNIFFDATA."ObjectType", $type, SniffQuery::CONDITION_EQUAL);
            if (!empty($value))
                $sqlQuery->AddCondition(ctype_digit($value) ? SniffQuery::DATABASE_SNIFFDATA."Id" : SniffQuery::DATABASE_OBJECTNAMES."name", $value);
        }

        /// NOT a typo: just me not thinking straight when coding.
        $sqlQuery->SetAndGroup(isset($_GET['isAndGroup'][$i]) ? !$_GET['isAndGroup'][$i] : true);

        $sqlQuery->CreateNewConditionGroup();
    }

    $resultSet = $sqlQuery->Generate();

    if ($resultSet === false)
        echo "Nothing to look for, sorreh.";
    else {
        echo "<p>Query executed: {$resultSet[1]}</p>";
        $resultSet = $resultSet[0];
        if (count($resultSet) == 0) {
            echo "No result.";
            return;
        }

        echo '<table id="resultSet"><tr><th style="width:90px">Build</th><th style="width:183px">Sniff Name</th><th>Data Name</th><th style="width:70px">Value</th><th>Name</th></tr>';
        foreach ($resultSet as $i => &$row) {
            echo '<tr' . ($i % 2 == 0 ? " class='odd'" : '') . '><td>' . $row[0] . '</td>';
            echo '<td><a title="' . $row[1] . '">' . substr($row[1], 0, 28) . '</a></td>';
            echo '<td>' . $row[2] . '</td>';
            echo '<td>' . $row[3] . '</td>';
            echo '<td>' . $row[4] . '</td></tr>';
        }
        echo "</table>";
        $pageArgs = http_build_query($_GET, "&amp;");
        if ($startOffset != 0)
            echo '<a class="paging" href="?'.$pageArgs.'&amp;startOffset='.($startOffset - 50).'">Previous Page</a>';
        if (count($resultSet) == 50)
            echo '<a class="paging" href="?'.$pageArgs.'&amp;startOffset='.($startOffset + 50).'">Next Page</a>';
    }
}
?>
<script src="./includes/jquery.js"></script>
<script>
$(function() {
    var types = <?php echo json_encode($types); ?>;

    function filterSelect(select) {
        alert("Yeah, i'm broken too.");
    }

    $("#removeSearch").click(function() {
        if ($(".searchFilter").length > 1)
            $(".searchFilter").last().remove();
    });

    $("#addSearch").click(function() {
        // var filtersCount = $("div.searchFilter").length;
        var entriesDiv = $(document.createElement('div')).attr('class', 'searchFilter');
        $(entriesDiv).append($(document.createElement('hr'))).css({
            'clear': 'both',
            'margin-bottom': '4px'
        });
        $(entriesDiv).append($(document.createElement('p')).css('clear','both').append($(document.createElement('input')).attr({
            'type': 'checkbox',
            'name': 'isAndGroup[]'}
        )).append(' Previous search OR new search (Defaults to AND).'));
        $(entriesDiv).append($(document.createElement('label')).text('Entry Type: '));
        var entriesSel = $(document.createElement('select')).attr('name','entryType[]');

        for (type in types)
            $(entriesSel).append($(document.createElement('option')).val(types[type]).text(types[type]));

        $(entriesDiv).append($(entriesSel));
        $(entriesDiv).append($(document.createElement('label')).text('Entry: '));
        $(entriesDiv).append($(document.createElement('input')).attr({
            'type': 'text',
            'name': 'entry[]'
        }).addClass('searchInput'));

        /* $(entriesDiv).append($(document.createElement('p')).css({
            'display': 'none',
            'clear': 'both'
        }).attr('id','likesentries' + entriesCount).append($(document.createElement('input')).attr({
            'type': 'checkbox',
            'name': 'likes' + entriesCount
        }).val(1)).append(' Use like instead of equals for opcode name.')); */

        $('#entryContainer').append(entriesDiv);
        // $('#entries[] select').change(function(i) { filterSelect(this); });
    });
});
</script>
<?php
include('includes/footer.php');
?>
