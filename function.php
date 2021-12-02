<?php
//HTMLタグ無効化
function h($text){
    $htext = htmlspecialchars($text);
    return $htext;
}

// アラート表示
function alert($message){
    echo <<<HTML
    <script>
        alert('$message')
    </script>
    HTML;
}

//確認ダイアログボタン表示
// function alertbutton($button, $message, $link, $class, $hidden){
//     echo <<<HTML
//     <a class="$class" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-message='$message' data-link='$link' data-hidden='$hidden'>$button</a>
//     HTML;
// }

//ログイン状態チェック
function in(){
    if (isset($_SESSION['ACCOUNT'])){
        return true;
    }else{
        return false;
    }
}

//表示文字数制限
function omit($text, $limit){
    if (mb_strlen($text) > $limit){
        $res = mb_substr($text, 0, $limit). '...';
    }else{
        $res = $text;
    }
    return $res;
}

//現在のページを取得
function nowp($page){
    if ($_SERVER['SCRIPT_NAME'] == $page){
        return true;
    }else{
        return false;
    }
}

#accountチェック用関数です。
function session_user_id(){
    if(isset($_SESSION['ACCOUNT'])){
        return $_SESSION['ACCOUNT']['AC_ID'];
    }else{
        return 0;
    }
}

#accountチェック用関数です。
function session_user_name(){
    if(isset($_SESSION['ACCOUNT'])){
        return $_SESSION['ACCOUNT']['AC_NAME'];
    }else{
        return 0;
    }
}
#indexへジャンプする関数です。主にリンクの不正入力の際呼び出して使います。
function index(){
    header('Location:index.php');
    exit();
}
#loginへジャンプする関数です。主にリンクの不正入力の際呼び出して使います。
function login(){
    header('Location:./login-induction.html');
    exit();
}


#URLGETアドレスを取得
function GET(){
    return $_SERVER['QUERY_STRING'];
}
?>