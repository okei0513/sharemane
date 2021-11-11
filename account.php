<?php
// session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
// check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録画面</title>
</head>

<body>
    <!-- ヘッダー部分 -->
    <header>
        <ul>
            <li><a href="top.php">戻る</a></li>

        </ul>
    </header>
    <!-- メイン部分 -->
    <div>
        <fieldset>
            <h1>Share Mane</h1>
            <form action="account_create.php" method="post">
                <h3>NEW account</h3>
                <div>
                    Mail Addres: <input type="text" name="mail" required="required" placeholder="Email Address">
                </div>
                <div>
                    パスワード: <input type="text" name="password" required="required" placeholder="Password"><br>
                    半角・英数含む６文字以上
                </div>
                <!-- <div>
                    確認用パスワード: <input type="text" name="kakuninpassword">
                </div> -->
                <div>
                    表示する名前: <input type="text" name="namae" required="required" placeholder="なまえ">
                </div>

                <div>
                    <button class="button">登録する</button>
                </div>

            </form>
        </fieldset>


</body>

</html>