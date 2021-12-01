<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>

<?php
$time = date("[Y/m/d]H:i");
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
$answer_id = $_REQUEST['ANS_ID'];
$sql=$pdo->prepare('INSERT INTO RESPONSE VALUES(NULL, ?, ?, ?, ?)');
$sql->execute([$answer_id, $_SESSION['ACCOUNT']['AC_ID'], $_REQUEST['RES'], $time]);
$response_id =$pdo -> query('SELECT last_insert_id()');
$response_id = $response_id ->fetch(PDO::FETCH_ASSOC);

/*-----------------------------------------------------------------------------------------------------*/
$me =session_user_id();

$answer = $pdo -> prepare('SELECT AC_ID, QUE_ID, ANS_ID FROM ANSWER WHERE ANS_ID = ?');
$answer -> execute([$answer_id]);
$answer = $answer -> fetch(PDO::FETCH_ASSOC);

$question_user = $pdo -> prepare('SELECT AC_ID FROM QUESTION WHERE QUE_ID = ?');
$question_user -> execute([$answer['QUE_ID']]);
$question_user = $question_user -> fetch(PDO::FETCH_ASSOC);

// // var_dump($answer['AC_ID']);
// // var_dump($question_user['AC_ID']);
// // var_dump($me);
// // var_dump($response_id['last_insert_id()']);
if ($answer['AC_ID'] == $me){
    // 返信と回答者が同じ
    $notif = $pdo -> prepare('INSERT INTO RESPONSE_notification(AC_ID, RES_ID) VALUES(?,  ?)');
    $notif -> execute([$question_user['AC_ID'] , $response_id['last_insert_id()']]);
} else if($question_user['AC_ID'] == $me) {
    // 返信と回答者が別（返信したのが質問者）
    $notif = $pdo -> prepare('INSERT INTO RESPONSE_notification(AC_ID,  RES_ID) VALUES(?,  ?)');
    $notif -> execute([$answer['AC_ID'] ,$response_id['last_insert_id()']]);
}
/*-----------------------------------------------------------------------------------------------------*/

header('Location:question-detail.php?QUE_ID='. $_REQUEST['QUE_ID']);
?>

<?php require_once '../footer.php'; ?>

