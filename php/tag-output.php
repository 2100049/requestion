<?php
require '../function.php';
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');

//タグフォーム処理
$QUE_ID = $_REQUEST['QUE_ID'];
$TAG = $_REQUEST['TAG'];
// if($TAG == ""){
//   exit;
// }

$sql = $pdo->prepare('SELECT * FROM TAG WHERE QUE_ID=? AND TAG=?');
$sql->execute([$QUE_ID, $TAG]);

if (empty($sql->fetchAll())){
    $sql = $pdo->prepare('INSERT INTO TAG(QUE_ID,TAG) VALUES(?, ?)');
    $sql->execute([$QUE_ID, $TAG]);

    $tag = h($TAG);
    echo <<<HTML
    <input class="submitlink" type="submit" name="TAG" value="$tag">, 
    HTML;
} else {
  // 重複の処理
}
// REQUESTで出してるせいで追加できてない（重複してる場合）も表示されてしまうお
//omg orz
// 変数に入れただけやから絶対意味ないＷ<<?
// 重複問題はあるけど動きはいいかんじやで
// (*＾＾)b
// お、いいんちゃう
// (*＾＾)b
// ：-)
// (⌒,_ゝ⌒)ﾂﾈﾆ ﾏｲﾉﾘﾃｨﾃﾞ ｱﾚ

?>
