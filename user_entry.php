<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
$id = $_SESSION["id"];
$name = $_SESSION["name"];
$mail = $_SESSION["mail"];
$user_code = $_SESSION["user_code"];

// $group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得

// var_dump($id);
// exit;

$pdo = connect_to_db();

$sql = 'SELECT * FROM user WHERE id';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容表示(ユーザー名を押したとき)</title>
</head>

<body>
    <fieldset>
        <button><a href="member_menu.php">閉じる</a></button>
        <div>
            <h2>登録内容</h2>
        </div>
        <table>
            <tr>
                <th>表示名</th>
                <td><?= $name ?></td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td><?= $mail ?></td>
            </tr>
            <tr>
                <th>あなたのID</th>
                <td><input id="user_code" type="text" name="user_code" value="<?= $user_code ?>" readonly>
                    <button onclick="copyToClipboard()">コピー</button>
                </td>
            </tr>
            <tr>
                <td><a href='user_entry_hensyu.php?id={$record["id"]}'>編集する</a></td>
            </tr>

        </table>

    </fieldset>


    <script>
        // ここからグループIDをコピーするJS
        function
        copyToClipboard() {
            //コピー対象をJavaScript上で変数として定義する
            var user_code = document.getElementById("user_code");
            //コピー対象のテキストを選択する
            user_code.select();
            //選択しているテキストをクリップボードにコピーする
            document.execCommand("Copy");
            //コピーをお知らせする
            alert("コピーできました！:" + user_code.value);
        }
    </script>

</body>

</html>