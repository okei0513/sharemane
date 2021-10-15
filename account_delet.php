<?php
// var_dump($_GET);
// exit();

//DBの接続
include('functions.php');
$pdo = connect_to_db();

$id = $_POST['id'];

// idを指定して更新するSQLを作成 -> 実行の処理
$sql = 'DELETE FROM users_list WHERE id=:id'; //WHERE id=:id

//１ヶ月経ったら物理削除するという設定方法もあり

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 各値をpostで受け取る
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
    header("Location:top.php");
    exit();
};
