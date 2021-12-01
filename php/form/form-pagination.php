<?php
//現在のページを取得
if (isset($_GET['page'])){
    $getp = $_GET['page'];
}else{
    $getp = 1;
}

echo <<<HTML
<nav aria-label="...">
    <div class="mx-auto">
        <ul class="pagination justify-content-center mt-5">
HTML;

//「<<」の無効化処理
if ($getp == 1){
    echo <<<HTML
    <li class="page-item disabled">
        <span class="page-link">&laquo;</span>
    </li>
    HTML;
}else{
    echo <<<HTML
    <li class="page-item">
        <a class="page-link" href="?page=1">
            <span aria-hidden="true">&laquo;</span>
        </a>
    </li>
    HTML;
}

//ページネーション表示数を7個に制限 要修正(?)
if ($getp <= 3){
    $min = 1;
    if ($page >= 7){
        $max = 7;
    }else{
        $max = $page;
    }
}
if ($getp >= 4){
    $min = $getp - 3;
    if ($getp + 3 <= $page){
        $max = $getp + 3;
    }else{
        $max = $page;
    }
}
if ($getp >= $page - 2){
    if ($page > 7){
        $min = $page - 6;
        $max = $page;
    }else{
        $min = 1;
        $max = $page;
    }
}

//ページネーションを表示
for ($i = $min; $i <= $max; $i++){
    if ($getp == $i){
        echo <<<HTML
        <li class="page-item active" aria-current="page">
            <span class="page-link">$i</span>
        </li>
        HTML;
    }else{
        echo '<li class="page-item"><a class="page-link" href="?page=', $i, '">', $i, '</a></li>';
    }
}

//「>>」の無効化処理
if ($getp == $page){
    echo <<<HTML
    <li class="page-item disabled">
        <span class="page-link">&raquo;</span>
    </li>
    HTML ;
}else{
    echo <<<HTML
    <li class="page-item">
        <a class="page-link" href="?page=$page">
            <span aria-hidden="true">&raquo;</span>
        </a>
    </li>
    HTML ;
}

echo <<<HTML
            </li>
        </ul>
    </div>
</nav>
HTML;
?>
