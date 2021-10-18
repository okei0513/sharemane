<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

// $pdo = dbConnect();

$pdo = connect_to_db();
$user_id = $_SESSION["id"];
$name = $_SESSION["name"];


// $group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得

try {
    $sql = 'SELECT * FROM group_member LEFT OUTER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $status = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    // var_dump($result);
    // exit();

    $output = "";

    foreach ($result as $row) {
        $output .= "<table>";
        $output .= "<tr>";
        // スタッフ名一覧を取得
        $output .= "<td><a href=\"staff_input.php?user_id={$row["user_id"]}&group_id={$row["group_id"]}\">・{$row["name"]}</a></td>";

        $output .= "</tr>";
        $output .= "</table>";
    }
    unset($row);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$sql =
    'SELECT * FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute();

// // var_dump($user_id);
// // exit();
if ($status == false) {
    $error = $stmt->errorInfo(); //失敗時はエラー
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // データの出力用変数（初期値は空文字）を設定
    $array = "";
    // var_dump($result);
    // exit;    
    foreach ($result as $record) {
        $array .= "<table>";
        $array .= "<tr>";
        // グループ名を取得したい！現在はグループコード(groupのnameがほしい。nameはuserテーブルにもある。セッション変数としても使用済)
        $array .= "<td><a href=\"new_in.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_code"]}</a></td>";

        $array .= "</tr>";
        $array .= "</table>";
    }
    unset($row);
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
        <!-- グループ名の表示をしたい（現在はグループコードの表示） -->
        <div><a href="new_in.php"><?= $array ?></div>
        <ul>
            <!-- スタッフ名一覧を表示 -->
            <li><a href="user_entry.php"><?= $name ?></a></li>
            <!-- <li><a href="tsuchi.html">通知</a></li> -->
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
                <!-- <p>事業内容</p> -->
            </div>

        </div>
    </div>

    <footer>
        <li><a href="member_menu.php">戻る</a></li>
    </footer>

</body>

</html>