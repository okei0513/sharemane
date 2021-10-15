<?php
$id = $_POST['id'];
$namae = $_POST['qr'];
$mail = $_POST['file'];
$id = $_POST['writting'];
$namae = $_POST['request'];
$mail = $_POST['instagram'];

//DBの接続
include('functions.php');
$pdo = connect_to_db();

// idを指定して更新するSQLを作成（UPDATE文）
$sql = "UPDATE user SET name=:name, mail=:mail WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':qr', $qr, PDO::PARAM_STR);
$stmt->bindValue(':file', $file, PDO::PARAM_STR);
$stmt->bindValue(':writting', $writting, PDO::PARAM_INT);
$stmt->bindValue(':request', $request, PDO::PARAM_STR);
$stmt->bindValue(':instagram', $instagram, PDO::PARAM_STR);

$status = $stmt->execute();

// 各値をpostで受け取る
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常に実行された場合は一覧ページファイルに移動し，処理を実行する
    header("Location:staff_input.php");
    exit();
}
