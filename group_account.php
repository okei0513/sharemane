<?php

session_start();
include('functions.php');
check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();

$name = $_SESSION["name"];

$user_id = $_GET['user_id'];
$group_id = $_GET['group_id'];
// var_dump($_GET);
// exit();
$sql = 'SELECT user.id, user.user_code, user.mail, user.password, user.name AS user_name, group.id,group.group_code,group.name AS group_name,group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id';

$stmt = $pdo->prepare($sql);
// $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

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
    $array = "";
    foreach ($result as $record) {

        $output .= "<p><a href=\"member_menu.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_name"]}</a></p>";
    }

    foreach ($result as $row) {
        $array .= "{$row["group_code"]}";
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
    <title>登録完了ファースト画面</title>
</head>

<body>
    <header>
        <ul>
            <li><a href="user_entry.php">
                    <?= $record["user_name"] ?></a>
            </li>
            <!-- <li><a href="tsuchi.html">通知</a></li> -->
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
            <?= $output ?>グループに招待する<br>
            グループのID：<input id="group_code" type="text" name="group_code" value="<?= $array ?>" readonly>
            <button onclick="copyToClipboard()">コピー</button>
        </p>
    </div>
    <footer>
        <ul>
            <li><a href="member_menu.php">戻る</a></li>
        </ul>
    </footer>



    <script>
        // ここからグループIDをコピーするJS
        function
        copyToClipboard() {
            //コピー対象をJavaScript上で変数として定義する
            var group_code = document.getElementById("group_code");
            //コピー対象のテキストを選択する
            group_code.select();
            //選択しているテキストをクリップボードにコピーする
            document.execCommand("Copy");
            //コピーをお知らせする
            alert("コピーできました！:" + group_code.value);
        }
    </script>

</body>

</html>