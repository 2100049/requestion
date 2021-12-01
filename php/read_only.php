<?php
session_start();
#accountチェック用関数です。
function session_user_id(){
  if(isset($_SESSION['ACCOUNT'])){
      return $_SESSION['ACCOUNT']['AC_ID'];
  }
}
$me = session_user_id();

$partner = json_decode($_REQUEST['fragment']);
// $partner = 1;

$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
$sql = $pdo -> prepare('SELECT * FROM chat WHERE (self_id = ? AND partner_id = ?) OR (self_id = ? AND partner_id = ?) ');
$sql -> execute([$me, $partner, $partner, $me]);

$defsrc = "user-icon-images/question.jpg";
$img = $pdo -> prepare('SELECT user_icon FROM account WHERE AC_ID = ?');
$img -> execute([$partner]);
foreach ($img as $hoge) {
  if ($hoge['user_icon']){
    $partnerimg = "user-icon-images/". $hoge['user_icon'];
  } else {
    $partnerimg = $defsrc;
  }
}

$img -> execute([$me]);
foreach ($img as $hoge) {
  if ($hoge['user_icon']){
    $meimg = "user-icon-images/". $hoge['user_icon'];
  } else {
    $meimg = $defsrc;
  }
}

foreach($sql as $row){
  $row['chat'] = nl2br($row['chat']);
  if($row['self_id'] == $me){
    echo <<< HTML
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <div class="mychat border rounded m-2 p-2" style="max-width: 400px; overflow-wrap: break-word">
          $row[chat]
      </div>
    <img src=$meimg class="icon border border-2 mt-2 me-2" style="width: 40px; height: 40px">
    HTML;
  }else if($row['self_id'] == $partner){
    echo <<< HTML
    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
      <img src=$partnerimg class="icon border border-2 mt-2 ms-2" style="width: 40px; height: 40px">
      <div class="border rounded bg-light m-2 p-2" style="max-width: 400px; overflow-wrap: break-word">
          $row[chat]
      </div>
    HTML;
  }
  echo '</div>';
}

//   header("Content-type: application/json; charset=UTF-8");
//   echo json_encode($data);
  exit;
?>