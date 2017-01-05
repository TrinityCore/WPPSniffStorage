<?php
require_once('includes/header.php');

if (!empty($_POST["user"]) && !empty($_POST["pass"])) {
    $safeHash = strtolower($_POST['user']) . ":" . sha1(substr($config['unused'], 0, 5) . strtoupper($_POST["user"]) . ":" . strtoupper($_POST['pass']) . substr($config['unused'], 5));
    // die($safeHash); // Uncomment to get a hash pair to store in pair.txt
    $pairs = array_map("trim", explode(PHP_EOL, file_get_contents("./pair.txt")));
    $valid = false;
    foreach ($pairs as $pair) {
        if (empty($pair))
            continue;

        if ($safeHash == $pair) {
            $_SESSION['uid'] = $_POST['user'];
            $valid = true;
            break;
        }
    }

    if (!$valid)
        echo "Sorry, wrong credentials. Try <a href=\"./login.php\">again</a>.";
    else
        echo "Welcome, " . $_SESSION['uid'];
} else {
?>
<form method="post">
    Username: <input type="text" name="user" /><br />
    Password: <input type="password" name="pass" /><br />
    <input type="submit" value="Login" />
</form>
<?php
}
?>
<script src="./includes/jquery.js"></script>
<script type="text/javascript">
$(function() {

});
</script>
<?php
require_once('includes/footer.php');
?>
