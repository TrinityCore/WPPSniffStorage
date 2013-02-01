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
                       13164 => "4.0.1 13164",13205 => "4.0.1a 13205", 13329 => "4.0.3 13329", 13596 => "4.0.6 13596", 13623 => "4.0.6a 13623",
                       13914 => "4.1.0 13914",14007 => "4.1.0a 14007",
                       14333 => "4.2.0 14333",14480 => "4.2.0a 14480", 14545 => "4.2.2 14545",
                       15005 => "4.3.0 15005",15050 => "4.3.0 15050", 15211 => "4.3.2 15211", 15354 => "4.3.3 15354", 15595 => "4.3.4 15595");

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
    if ($fileData['type'] === "application/octet-stream") { // SQL/PKT files have that type, so we should extract extention from the pathinfo
        if ($pathInfo['extension'] === "sql") {
            if ($data['size'] < 10 * 1024 * 1024)
                if (!$data['error'])
                    $allowedFile = true;
        }
        else if ($pathInfo['extension'] === "pkt") {
            // No size limit for the PKT (Actually let PHP handle it through its config).
            // Anyway you *shouldn't* enable this unless you totally trust your users.
            if (!$data['error'])
                $allowedFile = true;
        }
    }
    unset($pathInfo);
    
    if (!$allowedFile) {
        switch ($data['error']) {
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
    while ($lineIndex < $lineCount) {
        $line = &$commandLines[$lineIndex];
        ++$lineIndex;

        if (empty($line))
            continue;

        if ($line[0] === "(") { // New record - Inject it, if we have a valid INSERT header
            if ($insertCommand !== "")
                $mysqlCon->query($insertCommand . substr($line, 0, -1)); // Remove the coma or semicolon.
        } else {
            $lineTokens = explode(" ", $line);
            if (count($lineTokens) < 3)
                continue;
            $isIgnore = ($lineTokens[1] === "IGNORE");
            if ($lineTokens[0] === "INSERT" && (($isIgnore && $lineTokens[2] === "INTO") || (!$isIgnore && $lineTokens[1] === "INTO"))) {
                $insertCommand = ""; // We ensure nothing will get injected until we meet another INSERT query
                if (in_array(str_replace("`", "", strtolower($lineTokens[$isIgnore ? 3 : 2])), array("sniffdata", "objectnames"))) // We're all set, assume it is a valid INSERT query
                    $insertCommand = $line;
            }
        }
    }
}
?>
