<?php
session_start();

// Load all classes
require_once 'classes/Database.php';
require_once 'classes/User.php';
require_once 'classes/Auth.php';
require_once 'classes/Member.php';
require_once 'classes/GymSession.php';

// Initialize DB
$database = new Database();

// Init classes
$userObj    = new User($database);
$auth       = new Auth($userObj);
$memberObj  = new Member($database);
$sessionObj = new GymSession($database);
?>