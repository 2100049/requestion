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
        <span class="bold">$row[AC_NAME]</span>
    </div>
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
    <span>カテゴリ : $row[CAT]</span>
    HTML;

    //タグ表示
    $tag = $pdo->prepare('SELECT * FROM TAG WHERE QUE_ID= ?');
    $tag->execute([$row['QUE_ID']]);

    echo '<form action="serch-result.php" method="POST">';
    echo '<span class="smtxt">タグ : ';

    foreach ($tag as $res){
        echo h($res['TAG']);
    }

    echo '</span>';
    echo '</form>';
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