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
    var searchTimer;
    $('input[name="sniffName"]').keyup(function() {
        if ($(this).val().length == 0) {
            clearTimeout(searchTimer);
            $("#approxMatch").html("");
            $("#extraMatch").html("");
            $("#sniffCount").html(0);
            return;
        }

        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            $("#approxMatch").html("");
            $("#extraMatch").html("");
            $("#filterMoar").html("");

            var searchString = $('input[name="sniffName"]').val(),
                hasExactName = (jQuery.inArray(searchString, sniffFiles) != -1),
                approxFiles  = [],
                sniffCount   = 0;

            // Cleaning up the search string to remove metacharacters
            searchString = searchString.replace("(", "\\(");
            searchString = searchString.replace(")", "\\)");
            searchString = searchString.replace(".", "\\.");

            if (searchString.length == 0) {
                $("#sniffCount").html(0);
            } else {
                if (hasExactName) {
                    $("#extraMatch").html('An exact match has been found: that sniff has been parsed.');
                    $("#sniffCount").html(1);
                } else {
                    var regex = new RegExp("(" + searchString + ")", "i");
                    console.log(regex);
                    // Look for strings containing the filename
                    for (var i in sniffFiles) {
                        if (sniffCount > 50)
                        {
                            $("#sniffCount").html($("#sniffCount").html() + "+");
                            $("#filterMoar").html("Too many results. Improve your search string.");
                            break;
                        }

                        var item = sniffFiles[i];
                    // jQuery.each(sniffFiles, function(idx, item) {
                        if (regex.test(item.substring(0, item.length - 4)) && item.toLowerCase() != searchString.toLowerCase()) {
                            approxFiles.push(item);
                            ++sniffCount;
                        }
                    }/*)*/  ;

                    if (approxFiles.length != 0) {
                        $("#approxMatch").html("<b>Possible matches:</b>");
                        jQuery.each(approxFiles, function(idx, item) {
                            $("#approxMatch").html($("#approxMatch").html() + '<br />' + item.replace(regex, '<span class="matchPattern">$1</span>'));
                        });
                    }
                    $("#sniffCount").html(sniffCount);
                }
            }
        }, 750);
    });
});
</script>
<?php
require_once('includes/footer.php');
?>
