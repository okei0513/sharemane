<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>

<body>
    <!-- ヘッダー部分 -->
    <header>
        <ul>
            <li><a href="top.php">戻る</a></li>
        </ul>
    </header>

    <div>
        <fieldset>
            <h1>Share Mane</h1>
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
            <!-- <p><a href="">Forgot password?</a></p> -->


        </fieldset>


</body>

</html>