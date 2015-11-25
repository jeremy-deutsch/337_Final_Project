<html>
    <head> Create New User </head>
    <body>
        <form method="post">
            New Username: <input type="text" name="newUser" required>
            New Password: <input type="text" name="newPass" required>
            <input type="submit" name="submit" value="submit">
        </form>
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

        register($user, $pass);

        if(verified($user, $pass)) {
            echo 'User created. Go back to login';
        }
        else {
            echo 'Error: failed to create user';
        }
    }





    function verified($username, $password) {
        global $db;
        $stmt = $db->prepare("SELECT password FROM users WHERE username='$username';");
        $stmt->execute();
        $hash = $stmt->fetchColumn();

        echo $username . '----<br>';
        echo $password . '----<br>';
        echo '<br>       *--- ' . $hash . ' ---*       ';

        return password_verify($password,  $hash);
    }

    function register($username, $password) {
        global $db;

        $currentTime = time();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("SELECT count(*) FROM users WHERE username = '$username';");
        $stmt->execute();
        $numUsers = $stmt->fetchColumn();

        if($numUsers == "0" ) {
            $sql = "INSERT INTO users(username, password, login) VALUES('$username', '$hash', '$currentTime')";
            $db->exec($sql);
        }
        else {
            echo "Username already exists";
        }
        return $hash;

    }

 ?>
