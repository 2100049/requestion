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
<div class="text-center border-end p-2 ps-0" style="width: 20%;">
    <div><img src="$meimg" class="rounded-circle border border-2" style="width: 40px; height: 40px"></div>
    <div>
        <span class="bold">$row[AC_NAME]</span>
    </div>
</div>
HTML;

echo <<<HTML
<div class="p-2 pe-0" style="width: 100%;">
    <span class="ltext">$QUE</span>
HTML;

//希望表示
echo '<div class="mt-5 text-secondary">';
echo '<small>希望 : ';
if ($row['SPEED'] == 0){
    echo 'なし';
}else if($row['SPEED'] == 1){
    echo 'とにかく早く回答が欲しい';
}else if ($row['SPEED'] == 2){
    echo 'ゆっくり考えて回答が欲しい';
}else{
    echo '雑談';
}

//時間表示
echo <<<HTML
            <div class="text-end">$row[QUE_TIME]</div>
            </small>
        </div>
    </div>
</div>
HTML;
?>