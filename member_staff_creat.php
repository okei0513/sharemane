<?php
include('functions.php');
// $pdo = dbConnect();

$pdo = connect_to_db();

$sql = 'INSERT INTO group_member(id, group_id, user_id, business, is_admin)
VALUES(NULL, :group_id, :user_id, :business, 0)'; // SQL作成
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':group_id', $group_id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':business', $business, PDO::PARAM_INT);
$status = $stmt->execute(); // SQL実行
if ($status == false) {
    // エラー処理
} else {
    header('Location:member_staff.php');
}
