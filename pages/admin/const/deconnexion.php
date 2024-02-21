<?php

session_start();

$_SESSION = array();

session_destroy();

header("location: ../../Fr/index.php");

exit();

?>
