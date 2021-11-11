<?php
    class User {
        public $id;
        public $username;
        public $email;
        public $password;
        public $is;
        public $dateOfCreation;

        function __construct($id, $username, $email, $password, $is, $dateOfCreation) {
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->is = $is;
            $this->dateOfCreation = $dateOfCreation;
        }

        public function getId() {
            return $this->id;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getEmail() {
            return $this->email;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getIs() {
            return $this->is;
        }

        public function getDateOfCreation() {
            return $this->dateOfCreation;
        }

        public function getLogin() {
            $id = $this->getId();
            $user = $this->getUsername();
            $pass = $this->getPassword();
            $login = array ("id"=> $id, "name" => $user, "password" => $pass);
            return $login;
        }
    }
?>