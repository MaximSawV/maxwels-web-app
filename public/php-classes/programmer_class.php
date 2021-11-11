<?php
    class Programmer  extends User{
        public $pid;
        public $firstName;
        public $lastName;
        public $doneRequests;
        public $status;

        function __construct($pid, $firstName, $lastName, $doneRequests, $status, $id, $username, $email, $password, $is, $dateOfCreation) {
            parent::__construct($id, $username, $email, $password, $is, $dateOfCreation);
            $this->pid = $pid;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->doneRequests = $doneRequests;
            $this->status = $status;
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->is = $is;
            $this->dateOfCreation = $dateOfCreation;

        }

        public function getPid() {
            return $this->pid;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function getDoneRequests() {
            return $this->doneRequests;
        }

        public function getStatus() {
            return $this->status;
        }
    }
?>