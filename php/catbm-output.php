<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>

<?php
$check = json_decode($_POST['check']);
$user = $_SESSION['ACCOUNT']['AC_ID'];
$cat_id = $_REQUEST['cat_id'];

if ($check){
    $sql = $pdo->prepare('INSERT INTO bmcategory VALUE (?, ?)');
    $sql -> execute([$user , $cat_id]);
} else {
    $sql = $pdo->prepare('DELETE FROM bmcategory WHERE ac_id=? AND cat_id=?');
    $sql -> execute([$user , $cat_id]);
}
?>