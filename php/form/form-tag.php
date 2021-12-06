<?php
//タグフォーム
    if (in()){
        echo <<< HTML
            <div class="input-group input-group-sm mb-2" id="addtag">
                <span class="input-group-text" id="inputGroup-sizing-sm">タグ追加</span>
                <input type="hidden" name="QUE_ID" value="$_GET[QUE_ID]">
                <input type="text" class="form-control" name="TAG" placeholder="8文字以内で入力" maxlength="8" required
                list="datalistOptions" id="exampleDataList" oninput="inputtag();">
                <datalist id="datalistOptions">
                    
                </datalist>
                <input type="button" class="btn btn-secondary" id="addtagbtn" value="送信">
            </div>
        HTML;
    }
?>