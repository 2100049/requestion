<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>
<?php require_once '../nav.php'; ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Larry the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>
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
echo <<< HTML
<div class="text-center mb-2">
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
        <label class="btn btn-outline-danger" for="btnradio1">緊急！</label>

        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
        <label class="btn btn-outline-secondary" for="btnradio2">慎重に！</label>

        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
        <label class="btn btn-outline-dark " for="btnradio3">その他</label>
    </div>
</div>
HTML;
foreach ($sql as $row){
    echo <<<HTML
    <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
    HTML;

    $QUE = omit(nl2br(h($row['QUE'])), 100);

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
<form action="question.php" method="POST">
    <input type="hidden" name="question">
    <button type="submit" class="qicon"><i class="fas fa-pen fa-border"></i></button>
</form>

<?php require_once '../footer.php' ?>