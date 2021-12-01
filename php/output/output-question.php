<?php
echo <<<HTML
<span class="bold">$row[AC_NAME]</span>
<p class="mx-auto p-3" style="width: 600px;">$QUE</p>
HTML;

//画像表示
if (isset($_GET['QUE_ID'])){
    if (file_exists('../img/QUEIMG/'. $row['QUE_ID'])){
        $images = glob('../img/QUEIMG/'. $row['QUE_ID']. '/*');
        echo '<div class="text-center">';
        foreach($images as $path) {
            echo '<a href="'. $path.'" data-lightbox="QUEIMG"><img src="', $path, '" class="m-2" style="max-width: 500px; max-height: 300px"></a>';
        }
        echo '</div>';
    }
}

if (isset($_GET['QUE_ID'])){
    //カテゴリ表示
    if (nowp('/requestion/php/question-detail.php')){
        echo <<<HTML
        <form action="serch-result.php" method="POST">
            <span class="smtxt">カテゴリ : </span>
            <input type="hidden" name="CAT_ID" value="$row[CAT_ID]">
            <input class="cat" type="submit" value="$row[CAT]">
        </form>
        HTML;
    }else{
        echo '<span class="smtxt">カテゴリ : ', $row['CAT'], '</span><br>';
    }

    //タグ表示
    $tag = $pdo->prepare('SELECT * FROM TAG WHERE QUE_ID= ?');
    $tag->execute([$row['QUE_ID']]);

    if (nowp('/REQUESTION/php/question-detail.php')){
        echo '<form action="serch-result.php" method="POST">';
        echo '<span class="smtxt">タグ : ';
    
        foreach ($tag as $res){
            echo '<input class="tag" type="submit" name="TAG" value="', h($res['TAG']), '">, ';
        }
    
        echo '</span>';
        echo '</form>';
    } else {
        echo '<span class="smtxt">タグ : ';
    
        foreach ($tag as $res){
            echo h($res['TAG']). ', ';
        }
    
        echo '</span>';
    }
}

//希望表示
echo '<p class="smtxt">希望 : ';
if ($row['SPEED'] == 0){
    echo 'なし';
}else if($row['SPEED'] == 1){
    echo 'とにかく早く回答が欲しい';
}else if ($row['SPEED'] == 2){
    echo 'ゆっくり考えて回答が欲しい';
}else{
    echo '雑談';
}
echo '</p>';

//時間表示
echo <<<HTML
        <p class="smtxt text-end">$row[QUE_TIME]</p>
HTML;
?>