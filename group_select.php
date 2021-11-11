<?php
session_start(); // セッションの開始
include('functions.php');
check_session_id(); // idチェック関数の実行

$pdo = connect_to_db();

$user_id = $_SESSION["id"];
$name = $_SESSION["name"];

// $group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得
try {
    // $sql = 'SELECT * FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id';
    $sql = 'SELECT user.id, user.user_code, user.mail, user.password, user.name AS user_name, group.id,group.group_code,group.name AS group_name,group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id ';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    // $stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
    $status = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    $array = "";
    // var_dump($result);
    // exit();


    if (count($result) > 0) {
        foreach ($result as $record) {
            //グループの登録があれば、グループ名を呼び出す
            $output .= "<div><a href=\"member_menu.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">・{$record["group_name"]}</a></div>";
        }
        unset($record);
    } else {
        echo "<p><a href=\"new_in.php?\">グループを作成する</a></p>";
        // foreach ($result as $user) {
        //     $array .= "<div><a href=\"user_entry.php?user_id={$user["user_id"]}\">・{$user["user_name"]}</a></div>";
        // }
        unset($user);

        // exit();
    }
} catch (Exception $e) {
    echo $e->getMessage();
    // exit();
}
foreach ($result as $user) {
    $array .= "<div><a href=\"user_entry.php?user_id={$user["user_id"]}\">{$user["user_name"]}</a></div>";
    // var_dump($array);
    // exit();
}
unset($user);
// var_dump($result);
// exit();
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン後のグループ選択</title>
</head>

<body>
    <header>
        <!-- グループ名の表示 -->
        <div><?= $output ?></a></div>
        <ul>
            <!-- ユーザー名の表示 -->
            <li><?= $array ?></li>
            <!-- <li><a href="tsuchi.html">通知</a></li> -->
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <p>退会・グループの削除ページをどこに作るか</p>

    <footer>
    </footer>

</body>

</html>