<?php
session_start();
require(__DIR__ . "/../../lib/functions.php");
reset_session();
flash("Successfully logged out", "success");
header("Location: login.php");
?>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>
