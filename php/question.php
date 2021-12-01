<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>

<?php
//投稿フォーム処理
if (isset($_REQUEST['QUE'])){
    $time = date("[Y/m/d]H:i");

    $sql = $pdo->prepare('INSERT INTO QUESTION VALUES(NULL, ?, ?, ?, ?, ?)');
    if ($sql->execute([$_SESSION['ACCOUNT']['AC_ID'], $_REQUEST['QUE'], $_REQUEST['CAT_ID'], $_REQUEST['SPEED'], $time])){
        //QUE_IDの取得
        $sql = $pdo->prepare('SELECT * FROM QUESTION WHERE QUE_TIME=?');
        $sql->execute([$time]);

        foreach($sql as $row){
            $QUE_ID = $row['QUE_ID'];
        }
        
        //画像アップロード
        if (isset($_FILES['img'])){
            if (!file_exists('../img/QUEIMG')){
                mkdir('../img/QUEIMG');
            }

            for($i = 0; $i < count($_FILES["img"]["name"]); $i++){
                if(is_uploaded_file($_FILES["img"]["tmp_name"][$i])){

                    //質問ごとに画像フォルダ作成
                    if (!file_exists('../img/QUEIMG/'. $QUE_ID)){
                        mkdir('../img/QUEIMG/'. $QUE_ID);
                    }

                    $file = '../img/QUEIMG/'. $QUE_ID. '/'. $_FILES['img']['name'][$i];

                    if (move_uploaded_file($_FILES["img"]["tmp_name"][$i], $file)){
                        $sql = $pdo->prepare('INSERT INTO QUEIMG VALUES(NULL, ?, ?)');
                        $sql->execute([$QUE_ID, $file]);
                    }
                }
            }
        }
        header('Location:question-detail.php?QUE_ID='. $QUE_ID);
    }
    alert('投稿に失敗しました');
}

if (in()){
    echo <<<HTML
    <section class="mt-5">
        <div class="border bg-white shadow-sm mx-auto p-2" style="width: 700px;">
            <form onsubmit=" return text_chack(); " method="POST" enctype="multipart/form-data">
                <textarea id="textarea" class="form-control " name="QUE" placeholder="500文字以内で入力" rows="7" maxlength="500" required autofocus></textarea>

                <div class="input-group input-group-sm mt-2">
                    <select class="form-select" name="CAT_ID" required>
                        <option selected disabled value="">カテゴリ選択</option>
    HTML;
    foreach ($pdo->query('SELECT * FROM CATEGORY') as $row){
        echo "<option value=$row[CAT_ID]>$row[CAT]</option>";
    }

    echo <<<HTML
                    </select>

                    <select class="form-select" name="SPEED" required>
                        <option selected disabled value="">希望回答スピード選択</option>
                        <option value=0>なし</option>
                        <option value=1>とにかく早く回答が欲しい</option>
                        <option value=2>ゆっくり考えて回答が欲しい</option>
                        <option value=3>雑談</option>
                    </select>
                </div>

                <div class="input-group input-group-sm mt-2">
                    <input type="file" class="form-control" id="inputGroupFile02" name="img[]" value="画像" accept="image/*" multiple onChange="check();">
                    <label class="input-group-text" for="inputGroupFile02">画像</label>
                </div>
                <div class="text-end"><small class="text-danger">選択できる画像は3枚までです</small></div>

                <div class="d-grid gap-2">
                    <input type="submit" class="btn btn-primary btn-sm mt-2" value="質問を投稿" >
                </div>
            </form>
        </div>
    </section>
    HTML;
}else{
    login();
    // alert('投稿するにはログインしてください');
    // echo '<p><a href="index.php">トップページへ</a></p>';
    // echo '<p><a href="login.php">ログインページへ</a></p>';
}
?>

<?php require_once '../footer.php'; ?>

<script>
    function text_chack() {
        if($('#textarea').val().match(/^\s*$/)){
            alert('質問を入力してください！');
            return false;
        }
    };
</script>