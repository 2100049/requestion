<?php session_start(); ?>
<?php 
require_once '../function.php';
require_once '../header.php';
require_once '../nav.php'; 
if (isset($_REQUEST['QUE_ID'])){
    header('Location:question-detail.php?QUE_ID='. $_REQUEST['QUE_ID']);
}
$sql = $pdo->prepare(
  'SELECT * FROM QUESTION
  INNER JOIN CATEGORY USING (CAT_ID)
  INNER JOIN ACCOUNT USING (AC_ID)
  -- WHERE SPEED  = 1
  ORDER BY QUE_ID DESC
  LIMIT ?,10
  ');
// $sql2 = $pdo->prepare(
//   'SELECT * FROM QUESTION
//   INNER JOIN CATEGORY USING (CAT_ID)
//   INNER JOIN ACCOUNT USING (AC_ID)
//   -- WHERE SPEED  = 2
//   ORDER BY QUE_ID DESC
//   LIMIT ?,10
//   ');
// $sql3 = $pdo->prepare(
//   'SELECT * FROM QUESTION
//   INNER JOIN CATEGORY USING (CAT_ID)
//   INNER JOIN ACCOUNT USING (AC_ID)
//   -- WHERE SPEED  = 3
//   ORDER BY QUE_ID DESC
//   LIMIT ?,10
//   ');
if(isset($_GET['page'])){
  $start = 10 * ( $_GET['page'] - 1);
}else{
  $start = 0;
}
$sql->bindParam(1, $start, PDO::PARAM_INT);
$sql->execute();


$show_active1 = $show_active2 = $show_active3 = '';
$active1 = $active2 = $active3 = '';
if(isset($_GET['tab'])){
  if($_GET['tab'] == 1){
    $show_active1 = 'show active';
  }else if($_GET['tab'] == 2){
    $show_active2 = 'show active';
  }else if($_GET['tab'] == 3){
    $show_active3 = 'show active';
  }
}else {
  $show_active1 = 'show active';
  $active1 = 'active';
}
echo <<< HTML
<!-- ↓col-のサイズを変更することで横幅変更できます -->
<div class="btn-group nav mb-2 col-5 mx-auto " role="group" aria-label="Basic radio toggle button group"  id="nav-tab" role="tablist">
  <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
  <label class="btn btn-outline-danger {$active1}" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
    緊急！</label>
  <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
  <label class="btn btn-outline-secondary {$active2}" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
    慎重に！</label>
  <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
  <label class="btn btn-outline-dark {$active3}" id="nav-contact-tab" data-bs-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
    その他</label>
</div>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade {$show_active1}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    1</div>
  <div class="tab-pane fade {$show_active2}" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    2</div>
  <div class="tab-pane fade {$show_active3}" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
    3</div>
</div>
HTML;

foreach ($sql as $row){
  $QUE = omit(nl2br(h($row['QUE'])), 100);
  $img = $pdo -> prepare('SELECT user_icon FROM account WHERE AC_ID = ?');
  $img -> execute([$row['AC_ID']]);
  foreach ($img as $hoge) {
    if ($hoge['user_icon']){
      $meimg = "user-icon-images/". $hoge['user_icon'];
    } else {
      $defsrc = "user-icon-images/question.jpg";
      $meimg = $defsrc;
    }
  }
  if ($row['SPEED'] == 0){
      $this_speed = 'なし';
  }else if($row['SPEED'] == 1){
    $this_speed = 'とにかく早く回答が欲しい';
  }else if ($row['SPEED'] == 2){
    $this_speed = 'ゆっくり考えて回答が欲しい';
  }else{
    $this_speed = '雑談';
  }
  // 表示処理
  echo <<<HTML
  <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
    <div class="d-flex">
      <div class="text-center border-end p-2 ps-0" style="width: 20%;">
        <div><img src="$meimg" class="rounded-circle border border-2" style="width: 40px; height: 40px"></div>
        <div><span class="bold">$row[AC_NAME]</span></div>
      </div>
      <div class="p-2 pe-0" style="width: 100%;">
        <span class="ltext">{$QUE}</span>
        <div class="mt-5 text-secondary">
          <small>希望 : {$this_speed}
            <div class="text-end">$row[QUE_TIME]</div>
          </small>
        </div>
      </div>
    </div>
    <a href="question-detail.php?QUE_ID=$row[QUE_ID]" class="link"></a>
  </div>
HTML;
}
// 表示処理ここまで

//ページネーション(画面下のページナビ)
$sql = $pdo->query('SELECT * FROM QUESTION');
$count = $sql->rowCount();
$all_page = ceil($count / 10);  //ceil...小数点以下切り上げ
//現在のページを取得(なければ１)
$now_page = 1;
if (isset($_GET['page'])){
  $now_page = $_GET['page'];
}
//ページネーション表示数を7個に制限 要修正(?)
$min = $now_page - 3;
$max = $now_page + 3;
$if_max = 7;
if($all_page < 7){
  $if_max = $all_page;
}
if($now_page < 4){
  $min = 1;
  $max = $if_max;
}else if($now_page > $all_page - 3){
  $min = $all_page - 6;
  $max = $all_page;
}

echo <<<HTML
<nav aria-label="...">
  <div class="mx-auto">
    <ul class="pagination justify-content-center mt-5">
HTML;
      //「<<」の無効化処理
      if ($now_page == 1){
        echo <<<HTML
        <li class="page-item disabled">
          <span class="page-link">&laquo;</span>
        </li>
        HTML;
      }else{
      echo <<<HTML
      <li class="page-item">
        <a class="page-link" href="?page=1">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      HTML;
      }
      //ページネーションを表示
      for ($i = $min; $i <= $max; $i++){
        if ($now_page == $i){
          echo <<<HTML
          <li class="page-item active" aria-current="page">
            <span class="page-link">$i</span>
          </li>
          HTML;
        }else{
          echo <<< HTML
          <li class="page-item"><a class="page-link" href="?page=$i">$i</a></li>
          HTML;
        }
      }
      //「>>」の無効化処理
      if ($now_page == $all_page){
        echo <<<HTML
        <li class="page-item disabled">
          <span class="page-link">&raquo;</span>
        </li>
        HTML ;
      }else{
        echo <<<HTML
        <li class="page-item">
          <a class="page-link" href="?page={$all_page}">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
        HTML ;
      }
echo <<<HTML
    </ul>
  </div>
</nav>
HTML;

?>

<!--投稿フォーム-->
<!--
<form action="question.php" method="POST">
  <input type="hidden" name="question">
  <button type="submit" class="qicon"><i class="fas fa-pen fa-border"></i></button>
</form>
 -->
<a href="question.php"class="qicon"><i class="fas fa-pen fa-border"></i></a>

<?php require_once '../footer.php' ?>