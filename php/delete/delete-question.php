<?php session_start(); ?>
<?php require_once '../../function.php'; ?>
<?php require_once '../../header.php'; ?>

<?php
//投稿削除フォーム処理
if (isset($_REQUEST)){
    $DEL_QUE_ID = $_REQUEST['QUE_ID'];

    $sql = $pdo->prepare('DELETE FROM ANSWER WHERE QUE_ID = ?');
    if ($sql->execute([$DEL_QUE_ID])){
        $sql = $pdo->prepare('DELETE FROM QUESTION WHERE QUE_ID = ?');
        if ($sql->execute([$DEL_QUE_ID])){
            //画像削除
            $file = '../../img/QUEIMG/'. $DEL_QUE_ID;
            echo $file;

            foreach (glob($file. '/*') as $tmp) {
                echo 'a';
                unlink($tmp);
            }

            if (file_exists($file)){
                rmdir($file);
            }
            header('Location:../index.php');
        }
    }
}
alert('削除に失敗しました');
?>

<?php require_once '../../footer.php'; ?>