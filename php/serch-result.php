<?php session_start(); ?>
<?php require_once '../function.php'; ?>
<?php require_once '../header.php'; ?>
<?php require_once '../nav.php'; ?>

<?php
if (isset($_REQUEST['serchkey'])){
    echo <<<HTML
    <div class="mb-2 d-grid gap-2 col-5 mx-auto" role="group">
        <div class="btn-group" role="group">
            <input type="radio" class="btn-check" name="btnradio" id="key" autocomplete="off" checked>
            <label class="btn btn-outline-primary" for="key">キーワード検索</label>

            <input type="radio" class="btn-check" name="btnradio" id="tag" autocomplete="off">
            <label class="btn btn-outline-primary" for="tag">タグ検索</label>
        </div>
    </div>
    HTML;
}

//フォーム検索
if (isset($_REQUEST['serchkey'])){
    $serchkey = '%'.$_REQUEST['serchkey'].'%';

    $key = $pdo->prepare(
    'SELECT * FROM QUESTION
    INNER JOIN CATEGORY USING (CAT_ID)
    INNER JOIN ACCOUNT USING (AC_ID)
    WHERE QUE LIKE ?
    ORDER BY QUE_ID DESC
    ');
    $key->execute([$serchkey]);

    $tag = $pdo->prepare(
    'SELECT * FROM TAG
    INNER JOIN QUESTION USING (QUE_ID)
    INNER JOIN ACCOUNT USING (AC_ID)
    WHERE TAG LIKE ?
    ORDER BY QUE_ID DESC
    ');
    $tag->execute([$serchkey]);
 
    //キーワード検索
    echo <<<HTML
    <div id="listkey">
    HTML;

    if (!$key = $key->fetchAll()){
        echo <<<HTML
        <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
            検索結果が見つかりませんでした
        </div>
        HTML;
    }else{
        foreach ($key as $row){ //検索結果表示
            echo <<<HTML
            <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
            HTML;

            $QUE = omit(nl2br(h($row['QUE'])), 100);

            require 'output/output-question-index.php';

            echo <<<HTML
                    <a href="question-detail.php?QUE_ID=$row[QUE_ID]" class="link"></a>
                </div>
            HTML;
        }
    }

    echo <<<HTML
    </div>
    HTML;

    //タグ検索
    echo <<<HTML
    <div id="listtag">
    HTML;

    if (!$tag = $tag->fetchAll()){
        echo <<<HTML
        <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
            検索結果が見つかりませんでした
        </div>
        HTML;
    }else{
        foreach ($tag as $row){ //検索結果表示
            echo <<<HTML
            <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
            HTML;

            $QUE = omit(nl2br(h($row['QUE'])), 100);

            require 'output/output-question-index.php';

            echo <<<HTML
                <a href="question-detail.php?QUE_ID=$row[QUE_ID]" class="link"></a>
            </div>
            HTML;
        }
    }

    echo <<<HTML
    </div>
    HTML;
}

//カテゴリ検索
if (isset($_REQUEST['CAT_ID'])){
    $CAT_ID = $_REQUEST['CAT_ID'];
    $sql=$pdo->prepare('
    SELECT * FROM QUESTION
    INNER JOIN CATEGORY USING (CAT_ID)
    INNER JOIN ACCOUNT USING (AC_ID)
    WHERE CAT_ID = ?
    ORDER BY QUE_ID DESC
    ');
    $sql->execute([$CAT_ID]);

    if (in()){
        $cat = $pdo->prepare('
        SELECT cat FROM category WHERE cat_id=?
        ');
        $cat ->execute([$CAT_ID]);
        foreach ($cat as $cow){
            $cat = $cow['cat'];
        }

        $bm = $pdo->prepare('
        SELECT * from bmcategory WHERE ac_id=? AND cat_id=?
        ');
        $bm ->execute([$_SESSION['ACCOUNT']['AC_ID'], $CAT_ID]);
        if($bm->fetch(PDO::FETCH_ASSOC)){
            $checked = 'checked';
        }else{
            $checked = '';
        }

        echo <<<HTML
        <div class="form-check mx-auto mb-3" style="width: 700px;">
            <input class="form-check-input" type="checkbox" id="catbm" name="catbm" value="$CAT_ID" $checked>
            <label class="form-check-label" for="catbm">
                「{$cat}」をお気に入りに登録する
            </label>
        </div>
        HTML;
    }

    if (!$sql = $sql->fetchAll()){
        echo <<<HTML
        <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
            検索結果が見つかりませんでした
        </div>
        HTML;
    }else{
        foreach ($sql as $row){ //検索結果表示
            echo <<<HTML
            <div class="divlink mx-auto mb-3 p-2 border bg-white shadow-sm" style="width: 700px">
            HTML;

            $QUE = omit(nl2br(h($row['QUE'])), 100);

            require 'output/output-question-index.php';

            echo <<<HTML
                <a href="question-detail.php?QUE_ID=$row[QUE_ID]" class="link"></a>
            </div>
            HTML;
        }
    }
}
?>

<?php require_once '../footer.php'; ?>

<script>
$(document).ready(function() {
  $("#listtag").addClass('d-none');

  $("#key").click(function () {
    $("#listkey").removeClass('d-none');
    $("#listtag").addClass('d-none');
  });
  $("#tag").click(function () {
    $("#listkey").addClass('d-none');
    $("#listtag").removeClass('d-none');
  });
});
</script>