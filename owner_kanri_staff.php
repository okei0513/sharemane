<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者＞スタッフページ編集</title>
</head>

<body>
    <header>
        <div>グループ名の表示</div>

        <ul>
            <li><a href="owner_kanri_menu.html">戻る</a></li>
            <li><a href="">完了</a></li>
        </ul>
    </header>

    <div>
        <div>
            <a href="">メニュー</a>><a href="">管理者</a>><a href="">スタッフ</a>
        </div>

        <div>
            タイトル：<input type="text" placeholder=ページのタイトル">
            <button>編集</button>
            <!-- 編集を押したら保存ボタンが出てくる -->
        </div>
        <div>
            <div>
                <h4>現在のメンバー</h4>
            </div>
            <div>
                <li>Mai：メンバーの名前が自動入力される</li>
                <div>
                    <p>役職</p>
                    <p>事業内容</p>
                </div>
                <p>権利</p>
                <button>編集</button>
                <button>削除</button>
            </div>
            <div>
                <button>＋メンバーを追加する</button>
            </div>
        </div>

        <div>
            <p>NEW</p>
            <li>名前</li>
            <p>承認待ち</p>
            <button>承認する</button>
        </div>

    </div>

    <footer>
    </footer>


</body>

</html>