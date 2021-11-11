<?php
session_start(); // セッションの開始
include('functions.php');
check_session_id(); // idチェック関数の実行

$pdo = connect_to_db();
$id = $_SESSION["id"];
$name = $_SESSION["name"];


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
    <title>新規グループ名</title>
</head>

<body>
    <header>
        <ul>
            <li><?= $name ?></li>
            <!-- <li><a href="tsuchi.html">通知</a></li> -->
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>
    <form action="new_group_name_creat.php" method="post">
        <div>
            <p>社名またはグループ名を決める</p>
            <input type="text" name="groupname" required="required" placeholder="新しいグループ名">
        </div>
        <button>次へ</button>
    </form>

    <footer>
        <ul>
            <li><a href="new_in.php?">戻る</a></li>
        </ul>
    </footer>



</body>

</html>