<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>
<?php require_once '../nav.php'; ?>

<?php
$user_id = session_user_id();#セッションがあればアカウントIDを取得する自作関数。 
$link = GET();#URLGETアドレスを取得する自作関数

$select_user = 'SELECT * FROM account WHERE AC_ID=?';
$user = $pdo -> prepare($select_user);
$user->execute([$link]);
if(!$user = $user->fetch(PDO::FETCH_ASSOC)){
    #不正なリンクを入力された場合indexにジャンプ
    index();#indexへジャンプする自作関数
}
if($user_id != $user['AC_ID']){
    $select_check_follow = 'SELECT * FROM follow WHERE self_id = ? AND partner_id = ?';
    $check_follow = $pdo -> prepare($select_check_follow);
    $check_follow -> execute([$user_id , $user['AC_ID']]);
    if($check_follow->fetch(PDO::FETCH_ASSOC)){
        $checked = 'checked';
    }else{
        $checked = '';
    }
}

if($user_id == $user['AC_ID']){
    $select_follow = 'SELECT * FROM follow WHERE self_id = ? ';
    $follow = $pdo -> prepare($select_follow);
    $follow -> execute([$user_id]);
    $follow_count = $follow -> rowCount();

    $select_follower = 'SELECT * FROM follow WHERE partner_id = ? ';
    $follower = $pdo -> prepare($select_follower);
    $follower -> execute([$user_id]);
    $follower_count = $follower -> rowCount();
}

$select_questions ='SELECT * FROM question WHERE AC_ID =? ORDER BY QUE_ID DESC';
$questions = $pdo->prepare($select_questions);
$questions -> execute([$user['AC_ID']]);
$questions_count = $questions -> rowCount();

$select_answers ='SELECT * FROM answer WHERE AC_ID =? ORDER BY ANS_ID DESC';
$answers = $pdo->prepare($select_answers);
$answers -> execute([$user['AC_ID']]);
$answers_count =  $answers -> rowCount();

$select_rate = 'SELECT RATE FROM answer WHERE RATE = 1 AND AC_ID = ? ';
$rate_count = $pdo -> prepare($select_rate);
$rate_count -> execute([$user['AC_ID']]);
$answers_rate_count = $rate_count -> rowCount();

if ($user['self_introduction']){
    $self_introduction = $user['self_introduction'];
} else {
    $self_introduction = '自己紹介は設定されていません';
}

    #上定義 下表示

echo <<<HTML
<div class="profilecontentsbox mx-auto d-flex">
    <div class="profilebox">
        <div class="border bg-white shadow-sm p-2">
HTML;

if($user_id != $user['AC_ID'] && $user_id){
    echo <<< HTML
        <input type="checkbox" id="followercheck" name="follower" value="$user[AC_ID]" $checked>
        <label for="followercheck">フォロー</label>
    HTML;
}

echo '<div class="text-center">';
echo '<p><img src="user-icon-images/';
if($user['user_icon']){
    echo $user['user_icon'];
}else{
    echo 'question.jpg';
}
echo '" class="icon border shadow-sm" style="width: 180px; height: 180px"></p>';

echo <<<HTML
                <h3>$user[AC_NAME]</h3>
HTML;

if($user_id == $user['AC_ID']){
    echo <<< HTML
    <a href="follow_follower_view.php">
        フォロー数:$follow_count フォロワー数:$follower_count
    </a>
    HTML;
}

echo <<<HTML
                <div class="mt-5">
                    <small>質問数:$questions_count 回答数:$answers_count</small><br>
                    <small>回答に高評価がついた数:$answers_rate_count</small><br>
                    <small class="text-secondary">アカウント作成日:$user[timecreated_at]</small>
                </div>
            </div>
        </div>

        <div class="introbox border bg-white shadow-sm mt-2 p-2">
            <h6>自己紹介:</h6>
            $self_introduction
        </div>
HTML;

if($user_id == $user['AC_ID']){
    echo <<< HTML
    <div class="d-grid gap-2 fixed-bottom" style="position: absolute;"><a type="button" class="btn btn-primary btn-sm" href="profile-input.php">プロフィールを更新する</a></div>
    HTML;
}

echo <<<HTML
    </div>
    
    <div class="historybox border bg-white shadow-sm ms-2 p-2">
        <ul class="nav nav-tabs" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#question" role="tab" aria-controls="pills-home" aria-selected="true">質問</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#answer" role="tab" aria-controls="pills-profile" aria-selected="false">回答</a>
            </li>
    HTML;

    if ($link == $user_id){
        echo <<<HTML
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#quefav" role="tab" aria-controls="pills-contact" aria-selected="false">ブックマーク</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#catfav" role="tab" aria-controls="pills-contact" aria-selected="false">お気に入りカテゴリ</a>
            </li>
        HTML;
    }

    echo <<<HTML
        </ul>

        <div class="historylist">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="pills-home-tab">
    HTML;

                        if ($questions_count) {
                            echo <<<HTML
                            <ul class="list-group list-group-flush text-center">
                            HTML;

                            foreach($questions as $row){
                                $QUE = omit($row['QUE'], 60);
                                echo <<<HTML
                                <li class="list-group-item pt-3 pb-3">
                                    <a href="question-detail.php?QUE_ID=$row[QUE_ID]">$QUE</a>
                                </li>
                                HTML;
                            }

                            echo <<<HTML
                            </ul>
                            HTML;
                        } else {
                            echo '<p class="questions">質問はありません</p>';
                        }

                    echo<<< HTML
                    </div>
                    <div class="tab-pane fade" id="answer" role="tabpanel" aria-labelledby="pills-profile-tab">
                    HTML;

                        if ($answers_count) {
                            echo <<<HTML
                            <ul class="list-group list-group-flush text-center">
                            HTML;

                            foreach($answers as $row){
                                $ANS = omit($row['ANS'], 60);
                                echo <<<HTML
                                <li class="list-group-item pt-3 pb-3">
                                <a href="question-detail.php?QUE_ID=$row[QUE_ID]">$ANS</a>
                                </li>
                                HTML;
                            }

                            echo <<<HTML
                            </ul>
                            HTML;
                        } else {
                            echo '<p class="answers">回答はありません</p>';
                        }

                    echo<<<HTML
                    </div>
                    <div class="tab-pane fade" id="quefav" role="tabpanel" aria-labelledby="pills-contact-tab">
                    HTML;

                    //ブックマーク処理
                    if (in()){
                        $sql = $pdo->prepare(
                        'SELECT * FROM BMQUE
                        INNER JOIN QUESTION USING (QUE_ID)
                        WHERE bmque.AC_ID = ?
                        ORDER BY bmque.BMQUE_ID DESC
                        ');
                        $sql -> execute([$_SESSION['ACCOUNT']['AC_ID']]);

                        $bmcount = $sql -> rowCount();
                        if ($bmcount){
                            echo <<<HTML
                            <ul class="list-group list-group-flush text-center">
                            HTML;

                            foreach($sql as $row){
                                $QUE = omit($row['QUE'], 60);
                                echo <<<HTML
                                <li class="list-group-item pt-3 pb-3">
                                    <a href="question-detail.php?QUE_ID=$row[QUE_ID]">$QUE</a>
                                </li>
                                HTML;
                            }

                            echo <<<HTML
                            </ul>
                            HTML;
                        }else{
                            echo '<p class="questions">ブックマークはありません</p>';
                        }
                    }

                    echo <<< HTML
                    </div>
                    <div class="tab-pane fade" id="catfav" role="tabpanel" aria-labelledby="pills-contact-tab">
                    HTML;

                    //お気に入りカテゴリ処理
                    if (in()){
                        $sql = $pdo->prepare('
                        SELECT * FROM BMCATEGORY
                        INNER JOIN category USING (CAT_ID)
                        WHERE AC_ID = ?
                        ORDER BY CAT_ID DESC
                        ');
                        $sql -> execute([$_SESSION['ACCOUNT']['AC_ID']]);
                    
                        $bmcount = $sql -> rowCount();
                        if ($bmcount){
                            echo <<<HTML
                            <ul class="list-group list-group-flush text-center">
                            HTML;

                            foreach ($sql as $row){
                                echo <<<HTML
                                <li class="list-group-item pt-3 pb-3">
                                    <form action="serch-result.php" method="POST" class="bmcat">
                                        <input type="hidden" name="CAT_ID" value="$row[CAT_ID]">
                                        <input class="submitlink" type="submit" value="$row[CAT]">
                                    </form>
                                </li>
                                HTML;
                            }

                            echo <<<HTML
                            </ul>
                            HTML;
                        }else{
                            echo '<p class="questions">お気に入りカテゴリはありません<p>';
                        }
                    }
                    
                    echo <<<HTML
                </div>
            </div>
        </div>
    </div>
</div>
HTML;
?>

<?php require_once '../footer.php'; ?>