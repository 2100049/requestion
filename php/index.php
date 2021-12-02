<?php session_start(); ?>
<?php 
require_once '../function.php';
 require_once '../header.php';
 require_once '../nav.php'; 
 ?>

<?php
//表示フォーム処理
if (isset($_REQUEST['QUE_ID'])){
    header('Location:question-detail.php?QUE_ID='. $_REQUEST['QUE_ID']);
  }
  //投稿表示
  $sql = $pdo->prepare(
    'SELECT * FROM QUESTION
    INNER JOIN CATEGORY USING (CAT_ID)
    INNER JOIN ACCOUNT USING (AC_ID)
    ORDER BY QUE_ID DESC
    LIMIT ?,10
');
if (isset($_GET['page'])){
  $page = $_GET['page'];
  $start = 10 * ($page - 1);
  $sql->bindParam(1, $start, PDO::PARAM_INT);
  $sql->execute();
}else{
  $start = 0;
  $sql->bindParam(1, $start, PDO::PARAM_INT);
  $sql->execute();
}

?>
<!-- ↓col-のサイズを変更することで横幅変更できます -->
<div class="btn-group nav mb-2 col-5 mx-auto " role="group" aria-label="Basic radio toggle button group"  id="nav-tab" role="tablist">
  <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
  <label class="btn btn-outline-danger  active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">緊急！</label>
  <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
  <label class="btn btn-outline-secondary " id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">慎重に！</label>
  <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
  <label class="btn btn-outline-dark " id="nav-contact-tab" data-bs-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">その他</label>
</div>

<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">1</div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">2</div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">3</div>
</div>


<?php
foreach ($sql as $row){
  $QUE = omit(nl2br(h($row['QUE'])), 100);

  echo <<<HTML
  <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
  HTML;  
  require 'output/output-question-index.php';
  echo <<<HTML
    <a href="question-detail.php?QUE_ID=$row[QUE_ID]" class="link"></a>
  </div>
  HTML;
  }
    
//ページネーション(画面下のページナビ)
$sql = $pdo->query('SELECT * FROM QUESTION');
$count = $sql->rowCount();
    
$page = ceil($count / 10);  //ceil...小数点以下切り上げ

require 'form/form-pagination.php';
?>

<!--投稿フォーム-->
<!-- <form action="question.php" method="POST">
    <input type="hidden" name="question">
    <button type="submit" class="qicon"><i class="fas fa-pen fa-border"></i></button>
</form> -->
<a href="question.php"class="qicon"><i class="fas fa-pen fa-border"></i></a>

<?php require_once '../footer.php' ?>