<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>
<?php require_once '../nav.php' ?>

<div class="catbox bg-white border shadow-sm mx-auto p-2">
  <h5>カテゴリ一覧</h5>
  <?php
  // $sql = $pdo->query('SELECT * FROM CATEGORY');
  // foreach ($sql as $row){
  //     echo <<<HTML
  //     <form action="serch-result.php" method="POST">
  //         <input type="hidden" name="CAT_ID" value="$row[CAT_ID]">
  //         <input class="submitlink" type="submit" value="$row[CAT]">
  //     </form>
  //     HTML;
  // }
  ?>
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
        <td><a href="fsadf">{$sql[0]['CAT']}</a></td>
        <td>{$sql[1]['CAT']}</td>
      
      </tr>
      <tr>
        <td>{$sql[2]['CAT']}</td>
        <td>{$sql[3]['CAT']}</td>
        <td>{$sql[4]['CAT']}</td>
        
      </tr>
      <tr>
        <td>{$sql[5]['CAT']}</td>
        <td>{$sql[6]['CAT']}</td>
      </tr>
      <tr>
        <td>{$sql[7]['CAT']}</td>
        <td>{$sql[8]['CAT']}</td>
        <td>{$sql[9]['CAT']}</td>
      </tr>
      <tr>
      <td>{$sql[10]['CAT']}</td>
        <td>{$sql[11]['CAT']}</td>
        <td>{$sql[12]['CAT']}</td>
      </tr>
      <tr>
        <td>{$sql[13]['CAT']}</td>
        <td>{$sql[14]['CAT']}</td>
      </tr>
      <tr>
        <td>{$sql[15]['CAT']}</td>
        <td>{$sql[16]['CAT']}</td>
        <td>{$sql[17]['CAT']}</td>
      </tr>
      <tr>
        <td>{$sql[18]['CAT']}</td>
        <td>{$sql[19]['CAT']}</td>
      </tr>
      <tr>
        <td>{$sql[20]['CAT']}</td>
        <td>{$sql[21]['CAT']}</td>
        <td>{$sql[22]['CAT']}</td>
      </tr>
      <tr>
        <td>{$sql[23]['CAT']}</td>
        <td>{$sql[24]['CAT']}</td>
      </tr>
    </tbody>
  </table>
</div>
HTML;
?>

<?php require_once '../footer.php' ?>