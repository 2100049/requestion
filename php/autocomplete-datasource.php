<?php
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
$sql = $pdo->query('SELECT DISTINCT(TAG) FROM TAG');
// $i = 0;
foreach ($sql as $row){
    $a[] = $row['TAG'];
}
if(empty($a[0])){
  $a[0] = '';
}
// if (isset($tag)){
//     $tagj = json_encode($tag);
// }
// $a = array(
//   'HPI',
//   'Kyosho',
//   'Losi',
//   'Tamiya',
//   'Team Associated',
//   'Team Durango',
//   'Traxxas',
//   'Yokomo'
// );

$b = array();

if($_POST['param1']){
  $w = $_POST['param1'];  
  foreach($a as $i){
    if(stripos($i, $w) !== FALSE){
      $b[] = $i;
    }
  }
  echo json_encode($b);
}
else{
  echo json_encode($b);
}
?>