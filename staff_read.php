<?php
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

// $group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得

var_dump($id);
exit;

$pdo = connect_to_db();

$sql = 'SELECT * FROM staff_page WHERE user_id=:user_id AND group_id=:group_id';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
}
