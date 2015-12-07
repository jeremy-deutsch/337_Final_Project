<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h2>Login</h2>
        <div id=login>
        <div id="loginform">
        <form  method="post">
            Username: <input type="text" name="user" placeholder="username" required>
            <br>
            <br>
            Password: <input type="password" name="pass" placeholder="password" required>
            <br>
            <br>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
        <div id="registerlogform">
        <form action="RegisterUser.php">
            <input type="submit" value="Create New User">
        </form>
    </div>
</div>

    </body>
</html>


<?php
    session_start();
    $db = 'mysql:dbname=idlegame;host=127.0.0.1';
    $user = 'root';
    $pass = '';

    try {
        $db = new PDO ($db, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo ('Error establishing Connection');
        exit();
    }

    if(isset($_POST['submit'])) {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $_SESSION['user'] = $user;
    }

    if(verify($user, $pass)) {
        echo 'success';
        $_SESSION['user'] = $user;
        $_SESSION['lines'] = (int)getLines($user);
        $_SESSION['hands'] = (int)getHands($user);
        $_SESSION['cups'] = (int)getCoffee($user);
        $_SESSION['seconds'] = (int)getSeconds($user);
        $_SESSION['money'] = (int)getMoney($user);
        header('Location: menu.php');
    }
    else {
        echo 'incorrect username or password';
    }

    function verify($username, $password) {
        global $db;
        $stmt = $db->prepare("SELECT password FROM users WHERE username='$username';");
        $stmt->execute();
        $hash = $stmt->fetchColumn();

        return password_verify($password,  $hash);
    }

    function getLines($user){
        global $db;
        $stmt = $db->prepare("SELECT lines_ FROM button_amounts WHERE username='$user';");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getHands($user) {
        global $db;
        $stmt = $db->prepare("SELECT hands_ FROM button_amounts WHERE username='$user';");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getCoffee($user) {
        global $db;
        $stmt = $db->prepare("SELECT cups_ FROM button_amounts WHERE username='$user';");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getSeconds($user) {
        global $db;
        $stmt = $db->prepare("SELECT seconds_ FROM button_amounts WHERE username='$user';");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function getMoney($user) {
        global $db;
        $stmt = $db->prepare("SELECT money_ FROM button_amounts WHERE username='$user';");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
?>
