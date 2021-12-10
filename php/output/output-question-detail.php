<?php
$defsrc = "user-icon-images/question.jpg";
$img = $pdo -> prepare('SELECT user_icon FROM account WHERE AC_ID = ?');
$img -> execute([$row['AC_ID']]);
foreach ($img as $hoge) {
  if ($hoge['user_icon']){
    $meimg = "user-icon-images/". $hoge['user_icon'];
  } else {
    $meimg = $defsrc;
  }
}

echo <<<HTML
<div class="d-flex">
    <div><img src="$meimg" class="rounded-circle border border-2" style="width: 40px; height: 40px"></div>
    <div class="p-1">
        <a href="profile-view.php?$row[AC_ID]">
            <span class="bold">$row[AC_NAME]</span>
        </a>
    </div>
HTML;

if (in()){
    //お気に入りフォーム
    $QUE_ID = $_GET['QUE_ID'];
    $bm = $pdo->prepare('SELECT * from bmque WHERE ac_id=? AND que_id=?');
    $bm ->execute([$_SESSION['ACCOUNT']['AC_ID'], $QUE_ID]);
    if($bm->fetch(PDO::FETCH_ASSOC)){
        $checked = 'checked';
        $yellow = 'yellow';
    }else{
        $checked = '';
        $yellow = '';
    }

    echo <<<HTML
    <div style="width: 100%;">
        <div class="form-check text-end">
            <input class="form-check-input" type="checkbox" id="quebm" name="quebm" value="$QUE_ID" $checked style="display: none;">
            <label class="form-check-label" for="quebm">
            <i id="star" class="fin fas fa-star bookmark $yellow" title="ブックマーク"></i>
            </label>
        </div>
    </div>
    HTML;
}

echo <<<HTML
</div>

<div class="mx-auto mt-3 mb-3" style="width: 600px;"><span class="ltext">$QUE</span></div>
HTML;

//画像表示
if (isset($_GET['QUE_ID'])){
    if (file_exists('../img/QUEIMG/'. $row['QUE_ID'])){
        $images = glob('../img/QUEIMG/'. $row['QUE_ID']. '/*');
        echo '<div class="text-center">';
        foreach($images as $path) {
            echo '<a href="'. $path.'" data-lightbox="QUEIMG"><img src="', $path, '" class="m-2" style="max-width: 500px; max-height: 300px"></a>';
        }
        echo '</div>';
    }
}

if (isset($_GET['QUE_ID'])){
    //カテゴリ表示
    echo <<<HTML
    <div class="mt-5">
    <form action="serch-result.php" method="POST">
        <span>カテゴリ : </span>
        <input type="hidden" name="CAT_ID" value="$row[CAT_ID]">
        <input type="submit" value="$row[CAT]" class="submitlink">
    </form>
    
    <input id="queid" type="hidden" name="QUE_ID" value="$_GET[QUE_ID]">
    <div id="showtag"></div>
    HTML;

    // //タグ表示
    // $tag = $pdo->prepare('SELECT * FROM TAG WHERE QUE_ID= ?');
    // $tag->execute([$row['QUE_ID']]);

    // echo '<form action="serch-result.php" method="POST">';
    // echo '<span class="smtxt">タグ : ';

    // foreach ($tag as $res){
    //     echo '<input class="submitlink" type="submit" name="TAG" value="', h($res['TAG']), '">, ';
    // }

    // echo '</span>';
    // echo '</form>';
}

//希望表示
echo '<div>';
echo '希望 : ';
if ($row['SPEED'] == 0){
    echo 'なし';
}else if($row['SPEED'] == 1){
    echo 'とにかく早く回答が欲しい';
}else if ($row['SPEED'] == 2){
    echo 'ゆっくり考えて回答が欲しい';
}else{
    echo '雑談';
}
echo '</div>';

//時間表示
echo <<<HTML
    <div class="text-end text-secondary"><small>$row[QUE_TIME]</small></div>
</div>
HTML;
?>
