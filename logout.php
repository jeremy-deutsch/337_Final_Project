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

    setLines($_SESSION['user'], $_SESSION['lines']);
    setHands($_SESSION['user'], $_SESSION['hands']);
    setCoffee($_SESSION['user'], $_SESSION['cups']);
    setSeconds($_SESSION['user'], $_SESSION['seconds']);
    setMoney($_SESSION['user'], $_SESSION['money']);

    function setLines($user, $lines) {
        global $db;
        $sql = "UPDATE button_amounts SET lines_='$lines' WHERE username='$user';";
        $db->exec($sql);
    }

    function setHands($user, $hands) {
        global $db;
        $sql = "UPDATE button_amounts SET hands_='$hands' WHERE username='$user';";
        $db->exec($sql);
    }

    function setCoffee($user, $cups) {
        global $db;
        $sql = "UPDATE button_amounts SET cups_='$cups' WHERE username='$user';";
        $db->exec($sql);
}

    function setSeconds($user, $seconds) {
        global $db;
        $sql = "UPDATE button_amounts SET seconds_='$seconds' WHERE username='$user';";
        $db->exec($sql);
}

    function setMoney($user, $money) {
        global $db;
        $sql = "UPDATE button_amounts SET money_='$money' WHERE username='$user';";
        $db->exec($sql);
}

    session_destroy();
    unset($_SESSION['user']);
    header('Location: login.html');
 ?>
