<?php header("Content-type: text/css"); ?>
html, body { text-align: center; }
p {text-align: left;}

body {
    margin: 0;
    padding: 0;
    background: #FFFFFF;
    background-repeat: repeat-x;
    text-align: left;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 13px;
    color: black;
}

* { margin: 0 auto 0 auto; text-align:left; }


html, body { text-align: center; }
p { text-align: left; }

#page
{
    width: 1024px;
    margin-top: 20px;
    padding: 20px;
    border: 1px solid rgb(34, 173, 218);
    background: rgb(192, 224, 235);
    border-radius: 5px;
    box-shadow: 0 0 20px lightblue;
    margin-bottom: 40px;
}

#pagetop
{
    height:100px;
}

#pagetop h1
{
    display:block;
    float:left;
    line-height:90px;
    color:#FFFFFF;
    text-align:left;
    font-size:27px;
    font-weight:bold;
    font-family:Arial, Helvetica, sans-serif;
    float:left;
    margin-left:23px;
}

#topbar {
    float: left;
    width:1024px;
    margin: -20px;
    padding: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgb(34, 173, 218);
}

#topbar #topContent > h4 {
    display: block;
    font-size: 15px;
    border-bottom: 1px solid black;
    padding-left: 15px;
}

#topbar #topContent { float: right !important; width: 900px; }
.topLinks ul { display: block; float: left; list-style-type: none;    padding: 0px; height:21px; text-align:center; overflow:hidden; }
.topLinks ul li a:hover { color:#65A9ED; }

.topLinks ul li , .topLinks ul li a, .topLinks ul li a:visited{
    display:block;
    float:right;
    margin: 0px;
    text-align:center;
    padding-left:5px;
    padding-right:5px;
    font-size:14px;
    font-weight:bold;
    text-decoration:none;
}


#main { width: 100%; }

#main .content {
    text-align: justify;
    color: #000000;
    word-spacing: 3px;
}

#main .content p { margin-bottom:8px; }
#main .content h1 { font-size:19px; margin-bottom:12px; }
#main a { text-decoration:none; }

.clear { clear:both; }

.searchInput {
    width:250px;
    clear:right;
    margin-bottom: 8px;
}

table td { vertical-align: top; }

form fieldset {
    width: 400px;
    margin: 0 30px;
    border: 1px solid green;
    border-radius: 3px;
    box-shadow: 0 0 15px rgb(34, 216, 34);
    background-color: rgb(158, 233, 158);
}

fieldset > legend {
    display: block;
    margin: 0;
    height: 20px;
    border: 1px solid green;
    border-radius: 3px;
    padding: 0 7px;
    background-color: rgb(158, 233, 158);
}

.clientBuildSelector {
    width:250px;
    margin-bottom: 10px;
    clear:both;
    border: 1px solid green;
    border-radius: 3px;
    /* background: white; */
}

input[type="submit"].submit {
    border: 1px solid black;
    border-radius: 4px;
    background-color: rgb(192, 224, 235);
    padding: 1px 8px;
}

.clientBuildSelector .searchInput
{
    width: 110px;
}

form[name="search"] select
{
    width: 120px;
    float:left;
    clear:right;
    margin-bottom: 8px;
}

.clientBuildSelector label
{
    width: 70px;
}

.submit
{
    margin-top: 10px;
    float:right;
}

.buildList li
{
    list-style-image: none;
    list-style-type: none;
}

fieldset label
{
    float:left;
    clear:both;
    width:100px;
}

#searchresults
{
    font-size:13px;
    border-top:1px solid black;
    border-bottom:1px solid black;
}

#searchresults tr
{
    background-color: #c9e2fc;
}

#searchresults tr.otherrow
{
    background-color: #edf4fc;
}

#searchresults td
{
    border-right:1px solid black;
    padding-left: 2px;
    padding-right: 2px;
    padding-bottom: 2px;
}

#searchresults td.first
{
    border-left:1px solid black;
}

#searchresults .headerrow
{
    font-size: 16px;
    font-weight: bold;
}

#resultSet
{
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    margin-bottom: 18px;
}

#resultSet td {
    width: auto;
    border: 1px dotted black;
    padding: 3px;
}

#resultSet th { border: 1px solid black; text-align: center; }

#sqlQueryContainer {
    border: 1px solid black;
    border-radius: 5px;
    padding: 5px;
}

hr { color: black; border: 0; border-top: 1px solid black; margin: 10px 0; }

.hidden, *.hidden { display: none; }

div#uploadTypeSelector {
    display: block;
    overflow: visible;
    border-radius: 3px;
    margin: auto;
    margin-bottom: 25px;
    width: <?php echo intval(isset($_GET['a']) ? $_GET['a'] : 0) * 335 + intval($_GET['a']) + 1; ?>px;
}

div#uploadTypeSelector a {
    display: inline-block;
    width: 335px;
    text-align: center;
    border: 1px solid #3269a0;
    border-right: 0;
    color: #333;
    padding: 10px 0;
    background-color: rgb(186, 219, 252);
    background-image: -moz-linear-gradient(rgb(107, 166, 224), rgb(186, 219, 252));
    background-image: -webkit-linear-gradient(rgb(107, 166, 224), rgb(186, 219, 252));
    background-image: linear-gradient(rgb(107, 166, 224), rgb(186, 219, 252));
}

div#uploadTypeSelector a:first-of-type {
    border-top-left-radius: 3px;
    border-bottom-left-radius: 3px;
}

div#uploadTypeSelector a:last-of-type {
    border-top-right-radius: 3px;
    border-bottom-right-radius: 3px;
    border-right: 1px solid #3269a0;
}

div#uploadTypeSelector a.activeSelector, div#uploadTypeSelector a:hover {
    background-color: rgb(107, 166, 224);
    background-image: -moz-linear-gradient(rgb(186, 219, 252), rgb(107, 166, 224));
    background-image: -webkit-linear-gradient(rgb(186, 219, 252), rgb(107, 166, 224));
    background-image: linear-gradient(rgb(186, 219, 252), rgb(107, 166, 224));
}

.matchPattern { font-weight: bold; color: green; }

#resultSet a {
    border-bottom: 1px dotted black;
    cursor: help;
}

#resultSet tr.odd td {
    background-color: rgb(170, 219, 236);
}

#resultSet th {
    background-color: white;
}