<?php
// 投稿フォーム処理
if (isset($_REQUEST['QUE'])){
  $time = date("[Y/m/d]H:i");
  $sql = $pdo->prepare('INSERT INTO QUESTION VALUES(NULL, ?, ?, ?, ?, ?)');
  if ($sql->execute([$_SESSION['ACCOUNT']['AC_ID'], $_REQUEST['QUE'], $_REQUEST['CAT_ID'], $_REQUEST['SPEED'], $time])){
      //QUE_IDの取得
      $sql = $pdo->prepare('SELECT * FROM QUESTION WHERE QUE_TIME=?');
      $sql->execute([$time]);
      foreach($sql as $row){
          $QUE_ID = $row['QUE_ID'];
      }
      //画像アップロード
      if (isset($_FILES['img'])){
          if (!file_exists('../img/QUEIMG')){
              mkdir('../img/QUEIMG');
          }
          for($i = 0; $i < count($_FILES["img"]["name"]); $i++){
              if(is_uploaded_file($_FILES["img"]["tmp_name"][$i])){
                  //質問ごとに画像フォルダ作成
                  if (!file_exists('../img/QUEIMG/'. $QUE_ID)){
                      mkdir('../img/QUEIMG/'. $QUE_ID);
                  }
                  $file = '../img/QUEIMG/'. $QUE_ID. '/'. $_FILES['img']['name'][$i];
                  if (move_uploaded_file($_FILES["img"]["tmp_name"][$i], $file)){
                      $sql = $pdo->prepare('INSERT INTO QUEIMG VALUES(NULL, ?, ?)');
                      $sql->execute([$QUE_ID, $file]);
                  }
              }
          }
      }
      header('Location:question-detail.php?QUE_ID='. $QUE_ID);
  }
  alert('投稿に失敗しました');
}
?>