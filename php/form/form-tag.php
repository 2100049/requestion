<?php
//タグフォーム
    if (in()){
        echo <<<end
        <form method="POST">
            <div class="input-group input-group-sm mb-2">
                <span class="input-group-text" id="inputGroup-sizing-sm">タグ追加</span>
                <input type="text" class="form-control" name="TAG" placeholder="8文字以内で入力" maxlength="8" required>
                <button class="btn btn-secondary" type="submit" id="button-addon2">送信</button>
            </div>
        </form>
        end;
    }
?>