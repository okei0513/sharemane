<?php
$id = $_POST['id'];
$namae = $_POST['namae'];
$mail = $_POST['mail'];
$user_code = $_POST['user_code'];


//DBの接続
session_start();
include("functions.php");
check_session_id();
$pdo = connect_to_db();

// idを指定して更新するSQLを作成（UPDATE文）
$sql = "UPDATE user SET name=:name, mail=:mail, user_code=:user_code WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $namae, PDO::PARAM_STR);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':user_code', $user_code, PDO::PARAM_INT);

$status = $stmt->execute();

// 各値をpostで受け取る
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
    header("Location:user_entry.php");
    exit();
}

//更新は負荷・コストかかる
//更新処理は必要か要検討
