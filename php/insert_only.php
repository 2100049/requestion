<?php
session_start();
    // $count = 0;
    // $strMsg   = '';

    $request = '';
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        $request = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);
    }
    if ($request !== 'xmlhttprequest') {
        exit;
    }

    $message = '';
    if (isset($_POST['message']) && is_string($_POST['message'])) {
        $message = htmlspecialchars($_POST['message'], ENT_QUOTES);
    }
    if ($message == '') {
        exit;
    }

    // $fp = fopen('message.log', 'r');
    // if (flock($fp, LOCK_SH)) {
    //     while (!feof($fp)) {
    //         if ($count > 200) {
    //             break;
    //         }
    //         $strMsg = $strMsg . fgets($fp);
    //         $count = $count + 1;
    //     }
    // }
    // flock($fp, LOCK_UN);
    // fclose($fp);   
    // $strMsg =  $message . "\n" ;


    function session_user_id(){
        if(isset($_SESSION['ACCOUNT'])){
            return $_SESSION['ACCOUNT']['AC_ID'];
        }
      }
      $me = session_user_id();
      $partner = json_decode($_REQUEST['fragment']);


    $pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
    $sql = $pdo -> prepare('INSERT INTO chat(chat , self_id , partner_id) VALUES ( ?, ? , ? )');
    $sql->execute([$message, $me, $partner]);

    $chat_notification = $pdo -> prepare('INSERT INTO chat_notification(self_id , partner_id) VALUES ( ?, ?)');
    $chat_notification -> execute([$partner , $me]);

    // file_put_contents('message.log', $strMsg, LOCK_EX);
?>