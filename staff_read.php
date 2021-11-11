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
// $user_id = $_GET['id'];


$sql = 'SELECT user.id, user.user_code, user.mail, user.password, user.name AS user_name, group.id,group.group_code,group.name AS group_name,group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN `group` ON group_member.group_id = group.id INNER JOIN user ON group_member.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$status = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定

$output = "";
$array = "";
$third = "";

foreach ($result as $record) {
    // var_dump($result);
    // exit();

    // グループ名を取得
    $array .= "<p><a href=\"group_account.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_name"]}</a></p>";
}

try {
    $sql = 'SELECT * FROM staff_page LEFT OUTER JOIN `group` ON staff_page.group_id = group.id INNER JOIN user ON staff_page.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id ';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
    $status = $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    // var_dump($result);
    // exit();
    foreach ($result as $display) {
        //グループの登録があれば、グループ名を呼び出す    foreach ($result as $row) {
        $output .= "<div>";
        // $output .= "<p>URL:{$display["qr"]}</p>";
        $output .= "<h3>{$display["title"]}</h3>";
        // $output .= "<p>{$display["file"]}</p>";
        $output .= "<p>{$display["writting"]}</p>";
        $output .= "<p>ご依頼：{$display["request"]}</p>";
        $output .= "<p>インスタ：{$display["instagram"]}</p>";
        $output .= "<p><a href=\"staff_edit.php?user_id={$display["user_id"]}&group_id={$display["group_id"]}\">編集する</a></p>";
        $output .= "</div>";
    }
    unset($display);
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
    <title>スタッフページ</title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <header>
        <h2><?= $array ?></h2>
        <ul>
            <li><a href="member_staff.php?group_id=<?= $group_id ?>">戻る</a></li>
        </ul>
    </header>

    <div>
        <div>
            <h2><?= $record["user_name"] ?></h2>
            <div>URL：<?= $_SERVER["REQUEST_URI"] ?></div>
        </div>

        <div><?= $output ?></div>
        <!-- 
        <div>
            <p>サンプル画面です</p>
            <p>あなたの事業内容</p>
        </div>
        <div>
            <img src="imgファイル/IMG_0773.JPG" title="image">
        </div>
        <div>
            <p>実績等</p>
        </div>
            <div>
        <p>要望・お仕事依頼等...</p>
    </div>

 -->
    </div>
</body>

</html>