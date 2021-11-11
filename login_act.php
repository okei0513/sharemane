<?php

session_start();
include("functions.php"); // DBファイルの読み込み
// $pdo = dbConnect();

$pdo = connect_to_db(); //関数実行
$mail = $_POST["mail"];
$password = $_POST["password"];

// DBにデータがあるかどうか検索

$sql = 'SELECT * FROM user WHERE mail=:mail AND password=:password AND is_deleted=0';
// var_dump($sql);
// exit;
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// DBのデータ有無で条件分岐
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $val = $stmt->fetch(PDO::FETCH_ASSOC); // 該当レコードだけ取得
    // var_dump($val);
    // exit();
}
if (!$val) { // 該当データがないときはログインページへのリンクを表示
    echo "<p>ログイン情報に誤りがあります．</p>";
    echo '<a href="login.php">login</a>';
    exit();
    // DBにデータがあればセッション変数に格納
} else {
    // var_dump($val);
    // exit();

    $_SESSION = array(); // セッション変数を空にする
    $_SESSION["session_id"] = session_id();
    $_SESSION["id"] = $val["id"];
    $_SESSION["mail"] = $val["mail"];
    $_SESSION["name"] = $val["name"];
    $_SESSION["user_code"] = $val["user_code"];
    // var_dump($val);
    // exit();
    // セッション変数にID/mail/nameを挿入する

    header("Location:group_select.php?id={$_SESSION["id"]}"); // 一覧ページへ移動
    exit();
}
