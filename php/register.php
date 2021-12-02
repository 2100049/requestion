<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>

<?php
if (isset($_REQUEST['AC_NAME']) && isset($_REQUEST['AC_PASS'])){
    $AC_NAME = $_REQUEST['AC_NAME'];
    $AC_PASS = $_REQUEST['AC_PASS'];

    if (mb_ereg("^.{5,15}$", $AC_NAME) && !preg_match('/( |　)+/', $AC_NAME) && !preg_match('/( |　)+/', $AC_PASS) && preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}/', $AC_PASS)){
        $sql=$pdo->prepare('SELECT * FROM ACCOUNT WHERE AC_NAME=?');
        $sql->execute([$_REQUEST['AC_NAME']]);

        if (empty($sql->fetchAll())){
            $sql=$pdo->prepare('INSERT INTO ACCOUNT VALUES(null, ?, ?, NULL, NULL, NULL)');
            $sql->execute([$_REQUEST['AC_NAME'], $_REQUEST['AC_PASS']]);

            $_SESSION['REGISTER']=[
                'AC_NAME'=>$_REQUEST['AC_NAME'],'AC_PASS'=>$_REQUEST['AC_PASS']
            ];

            header('Location:login.php');
        }else{
            alert('IDが既に使用されています');
        }
    }else{
        alert('不正なユーザーIDまたはパスワードです');
    }
}
?>

<div class="text-center mt-5"><img src="../img/logo.svg" style="height: 30px;"></div>

<div class="mx-auto border bg-white shadow-sm mt-2 p-5" style="width: 500px;">
<h3 class="text-center">アカウント作成</h3>

    <form class="mt-5" method="POST">
        <div class="alert alert-danger" role="alert">
            <small>
                ユーザーIDは5文字以上15文字以内<br>
                パスワードはスペースを含まない半角大文字、小文字、数字を含む8文字以上にしてください
            </small>
        </div>

        <div class="mt-2">
            <input type="text" class="form-control" name="AC_NAME" placeholder="ユーザーID" maxlength="15" required autofocus>
        </div>

        <div class="mt-2">
            <input type="password" class="form-control" name="AC_PASS" placeholder="パスワード" maxlength="100" required>
        </div>

        <div class="text-center mt-5">
            <input type="submit" class="btn btn-primary btn-sm" id="btn" value="作成" style="width: 100%;">
        </div>
    </form>

    <div class="text-center">
        <a href="login.php"><small>ログインページへ</small></a>
    </div>
</div>

<?php require '../footer.php'; ?>