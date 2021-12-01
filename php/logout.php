<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>

<?php
unset($_SESSION['ACCOUNT']);
header('Location:index.php')?>

<?php require '../footer.php'; ?>