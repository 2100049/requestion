<?php 
session_start(); 
require_once '../function.php';
$me_id = session_user_id();
if(!$me_id){
  login();
}
$answer_response_c = $question_response_c = '';
$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
// 回答通知すべて表示
$answer_notif = $pdo -> prepare('SELECT * FROM ANSWER_notification INNER JOIN ANSWER USING (ANS_ID) WHERE ANSWER_notification.AC_ID = ? ORDER BY id DESC');
$answer_notif -> execute ([$me_id]);
// 未読回答通知数
$answer_notif_c = $pdo -> prepare('SELECT * FROM ANSWER_notification WHERE AC_ID = ? AND is_read IS NULL');
$answer_notif_c -> execute([$me_id]);
if (!$answer_notif_c = $answer_notif_c -> rowCount()){
  $answer_notif_c = '';
}

//  回答者からの返信
$answer_response_notif = $pdo -> prepare('SELECT * FROM RESPONSE_notification
INNER JOIN RESPONSE USING (RES_ID)
RIGHT OUTER JOIN ANSWER USING (ANS_ID) 
WHERE RESPONSE_notification.AC_ID = ? AND RESPONSE_notification.AC_ID != ANSWER.AC_ID
ORDER BY id DESC');
$answer_response_notif -> execute([$me_id]);

// 回答者からの返信の未読数
$answer_response_c = $pdo -> prepare('SELECT * FROM RESPONSE_notification
INNER JOIN RESPONSE USING (RES_ID)
RIGHT OUTER JOIN ANSWER USING (ANS_ID) 
WHERE RESPONSE_notification.AC_ID = ? AND RESPONSE_notification.AC_ID != ANSWER.AC_ID AND is_read IS NULL');
$answer_response_c -> execute([$me_id]);
if(!$answer_response_c = $answer_response_c ->  rowCount()) {
  $answer_response_c = '';
}

// 質問者からの返信
$question_response_notif = $pdo -> prepare('SELECT * FROM RESPONSE_notification
INNER JOIN RESPONSE USING (RES_ID)
RIGHT OUTER JOIN ANSWER USING (ANS_ID) 
WHERE RESPONSE_notification.AC_ID = ? AND RESPONSE_notification.AC_ID = ANSWER.AC_ID 
ORDER BY id DESC');
$question_response_notif -> execute([$me_id]);

// 質問者からの返信の未読数
$question_response_c = $pdo -> prepare('SELECT * FROM RESPONSE_notification
INNER JOIN RESPONSE USING (RES_ID)
RIGHT OUTER JOIN ANSWER USING (ANS_ID) 
WHERE RESPONSE_notification.AC_ID = ? AND RESPONSE_notification.AC_ID = ANSWER.AC_ID AND is_read IS NULL');
$question_response_c -> execute([$me_id]);
if(!$question_response_c = $question_response_c -> rowCount()) {
  $question_response_c = '';
}


/*下から表示処理*/
require_once '../header.php'; 
require_once '../nav.php';
?>
<div class="container card p-2 px-5 mt-3 w-75">
  <div class="card">
    <div class="row">
      <div class="text-center ">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs" id="pills-tab" role="tablist">
              <li class="nav-item col" role="presentation">
                  <a class="nav-link   active" id="pills-home-tab" data-bs-toggle="pill" href="#a" role="tab"  aria-selected="true">
                    回答の通知
                    <span class="badge bg-secondary"><?=$answer_notif_c;?></span>
                  </a>
              </li>
              <li class="nav-item col   " role="presentation">
                  <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#b" role="tab" " aria-selected="false">
                    回答者からの返信
                    <span class="badge bg-secondary"><?=$answer_response_c;?></span>
                  </a>
              </li>
              <li class="nav-item col   " role="presentation">
                  <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#c" role="tab"  aria-selected="false">
                    質問者からの返信
                    <span class="badge bg-secondary"><?=$question_response_c;?></span>
                  </a>
              </li>
          </ul>
        </div>
      </div>
      <div class="tab-content mt-3 " id="pills-tabContent">
        <div class="tab-pane fade show active" id="a" role="tabpanel" >
          <?php 
          foreach($answer_notif as $row){
            if($row['is_read'] == NULL){
              echo <<< HTML
              <div class = "alert alert-info">
              HTML;
            }else{
              echo <<< HTML
              <div class="alert alert-secondary">
              HTML;
              }
          echo <<< HTML
              <a href="question-detail.php?QUE_ID=$row[QUE_ID]">
                $row[ANS]
              </a>
          </div>
          HTML;
          } ?>
        </div>
        <div class="tab-pane fade" id="b" role="tabpanel" >
          <?php
          foreach($answer_response_notif as $row){
          if($row['is_read'] == NULL){
                echo <<< HTML
                <div class = "alert alert-info">
                HTML;
              }else{
                echo <<< HTML
                <div class="alert alert-secondary">
                HTML;
                }
              echo <<< HTML
              <a href="question-detail.php?QUE_ID=$row[QUE_ID]">
                $row[RES];
              </a>
            </div>
            HTML;
          } ?>
        </div>
        <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="pills-contact-tab">
        <?php
          foreach($question_response_notif as $row){
                    if($row['is_read'] == NULL){
                echo <<< HTML
                <div class = "alert alert-info">
                HTML;
              }else{
                echo <<< HTML
                <div class="alert alert-secondary">
                HTML;
                }
            echo <<< HTML
              <a href="question-detail.php?QUE_ID=$row[QUE_ID]">
                $row[RES];
              </a>
            </div>
            HTML;
          } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
require_once '../footer.php';
?>