<?php
session_start();

// Load all classes
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Auth.php';
require_once 'classes/Member.php';
require_once 'classes/Order.php';
require_once 'classes/MLModel.php';

// Sentiment Analyzer via Composer (davmixcool/php-sentiment-analyzer from Packagist.org)
require_once __DIR__ . '/vendor/autoload.php';

// Initialize DB
$database = new Database();

// Init classes
$userObj   = new User($database);
$auth      = new Auth($userObj);
$memberObj = new Member($database);
$orderObj  = new Order($database);
$mlModel   = new MLModel($database);
?>
