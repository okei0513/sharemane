<?php
session_start(); // セッションの開始
include('functions.php');
check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();

$name = $_SESSION["name"];
$user_id = $_GET['user_id'];
$group_id = $_GET['group_id'];
// $group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得
try {
    // $sql = 'SELECT * FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id';
    $sql = 'SELECT user.id, user.user_code, user.mail, user.password, user.name AS user_name, group.id,group.group_code,group.name AS group_name,group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id ';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
    $status = $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    $array = "";
    // var_dump($result);
    // exit();
    foreach ($result as $record) {
        //グループの登録があれば、グループ名を呼び出す
        $output .= "<p><a href=\"group_account.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">・{$record["group_name"]}</a></p>";
    }
    unset($record);
    foreach ($result as $row) {
        //スタッフページへ移る
        $array .= "<p><a href=\"member_staff.php?group_id={$row["group_id"]}\">スタッフ</a></p>";
    }
    unset($row);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
// var_dump($result);
// exit();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>選択したグループメニュー画面</title>
</head>

<body>
    <header>
        <!-- グループ名の表示 -->
        <div><?= $output ?></div>
        <div><a href="new_in.php?">グループを作成する</a></div>
        <ul>
            <!-- ユーザー名の表示 -->
            <li><a href="user_entry.php?user_id=<?= $user_id ?>"><?= $name ?></a></li>
            <li><a href=" login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <div>
        <div><?= $array ?></div>
        <!-- シフト・売上・在庫等をこちらへ表示予定 -->
    </div>

    <div>
        <a href="group_select.php">戻る</a>

    </div>
    <footer>
    </footer>

</body>

</html>