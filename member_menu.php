<?php
session_start(); // セッションの開始
include('functions.php');
check_session_id(); // idチェック関数の実行
$pdo = dbConnect();

// $pdo = connect_to_db();

$user_id = $_SESSION["id"];
$name = $_SESSION["name"];

$group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得


try {
    // $sql = 'SELECT * FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id';
    $sql = 'SELECT * FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
    $status = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";

    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["group.name"]}</td>";
        $output .= "</tr>";
    }
    unset($record);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
// var_dump($result);
// exit();


$sql = 'SELECT * FROM user';

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
    <title>メンバーメニュー画面</title>
</head>

<body>
    <header>
        <div><a href="new_in.php"><?= $output ?></a></div>
        <div><?= $group_id ?></div>
        <ul>
            <li><a href="user_entry.php">
                    <?= $name ?></a></li>
            </a></li>
            <li><a href="tsuchi.html">通知</a></li>
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <div>
        <div><a href="member_staff.php">スタッフ</a></div>
        <!-- シフト・売上・在庫等をこちらへ表示予定 -->
    </div>

    <footer>
    </footer>

</body>

</html>