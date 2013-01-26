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
?>
<form name="search" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Sniff Data Upload</legend>
        <textarea name="sniffData" style="width: 100%; height: 150px"></textarea>
        <br />
        If the dump is quite heavy, upload the file here. (Up to <b>10Mbs</b>)<br />
        <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
        <input type="file" name="fileData" />
        <input type="submit" name="submit" class="submit" value="Submit" />
    </fieldset>
</form>

<?php
if (isset($_POST['submit'])) {
    $errors = array();
    if (!empty($_POST['sniffData'])) {
        $mysqlCon->multi_query($_POST['sniffData']);
    } else if (!empty($_FILES["fileData"])) {
        $data = &$_FILES['fileData'];
        $allowedFile = false;
        $pathInfo = pathinfo($data['name']);
        if ($data['type'] === "application/octet-stream") // SQL files have that type, so we should extract extention from the pathinfo
            if ($pathInfo['extension'] === "sql")
                if ($data['size'] < 10 * 1024 * 1024)
                    if (!$data['error'])
                        $allowedFile = true;
        if (!$allowedFile) {
            switch ($data['error']) {
                case 1: // UPLOAD_ERR_INI_SIZE
                case 2: // UPLOAD_ERR_FORM_SIZE
                    $errors[] = "The file's size exceeds the limit.";
                    break;
                case 3: // UPLOAD_ERR_PARTIAL
                    $errors[] = "The file has only been partially transferred.";
                    break;
                case 4: // UPLOAD_ERR_NO_FILE:
                    $errors[] = "No file has been uploaded.";
                    break;
            }
        } else {
            // Read the file
            $commandBlock = file_get_contents($data['tmp_name']);
            $mysqlCon->multi_query($commandBlock);
        }
    }
}
?>
<script src="./includes/jquery.js"></script>
<script>
$(function() {

});
</script>
<?php
include('includes/footer.php');
?>
