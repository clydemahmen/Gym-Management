<?php
require_once 'init.php';
Auth::check();

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    $sessionObj->delete($id);
}

header("Location: sessions.php");
exit();
?>
