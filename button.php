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

       public function getButtonsArray() {
           $sql = "SELECT username FROM users JOIN button_amounts ON button_amounts.username = users.username WHERE users.username = " . $username . ";";
           $stmt = $this->DB->prepare($sql);
       }

       public function countIncrement($button) {
           $sql = "UPDATE button_amounts " . $button . " JOIN users ON button_amounts.username = users.username WHERE users.username = " . $username . " SET " . $button "=" . $button "+1;";
           $stmt = $this->DB->prepare($sql)
       }


    }
