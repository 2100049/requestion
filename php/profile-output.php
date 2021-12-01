<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>

<div class="mgmain">
<?php
if(empty($_REQUEST['name'])){
    $url  = "index.php";
    header("Location:".$url );
}
$user_id = session_user_id();#セッションがあればアカウントIDを取得する自作関数。
$parameter =[
    'name' => htmlspecialchars($_REQUEST['name']),
    'self_introduction' => htmlspecialchars($_REQUEST['self_introduction']),
    'AC_ID' => $user_id,
    'user_icon' => basename($_FILES['icon']['name'])
];

if($_REQUEST['update'] == '画像を削除する'){
    $delete_image = $pdo->prepare('UPDATE ACCOUNT SET user_icon = NULL WHERE AC_ID= ?');
    if($delete_image ->execute([$parameter['AC_ID']])){
        echo '削除しました';
    }
}else if($_REQUEST['update'] == 'プロフィールを更新する'){
    if(is_uploaded_file($_FILES['icon']['tmp_name'])){

        if(!file_exists('user-icon-images')){
            mkdir('user-icon-images');
        }
    }

    function updata($updata){
        return 'UPDATE ACCOUNT SET '. $updata .' = ? WHERE AC_ID = ';
    }

    $update_name = updata('AC_NAME').$parameter['AC_ID'];
    $new_name = $pdo->prepare($update_name);
    $new_name->execute([$parameter['name']]);

    $update_self_introduction = updata('self_introduction').$parameter['AC_ID'];
    $new_self_intoroduction = $pdo->prepare($update_self_introduction);
    $new_self_intoroduction->execute([$parameter['self_introduction']]);

    if($_FILES['icon']['name']){
            $file = 'user-icon-images/'.basename($_FILES['icon']['name']);
            if(move_uploaded_file($_FILES['icon']['tmp_name'],$file) ){
                $update_icon = updata('user_icon').$parameter['AC_ID'];
                $new_user_icon = $pdo-> prepare($update_icon);
                $new_user_icon -> execute([$parameter['user_icon']]);
            }
    }
}

$_SESSION['ACCOUNT']['AC_NAME']=$parameter['name'];

#処理終了後表示へ移動
    $url = "profile-view.php?". $user_id;
    header("Location:". $url );

?>
</div>

<?php require_once '../footer.php'; ?>