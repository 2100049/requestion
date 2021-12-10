<?php
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');

//タグフォーム処理
$QUE_ID = $_REQUEST['QUE_ID'];
$TAG = $_REQUEST['TAG'];

$sql = $pdo->prepare('SELECT * FROM TAG WHERE QUE_ID=? AND TAG=?');
$sql->execute([$QUE_ID, $TAG]);

if (empty($sql->fetchAll())){
    $sql = $pdo->prepare('INSERT INTO TAG VALUES(null, ?, ?)');
    $sql->execute([$QUE_ID, $TAG]);
} else {
    //重複処理
}
?>
