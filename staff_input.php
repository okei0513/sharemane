<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
// $pdo = dbConnect();

$pdo = connect_to_db();
// var_dump($_GET["user_id"]);
// exit;

$user_id = $_GET['user_id'];
$group_id = $_GET['group_id'];
$_SERVER["REQUEST_URI"];

$sql = 'SELECT user.id, user.user_code, user.mail, user.password, user.name AS user_name, group.id,group.group_code,group.name AS group_name,group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$status = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定

$output = "";
$array = "";
foreach ($result as $record) {
    // var_dump($result);
    // exit();

    // グループ名を取得したい！現在はグループコード(groupのnameがほしい。nameはuserテーブルにもある。セッション変数としても使用済)
    $array .= "<p><a href=\"group_account.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_name"]}</a></p>";
}


$sql = 'SELECT * FROM staff_page LEFT OUTER JOIN `group` ON staff_page.group_id = group.id INNER JOIN user ON staff_page.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id ';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
} else {
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // データの出力用変数（初期値は空文字）を設定
    foreach ($result as $row)
        if (count($result) > 0) {
            // スタッフページに登録されているときは情報の表示画面(staff_read.php)に飛ばす

            header("staff_read.php?user_id={$row["user_id"]}&group_id={$row["group_id"]}");
        }


    //     foreach ($result as $record) {
    //         $output .= "<tr>";
    //         $output .= "<td>{$record["qr"]}</td>";
    //         $output .= "<td>{$record["file"]}</td>";
    //         $output .= "<td>{$record["writting"]}</td>";
    //         $output .= "<td>{$record["request"]}</td>";
    //         $output .= "<td>{$record["instagram"]}</td>";
    //         $output .= "</tr>";
    //     }
    //     unset($record);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフページ</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <header>
        <div><?= $array ?></div>

        <ul>
            <li><a href="member_staff.php?group_id=<?= $group_id ?>">戻る</a></li>
            <li><a href="staff_edit.php?user_id=<?= $user_id ?>&group_id=<?= $group_id ?>">編集する</a></li>

        </ul>
    </header>

    <div>
        <div>
            <div><?= $record["user_name"] ?></div>
            <div>URL：<?= $_SERVER["REQUEST_URI"] ?>
            </div>
        </div>

        <div>・事業内容</div>

        <div>
            <div>
                <img src=" imgファイル/IMG_0372.jpg" title="image">
            </div>

            <div>
                <p>サンプル</p>
                <p>こちらに入力ください</p>
            </div>

            <div>
                <img src="imgファイル/IMG_0372.jpg" title="image">
            </div>

            <div>
                <p>サンプル</p>
                <p>こちらに入力ください</p>
            </div>
            <!-- <form action="" method="post"></form>を使用。必ず、「enctype="multipart/form-data"」を記載すること -->

        </div>

        <div>
            <p>要望・お仕事依頼等...</p>
        </div>

        <div>
            インスタグラムの連動させたい
        </div>

    </div>

    <footer>
    </footer>

</body>

</html>