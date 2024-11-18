<?php
echo __DIR__; // Add this line to debug the current directory
require __DIR__ . '/../../partial/header.php';

// check login status
if(!isset($_SESSION['user-id'])) {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
?>
<link rel = "stylesheet" href="/Blog/css/style.css">

