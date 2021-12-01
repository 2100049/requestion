<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>requestion</title>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../css/lightbox.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
</head>

<!--ダイアログ-->
<!-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">REQUESTION</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {message}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <form id="url" action="{link}" method="POST">
          <div id="hidden">
            {hidden}
          </div>
          <button type="submit" class="btn btn-primary">確認</button>
        </form>
      </div>
    </div>
  </div>
</div> -->
<!--=================================================-->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">REQUESTION</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
        <form action="" id="mod_form" name="mod_form" method="POST">
          <button type="submit" class="btn btn-primary">確認</button>
        </form>
      </div>
    </div>
  </div>
</div>

<body class="bg-light">

  <?php
  $pdo = new PDO('mysql:host=localhost; dbname=requestion; charset=utf8', 'staff', 'password');
  date_default_timezone_set('Asia/Tokyo');    //タイムゾーンの変更
  ?>