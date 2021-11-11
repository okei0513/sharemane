<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
// 送信されたidをgetで受け取る
$user_id = $_GET['user_id'];
$group_id = $_GET['group_id'];
// $pdo = dbConnect();
$pdo = connect_to_db();

$sql = 'SELECT user.id, user.user_code, user.mail, user.password, user.name AS user_name, group.id,group.group_code,group.name AS group_name,group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$status = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
$array = "";
$output = "";
foreach ($result as $record) {
    // グループ名を取得したい！現在はグループコード(groupのnameがほしい。nameはuserテーブルにもある。セッション変数としても使用済)
    $array .= "<p><a href=\"group_account.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_name"]}</a></p>";
}
$sql = 'SELECT * FROM staff_page LEFT OUTER JOIN `group` ON staff_page.group_id = group.id INNER JOIN user ON staff_page.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id ';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$status = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
foreach ($result as $row) {
    // var_dump($result);
    // exit();
    $output .= "<p><a href=\"staff_delete_delete.php?user_id={$row["user_id"]}&group_id={$row["group_id"]}\">削除する</a></p>";
}
if ($status == false) {
    $error = $stmt->errorInfo(); //失敗時はエラー
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $diplay = $stmt->fetch(PDO::FETCH_ASSOC);
}
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
    <header>
        <h2><?= $array ?></h2>
        <ul>
            <li><a href="staff_read.php?group_id=<?= $group_id ?>&user_id=<?= $user_id ?>">戻る</a></li>
        </ul>
    </header>
    <fieldset>
        <h2><?= $record["user_name"] ?>さん</h2>
        <p>のページを削除しますか</p>
        <p><?= $output ?></p>
    </fieldset>
</body>

</html>