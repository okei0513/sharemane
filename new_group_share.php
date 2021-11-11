<?php
session_start(); // セッションの開始
include('functions.php');
check_session_id(); // idチェック関数の実行

$pdo = connect_to_db();
$user_id = $_GET["user_id"];
$group_id = $_GET["group_id"];
$name = $_SESSION["name"];

$sql = 'SELECT id AS user_id, name AS user_name FROM user';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

$sql = 'SELECT id AS group_id, group_code, name FROM `group`';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    // var_dump($result);
    // exit();
    $output = "";

    foreach ($result as $record) {
        // $output .= "<div><a href=\"member_menu.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">・{$record["group_name"]}</a></div>";
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
    <title>新規グループシェア画面</title>
</head>

<body>
    <header>
        <ul>
            <li><?= $name ?></li>
            <!-- <li><a href="tsuchi.html">通知</a></li> -->
            <li><a href="login_logout.php">ログアウト</a></li>
        </ul>
    </header>

    <div>
        <!-- <p>
            メンバーを招待する<br>
            <button>リンクを共有する</button>
        </p> -->
        <p>グループIDを教える<br>
            グループID：<input id="group_code" type="text" name="group_code" value="<?= $result[10]["group_code"] ?>" readonly>
            <button onclick="copyToClipboard()">コピー</button>
        </p>
        <!-- <p>メンバーの検索<br>
            メンバーのID：<input type="text"><button>追加</button>
        </p> -->
    </div>

    <footer>
        <ul>
            <li><a href="member_menu.php?group_id=<?= $group_id ?>&user_id=<?= $user_id ?>">次へ</a></li>
        </ul>
    </footer>


    <script>
        // ここからグループIDをコピーするJS
        function
        copyToClipboard() {
            //コピー対象をJavaScript上で変数として定義する
            var group_code = document.getElementById(" group_code");
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