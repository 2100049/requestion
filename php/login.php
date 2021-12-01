<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>

<?php
if (isset($_REQUEST['AC_NAME'])){
    unset($_SESSION['ACCOUNT']);

    $sql=$pdo->prepare('SELECT * FROM ACCOUNT WHERE AC_NAME=? AND BINARY AC_PASS=?');
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

<section class="contents mt-5">
    <div class="mx-auto border bg-light p-3" style="width: 500px;">
        <p class="tytle text-center">ログイン</p>

        <form class="m-5" method="POST">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">ユーザーID</label>
                <input type="text" class="form-control" name="AC_NAME" value="<?= $AC_NAME ?>" maxlength="15" required autofocus>
            </div>
    
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">パスワード</label>
                <input type="password" class="form-control" name="AC_PASS" value="<?= $AC_PASS ?>" maxlength="100" required>
            </div>
    
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="submit" class="btn btn-secondary btn-sm" id="btn" value="ログイン">
            </div>
        </form>
    
        <a href="register.php"><span class="smtxt">アカウントを作成する</span></a>
    </div>
</section>

<?php require_once '../footer.php' ?>