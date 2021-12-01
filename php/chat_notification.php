<?php
session_start();

    function session_user_id(){
        if(isset($_SESSION['ACCOUNT'])){
            return $_SESSION['ACCOUNT']['AC_ID'];
        }
      }
      $me = session_user_id();

$partner = json_decode($_REQUEST['partner_id']);

if($me){
    $pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
    $sql = $pdo -> prepare('DELETE FROM chat_notification WHERE self_id = ? AND partner_id = ? ');
    $sql->execute([$me , $partner]);
}else{
    exit;
}

?>