<?php
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
    // グループ名を取得,グループ情報の確認画面へ以降ボタン
    $array .= "<p><a href=\"group_account.php?user_id={$record["user_id"]}&group_id={$record["group_id"]}\">{$record["group_name"]}</a></p>";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフページ登録画面</title>
</head>

<body>
    <!-- ヘッダー部分 -->
    <header>
        <h2><?= $array ?></h2>
        <ul>
            <li><a href="member_staff.php?group_id=<?= $group_id ?>&user_id=<?= $user_id ?>">戻る</a></li>
        </ul>
    </header>
    <!-- メイン部分 -->
    <div>
        <div>
            <h3><?= $record["user_name"] ?>さんの事業紹介ページ作成</h3>
            <form action="staff_create.php?user_id=<?= $user_id ?>&group_id=<?= $group_id ?>" method="POST">
                <!-- 画像挿入の際は「enctype="multipart/form-data"」を↑に追記する -->
                <fieldset>
                    <div>
                        事業内容タイトル : <input type="text" name="title" required="required">
                    </div>
                    <!-- <div>
                        <input type="file" name="file" accept="image/*" capture="camera">
                    </div> -->
                    <div>
                        実績や事業説明: <input type="text" name="writting" required="required">
                    </div>
                    <div>
                        ご依頼・要望等: <input type="text" name="request" required="required">
                    </div>
                    <div>
                        インスタURL: <input type="text" name="instagram">
                    </div>
                    <div>
                        <button class="button">登録する</button>
                    </div>
                </fieldset>
            </form>
        </div>


</body>

</html>