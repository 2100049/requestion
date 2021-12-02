<!-- カテゴリのやつが決まるまで保留 -->
<?php
session_start(); 
require_once '../function.php';
require_once '../header.php'; 
if(!in()){
  login();
}
if(empty($_REQUEST['tmp'])){
  index();
}
$user_id = session_user_id();
$user_name = session_user_name();
$img = $pdo -> prepare('SELECT user_icon FROM account WHERE AC_ID = ?');
$img -> execute([$user_id]);
$defsrc = "user-icon-images/question.jpg";
foreach ($img as $hoge) {
  if ($hoge['user_icon']){
    $meimg = "user-icon-images/". $hoge['user_icon'];
  } else {
    $meimg = $defsrc;
  }
}

// echo <<< HTML
// <img src="$imginfo['mime']" class="m-2" style="max-width: 500px; max-height: 300px">
// HTML;
$QUE = $_POST['QUE'];
echo <<< HTML
<p>投稿内容が間違いなければ　はいを押してください。</p>
<div class="mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
  <div class="d-flex">
    <div><img src="$meimg" class="rounded-circle border border-2" style="width: 40px; height: 40px"></div>
    <div class="p-1">
      <span class="bold">$user_name</span>
      <div class="mx-auto mt-3 mb-3" style="width: 600px;"><span class="ltext">$QUE</span></div>      
        <div class="text-center">
HTML;
          if (!empty($_FILES['img']['name'][0])){
            for($i = 0; $i < count($_FILES["img"]["name"]); $i++){
              $fp = fopen($_FILES['img']['tmp_name'][$i], "rb");
              $img = fread($fp, filesize($_FILES['img']['tmp_name'][$i]));
              fclose($fp);
              $enc_img = base64_encode($img);
              $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
              echo <<< HTML
            <a href="" data-lightbox="QUEIMG">
              <img src="data:$imginfo[mime];base64,$enc_img"  class="m-2" style="max-width: 500px; max-height: 300px">
            </a>  
            HTML;
            }
          }
      echo <<< HTML
      </div>
    </div>
  </div>
</div>  
HTML;
?>


<?php require_once '../footer.php' ?>