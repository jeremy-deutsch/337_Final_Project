<html>
    <head> Create New User </head>
    <body>

        <form method="post">
            <input type="text" name="newUser" required>
            <input type="text" name="newPass" required>
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
    }

    register($user, $pass);
    if(verified($user, $pass) == true) {
        echo 'User created. Go back to login';
    }
    else {
        echo 'Error: failed to create user';
    }



    public function verify($username, $password) {
        $stmt = $db->prepare("SELECT password FROM users WHERE username='$username';");
        $stmt->execute();
        $hash = $stmt->fetchColumn();

        return password_verify($password,  $hash);
    }

    public function register($username, $password) {
        $currentTime = time();
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("SELECT count(*) FROM users WHERE username = '$username';");
        $stmt->execute();
        $numUsers = $stmt->fetchColumn();

        if($numUsers == "0" ) {
            $sql = "INSERT INTO users(username, password, login) VALUES('$user', '$hash', '$currentTime')";
            $db->execute($sql);
        }
        else {
            echo "Username already exists";
        }
        return $hash;

    }

 ?>
