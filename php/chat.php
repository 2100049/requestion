<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php' ?>

<?php
$me_id = session_user_id();
if(!$me_id){
  login();
}

$pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
$us = $pdo -> prepare(
  'SELECT i.partner_id, ACCOUNT.AC_NAME FROM follow AS i
  LEFT OUTER JOIN chat ON i.self_id = chat.self_id AND i.partner_id = chat.partner_id
  LEFT JOIN ACCOUNT ON ACCOUNT.AC_ID = i.partner_id AND i.partner_id = ACCOUNT.AC_ID
  WHERE (SELECT partner_id FROM follow AS j WHERE j.self_id = i.partner_id AND i.self_id = j.partner_id) = ?
  GROUP BY ACCOUNT.AC_ID
  ORDER BY MAX(chat.id) DESC
  ');
$us -> execute([$me_id]);


require_once '../nav.php'; 
echo <<<HTML
<div class="fs-3"></div>

<div class="chatbox d-flex bg-white border shadow-sm mx-auto">
  <div class="friend border-end">
    <ul class="list-group list-group-flush">
HTML;
      foreach($us as $ro){
        $notification = $pdo ->prepare('SELECT * FROM chat_notification WHERE self_id = ? AND partner_id = ?');
        $notification->execute([$me_id , $ro['partner_id']]);
        if(!$count = $notification->rowCount()){
            $count = "";
          }
        echo <<<HTML
        <a id="$ro[partner_id]" href="#$ro[partner_id]" class="list-group-item">
          $ro[AC_NAME]<span class="position-absolute translate-middle badge rounded-pill bg-secondary">$count</span>
        </a>
        HTML;
      }
echo <<<HTML
    </ul>
  </div>
  <div style="width: 100%; position: relative;">
    <div id="chatarea" class="chat">
      <div id="messageTextBox"></div>
      <div class="input-group fixed-bottom" style="position: absolute;">
        <textarea id="message" class="form-control message" name="message" style="height: 24px; resize: none;" autofocus></textarea>
        <button type="button" class="btn btn-primary" type="button" id="button-addon2" onclick="writeMessage()" value="">送信</button>
      </div>
    </div>
  </div>
</div>
HTML;

require_once '../footer.php';
?>

<script>
$(function(){
  // メッセージボックスの幅
  $('.chat').css('height', 500 - $('#message').outerHeight(true) + 'px');
});
$(function(){
  // uri
  const anchor =  location.hash.substring(1);
  const href = $('.list-group-item').first().attr("href");
  if(!href){
    $('.list-group').html('<p>相互フォロワーがいません！<br>プロフィールからフォローできます</p>');
  } else if(!anchor){
    $('.list-group-item').first().addClass('active');
    location.href = href;
  }else{
    $('#' + anchor).addClass('active');}
});

$('.list-group-item').on("click", function() {
  $('.list-group-item').removeClass('active');
  $(this).addClass('active');
});

// 下二つは読み込みの仕方を書いているので常に呼び出すような他ファイルに移動しないほうが負荷かからないと思います！
$(document).ready(function() {
  readMessage();
  setInterval( () => {
    readMessage()
  },3000);
});

// フラグメント変更時に読みこみ
$(function(){
  $(window).hashchange(function(){
    readMessage();
  })
});

// 通知を読みましたのところ
$(function() {
  $(window).hashchange(function(){
    $.ajax({
        type: 'post',
        url: './chat_notification.php',
        data: {
            'partner_id' : location.hash.substring(1)
        }
    })
  })
});


</script>