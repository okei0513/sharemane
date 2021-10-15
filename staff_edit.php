<?php
// var_dump($_POST);
// exit();

// 関数ファイル読み込み
session_start();
include("functions.php");
check_session_id();

// 送信されたidをgetで受け取る
$id = $_GET['id'];

// // DB接続&id名でテーブルから検索

$pdo = connect_to_db();
$sql = 'SELECT * FROM staff_page WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// fetch()で1レコード取得できる．
if ($status == false) {
    $error = $stmt->errorInfo(); //失敗時はエラー
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スタッフページ編集画面</title>
</head>

<body>
    <header>
        <div>グループ名の表示</div>

        <ul>
            <li><a href="staff_input.php">戻る</a></li>
            <li><a href="">保存する</a></li>
        </ul>
    </header>

    <div>
        <div>
            <div>ユーザー名</div>
            <div>QRコード</div>
        </div>
        <form action="staff_update.php" method="POST">

            <div><input type="text" name="business" value="<?= $record["business"] ?>"></div>

            <div>
                <div>
                    <input type="file" name="file" accept="image/*" capture="camera">
                </div>

                <div>
                    <p>サンプル</p>
                    <p>こちらに入力ください</p>
                </div>

                <div>
                    <input type="file" name="upfile" accept="image/*" capture="camera">
                </div>

                <div>
                    <p>サンプル</p>
                    <p>こちらに入力ください</p>
                </div>
                <!-- <form action="" method="post"></form>を使用。必ず、「enctype="multipart/form-data"」を記載すること -->

            </div>

            <div>
                <p>要望・お仕事依頼等...</p>
            </div>

            <div>
                <p>インスタグラムの連動させたい</p>

                インスタグラムURL<input type="text" name="" placeholder="url"><button>確定</button>
            </div>
        </form>
        <button>スタッフページを削除する</button>
    </div>

    </div>

    <footer>
    </footer>

</body>

</html>