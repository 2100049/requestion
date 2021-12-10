<?php
require_once '../function.php';

$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');

//タグ表示
$id = $_REQUEST['id'];
$tag = $pdo->prepare('SELECT * FROM TAG WHERE QUE_ID= ?');
$tag->execute([$id]);

echo <<<HTML
<form action="serch-result.php" method="POST">
    <span class="smtxt">タグ : 
HTML;

foreach ($tag as $res){
    $settag = h($res['TAG']);
    echo <<<HTML
    <input class="submitlink" type="submit" name="TAG" value="$settag">, 
    HTML;
}

echo <<<HTML
    </span>
</form>
HTML;
?>
