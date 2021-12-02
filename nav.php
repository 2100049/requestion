<?php
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');

$notif = $pdo -> prepare(
    'SELECT * FROM 
    (SELECT AC_ID, is_read FROM ANSWER_notification UNION SELECT AC_ID, is_read FROM RESPONSE_notification) AS A 
    WHERE  A.is_read IS NULL AND AC_ID = ?
    ');
$notif -> execute([session_user_id()]);
if($notif -> fetch(PDO::FETCH_ASSOC)){
    $new_all = 'new';
}else {
    $new_all = '';
}

if(!$me_name = session_user_name()){
    $me_name = '';
}
if($me_id = session_user_id()){
}
$notif_chat = $pdo ->prepare('SELECT * FROM chat_notification WHERE self_id = ?');
$notif_chat->execute([$me_id]);
if($notif_chat->rowCount()){
    $chat_new = "nwe";
  }else{
    $chat_new = "";
  }

?>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom mb-5">
    <div class="container-fluid">
        <div class="navbar-brand">
        <a class="nav-link <?php if (nowp('/requestion/php/index.php')){echo 'active';} ?>" aria-current="page" href="index.php">    
            <img src="../img/logo.svg" alt="ロゴ" height="30">
        </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto me-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php if (nowp('/requestion/php/index.php')){echo 'active';} ?>" aria-current="page" href="index.php">ホーム</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if (nowp('/requestion/php/profile-view.php')){echo 'active';} ?>" href="
                        <?php
                        if (isset($_SESSION['ACCOUNT']['AC_ID'])){
                            echo 'profile-view.php?'. $_SESSION['ACCOUNT']['AC_ID'];
                        }else{
                            echo 'login-induction.html';
                        }
                        ?>
                        ">プロフィール</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php if (nowp('/requestion/php/catlist.php')){echo 'active';} ?>" href="catlist.php">
                    カテゴリ一覧
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (nowp('/requestion/php/chat.php')){echo 'active';} ?>" href="chat.php">
                    チャット <span class="position-absolute translate-middle badge rounded-pill bg-secondary"><?=$chat_new?></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if (nowp('/requestion/php/all_notification.php')){echo 'active';} ?>" href="all_notification.php">
                        通知
                        <span class="badge bg-dark"><?=$new_all;?></span>
                    </a>
                </li>
                

                <li class="nav-item">
                    <?php
                    if (in()){
                        echo <<< HTML
                        <div class="nav-link fin" 
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                         onclick="mod_link('$me_name さん<br>本当にログアウトしますか？','logout.php')">
                            ログアウト
                        </div>
                        HTML;
                    }else{
                        echo '<a class="nav-link" href="login.php">ログイン</a>';
                    }
                    ?>
                </li>
            </ul>
            <span class="navbar-text">
                <form action="serch-result.php" method="POST">
                    <div class="input-group input-group-sm mx-auto" style="width: 500px">
                        <input type="text" class="form-control" id="serch" name="serchkey" placeholder="キーワードを入力" required>
                        <button type="submit" class="btn btn-secondary">検索</button>
                    </div>
                </form>
            </span>
        </div>
    </div>
</nav>