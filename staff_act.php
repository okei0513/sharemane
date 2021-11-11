<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();

$user_id = $_GET['user_id'];
$group_id = $_GET['group_id'];
// var_dump($_GET);
// exit;

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
}

$sql = 'SELECT * FROM staff_page LEFT OUTER JOIN `group` ON staff_page.group_id = group.id INNER JOIN user ON staff_page.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id ';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$status = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
// var_dump($result);
// exit();
if (count($result) > 0) {
    foreach ($result as $display) {

        // スタッフ個人ページを表示 
        header("Location:staff_read.php?user_id={$display["user_id"]}&group_id={$display["group_id"]}");
    }
} else {
    header("Location:staff_input.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}"); // 入力ページへ移動
    exit();
}


    // 
    // unset($row);
