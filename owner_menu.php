<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

$pdo = connect_to_db();

$sql = 'SELECT * FROM user';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    // var_dump($result);
    // exit();
    $output = "";

    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["name"]}</td>";
        $output .= "</tr>";
    }
    unset($record);
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>オーナーメニュー画面</title>
</head>

<body>
    <header>
        <div>グループ名の表示</div>
        <ul>
            <li><a href="user_entry.php"><?= $output ?></a></li>
            <li><a href="tsuchi.html">通知</a></li>
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <div>
        <div><a href="member_staff.php">スタッフ</a></div>
        <div><a href="owner_kanri_menu.php">管理者</a></div>
    </div>

    <footer>
    </footer>

</body>

</html>