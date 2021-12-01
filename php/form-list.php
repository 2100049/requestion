<?php
echo <<<end
    <div class="card-header">
        <span class="bold">$row[AC_NAME]</span>
    </div>

    <div class="card-body">
        <p class="card-text mx-auto p-3" style="width: 600px;">$QUE</p>
        <p class="card-text smtxt">カテゴリ : $row[CAT]</p>
        <p class="card-text smtxt">タグ : 
end;

//タグ表示
$tag=$pdo->prepare('SELECT * FROM TAG WHERE QUE_ID= ?');
$tag->execute([$row['QUE_ID']]);

foreach ($tag as $res){
    echo h($res['TAG']);
}
echo '</p>';

//希望表示
echo '<p class="card-text smtxt">希望 : ';
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
echo '</div>';
?>