<?php
$message = '%'.$_POST['message'].'%';
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
$tagout = $pdo->prepare('SELECT * FROM TAG WHERE TAG LIKE ? GROUP BY TAG ORDER BY TAG_ID DESC LIMIT 5');
$tagout ->execute([$message]);
foreach($tagout as $row){
  echo <<< HTML
   <option value="$row[TAG]">
  HTML;
};
