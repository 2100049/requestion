<?php
$flg = 0;
$RES = nl2br(h($tmp['RES']));  //特殊文字無効、改行を維持

$defsrc = "user-icon-images/question.jpg";
$img = $pdo -> prepare('SELECT user_icon FROM account WHERE AC_ID = ?');
$img -> execute([$tmp['AC_ID']]);
foreach ($img as $hoge) {
  if ($hoge['user_icon']){
    $meimg = "user-icon-images/". $hoge['user_icon'];
  } else {
    $meimg = $defsrc;
  }
}

echo <<<HTML
<div>
    <div class="ms-2 ps-2 border-start border-3">
HTML;

echo <<<HTML
<div class="d-flex">
    <div><img src="$meimg" class="rounded-circle border border-2" style="width: 40px; height: 40px"></div>
    <div class="p-1">
        <a href="profile-view.php?$row[AC_ID]">
            <span class="bold">$tmp[AC_NAME]</span>
        </a>
    </div>
</div>
HTML;

echo <<<HTML
    <div class="mx-auto mt-3 mb-3" style="width: 600px;">$RES</div>
    <div class="text-end text-secondary"><small>$tmp[RES_TIME]</small></div>
HTML;

//返信削除
if (in()){
    if ($_SESSION['ACCOUNT']['AC_ID'] == $tmp['AC_ID']){
        echo <<< HTML
        <div class="gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-outline-danger btn-sm" type="button" title="返信を削除"
                data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                onclick="mod_link('本当に削除しますか?','delete/delete-response.php?RES_ID=$tmp[RES_ID]')">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
        HTML;
    }
}
echo '</div>';
echo '</div>';
?>