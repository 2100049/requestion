<?php
//返信フォーム
if (in()){
    if ($_SESSION['ACCOUNT']['AC_ID'] == $quer || $_SESSION['ACCOUNT']['AC_ID'] == $row['AC_ID']){ //質問者||回答者
        echo <<<end
        <form action="response.php" method="POST" class="mt-2">
            <div class="input-group input-group-sm mb-2">
                <span class="input-group-text" id="inputGroup-sizing-sm">返信を入力</span>
                <input type="hidden" name="ANS_ID" value="$row[ANS_ID]">
                <input type="hidden" name="QUE_ID" value="$_GET[QUE_ID]">
                <textarea id="message" class="form-control" name="RES" placeholder="300文字以内で入力" rows="1" maxlength="300" required></textarea>
                <button class="btn btn-secondary" type="submit" id="button-addon2">送信</button>
            </div>
        </form>
        end;
    }
}
?>