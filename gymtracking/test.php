<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'init.php';
Auth::check();
echo "Auth OK!";
?>