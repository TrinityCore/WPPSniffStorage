<?php

function getExpansion($build)
{
	if ($build <= 5875)
		return Expansions::Classic;
	else if ($build > 5875 && $build <= 8606)
		return Expansions::Tbc;
	else if ($build > 8606 && $build <= 12340)
		return Expansions::Wotlk;
	else if ($build > 12340 && $build <= 15595)
		return Expansions::Cataclysm;
	else if ($build > 15595 && $build <= 18414)
		return Expansions::Mop;
	else if ($build > 18414 && $build <= 21742)
		return Expansions::Wod;
	else if ($build > 21742 && $build <= 24742)
		return Expansions::Legion;
	return Expansions::Unknown;
}

abstract class Expansions
{
	const Unknown     = -1;
	const Classic     = 0;
	const Tbc         = 1;
	const Wotlk       = 2;
	const Cataclysm   = 3;
	const Mop         = 4;
	const Wod         = 5;
	const Legion      = 6;
};

$buildVersions = array(0 => "All Builds",
                       // Classic
                       5875 => "1.12.1 5875",
                       // The Burning Crusade
                       6180 => "2.0.1 6180", 6299 => "2.0.3 6299", 6337 => "2.0.6 6337",
                       6692 => "2.1.0 6692", 6739 => "2.1.1 6739", 6803 => "2.1.2 6803", 6898 => "2.1.3 6898",
                       7272 => "2.2.0 7272", 7318 => "2.2.2 7318", 7359 => "2.2.3 7359",
                       7561 => "2.3.0 7561", 7741 => "2.3.2 7741", 7799 => "2.3.3 7799",
                       8089 => "2.4.0 8089", 8125 => "2.4.1 8125", 8209 => "2.4.2 8209", 8606 => "2.4.3 8606",
                       // Wrath of the Lich King
                       9056 => "3.0.2 9056", 9183 => "3.0.3 9183", 9464 => "3.0.8 9464", 9506 => "3.0.8a 9506", 9551 => "3.0.9 9551",
                       9767 => "3.1.0 9767", 9806 => "3.1.1 9806", 9835 => "3.1.1a 9835", 9901 => "3.1.2 9901", 9947 => "3.1.3 9947",
                       10192 => "3.2.0 10192", 10314 => "3.2.0a 10314", 10482 => "3.2.2 10482", 10505 => "3.2.2a 10505",
                       10958 => "3.3.0 10958", 11159 => "3.3.0a 11159", 11685 => "3.3.3 11685", 11723 => "3.3.3a 11723", 12213 => "3.3.5 12213", 12340 => "3.3.5a 12340",
                       // Cataclysm
                       13164 => "4.0.1 13164", 13205 => "4.0.1a 13205", 13329 => "4.0.3 13329", 13596 => "4.0.6 13596", 13623 => "4.0.6a 13623",
                       13914 => "4.1.0 13914", 14007 => "4.1.0a 14007",
                       14333 => "4.2.0 14333", 14480 => "4.2.0a 14480", 14545 => "4.2.2 14545",
                       15005 => "4.3.0 15005", 15050 => "4.3.0 15050", 15211 => "4.3.2 15211", 15354 => "4.3.3 15354", 15595 => "4.3.4 15595",
                       // Mists of Pandaria
                       16016 => "5.0.4 16016", 16048 => "5.0.5 16048", 16057 => "5.0.5 16057", 16135 => "5.0.5b 16135",
                       16309 => "5.1.0 16309", 16357 => "5.1.0a 16357",
                       16650 => "5.2.0 16650", 16669 => "5.2.0a 16669", 16683 => "5.2.0b 16683", 16685 => "5.2.0c 16685", 16701 => "5.2.0d 16701", 16709 => "5.2.0e 16709", 16716 => "5.2.0f 16716", 16733 => "5.2.0g 16733", 16760 => "5.2.0h 16760", 16769 => "5.2.0i 16769", 16826 => "5.2.0j 16826",
                       16977 => "5.3.0 16977", 16981 => "5.3.0 16981", 16983 => "5.3.0hotfix1 16983", 16992 => "5.3.0hotfix2 16992", 17055 => "5.3.0hotfix3 17055", 17116 => "5.3.0hotfix4 17116", 17128 => "5.3.0a 17128",
                       17359 => "5.4.0 17359", 17371 => "5.4.0hotfix1 17371", 17399 => "5.4.0hotfix2 17399", 17538 => "5.4.1 17538", 17658 => "5.4.2 17658", 17688 => "5.4.2 17688", 17898 => "5.4.7 17898", 17930 => "5.4.7 17930", 17956 => "5.4.7 17956", 18019 => "5.4.7 18019", 18291 => "5.4.8 18291", 18414 => "5.4.8 18414",
                       // Warlords of Draenor
                       19034 => "6.0.2 19034", 19103 => "6.0.3 19103", 19116 => "6.0.3 19116", 19342 => "6.0.1 19342",
                       19678 => "6.1.0 19678", 19702 => "6.1.0 19702", 19802 => "6.1.2 19802", 19831 => "6.1.2 19831", 19865 => "6.1.2 19865",
                       20173 => "6.2.0 20173", 20182 => "6.2.0 20182", 20201 => "6.2.0 20201", 20216 => "6.2.0 20216", 20253 => "6.2.0 20253", 20338 => "6.2.0 20338", 20444 => "6.2.2 20444", 20490 => "6.2.2a 20490", 20574 => "6.2.2a 20574", 20726 => "6.2.3 20726", 20779 => "6.2.3 20779", 20886 => "6.2.3 20886", 21315 => "6.2.4 21315", 21336 => "6.2.4 21336", 21348 => "6.2.4 21348", 21355 => "6.2.4 21355", 21463 => "6.2.4 21463", 21676 => "6.2.4 21676", 21742 => "6.2.4 21742",
                       // Legion
                       22248 => "7.0.3 22248", 22267 => "7.0.3 22267", 22280 => "7.0.3 22280", 22289 => "7.0.3 22289", 22293 => "7.0.3 22293", 22345 => "7.0.3 22345", 22396 => "7.0.3 22396", 22410 => "7.0.3 22410", 22423 => "7.0.3 22423", 22498 => "7.0.3 22498", 22522 => "7.0.3 22522", 22566 => "7.0.3 22566", 22594 => "7.0.3 22594", 22624 => "7.0.3 22624", 22747 => "7.0.3 22747", 22810 => "7.0.3 22810",
                       22900 => "7.1.0 22900", 22908 => "7.1.0 22908", 22950 => "7.1.0 22950", 22989 => "7.1.0 22989", 22995 => "7.1.0 22995", 22996 => "7.1.0 22996", 23171 => "7.1.0 23171", 23222 => "7.1.0 23222",
                       23360 => "7.1.5 23360", 23420 => "7.1.5 23420",
                       23826 => "7.2.0 23826", 23835 => "7.2.0 23835", 23836 => "7.2.0 23836", 23846 => "7.2.0 23846", 23852 => "7.2.0 23852", 23857 => "7.2.0 23857", 23877 => "7.2.0 23877", 23911 => "7.2.0 23911", 23937 => "7.2.0 23937", 24015 => "7.2.0 24015"
                       );

require_once('./includes/header.php');
require_once('./includes/SniffQuery.php');

$takenBuilds = array();
$builds = '<input type="checkbox" name="builds[]" value="0"> All Builds';
if ($result = $mysqlCon->query("SELECT DISTINCT(Build) AS b FROM sniff_data WHERE Build <> 0 ORDER BY Build DESC")) {
    while ($row = $result->fetch_object()) {
        $exp = getExpansion($row->b);
        $takenBuilds[$exp] .= '<input type="checkbox" name="builds[]" value="' . $row->b . '"';
        if (isset($_GET['builds']) && in_array($row->b, $_GET["builds"]))
            $takenBuilds[$exp] .= ' checked';
        $takenBuilds[$exp] .= '> ' . $buildVersions[$row->b] . '</br>';
    }
}

$builds .= '<table><tr>';
if (!empty($takenBuilds[Expansions::Classic]))
	$builds .= '<td><input type="checkbox" name="builds[]" value="classic"> Classic<br>' . $takenBuilds[Expansions::Classic] . '</td>';
if (!empty($takenBuilds[Expansions::Tbc]))
	$builds .= '<td><input type="checkbox" name="builds[]" value="tbc"> TBC<br>' . $takenBuilds[Expansions::Tbc] . '</td>';
if (!empty($takenBuilds[Expansions::Wotlk]))
	$builds .= '<td><input type="checkbox" name="builds[]" value="wotlk"> Wotlk<br>' . $takenBuilds[Expansions::Wotlk] . '</td>';
if (!empty($takenBuilds[Expansions::Cataclysm]))
	$builds .= '<td><input type="checkbox" name="builds[]" value="cata"> Cataclysm<br>' . $takenBuilds[Expansions::Cataclysm] . '</td>';
if (!empty($takenBuilds[Expansions::Mop]))
	$builds .= '<td><input type="checkbox" name="builds[]" value="mop"> Mop<br>' . $takenBuilds[Expansions::Mop] . '</td>';
if (!empty($takenBuilds[Expansions::Wod]))
	$builds .= '<td><input type="checkbox" name="builds[]" value="wod"> Wod<br>' . $takenBuilds[Expansions::Wod] . '</td>';
if (!empty($takenBuilds[Expansions::Legion]))
	$builds .= '<td><input type="checkbox" name="builds[]" value="legion"> Legion<br>' . $takenBuilds[Expansions::Legion] . '</td>';

$builds .= '</tr></table>';

$searchQuantity = isset($_GET['entryType']) ? count($_GET['entryType']) : 1;
$startOffset    = isset($_GET['startOffset']) ? intval($_GET['startOffset']) : 0;
?>
<form action="?startOffset=<?php echo $startOffset; ?>" name="search" method="get">
  <table><tr><td>
    <fieldset>
        <legend>Sniff Search</legend>
        <div id="entryContainer">
            <p>
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
                </select><br>
                <label>Entry: </label>
                <input type="text" name="entry[]" class="searchInput" value="<?php echo isset($_GET['entry'][$i]) ? $_GET['entry'][$i] : ""; ?>" />
                <p style="display:none;clear:both;" id="likesentries[]">
                    <input type="checkbox" name="likeBehavior[]" value="1" <?php if (isset($_GET['likeBehavior'][$i])) echo 'checked '; ?>/>
                    Use like instead of equals for opcode name.
                </p>
                <?php if ($searchQuantity != 1 && $i+1 != $searchQuantity) { ?>
                <hr />
                <p style="clear: both">
                    <input type="checkbox" name="isAndGroup[]" <?php
                        if (isset($_GET['isAndGroup'][$i]) && $_GET['isAndGroup'][$i] == true)
                            echo "checked ";
                    ?>/> <small>Previous search OR new search (Defaults to AND).</small>
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
        <div class="buildList" name="buildList"><?php echo $builds; ?></div>
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

        echo '<table id="resultSet"><tr><th style="width:90px">Build</th><th style="width:500px">Sniff Name</th><th>Data Name</th><th style="width:70px">Value</th><th>Name</th></tr>';
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
        if ($(".searchFilter").length > 0)
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
        )).append(' <small>Previous search OR new search (Defaults to AND).</small>'));
        $(entriesDiv).append($(document.createElement('label')).text('Entry Type: '));
        var entriesSel = $(document.createElement('select')).attr('name','entryType[]');

        for (type in types)
            $(entriesSel).append($(document.createElement('option')).val(types[type]).text(types[type]));

        $(entriesDiv).append($(entriesSel));
        $(entriesDiv).append('<br>');
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
	
	$("input[value=classic]").click(function() {
		var checked = $(this).prop("checked");
		$("input[value=classic] ~ input").each(function(i) {
			$(this).prop("checked", checked ? true : false);
		});
	});
	
	$("input[value=tbc]").click(function() {
		var checked = $(this).prop("checked");
		$("input[value=tbc] ~ input").each(function(i) {
			$(this).prop("checked", checked ? true : false);
		});
	});
	
	$("input[value=wotlk]").click(function() {
		var checked = $(this).prop("checked");
		$("input[value=wotlk] ~ input").each(function(i) {
			$(this).prop("checked", checked ? true : false);
		});
	});
	
	$("input[value=cata]").click(function() {
		var checked = $(this).prop("checked");
		$("input[value=cata] ~ input").each(function(i) {
			$(this).prop("checked", checked ? true : false);
		});
	});
	
	$("input[value=mop]").click(function() {
		var checked = $(this).prop("checked");
		$("input[value=mop] ~ input").each(function(i) {
			$(this).prop("checked", checked ? true : false);
		});
	});
	
	$("input[value=wod]").click(function() {
		var checked = $(this).prop("checked");
		$("input[value=wod] ~ input").each(function(i) {
			$(this).prop("checked", checked ? true : false);
		});
	});
	
	$("input[value=legion]").click(function() {
		var checked = $(this).prop("checked");
		$("input[value=legion] ~ input").each(function(i) {
			$(this).prop("checked", checked ? true : false);
		});
	});
});
</script>
<?php
include('includes/footer.php');
?>
