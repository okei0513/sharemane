<?php
session_start(); // セッションの開始
include('functions.php');
check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();

$id = $_SESSION["id"];

$group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得

// $sql = 'SELECT * FROM post INNER JOIN user ON post.code = user.code INNER JOIN comment ON post.post_id = comment.post_id WHERE post.slug=?';
// $sql = 'SELECT * FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id';
try {
    $sql = 'SELECT * FROM group_member INNER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE group.name';
    $stmt = $pdo->prepare($sql);
    $status = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    var_dump($result);
    exit();
    $output = "";
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["name"]}</td>";
        $output .= "</tr>";
    }
    unset($record);
} catch (Exception $e) {
    echo $e->getMessage();
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
        <ul>
            <li><a href="user_entry.php">
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