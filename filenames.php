<?php
require_once('includes/header.php');

if ($result = $mysqlCon->query("SELECT DISTINCT(SniffName) AS f FROM SniffData")) {
    $fileNames = array();
    while ($row = $result->fetch_object())
        $fileNames[] = $row->f;
    echo '<script type="text/javascript">sniffFiles = ' . json_encode($fileNames) . ';</script>';
} else {
    echo "No sniff found!";
    require_once('includes/footer.php');
    die;
}
?>
<h3 style="margin-bottom: 3px; display: block; width: 100%; border-bottom: 1px solid black;">Sniff file searcher</h3>
<p>Wanna know if a sniff has already been parsed ? Enter part or all of its name in the input box below.</p>
<div style="margin: auto; width: 850px; text-align: center;">
    Sniff filename: <input type="text" name="sniffName" size="40" /><br />
    Sniffs found: <span id="sniffCount" style="font-weight: bold">0</span>
    <div id="extraMatch" style="color: green; font-weight: bold;"></div>
    <div id="approxMatch"></div>
</div>
<script src="./includes/jquery.js"></script>
<script type="text/javascript">
$(function() {
    $('input[name="sniffName"]').keyup(function() {
        var searchString = $(this).val(),
            hasExactName = (jQuery.inArray(searchString, sniffFiles) != -1),
            approxFiles  = [],
            sniffCount   = 0;
        
        $("#approxMatch").html("");
        if (searchString.length == 0) {
            $("#extraMatch").html("");
            $("#sniffCount").html(0);
        } else {
            if (hasExactName)
                $("#extraMatch").html('Exact match has been found: that sniff has been parsed.');

            // Also look for strings containing the filename
            jQuery.each(sniffFiles, function(idx, item) {
                if ((new RegExp(searchString, "i")).test(item) && item.toLowerCase() != searchString.toLowerCase()) {
                    approxFiles.push(item);
                    ++sniffCount;
                }
            });
            unique(approxFiles);
            jQuery.each(approxFiles, function(idx, item) {
                $("#approxMatch").html($("#approxMatch").html() + ($("#approxMatch").html().length > 0 ? '<br />' : '') + item.replace(searchString, '<span class="matchPattern">' + searchString + '</span>'));
            });
            $("#sniffCount").html(sniffCount + (hasExactName ? 1 : 0));
        }
    });

    function unique(array){
        return $.grep(array,function(el,index){
            return index == $.inArray(el,array);
        });
    }
});
</script>
<?php
require_once('includes/footer.php');
?>
