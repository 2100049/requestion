<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>
<?php require_once '../nav.php' ?>

<div class="mgmain">
<?php
if (in()){
    $sql = $pdo->prepare('INSERT INTO QUESTION VALUES(NULL, ?, ?, ?, ?, ?)');
    for ($i = 1; $i <= 100; $i++){
        $time = date("[Y/m/d]H:i");
        $text = 'サンプルデータ'. $i;

        $sql->execute([$_SESSION['ACCOUNT']['AC_ID'], $text, 1, 1, $time]);
    }
    echo 'サンプルデータの出力が終了しました';
}else{
    header('Location:login.php');
}
?>
</div>

<?php require_once '../footer.php' ?>