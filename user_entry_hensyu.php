<?php
// var_dump($_POST);
// exit();

// 関数ファイル読み込み
session_start();
include("functions.php");
check_session_id();
$name = $_SESSION["name"];
$mail = $_SESSION["mail"];
$user_code = $_SESSION["user_code"];
// 送信されたidをgetで受け取る
$id = $_GET['id'];

$pdo = connect_to_db();
$sql = 'SELECT user.id AS user_id , user.user_code, user.mail, user.password, user.name FROM user WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
$output = "";
$user_id = $id;
foreach ($result as $record) {
    // var_dump($result);
    // exit();
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
    <title>登録内容編集画面</title>
</head>

<body>
    <fieldset>
        <p><a href="user_entry.php?id=<?= $user_id ?>">閉じる</a></p>

        <!-- <p><a href='user_entry.php?user_id={$record["user_id"]}'>閉じる</a></p> -->

        <div>
            <h2>登録内容</h2>
        </div>
        <form action="user_entry_update.php?user_id=<?= $user_id ?>" method="POST">

            <div>
                <p>表示名：<input type="text" name="namae" value="<?= $record["name"] ?>"></p>
                <p>メールアドレス：<input type="text" name="mail" value="<?= $record["mail"] ?>"></p>
                <p>あなたのID：<input type="text" name="user_code" value="<?= $record["user_code"] ?>" readonly></p>
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