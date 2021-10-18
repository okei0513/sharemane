<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

// $pdo = dbConnect();

$pdo = connect_to_db();
$id = $_SESSION["id"];
$name = $_SESSION["name"];


$group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得

try {
    $sql = 'SELECT * FROM group_member LEFT OUTER JOIN user ON group_member.user_id = user.id';

    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    // var_dump($result);
    // exit();

    $output = "";

    foreach ($result as $row) {
        $output .= "<table>";
        $output .= "<tr>";
        $output .= "<td><a href=\"staff_input.php?user_id={$row["user_id"]}&group_id={$row["group_id"]}\">{$row["name"]}</a></td>";

        $output .= "</tr>";
        $output .= "</table>";
    }
    unset($row);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$sql = 'SELECT * FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// // var_dump($user_id);
// // exit();
if ($status == false) {
    $error = $stmt->errorInfo(); //失敗時はエラー
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
    <title>メンバーのスタッフ紹介画面</title>
</head>

<body>
    <header>
        <div>グループ名の表示</div>
        <ul>
            <li><?= $name ?></li>
            <li><a href="tsuchi.html">通知</a></li>
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <div>

        <div>
            <h2>スタッフ紹介</h2>
        </div>

        <div>
            <div>
                <?= $output ?>
                <p>事業内容</p>
            </div>

        </div>
    </div>

    <footer>
        <li><a href="member_menu.php">戻る</a></li>
    </footer>

</body>

</html>