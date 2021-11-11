<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
// $id = $_SESSION["id"];
// $name = $_SESSION["name"];
// $mail = $_SESSION["mail"];
// $user_code = $_SESSION["user_code"];
$id = $_GET['user_id'];
// var_dump($id);
// exit;
$pdo = connect_to_db();

$sql = 'SELECT * FROM user WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
$array = "";
foreach ($result as $record) {
    $array .= "<table>";
    $array .= "<tr><th>表示名</th><td>{$record["name"]}</td></tr>";
    $array .= "<tr><th>メールアドレス</th><td>{$record["mail"]}</td></tr>";
    $array .= "<tr><th>ユーザーID</th><td>{$record["user_code"]}</td></tr>";
    $array .= "<p><a href=\"user_entry_hensyu.php?id={$record["id"]}\">編集する</a></p>";
    $array .= "</table>";
    unset($display);
}
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
        <button><a href="group_select.php?id=<?= $id ?>">閉じる</a></button>
        <div>
            <h2>登録内容</h2>
            <?= $array ?>

        </div>
    </fieldset>


    <!-- <script>
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
    </script> -->

</body>

</html>