<?php session_start(); ?>
<?php require_once '../../function.php'; ?>
<?php require_once '../../header.php'; ?>

<?php
$RES_ID = $_REQUEST['RES_ID'];

$sql = $pdo->prepare(
    'SELECT QUE_ID FROM RESPONSE
    INNER JOIN answer USING (ANS_ID)
    WHERE RES_ID = ?
');
$sql->execute([$RES_ID]);
foreach ($sql as $row){
    $QUE_ID = $row['QUE_ID'];
}

//返信削除
$sql=$pdo->prepare('DELETE FROM RESPONSE WHERE RES_ID = ?');
if ($sql->execute([$RES_ID])){
    header('Location:../question-detail.php?QUE_ID='. $QUE_ID);
}else{
    echo '削除に失敗しました';
}
?>

<?php require_once '../../footer.php'; ?>