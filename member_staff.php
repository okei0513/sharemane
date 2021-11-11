<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();
$user_id = $_SESSION["id"];
$name = $_SESSION["name"];
$group_id = $_GET['group_id'];

// var_dump($_GET);
// exit();

// $group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得

try {
    $sql = 'SELECT user.id, user.user_code, user.mail, user.password, user.name AS user_name, group.id,group.group_code,group.name AS group_name,group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);

    $status = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    // var_dump($result);
    // exit();
    $array = "";
    $output = "";
    // if (count($result) > 0) {
    foreach ($result as $record) {
        // グループ名を取得したい！現在はグループコード(groupのnameがほしい。nameはuserテーブルにもある。セッション変数としても使用済)
        $array .= "<p><a href=\"group_account.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_name"]}</a></p>";
    }
    unset($record);
    // スタッフ名一覧を取得
    foreach ($result as $row) {
        $output .= "<table>";
        $output .= "<tr>";
        $output .= "<td><a href=\"staff_act.php?user_id={$row["user_id"]}&group_id={$row["group_id"]}\">・{$row["user_name"]}</a></td>";
        $output .= "</tr>";
        $output .= "</table>";
    }
    unset($row);
    // } else {
    // $output .= "<p><a href=\"new_in.php?\">メンバーがいませんグループを作成してください</a></p>";
    // exit();
    // }
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
    <title>メンバーのスタッフ一覧画面</title>
</head>

<body>
    <header>
        <!-- グループ名の表示をしたい（現在はグループコードの表示） -->
        <div><?= $array ?></div>
        <ul>
            <!-- ユーザー名を表示 -->
            <li><a href="user_entry.php?id=<?= $user_id ?>"><?= $name ?></a></li>
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

    <!-- <footer>
        <li><a href='member_menu.php?id={$record["id"]}'>戻る</a></li>
    </footer> -->

</body>

</html>