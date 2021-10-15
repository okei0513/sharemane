<?php

session_start();
include('functions.php');
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
        // $output .= "<td>{$record["user_id"]}</td>";
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
    <title>登録完了ファースト画面</title>
</head>

<body>
    <header>
        <ul>
            <li><a href="user_entry.php"><?= $result[0]["name"] ?></a></li>
            <li><a href="tsuchi.html">通知</a></li>
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <div>
        <!-- 新規グループ作成 -->
        <p><a href="new_group_name.php">グループを作成</a></p>
        <p>グループを検索する<br>
            グループID：<input type="text"><button>確認</button>
        </p>
        <p>
            グループに招待してもらう<br>
            あなたのID：<input type="text"><button>コピー</button>
        </p>
    </div>
    <footer>
        <ul>
            <li><a href="top.php">戻る</a></li>
            <li>次へ</li>
        </ul>
    </footer>
</body>

</html>