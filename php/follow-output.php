<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>
<?php require_once '../nav.php'; ?>

<?php
$check =json_decode($_POST['check']);
$follower =  $_REQUEST['user'];

$user_id = session_user_id();#セッションがあればアカウントIDを取得する自作関数。 


if($check){
    $insert_follow = 'INSERT INTO follow VALUE (?,?)';
    $follow = $pdo->prepare($insert_follow);
    $follow -> execute([$user_id , $follower]);
}else{
    $delete_follow = 'DELETE FROM follow WHERE self_id = ? AND partner_id = ?';
    $delete = $pdo -> prepare($delete_follow);
    $delete -> execute([$user_id , $follower]);
}
?>

<?php require_once '../footer.php'; ?>
