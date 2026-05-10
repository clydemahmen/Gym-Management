<?php
require_once 'init.php';
$auth->check();

$id    = (int)($_GET['id'] ?? 0);
$order = $orderObj->getById($id);

if(!$order){
    header('Location: orders.php');
    exit();
}

$orderObj->delete($id);
header('Location: orders.php?deleted=1');
exit();
