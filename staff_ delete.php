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
    <title>スタッフページ削除</title>
</head>

<body>
    <fieldset>
        <p>ユーザー名</p>
        <p>のスタッフページを本当に削除しますか</p>
        <button>削除する</button>
    </fieldset>
</body>

</html>