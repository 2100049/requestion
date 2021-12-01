<section>

<form action="serch.php">
    <div class="input-group mb-3 mx-auto" style="width: 500px">
        <input type="text" class="form-control" name="keyword" placeholder="キーワードで検索">
        <button type="submit" class="btn btn-secondary">検索</button>
    </div>

    <div class="input-group mb-3 mx-auto" style="width: 500px">
        <select class="form-select" name="CAT_ID">
            <option selected>カテゴリで検索</option>
    <?php
    $sql=$pdo->query('SELECT * FROM CATEGORY LIMIT 1, 18446744073709551615');
    foreach ($sql as $row){
        echo "<option value=$row[CAT_ID]>$row[CAT]</option>";
    }
    ?>
        </select>
        <button type="submit" class="btn btn-secondary">検索</button>
    </div>
</form>

</section>