<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOPページ</title>
</head>

<body>
    <!-- ヘッダー部分 -->
    <header>
        <ul>
            <li><a href="top.php">TOP</a></li>
            <li><a href="login.php">ログイン</a></li>
            <li><a href="account.php">新規登録</a></li>
        </ul>
    </header>

    <!-- 中身部分 -->
    <div>
        <!-- 中身 main -->
        <div>
            <h1>Share Mane</h1>
            <p>お店やグループメンバーのプロフィールやビジネス情報・シフトや売上管理の業務ツールにも最適</p>
            <p>電子名刺として</p>
            <p>シフト共有ツールとして</p>
            <p>売上・在庫管理として</p>
        </div>
        <!-- 中身 イメージ図 -->
        <div>
            <p>イメージ写真</p>
            <p>イメージ写真</p>
        </div>

        <!-- 中身 下記ログイン入力 -->
        <div>
            <fieldset>
                <form action="login_act.php" method="post">
                    <div>
                        Mail Addres: <input type="text" name="mail" required="required" placeholder="Email Address">
                    </div>
                    <div>
                        パスワード: <input type="text" name="password" required="required" placeholder="Password">
                    </div>
                    <!-- <div>
                        <input type="checkbox" name="remenber">Remember Me
                    </div> -->

                    <div>
                        <button class="button">Sign In</button>
                    </div>
                </form>

                <!-- <div>
                    <!-- パスワードを忘れた場合-->
                <!-- <p><a href="password.html">Forgot password?</a></p></div> -->
                <!-- 新規登録ボタン -->
                <p><a href="account.php">NEW account</a></p>

            </fieldset>

        </div>

    </div>

    <!-- フッター部分 -->
    <!-- <footer></footer> -->

</body>

</html>