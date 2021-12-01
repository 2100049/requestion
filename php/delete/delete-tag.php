<?php session_start(); ?>
<?php require_once '../../function.php'; ?>
<?php require_once '../../header.php'; ?>

<?php
var_dump($_REQUEST);
if(isset($_REQUEST['DEL_TAG_ID'])){
    $tag = $_REQUEST['DEL_TAG_ID'];
    $sql = $pdo->prepare('DELETE FROM TAG WHERE TAG_ID = ?');
    // $tag = explode(",", $_REQUEST['DEL_TAG_ID']);
    foreach ($tag as $row){
        $sql->execute([$row]);
    }
}
header('Location:../question-detail.php?QUE_ID='. $_REQUEST['QUE_ID']);
?>

<?php require_once '../../footer.php'; ?>