<?php session_start(); ?>
<?php require_once '../../function.php'; ?>
<?php require_once '../../header.php'; ?>

<?php
//回答削除フォーム処理
if (isset($_REQUEST)){
    $DEL_ANS_ID = $_REQUEST['ANS_ID'];

    $sql = $pdo->prepare('SELECT QUE_ID FROM ANSWER WHERE ANS_ID = ?');
    $sql->execute([$DEL_ANS_ID]);
    foreach ($sql as $row){
        $QUE_ID = $row['QUE_ID'];
    }

    $sql = $pdo->prepare('DELETE FROM ANSWER WHERE ANS_ID = ?');
    if ($sql->execute([$DEL_ANS_ID])){
        //画像削除
        $file = '../../img/ANSIMG/'. $DEL_ANS_ID;

        foreach (glob($file. '/*') as $tmp) {
            unlink($tmp);
        }

        if (file_exists($file)){
            rmdir($file);
        }
        header('Location:../question-detail.php?QUE_ID='. $QUE_ID);
    }
}
alert('削除に失敗しました');
?>

<?php require_once '../../footer.php'; ?>