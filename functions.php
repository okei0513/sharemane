<?php
// function connect_to_db()
// {
//     $dbn = 'mysql:/CLEARDB_DATABASE_URL=/b0131df80f3cb7:17df090c@us-cdbr-east-04.cleardb.com/heroku_25bb3d133c3b6f5?reconnect=true';
//     $user = 'root';
//     $pwd = '';
//     $options = array(
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
//     );
//     $dbh = new PDO($dbn, $user, $pwd, $options);
//     return $dbh;

//     try {
//         return new PDO($dbn, $user, $pwd);
//     } catch (PDOException $e) {
//         echo json_encode(["db error" => "{$e->getMessage()}"]);
//         exit();
//     }
// }

function connect_to_db()
{
    $dbn = 'mysql:dbname=sharemane;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        return new PDO($dbn, $user, $pwd);
    } catch (PDOException $e) {
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}

// ログイン状態のチェック関数
function check_session_id()
{
    // 失敗時はログイン画面に戻る
    if (
        !isset($_SESSION['session_id']) || // session_idがない
        $_SESSION['session_id'] != session_id() // idが一致しない
    ) {
        header('Location:login.php'); // ログイン画面へ移動
    } else {
        session_regenerate_id(true); // セッションidの再生成
        $_SESSION['session_id'] = session_id(); // セッション変数上書き
    }
}
