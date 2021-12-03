<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>
<?php require_once '../nav.php' ?>

<div class="catbox bg-white border shadow-sm mx-auto p-2">
<h5>カテゴリ一覧</h5>

<?php
$sql = $pdo->query('SELECT * FROM CATEGORY');
foreach ($sql as $row){
    echo <<<HTML
    <form action="serch-result.php" method="POST">
        <input type="hidden" name="CAT_ID" value="$row[CAT_ID]">
        <input class="submitlink" type="submit" value="$row[CAT]">
    </form>
    HTML;
}
?>

</div>
<?php
$sql = $pdo->query('SELECT * FROM CATEGORY');
$sql = $sql ->fetchAll();
$tmp = $sql[0]['CAT'];
echo <<< HTML
<table class="table">
  <thead>

  </thead>
  <tbody>
    <tr>
      <td>{$sql[0]['CAT']}</td>
      <td>{$sql[1]['CAT']}</td>
      <td>{$sql[2]['CAT']}</td>
    </tr>
    <tr>
      <td>{$sql[3]['CAT']}</td>
      <td>{$sql[4]['CAT']}</td>
      <td>{$sql[5]['CAT']}</td>
    </tr>
    <tr>
      <td>{$sql[6]['CAT']}</td>
      <td>{$sql[7]['CAT']}</td>
      <td>{$sql[8]['CAT']}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
HTML;
?>

<?php require_once '../footer.php' ?>