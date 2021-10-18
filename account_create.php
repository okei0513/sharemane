<?php
// var_dump($_POST);
// exit();

//入力チェック(未入力の場合は弾く，commentのみ任意) 
// issetは「ありますか？」、!isset「ないですよね」
//  || は or の意味
if (
    !isset($_POST['mail']) || $_POST['mail'] == '' ||
    !isset($_POST['password']) || $_POST['password'] == '' ||
    !isset($_POST['namae']) || $_POST['namae'] == ''
) {
    exit('ParamError');
};

//データを変数に格納
$mail = $_POST['mail'];
$password = $_POST['password'];
$namae = $_POST['namae'];

// (uniqid("userid_"));

// DB接続情報
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

// $pdo = dbConnect();

$pdo = connect_to_db();

//SQLで表示⇨VALUESを編集

//userのテーブルへ
$sql = 'INSERT INTO user(id, user_code, mail, password, name, is_deleted, created_at, updated_at)
        VALUES(NULL, :user_code, :mail, :password, :name, 0, sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$user_code = uniqid();
$stmt->bindValue(':user_code', $user_code, PDO::PARAM_STR);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':name', $namae, PDO::PARAM_STR);

$status = $stmt->execute(); // SQLを実行

// 失敗時にエラーを出力し,成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header("Location:new_in.php");
    exit();
}
