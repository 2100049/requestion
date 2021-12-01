<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>
<?php require_once '../nav.php'; ?>

<?php
//タグフォーム処理
if (isset($_REQUEST['TAG'])){
    $QUE_ID = $_GET['QUE_ID'];

    $sql = $pdo->prepare('SELECT * FROM TAG WHERE QUE_ID=? AND TAG=?');
    $sql->execute([$QUE_ID, $_REQUEST['TAG']]);

    if (empty($sql->fetchAll())){
        $sql = $pdo->prepare('INSERT INTO TAG VALUES(null, ?, ?)');
        $sql->execute([$QUE_ID, $_REQUEST['TAG']]);
    } else {
        alert($_REQUEST['TAG']. ' は既に設定されています');
    }
}

//評価フォーム処理
if (isset($_REQUEST['rate'])){
    if ($_REQUEST['rate'] == 'GOOD'){
        $rate = 1;
    }else{
        $rate = -1;
    }

    $sql=$pdo->prepare('UPDATE ANSWER SET RATE = ? WHERE ANS_ID=?');
    $sql->execute([$rate, $_REQUEST['ANS_ID']]);
}

//投稿表示
$sql = $pdo->prepare(
    'SELECT * FROM QUESTION
    INNER JOIN CATEGORY USING (CAT_ID)
    INNER JOIN ACCOUNT USING (AC_ID)
    WHERE QUE_ID = ?
');
$sql->execute([$_GET['QUE_ID']]);

$count = $sql->rowCount();
if (!$count){
    index();
}

foreach ($sql as $row){
    echo <<<HTML
    <div class="mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
    HTML;

    $QUE = nl2br(h($row['QUE']));
    
    require 'output/output-question-detail.php';

    require 'form/form-tag.php';

    if (in()){
        $QUE_ID = $_GET['QUE_ID'];
        //タグ編集フォーム
        //投稿削除フォーム
        if ($_SESSION['ACCOUNT']['AC_ID'] == $row['AC_ID']){
            echo '<div class="d-grid gap-2 d-md-flex justify-content-md-end">';
            echo <<<HTML
                    <form action="manage-tag.php?QUE_ID=$_GET[QUE_ID]" method="POST">
                        <input type="hidden" name="QUE_ID" value="$_GET[QUE_ID]">
                        <button class="btn btn-outline-secondary btn-sm" type="submit">  タグ編集  </button>
                    </form>
            HTML;


            echo <<< HTML
            <button class="btn btn-outline-danger btn-sm" type="button" title="質問を削除"
                data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                onclick="mod_link('本当に削除しますか?','delete/delete-question.php?QUE_ID=$_REQUEST[QUE_ID]')">
                <i class="fas fa-trash-alt"></i>
            </button>
            HTML;
            echo '</div>';
        }
    }

    //投稿者以外に回答フォーム表示
    $flg = 0;
    if (in()){
        if ($_SESSION['ACCOUNT']['AC_ID'] != $row['AC_ID']){

            //回答状態判別
            $sql=$pdo->prepare('SELECT * FROM ANSWER WHERE QUE_ID = ? AND AC_ID = ?');
            $sql->execute([$_GET['QUE_ID'], $_SESSION['ACCOUNT']['AC_ID']]);
            $count = $sql->rowCount();

            if ($count == 0){
                $flg = 1;
            }
        }
    }else{
        $flg = 1;
    }

    if ($flg == 1){
        //回答フォーム
        echo <<<HTML
            <form action="answer.php?QUE_ID=$_GET[QUE_ID]" method="POST">
                <div class="d-grid gap-2">
                    <button class="btn btn-sm btn-primary" type="submit">回答</button>
                </div>
            </form>
        HTML;
    }

    echo '</div>';

    $quer = $row['AC_ID'];    //投稿者取得
}

//回答表示
$sql = $pdo->prepare('
SELECT * FROM ANSWER
INNER JOIN ACCOUNT USING (AC_ID)
WHERE QUE_ID = ?
');
$sql->execute([$_GET['QUE_ID']]);

$count = $sql->rowCount();

$i = 0;

echo <<<HTML
<div class="mx-auto mb-3 p-2 pt-0 pb-0 border bg-white shadow-sm" style="width: 700px">
    <ul class="list-group list-group-flush pt-0">
HTML;

if ($count == 0){
    echo '<div class="text-center">まだ回答がついていないようです</div>';
}

foreach ($sql as $row){
    $ANS = nl2br(h($row['ANS']));
    
    echo <<<HTML
    <li class="list-group-item p-0 pt-2">
        <div class="divlink">
    HTML;
    
    require 'output/output-answer.php';

    echo <<<HTML
            <button class="submitlink link" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample$i" aria-expanded="false" aria-controls="multiCollapseExample$i"></button>
        </div>
    HTML;

    if (in()){
        if ($_SESSION['ACCOUNT']['AC_ID'] == $row['AC_ID']){
            echo <<< HTML
            <div class="gap-2 d-md-flex justify-content-md-end">
                <button class="btn btn-outline-danger btn-sm mb-2" type="button" title="回答を削除"
                    data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                    onclick="mod_link('本当に削除しますか?','delete/delete-answer.php?ANS_ID=$row[ANS_ID]')">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            HTML;
        }
    }

    //返信表示
    $res = $pdo->prepare('
    SELECT * FROM RESPONSE
    INNER JOIN ACCOUNT USING (AC_ID)
    WHERE ANS_ID = ?
    ORDER BY response.RES_ID ASC
    ');
    $res->execute([$row['ANS_ID']]);

    $count = $res->rowCount();

    echo '<div class="collapse multi-collapse mt-2 mb-2 p-2 resbox border" id="multiCollapseExample', $i, '">';
    foreach ($res as $tmp){
        $RES = nl2br(h($tmp['RES']));
        require 'output/output-response.php';
    }
    
    if (!$count){
        echo '<div class="text-center">まだ返信がついていないようです<div>';
    }
    
    require 'form/form-response.php';
    
    echo '</div>';

    $i ++;
}

echo <<<HTML
</li>
</ul>
</div>
HTML;

// 既読スペース //
if(in()){
    $question_id = $_GET['QUE_ID'];
    $answer = $pdo -> prepare('SELECT ANS_ID FROM answer WHERE QUE_ID = ?');
    $answer->execute([$question_id]);
    $response = $pdo->prepare('SELECT RES_ID FROM answer LEFT OUTER JOIN response USING (ANS_ID) WHERE QUE_ID = ?');
    $response -> execute([$question_id]);
    $me_id = $_SESSION['ACCOUNT']['AC_ID'];

    // 回答既読
    foreach($answer as $row){
        $notif_answer = $pdo -> prepare(
            'UPDATE ANSWER_notification SET is_read = 1 WHERE AC_ID = ? AND ANS_ID = ?');
        $notif_answer  -> execute([$me_id,$row['ANS_ID']]);
    }

    // 返信既読
    foreach($response as $row){
        $notif_response = $pdo -> prepare('UPDATE RESPONSE_notification SET is_read = 1 WHERE AC_ID = ? AND RES_ID = ?');
        $notif_response -> execute([$me_id,$row['RES_ID']]);
    }
}   
// 既読スペース終わり。//
?>

<?php require_once '../footer.php' ?>