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
    <title>管理者＞グループ編集</title>
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
            <a href="">メニュー</a>><a href="">管理者</a>><a href="">グループ</a>
        </div>

        <div>
            グループ名：<input type="text" placeholder="現在のグループ名表示"><button>編集</button>
        </div>

        <div>
            <div>
                <h3>メンバーの追加</h3>
            </div>
            <div>
                <p>
                    メンバーを招待する<br>
                    <button>リンクを共有する</button>
                </p>

                <p>
                    グループを検索する<br>
                    グループID：<input type="text"><button>確認</button>
                </p>
                <p>
                    グループに招待してもらう<br>
                    あなたのID：<input type="text"><button>コピー</button>
                </p>
            </div>

        </div>

    </div>

    <footer>
    </footer>

</body>

</html>