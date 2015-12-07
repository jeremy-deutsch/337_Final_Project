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
        header('Location: menu.html');
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
?>
