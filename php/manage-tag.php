<?php session_start(); ?>
<?php require_once '../function.php' ?>
<?php require_once '../header.php' ?>
<?php require_once '../nav.php' ?>

<div class="mgmain">
<?php
if (isset($_REQUEST['DEL_TAG_ID'])){
    $DEL_TAG_ID = htmlspecialchars(implode(',', $_REQUEST['DEL_TAG_ID']), ENT_COMPAT | ENT_HTML401, 'UTF-8');

    $hidden = <<<HTML
    <input type="hidden" name="QUE_ID" value="$_GET[QUE_ID]">
    <input type="hidden" name="DEL_TAG_ID" value="$DEL_TAG_ID">
    HTML;

    // alertbutton('タグ削除', '本当に削除しますか?', 'delete/delete-tag.php', 'btn btn-outline-danger btn-sm', $hidden);
    }

//投稿表示
$sql = $pdo->prepare('
SELECT * FROM QUESTION
INNER JOIN CATEGORY USING (CAT_ID)
INNER JOIN ACCOUNT USING (AC_ID)
WHERE QUE_ID = ?
');
$sql->execute([$_REQUEST['QUE_ID']]);

foreach ($sql as $row){
    if ($row['AC_ID'] != $_SESSION['ACCOUNT']['AC_ID']){
        header('Location:index.php');
    }

    echo '<div class="card bg-light m-3 mx-auto" style="width: 700px">';
    echo '<div class="bg-white m-3 p-2 border">';

    $QUE = omit(nl2br(h($row['QUE'])), 100);

    require 'output/output-question-detail.php';

    echo '</div>';
    echo '</div>';
}

echo <<<HTML
<div class="card bg-light m-3 mx-auto" style="width: 700px">
    <div class="card-header">
        <h4 class="text-center">タグ編集</h4>
    </div>
HTML;

//タグ表示
$tag=$pdo->prepare('SELECT * FROM TAG WHERE QUE_ID= ?');
$tag->execute([$row['QUE_ID']]);

$count = $tag->rowCount();
if ($count){
    echo <<< HTML
    <div class="bg-white m-3 p-2 border">
    <form method="POST" onsubmit="return false;">
    </form>
    HTML;
    foreach ($tag as $res){
        $tmp = h($res['TAG']);
        echo <<<HTML
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="DEL_TAG_ID[]" id="$res[TAG_ID]" value="$res[TAG_ID]" form="mod_form">
            <label class="form-check-label" for="$res[TAG_ID]">$tmp</label>
        </div>
        HTML;

    }

    //タグ削除フォーム
    echo <<<HTML
            <br>
            <div class="text-end">
                <input class="btn btn-outline-danger btn-sm" type="button" value="タグ削除"
                data-bs-toggle="modal" data-bs-target="#staticBackdrop" 
                onclick="mod_link('本当に削除しますか?','delete/delete-tag.php?QUE_ID=$_REQUEST[QUE_ID]')">
            </div>
    </div>
    HTML;
}else{
    echo '<span class="text-center">登録されたタグはありません</span>';
}

echo '</div>';
?>
</div>

<?php require_once '../footer.php' ?>