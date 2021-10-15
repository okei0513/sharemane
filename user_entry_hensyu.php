<?php
// var_dump($_POST);
// exit();

// 関数ファイル読み込み
session_start();
include("functions.php");
check_session_id();
$id = $_SESSION["id"];
$name = $_SESSION["name"];
$mail = $_SESSION["mail"];
$user_code = $_SESSION["user_code"];


// 送信されたidをgetで受け取る
$id = $_GET['id'];

// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
$sql = 'SELECT * FROM user WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// fetch()で1レコード取得できる．
if ($status == false) {
    $error = $stmt->errorInfo(); //失敗時はエラー
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容編集画面</title>
</head>

<body>
    <fieldset>
        <p><a href="user_entry.php">閉じる</a></p>

        <div>
            <h2>登録内容</h2>
        </div>
        <form action="user_entry_update.php" method="POST">

            <div>
                <p>表示名：<input type="text" name="namae" value="<?= $name ?>"></p>
                <p>メールアドレス：<input type="text" name="mail" value="<?= $mail ?>"></p>
                <p>あなたのID：<input type="text" name="user_code" value="<?= $user_code ?>" readonly></p>
            </div>

            <div>
                <button>保存する</button>
            </div>
            <!-- // idを見えないように送る.input type="hidden"を使用する！form内に以下を追加 -->
            <input type="hidden" name="id" value="<?= $record['id'] ?>">

        </form>

    </fieldset>
</body>

</html>