<?
session_start();
$_SESSION = array();
session_destroy();
    echo "<script>";
    echo "top.location.href = '../index.php'";
    echo "</script>";

?>
