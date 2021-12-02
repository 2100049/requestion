<?php
//返信数取得
$res = $pdo->prepare(
'SELECT * FROM response
INNER JOIN answer USING (ANS_ID)
WHERE ANS_ID=?
');
$res->execute([$row['ANS_ID']]);
$count = $res->rowcount();

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
    <div class="p-1 userlink">
        <a href="profile-view.php?$row[AC_ID]">
            <span class="bold">$row[AC_NAME]</span>
        </a>
    </div>
    <div style="width: 100%;">
        <div class="text-end"><small><i class="fas fa-angle-double-down"></i>返信数 : $count</small></div>
    </div>
</div>
HTML;


echo <<<HTML
<div class="mx-auto mt-3 mb-3" style="width: 600px;">$ANS</div>
HTML;

//画像表示
if (file_exists('../img/ANSIMG/'. $row['ANS_ID'])){
    $images = glob('../img/ANSIMG/'. $row['ANS_ID']. '/*');
    echo '<div class="text-center">';
    foreach($images as $path) {
        echo '<a href="'. $path.'" data-lightbox="ANSIMG"><img src="', $path, '" class="m-2" style="max-width: 500px; max-height: 300px"></a>';
    }
    echo '</div>';
}

//評価表示
echo '<div class="mt-2 text-end rate">';
if ($row['RATE'] == 0){
    if (in()){
        if ($_SESSION['ACCOUNT']['AC_ID'] == $quer){   //投稿者には評価フォーム表示
            //評価フォーム
            echo <<<HTML
            <form method="POST">
                <input type="hidden" name="ANS_ID" value="$row[ANS_ID]">
                <button type="submit" class="btn btn-link" name="rate" value="GOOD"><i class="fas fa-thumbs-up good blue"></i></button>
                <button type="submit" class="btn btn-link" name="rate" value="BAD"><i class="fas fa-thumbs-down bad red"></i></button>
            </form>
            HTML;
        }else{
            echo '評価 : 未';
        }
    }else{
        echo '評価 : 未';
    }
}else if ($row['RATE'] == 1){
    echo '評価 : <i class="fas fa-thumbs-up blue"></i>';
}else{
    echo '評価 : <i class="fas fa-thumbs-down red"></i>';
}

echo <<<HTML
    </div>
    <div class="text-end text-secondary"><small>$row[ANS_TIME]</small></div>
HTML;
?>