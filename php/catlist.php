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

<?php require_once '../footer.php' ?>