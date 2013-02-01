<?php
session_start();
$config        = parse_ini_file("./includes/config.ini.php");

if ($config['passwordProtection'] == "1" && basename($_SERVER["PHP_SELF"]) !== "login.php")
    if (!isset($_SESSION['uid']) || empty($_SESSION['uid'])) // We don't bother with it, just a marker
        header("Location: http://" . $_SERVER['SERVER_NAME'] . substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/')) . "/login.php");

$mysqlCon      = new mysqli($config['DBhost'], $config['DBuser'], $config['DBpass'], $config['DBname']);
$types         = array('None', 'Spell', 'Map', 'LFGDungeon', 'Battleground', 'Unit', 'GameObject', 'Item', 'Quest', 'PageText', 'NpcText', 'Gossip', 'Zone', 'Area', 'Phase', 'Player', 'Opcode Name', 'Opcode Number');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./includes/style.php?a=<?php echo intval($config["allowPkt"]) + 2; ?>" />
    <title>WPP Sniff Data Storage</title>
</head>

<body>
    <div id="page">
      <div id="pagetop">
        <div id="topbar">
            <img src="http://www.trinitycore.org/f/public/style_images/1_trinitycore.png" alt="TrinityCore Sniff Storage" style="float: left; width: 116px; height: 67px;" />
            <div id="topContent">
                <h4>TrinityCore Sniff Storage</h4>
                <div class="topLinks">
                    <ul>
                        <?php if (!empty($_SESSION['uid'])) { ?>
                        <li><a href="./logout.php">Quit</a></li>
                        <?php } ?>
                        <li><a href="./filenames.php">Parsed sniffs list</a></li>
                        <li><a href="./upload.php">Upload</a></li>
                        <li><a href="./index.php">Search</a></li>
                    </ul>
                </div>
            </div>
        </div>
     </div>
     <div id="main">
        <div class="content">
            <div class="main_body">
<!-- End of header file (CBA to redo everything using OOP) -->
