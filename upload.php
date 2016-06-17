<?php
$buildVersions = array(5875 => "1.12.1 5875",
                       6180 => "2.0.1 6180", 6299 => "2.0.3 6299", 6337 => "2.0.6 6337",
                       6692 => "2.1.0 6692", 6739 => "2.1.1 6739", 6803 => "2.1.2 6803", 6898 => "2.1.3 6898",
                       7272 => "2.2.0 7272", 7318 => "2.2.2 7318", 7359 => "2.2.3 7359",
                       7561 => "2.3.0 7561", 7741 => "2.3.2 7741", 7799 => "2.3.3 7799",
                       8089 => "2.4.0 8089", 8125 => "2.4.1 8125", 8209 => "2.4.2 8209", 8606 => "2.4.3 8606",
                       9056 => "3.0.2 9056", 9183 => "3.0.3 9183", 9464 => "3.0.8 9464", 9506 => "3.0.8a 9506", 9551 => "3.0.9 9551",
                       9767 => "3.1.0 9767", 9806 => "3.1.1 9806", 9835 => "3.1.1a 9835", 9901 => "3.1.2 9901", 9947 => "3.1.3 9947",
                       10192 => "3.2.0 10192", 10314 => "3.2.0a 10314", 10482 => "3.2.2 10482", 10505 => "3.2.2a 10505",
                       10958 => "3.3.0 10958", 11159 => "3.3.0a 11159", 11685 => "3.3.3 11685", 11723 => "3.3.3a 11723", 12213 => "3.3.5 12213", 12340 => "3.3.5a 12340",
                       13164 => "4.0.1 13164", 13205 => "4.0.1a 13205", 13329 => "4.0.3 13329", 13596 => "4.0.6 13596", 13623 => "4.0.6a 13623",
                       13914 => "4.1.0 13914", 14007 => "4.1.0a 14007",
                       14333 => "4.2.0 14333", 14480 => "4.2.0a 14480", 14545 => "4.2.2 14545",
                       15005 => "4.3.0 15005", 15050 => "4.3.0 15050", 15211 => "4.3.2 15211", 15354 => "4.3.3 15354", 15595 => "4.3.4 15595",
                       16016 => "5.0.4 16016", 16048 => "5.0.5 16048", 16057 => "5.0.5 16057", 16135 => "5.0.5b 16135",
                       16309 => "5.1.0 16309", 16357 => "5.1.0a 16357",
                       16650 => "5.2.0 16650", 16669 => "5.2.0a 16669", 16683 => "5.2.0b 16683", 16685 => "5.2.0c 16685", 16701 => "5.2.0d 16701", 16709 => "5.2.0e 16709", 16716 => "5.2.0f 16716", 16733 => "5.2.0g 16733", 16760 => "5.2.0h 16760", 16769 => "5.2.0i 16769", 16826 => "5.2.0j 16826",
                       16977 => "5.3.0 16977", 16981 => "5.3.0 16981", 16983 => "5.3.0hotfix1 16983", 16992 => "5.3.0hotfix2 16992", 17055 => "5.3.0hotfix3 17055", 17116 => "5.3.0hotfix4 17116", 17128 => "5.3.0a 17128",
                       17359 => "5.4.0 17359", 17371 => "5.4.0hotfix1 17371", 17399 => "5.4.0hotfix2 17399", 17538 => "5.4.1 17538", 17658 => "5.4.2 17658", 17688 => "5.4.2 17688", 17898 => "5.4.7 17898", 17930 => "5.4.7 17930", 17956 => "5.4.7 17956", 18019 => "5.4.7 18019", 18291 => "5.4.8 18291", 18414 => "5.4.8 18414",
                       19034 => "6.0.2 19034", 19103 => "6.0.3 19103", 19116 => "6.0.3 19116", 19342 => "6.0.1 19342",
                       19678 => "6.1.0 19678", 19702 => "6.1.0 19702", 19802 => "6.1.2 19802", 19831 => "6.1.2 19831", 19865 => "6.1.2 19865",
                       20173 => "6.2.0 20173", 20182 => "6.2.0 20182", 20201 => "6.2.0 20201", 20216 => "6.2.0 20216", 20253 => "6.2.0 20253", 20338 => "6.2.0 20338", 20444 => "6.2.2 20444", 20490 => "6.2.2a 20490", 20574 => "6.2.2a 20574", 20726 => "6.2.3 20726", 20779 => "6.2.3 20779", 20886 => "6.2.3 20886", 21315 => "6.2.4 21315", 21336 => "6.2.4 21336", 21348 => "6.2.4 21348", 21355 => "6.2.4 21355", 21463 => "6.2.4 21463", 21676 => "6.2.4 21676", 21742 => "6.2.4 21742");

require_once('includes/header.php');
?>
<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
    <div id="uploadTypeSelector">
        <a class="typeSelector">Paste a SQL blob</a><a class="typeSelector">Upload a SQL blob</a><?php if ($config['allowPkt'] !== "0") { /* DON'T ASK */ ?><a class="typeSelector">Upload a .pkt</a><?php } ?>
    </div>

    <div class="uploadFormHolder hidden">
        <textarea name="sniffData" style="width: 100%; height: 150px"></textarea>
        <input type="submit" name="submit" value="Submit" />
    </div>

    <div class="uploadFormHolder hidden">
        <p>Only .zip and .sql files are allowed.</p>
        <input type="file" name="sqlData" />
        <input type="submit" name="submit" value="Submit" />
    </div>
    <?php if ($config['allowPkt'] !== "0") { /* DON'T ASK */ ?>
    <div class="uploadFormHolder hidden">
        <input type="file" name="pktData" /><br />
        Content description: <input type="text" name="pktContent" size="45" /><br />
        Do *NOT* put any exceedingly large description, it will be actually used to name the file.<br />
        Overwrite build: <input type="radio" name="overwriteBuild" value="1" /> Yes <input type="radio" name="overwriteBuild" value="0" checked /> No
        <select style="display: none" name="enforceBuildId"><?php
            foreach ($buildVersions as $val => &$build)
                echo "<option value=\"{$val}\">{$build}</option>";
        ?></select>
        <input type="submit" name="submit" value="Submit" />
    </div>
    <?php } ?>
    <input type="hidden" name="uploadType" value="-1" />
</form>
<?php
if (isset($_POST['submit']) && $_POST['uploadType'] != -1) {
    $errors = array();
    switch ($_POST['uploadType']) {
        case 0: // SQL blob injection
            if (!empty($_POST['sniffData']))
                injectSQL($_POST['sniffData']);
            break;
        case 1: // SQL blob upload
            if (!empty($_FILES["sqlData"]) || !empty($_FILES['pktData'])) {
                $data = &$_FILES['sqlData'];
                if (isValidFile($data))
                    injectSQL(file_get_contents($data['tmp_name']));
            }
            break;
        case 2: // Pkt upload - *NOT* totally done, leave it disabled until time X (Misses build enforcing)
            if ($config['allowPkt'] == "0") // Because PHP is an idiot
                break; // Disabled by config
            $description = str_replace(" ", "_", $_POST['pktContent']);
            if (isValidFile($data))
                move_uploaded_file($data['tmp_name'], $config["pktStoragePath"] . $description . ".pkt");
            break;
        default:
            $errors[] = "Invalid submitted action.";
            break;
    }

    if (!empty($errors)) {
        echo "<h4>Errors list</h4><ul>";
        foreach ($errors as &$error)
            echo "<li>" . $error. "</li>";
        echo "</ul>";
    }
}
?>
<script src="./includes/jquery.js"></script>
<script type="text/javascript">
$(function() {
    $("input[name='overwriteBuild']").click(function() {
        $("select[name='enforceBuildId']").css("display", $(this).val() == 1 ? "inline-block" : "none");
    });

    $("#uploadTypeSelector a").click(function() {
        $("#uploadTypeSelector a").removeClass("activeSelector");
        $(this).addClass("activeSelector");
        var itemIdx = $(this).index();
        $("div.uploadFormHolder").each(function(index, item) {
            var isHidden = $(item).hasClass("hidden");
            if (index != itemIdx) {
                if (!isHidden)
                    $(item).slideUp();
            } else {
                if (isHidden)
                    $(item).removeClass("hidden");
                $(item).slideDown();
            }
        });

        $("input[name='uploadType']").val(itemIdx);
    });
});
</script>
<?php
require_once('includes/footer.php');

function isValidFile($fileData) {
    global $errors;
    $allowedFile = false;

    $pathInfo = pathinfo($fileData['name']);
    if ($pathInfo['extension'] === "sql") {
        if ($fileData['size'] < 10 * 1024 * 1024)
            if (!$fileData['error'])
                $allowedFile = true;
    }
    else if ($pathInfo['extension'] === "pkt") {
        // No size limit for the PKT (Actually let PHP handle it through its config).
        // Anyway you *shouldn't* enable this unless you totally trust your users.
        if (!$fileData['error'])
            $allowedFile = true;
    }
    else if ($pathInfo['extension'] === "zip") {
        /// TODO: Hack: Prevents injectSQL() from being called next
        $allowedFile = false;
        if (!$fileData['error']) {
            $zip = new ZipArchive();
            if ($zip->open($fileData['tmp_name'])) {
                for ($i = 0; $i < $zip->numFiles; ++$i) {
                    $fileInfo = $zip->statIndex($i);
                    if (end(explode('.', $fileInfo['name'])) !== "sql")
                        continue;
                    injectSQL($zip->getFromIndex($fileInfo['index']));
                }
                $zip->close();
            } else {
                $errors[] = "Could not extract the ZIP file.";
                $allowedFile = false;
            }
        }
    }
    unset($pathInfo);

    if (!$allowedFile) {
        switch ($fileData['error']) {
            case 1: // UPLOAD_ERR_INI_SIZE
            case 2: // UPLOAD_ERR_FORM_SIZE
                $errors[] = "The file's size exceeds the limit.";
                break;
            case 3: // UPLOAD_ERR_PARTIAL
                $errors[] = "The uploaded file has only been partially transferred.";
                break;
            case 4: // UPLOAD_ERR_NO_FILE:
                // $errors[] = "No file has been uploaded."; // Debug only
                break;
        }
    }

    return $allowedFile;
}

function injectSQL($commandBlock) {
    global $mysqlCon;
    $commandLines  = array_map("trim", explode(PHP_EOL, $commandBlock));
    $lineIndex     = 0;
    $lineCount     = count($commandLines);
    $insertCommand = "";
    $insertSets    = array();
    $affectedRows  = intval($mysqlCon->query("SELECT COUNT(*) AS n FROM SniffData")->fetch_object()->n);
    while ($lineIndex < $lineCount) {
        $line = &$commandLines[$lineIndex];
        ++$lineIndex;
        if (empty($line))
            continue;

        if ($line[0] === "(") { // New record - Inject it, if we have a valid INSERT header
            if ($insertCommand !== "") {
                // $mysqlCon->query($insertCommand . substr($line, 0, -1)); // Remove the coma or semicolon.
                $insertSets[] = $line;
                if (substr($line, -1) == ";") { // Insert and clean up
                    $mysqlCon->multi_query($insertCommand . implode(PHP_EOL, $insertSets));

                    if ($mysqlCon->affected_rows == -1)
                        echo "<span style=\"color: red;\">Something bad happened!</span>" . $mysqlCon->error . "<br />";
                    $insertSets = array();
                    $insertCommand = ""; // We ensure nothing will get injected until we meet another INSERT query
                }
            }
        } else {
            $lineTokens = explode(" ", $line);
            if (count($lineTokens) < 3)
                continue;
            $isIgnore = ($lineTokens[1] === "IGNORE");
            if ($lineTokens[0] === "INSERT" && (($isIgnore && $lineTokens[2] === "INTO") || (!$isIgnore && $lineTokens[1] === "INTO"))) {
                if (in_array(str_replace("`", "", strtolower($lineTokens[$isIgnore ? 3 : 2])), array("sniffdata", "objectnames"))) // We're all set, assume it is a valid INSERT query
                    $insertCommand = $line;
            }
        }
    }
    $affectedRows = intval($mysqlCon->query("SELECT COUNT(*) AS n FROM SniffData")->fetch_object()->n) - $affectedRows;
    echo $affectedRows . " rows injected!";
    if ($affectedRows == 0)
        echo " No data was injected, because it is already present in database.";
}
?>
