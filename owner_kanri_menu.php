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
    <title>管理者メニュー</title>
</head>

<body>
    <header>
        <div>グループ名の表示</div>
        <!-- <ul>
            <li>ユーザー名</li>
            <li><a href="tsuchi.html">通知</a></li>
            <li><a href="top.html">ログアウト</a></li>
        </ul> -->
    </header>

    <div>
        <div>
            <a href="owner_menu.php">メニュー</a>><a href="owner_kanri_menu.php">管理者</a>
        </div>
        <div>
            <h3>管理者</h3>
        </div>
        <div>
            <li><a href="owner_kanri_group.php">グループ</a></li>
            <li><a href="owner_kanri_staff.php">スタッフ</a></li>
        </div>

    </div>

    <footer>
        <ul>
            <li><a href="owner_menu.php">戻る</a></li>
        </ul>
    </footer>


</body>

</html>