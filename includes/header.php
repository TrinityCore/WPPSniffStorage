<?php
$config        = parse_ini_file("config.ini.php");
$mysqlCon      = new mysqli($config['DBhost'], $config['DBuser'], $config['DBpass'], $config['DBname']);
$types         = array('None', 'Spell', 'Map', 'LFGDungeon', 'Battleground', 'Unit', 'GameObject', 'Item', 'Quest', 'PageText', 'NpcText', 'Gossip', 'Zone', 'Area', 'Phase', 'Player', 'Opcode Name', 'Opcode Number');

function BuildSearchList($result, $nobuild)
{
    if ($nobuild) $display = " style='display:none'";
    $html = '<table id="searchresults" cellspacing="0"><tr class="headerrow"><td class="first">Sniff Name</td><td'.$display.'>Build</td><td>Type</td><td>Id</td><td>Name</td></tr>';
    $otherrow = false;
    while ($row = $result->fetch_array(MYSQLI_ASSOC))
    {

        $html .= '<tr';
        if ($otherrow) $html .= ' class="otherrow"';
        $html .= '><td class="first"><a href="'.$row['SniffName'].'" target="blank">'.$row['SniffName'].'</a></td><td'.$display.'>'.$row['Build'].'</td><td style="text-align:center;">'.$row['ObjectType'].'</td><td>'.$row['Id'].'</td><td>';
        if ($row['ObjectType'] == 'Opcode')
            $html .= $row['Data'];
        else
            $html .= $row['name'];
        $html .= '</td></tr>';
        $otherrow = !$otherrow;
    }
    $html .= '</table>';
    return $html;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./includes/style.css" />
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
                        <li><a href="./index.php">Home</a></li>
                        <li><a href="./upload.php">Upload</a></li>
                    </ul>
                </div>
            </div>
        </div>
     </div>
     <div id="main">
        <div class="content">
            <div class="main_body">
<!-- End of header file (CBA to redo everything using OOP) -->
