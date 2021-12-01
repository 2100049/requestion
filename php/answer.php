<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>

<?php
if (isset($_REQUEST['ANS'])){   //回答フォーム処理
    $time = date("[Y/m/d]H:i");

    $sql = $pdo->prepare('INSERT INTO ANSWER VALUES(NULL, ?, ?, ?, ?, ?)');
    if ($sql->execute([$_GET['QUE_ID'], $_SESSION['ACCOUNT']['AC_ID'], $_REQUEST['ANS'], 0, $time])){
        //ANS_IDの取得
        $sql = $pdo->prepare('SELECT * FROM ANSWER WHERE ANS_TIME=?');
        $sql->execute([$time]);

        foreach($sql as $row){
            $ANS_ID = $row['ANS_ID'];
            $QUE_ID = $row['QUE_ID'];
        }

				//画像アップロード
        if (isset($_FILES['img'])){
            if (!file_exists('../img/ANSIMG')){
                mkdir('../img/ANSIMG');
            }

            for($i = 0; $i < count($_FILES["img"]["name"]); $i++){
                if(is_uploaded_file($_FILES["img"]["tmp_name"][$i])){
                    //質問ごとに画像フォルダ作成
                    if (!file_exists('../img/ANSIMG/'. $ANS_ID)){
                        mkdir('../img/ANSIMG/'. $ANS_ID);
                    }

                    $file = '../img/ANSIMG/'. $ANS_ID. '/'. $_FILES['img']['name'][$i];

                    if (move_uploaded_file($_FILES["img"]["tmp_name"][$i], $file)){
                        $sql = $pdo->prepare('INSERT INTO ANSIMG VALUES(NULL, ?, ?)');
                        $sql->execute([$ANS_ID, $file]);
                    }
                }
            }
        }
        // 通知インサート
        $question_user = $pdo -> prepare('SELECT AC_ID FROM QUESTION WHERE QUE_ID = ?');
        $question_user -> execute ([$QUE_ID]);
        $question_user = $question_user -> fetch( PDO::FETCH_ASSOC);
        $notif = $pdo -> prepare('INSERT INTO ANSWER_notification(AC_ID,  ANS_ID) VALUES(?,  ?)');
        $notif -> execute([$question_user['AC_ID'] , $ANS_ID]);
        header('Location:question-detail.php?QUE_ID='. $QUE_ID);
    }
    alert('投稿に失敗しました');
}

if (in()){
    //投稿表示
    $sql = $pdo->prepare('
    SELECT * FROM QUESTION
    INNER JOIN CATEGORY USING (CAT_ID)
    INNER JOIN ACCOUNT USING (AC_ID)
    WHERE QUE_ID = ?
    ');
    $sql->execute([$_GET['QUE_ID']]);

    foreach ($sql as $row){
        echo <<<HTML
        <div class="mx-auto mb-3 p-2 border bg-white shadow-sm mt-5" style="width: 700px">
        HTML;

        $QUE = nl2br(h($row['QUE']));

        require 'output/output-question-answer.php';

        echo <<<HTML
        </div>
        HTML;
    }

    echo <<<HTML
    <div class="border bg-white shadow-sm mx-auto p-2" style="width: 700px;">
        <form method="POST" enctype="multipart/form-data">
            <textarea id="textarea" class="form-control " name="ANS" placeholder="500文字以内で入力" rows="5" maxlength="500" required></textarea>

            <div class="input-group input-group-sm mt-2">
                <input type="file" class="form-control" id="inputGroupFile02" name="img[]" value="画像" accept="image/*" multiple onChange="check();">
                <label class="input-group-text" for="inputGroupFile02">画像</label>
            </div>
            <div class="text-end"><small class="text-danger">選択できる画像は3枚までです</small></div>

            <div class="d-grid gap-2">
                <input type="submit" class="btn btn-primary btn-sm mt-2" value="回答を投稿" >
            </div>
        </form>
    </div>
    HTML;
}else{
    login();
    // alert('回答するにはログインしてください');
    // echo '<p><a href="index.php">トップページへ</a></p>';
    // echo '<p><a href="login.php">ログインページへ</a></p>';
}
?>

<?php require_once '../footer.php'; ?>