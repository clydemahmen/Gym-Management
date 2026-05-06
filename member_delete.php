<?php
require_once 'init.php';
$auth->check();

$id = (int)$_GET['id'];

if($id){
    $memberObj->delete($id);
}

header("Location: members.php");
exit();
?>