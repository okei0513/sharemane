<?php
// var_dump($_POST);
// exit();
session_start(); // セッションの開
include('functions.php');
check_session_id(); // idチェック関数の実行
$pdo = connect_to_db();
$user_id = $_SESSION["id"];

if (
    !isset($_POST['groupname']) || $_POST['groupname'] == ''
) {
    exit('ParamError');
};

//データを変数に格納
$groupname = $_POST['groupname'];
// var_dump($_POST);
// exit();


try {
    $sql = 'INSERT INTO `group`(id, group_code, name) VALUES(NULL, :group_code, :name)';
    $stmt = $pdo->prepare($sql);
    $group_code = uniqid(); //グループIDを取得
    $stmt->bindValue(':group_code', $group_code, PDO::PARAM_STR);
    $stmt->bindValue(':name', $groupname, PDO::PARAM_STR);
    // var_dump($_POST);
    // exit();

    $status = $stmt->execute(); // SQLを実行

} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
// テーブルgroup_memberを作成
$group_id = $pdo->lastInsertId(); //直近のログインのグループIDを取得

//INSERT後にPDOオブジェクトからIDを取得できる
$sql = 'INSERT INTO group_member(id, group_id,user_id) VALUES(NULL, :group_id, :user_id)';
$stmt = $pdo->prepare($sql);
// var_dump($user_id);
// exit();
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$status = $stmt->execute(); //SQL実行
if ($status == false) {
    $error = $stmt->errorInfo(); //失敗時はエラー
    echo json_encode(["error_msg" => "{$error[2]}"]);
} else {
    header("Location:new_group_share.php?group_id=<?= $group_id ?>&user_id=<?= $user_id ?>");
    exit();
}


// $sql = 'SELECT group_member.id,group_member.group_id,group_member.user_id FROM group_member LEFT OUTER JOIN user ON group_member.user_id = user.id';
