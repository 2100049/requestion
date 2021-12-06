//アップロードファイルの拡張子確認
var allow_exts = new Array('jpg', 'jpeg', 'png');

function checkExt(filename) {
  var ext = getExt(filename).toLowerCase();
  if (allow_exts.indexOf(ext) === -1) return false;
  return true;
}

//画像の枚数制限
function check() {
  var fileList = document.getElementById("inputGroupFile02").files;
  var file = document.getElementById('inputGroupFile02');
  if (fileList.length > 3) {
    alert("選択できる画像は3枚までです");
    file.value = '';
  }
}

// アイコン画像のプレビュー表示
$(function () {
  $('#icon').change(function (e) {
    //ファイルオブジェクトを取得する
    var file = e.target.files[0];
    var reader = new FileReader();

    //画像でない場合は処理終了
    if (file.type.indexOf("image") < 0) {
      alert("画像ファイルを指定してください。");
      return false;
    }

    //アップロードした画像を設定する
    reader.onload = (function (file) {
      return function (e) {
        $("#img").attr("src", e.target.result);
        $("#img").attr("title", file.name);
      };
    })(file);
    reader.readAsDataURL(file);

  });
});

// フォロー処理
$('#followercheck').click(function () {
  if (!$(this).prop('checked')) {
    if (!confirm('本当にフォローを解除しますか？')) {
      this.checked = true;
    } 
  }
  $.ajax({
    type: 'post',
    url: 'follow-output.php',
    data: {
      "check": $(this).prop('checked'),
      "user": $(this).val(),
    },
  })
});

// カテゴリお気に入り処理
$('#catbm').click(function () {
  if (!$(this).prop('checked')) {
    if (!confirm('本当にお気に入りを解除しますか？')) {
      this.checked = true;
    }
  }
  $.ajax({
    type: 'post',
    url: 'catbm-output.php',
    data: {
      "check": $(this).prop('checked'),
      "cat_id": $(this).val(),
    },
  })
});

// 質問お気に入り処理
$('#quebm').click(function () {
  $('#star').addClass('yellow');
  if (!$(this).prop('checked')) {
    if (!confirm('本当にお気に入りを解除しますか？')) {
      this.checked = true;
      $('#star').addClass('yellow');
    } else {
      $('#star').removeClass('yellow');
    }
  }
  $.ajax({
    type: 'post',
    url: 'quebm-output.php',
    data: {
      "check": $(this).prop('checked'),
      "que_id": $(this).val(),
    },
  })
});

/* chat系 */
function readMessage() {
  $.ajax({
    type: 'post',
    url: './read_only.php',
    data: {
      'fragment' : location.hash.substring(1)
    }
  })
  .then(
    function (data) {
      const flg = $('.chat').get(0).scrollHeight == ($('.chat').scrollTop() + $('.chat').outerHeight(true));
      $('#messageTextBox').html(data);
      if(flg){
        $('.chat').scrollTop($('.chat').get(0).scrollHeight)
      }
    },
    function () {
      alert("読み込み失敗");
      }
  );
}
function writeMessage() {
  $.ajax({
    type: 'post',
    url: './insert_only.php',
    data: {
      'message' : $("#message").val(),
      'fragment' : location.hash.substring(1)
    }
  })
  .then(
    function (data) {
      $('#message').height(24);
      $("#message").val("");
      $('.chat').css('height', 500 - $('#message').outerHeight(true) + 'px');
      readMessage();
      },
      function () {
        alert("書き込み失敗");
      });
}
// ctrlKey と enter で書き込み
$("#message").keydown(function(event) {
  if(event.ctrlKey && event.keyCode == 13){
    writeMessage();
  }
});
// チャットエリアの幅 と重ならないやつ
$(function(){
  $('#message').on('input', function(){
    if(this.scrollHeight < 108) {
      const flg = $('.chat').get(0).scrollHeight == ($('.chat').scrollTop() + $('.chat').outerHeight(true));
      $(this).height(24);
      $(this).height($(this).height() + this.scrollHeight - 36);
      $('.chat').css('height', 500 -  $(this).outerHeight(true) + 'px');
      if(flg) {
        $('.chat').scrollTop($('.chat').get(0).scrollHeight);
      }
    }
  });
});

/* chat終わり */

//検索補完
$(document).ready( function() {
  $("#serch").autocomplete({
    source: function(req, resp){
        $.ajax({
            url: "autocomplete-datasource.php",
            type: "POST",
            cache: false,
            dataType: "json",
            data: {
            param1: req.term
            },
            success: function(o){
            resp(o);
            },
            error: function(xhr, ts, err){
            resp(['']);
            }
        });
    }
  });
});

// モーダル
function mod_link(mess,link){
  $(".modal-body").html(mess);
  document.mod_form.action = link;
};

// tag補助
exampleDataList
function inputtag() {
  $.ajax({
    type: 'post',
    url: './tag_comp.php',
    data: {
      'message' : $("#exampleDataList").val()
    }
  })
  .then(
    function (data) {
      $("#datalistOptions").html(data)
    },
      function () {
        alert("読み込み失敗");
      });
}

//tag投稿
$('#addtagbtn').click(function () {
  if($('#addtag [name="TAG"]').val().match(/^\s*$/)){
    alert('タグを入力してください！');
  }else{
    $.ajax({
      type: 'post',
      url: 'tag-output.php',
      data: {
        "QUE_ID": $('#addtag [name="QUE_ID"]').val(),
        "TAG": $('#addtag [name="TAG"]').val()
      },
    })
      .then(
      function (data) {
        $('#readtag').html(data);
        console.log(data);
        $('#addtag [name="TAG"]').val('');
      },
      function () {
        alert("読み込み失敗");
        }
    );
  }
})