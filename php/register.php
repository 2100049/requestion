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

<section class="contents mt-5">
    <div class="mx-auto border bg-light p-3" style="width: 500px;">
        <p class="tytle text-center">アカウント作成</p>

        <form class="m-5" method="POST">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">ユーザーID</label>
                <input type="text" class="form-control" name="AC_NAME" maxlength="15" required>
            </div>
    
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">パスワード</label>
                <input type="password" class="form-control" name="AC_PASS" maxlength="100" required>
            </div>
    
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="submit" class="btn btn-secondary btn-sm" value="作成">
            </div>
        </form>
    
        <p class="smtxt">
            ユーザーIDは5文字以上15文字以内<br>
            パスワードはスペースを含まない半角大文字、小文字、数字を含む8文字以上にしてください
        </p>

        <a href="login.php"><span class="smtxt">ログインページへ</span></a>
    </div>
</section>

<?php require '../footer.php'; ?>