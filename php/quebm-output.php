<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>

<?php
$check = json_decode($_POST['check']);
$user = $_SESSION['ACCOUNT']['AC_ID'];
$que_id = $_REQUEST['que_id'];

if ($check){
    $sql = $pdo->prepare('SELECT * FROM bmque WHERE AC_ID=? AND QUE_ID=?');
    $sql -> execute([$user , $que_id]);
    $count = $sql -> rowCount();

    if (!$count){
        $sql = $pdo->prepare('INSERT INTO bmque VALUE (NULL, ?, ?)');
        $sql -> execute([$user , $que_id]);
    }
} else {
    $sql = $pdo->prepare('DELETE FROM bmque WHERE ac_id=? AND que_id=?');
    $sql -> execute([$user , $que_id]);
}
?>