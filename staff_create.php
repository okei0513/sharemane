<?php
// var_dump($_POST);
// exit();
// DB接続情報
session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();
$user_id = $_GET['user_id'];
$group_id = $_GET['group_id'];
// var_dump($_GET);
// exit();
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
    // グループ名を取得
    $array .= "<p><a href=\"group_account.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_name"]}</a></p>";
}

//入力チェック(未入力の場合は弾く，commentのみ任意) 
// issetは「ありますか？」、!isset「ないですよね」
//  || は or の意味
if (
    !isset($_POST['title']) || $_POST['title'] == '' ||
    // !isset($_POST['file']) || $_POST['file'] == '' ||
    !isset($_POST['writting']) || $_POST['writting'] == '' ||
    !isset($_POST['request']) || $_POST['request'] == ''
) {
    exit('ParamError');
};

//データを変数に格納
$title = $_POST['title'];
// $file = $_POST['file'];
$writting = $_POST['writting'];
$request = $_POST['request'];
$instagram = $_POST['instagram'];

//staff_pageのテーブルへ
$sql = 'INSERT INTO staff_page(id, group_id, user_id, title, writting, request, instagram)
        VALUES(NULL, :group_id, :user_id, :title, :writting, :request, :instagram)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
// $stmt->bindValue(':file', $file, PDO::PARAM_STR);
$stmt->bindValue(':writting', $writting, PDO::PARAM_STR);
$stmt->bindValue(':request', $request, PDO::PARAM_STR);
$stmt->bindValue(':instagram', $instagram, PDO::PARAM_STR);
$status = $stmt->execute(); // SQLを実行

$sql = 'SELECT * FROM staff_page LEFT OUTER JOIN `group` ON staff_page.group_id = group.id INNER JOIN user ON staff_page.user_id = user.id WHERE user_id=:user_id AND group_id=:group_id ';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$status = $stmt->execute();

// 失敗時にエラーを出力し,成功時は登録画面に戻る
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header("Location:staff_read.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}");
    exit();
}
