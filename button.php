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


    }

    $buttonStuff = new button ();
    echo json_encode($buttonStuff->getButtonsArray($username));
    ?>
