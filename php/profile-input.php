<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>
<?php require_once '../nav.php'; ?>

<?php 
    $user_name = session_user_name(); #セッションがあればアカウントnameを取得する自作関数
    $select_user = 'SELECT * FROM ACCOUNT WHERE AC_NAME=?';
    $user = $pdo -> prepare($select_user);
    $user->execute([$user_name]);
    $user = $user->fetch(PDO::FETCH_ASSOC);
        if(isset($user['user_icon'])){
            $img = "user-icon-images/".$user['user_icon'];
        } else {
            $img = "user-icon-images/question.jpg";
        }

        #上定義下処理
        echo <<< HTML
        <form action="profile-output.php" method="post" enctype="multipart/form-data">
            <div class="profilecontentsbox mx-auto d-flex" style="min-height: 350px;">
                <div class="profilebox border bg-white shadow-sm p-2 text-center">
                    <label for="icon">
                        <img id="img" class="icon border shadow-sm" src="$img" style="width: 180px; height: 180px">
                    </label>
        HTML;

        if($user['user_icon']){
            echo <<< HTML
                    <input type="submit" class="btn btn-outline-danger btn-sm mt-2" name="update" value="画像を削除する" >
            HTML;
        }

        echo <<<HTML
                    <div class="d-grid fixed-bottom m-2" style="position: absolute;">
                        <div class="input-group input-group-sm">
                            <input type="file" class="form-control" name="icon" id="icon">
                            <label class="input-group-text" for="icon">画像</label>
                        </div>
    
                        <div class="input-group input-group-sm mt-2">
                            <span class="input-group-text" id="basic-addon1">ユーザ名</span>
                            <input type="text" class="form-control" name="name" value="$user[AC_NAME]" placeholder="5~15文字" minlength="5" maxlength="15" required>
                        </div>
                        <input class="btn btn-primary btn-sm mt-2" type="submit" name="update" value="プロフィールを更新する">
                    </div>
                </div>

                <div class="historybox border bg-white shadow-sm ms-2 p-2">
                    <h6>自己紹介:</h6>
                    <textarea id="intro" name="self_introduction" class="form-control" placeholder="500文字以内" maxlength="500" style="max-height: 350px" autofocus>$user[self_introduction]</textarea>
                </div>
            </div>
        </form>
        
        HTML;
?>

<?php require_once '../footer.php'; ?>