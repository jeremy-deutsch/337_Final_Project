<?php

    class button {

        private $DB;

        public function __construct() {
           $db = 'mysql:dbname=idlegame;host=127.0.0.1';
           $user = 'admin';
           $password = 'admin';

           try {
               $this->DB = new PDO ( $db, $user, $password );
               $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
           } catch ( PDOException $e ) {
               echo ('Error establishing Connection');
               exit ();
           }
       }

       public function getButtonsArray($username) {
           $sql = this->DB->prepare("SELECT * FROM button_amounts WHERE username='$username'");
           $stmt = $this->DB->prepare($sql);
           $stmt->execute ();
   		   $array = $stmt->fetchAll ( PDO::FETCH_ASSOC );
   		   return $array;
       }

       public function updateButtons($username, $lines, $hands, $cups, $money) {
           $sql = this->DB->prepare("UPDATE button_amounts SET lines_='$lines', hands_='$hands', cups_='$cups', money_='$money' WHERE username='$username';");
           $stmt = $this->DB->prepare($sql);
           $stmt->execute();

       }


    }


    $buttonStuff = new button ();
    echo json_encode($buttonStuff->getButtonsArray($_GET['username']));
    $buttonStuff->updateButtons($_GET['username'], $_GET['lines'], $_GET['hands'], $_GET['cups'], $_GET['money']);
    ?>
