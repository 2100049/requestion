<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>

<?php
if (isset($_REQUEST['AC_NAME'])){
    unset($_SESSION['ACCOUNT']);

    $sql=$pdo->prepare('SELECT * FROM ACCOUNT WHERE BINARY AC_NAME=? AND BINARY AC_PASS=?');
    $sql->execute([$_REQUEST['AC_NAME'], $_REQUEST['AC_PASS']]);

    foreach ($sql as $row){
        $_SESSION['ACCOUNT']=[
            'AC_ID'=>$row['AC_ID'], 'AC_NAME'=>$row['AC_NAME']
        ];
    }

    if (isset($_SESSION['ACCOUNT'])){
        header('Location:index.php');
    }else{
        alert('ユーザーIDまたはパスワードが違います');
    }
}

$AC_NAME = $AC_PASS = NULL;

if (isset($_SESSION['REGISTER'])){
    $AC_NAME = $_SESSION['REGISTER']['AC_NAME'];
    $AC_PASS = $_SESSION['REGISTER']['AC_PASS'];

    unset($_SESSION['REGISTER']);
}
?>

<div class="text-center mt-5"><img src="../img/logo.svg" style="height: 30px;"></div>

<div class="mx-auto border bg-white shadow-sm mt-2 pt-5 pb-5 ps-3 pe-3" style="width: 300px;">
    <h3 class="text-center">ログイン</h3>

    <form class="mt-5" method="POST">
        <div>
            <input type="text" class="form-control" name="AC_NAME" placeholder="ユーザーID" value="<?= $AC_NAME ?>" maxlength="15" required autofocus>
        </div>

        <div class="mt-2">
            <input type="password" class="form-control" name="AC_PASS" placeholder="パスワード" value="<?= $AC_PASS ?>" maxlength="100" required>
        </div>

        <div class="text-center mt-2">
            <input type="submit" class="btn btn-primary btn-sm" id="btn" value="ログイン" style="width: 100%;">
        </div>
    </form>

    <div class="text-center mt-5">
        <a href="register.php" class="btn btn-outline-primary btn-sm" style="width: 100%;">新規登録</a>
    </div>
</div>

<?php require_once '../footer.php' ?>