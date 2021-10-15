<?php
session_start(); // セッションの開始
include('functions.php');
check_session_id(); // idチェック関数の実行

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グループ申請済画面</title>
</head>

<body>
    <header>
        <ul>
            <li>ユーザー名</li>
            <li><a href="tsuchi.html">通知</a></li>
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <div>
        <fieldset>
            <h3>グループ名</h3>
            <p>への申請を受付ました</p>
            <p>グループ管理者からの承認をお待ちください</p>
        </fieldset>

    </div>

    <footer>
    </footer>
</body>

</html>