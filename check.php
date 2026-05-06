<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Auth.php';
require_once 'classes/Member.php';
require_once 'classes/Order.php';
require_once 'classes/MLModel.php';

echo "✅ All classes loaded OK<br>";

require_once __DIR__ . '/vendor/autoload.php';
echo "✅ vendor/autoload.php OK<br>";

$database = new Database();
echo "✅ Database connected OK<br>";
?>