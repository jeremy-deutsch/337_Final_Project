<html>
    <head> <link rel="stylesheet" type="text/css" href="style.css"> </head>
    <body>
        <h2>Create New User </h2>
        <div id="loginform">
        <form method="post">
            New Username: <input type="text" name="newUser" required>
            <br><br>
            New Password: <input type="password" name="newPass" required>
            <br><br>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
        <div id="registerlogform">
        <form action="login.html">
            <input type="submit" value="Login">
        </form>
    </div>
    </body>
</html>

<?php
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

        $user = $_POST['newUser'];
        $pass = $_POST['newPass'];

        $successfulRegister = register($user, $pass);

        if(verified($user, $pass) && $successfulRegister == true) {
                echo 'User created. Go back to login <br>';
        }
        else {
            echo 'Error: failed to create user <br>';
        }
    }





    function verified($username, $password) {
        global $db;
        $stmt = $db->prepare("SELECT password FROM users WHERE username='$username';");
        $stmt->execute();
        $hash = $stmt->fetchColumn();


        return password_verify($password,  $hash);
    }

    function register($username, $password) {
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        global $db;

        $currentTime = time();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("SELECT count(*) FROM users WHERE username = '$username';");
        $stmt->execute();
        $numUsers = $stmt->fetchColumn();

        if($numUsers == "0" ) {
            $sql = "INSERT INTO users(username, password, login) VALUES('$username', '$hash', '$currentTime')";
            $db->exec($sql);



            $sql = "INSERT INTO button_amounts(username, lines_, hands_, cups_, seconds_, money_) VALUES('$username', 0, 0, 0, 0, 0)";
            $db->exec($sql);
        }
        else {
            echo "Username already exists <br>";
            return false;
        }
        return true;

    }

 ?>
