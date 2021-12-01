<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>
<?php require_once '../nav.php'; ?>

<?php
$user_id = session_user_id();#セッションがあればアカウントIDを取得する自作関数。 

$select_follow = 'SELECT * FROM follow INNER JOIN account ON follow.partner_id = account.ac_id WHERE self_id = ?';
$follow = $pdo -> prepare($select_follow);
$follow -> execute([$user_id]);
$followcnt = $follow -> rowCount();

$select_follower = 'SELECT * FROM follow INNER JOIN account ON follow.self_id = account.ac_id WHERE partner_id = ? ';
$follower = $pdo -> prepare($select_follower);
$follower -> execute([$user_id]);
$followercnt = $follower -> rowCount();

echo <<< HTML
<div class="friendbox bg-white border shadow-sm mx-auto p-2">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#follow" role="tab" aria-controls="nav-home" aria-selected="true">フォロー</a>
            <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#follower"role="tab" aria-controls="nav-profile" aria-selected="false">フォロワー</a>
        </div>
    </nav>
    
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="follow" role="tabpanel" aria-labelledby="nav-home-tab">
HTML;

if($followcnt){
    echo <<<HTML
    <ul class="list-group list-group-flush text-center">
    HTML;

    foreach($follow as $row){
        echo<<<HTML
        <li class="list-group-item pt-3 pb-3">
            <a href="profile-view.php?$row[AC_ID]" >$row[AC_NAME] さん</a>
        </li>
        HTML;
    }

    echo <<<HTML
    </ul>
    HTML;
} else {
    echo <<<HTML
    フォローしているユーザーはいません
    HTML;
}

echo <<< HTML
</div>

<div class="tab-pane fade" id="follower" role="tabpanel" aria-labelledby="nav-profile-tab">
HTML;

if($followercnt){
    echo <<<HTML
    <ul class="list-group list-group-flush text-center">
    HTML;

    foreach($follower as $row){
    echo <<< HTML
        <li class="list-group-item pt-3 pb-3">
            <a href="profile-view.php?$row[AC_ID]">$row[AC_NAME] さん</a>
        </li>
    HTML;
    }

    echo <<<HTML
    </ul>
    HTML;
} else {
    echo <<<HTML
    フォローしているユーザーはいません
    HTML;
}

echo <<< HTML
        </div>
    </div>
</div>
HTML;
?>

<?php require_once '../footer.php'; ?>
