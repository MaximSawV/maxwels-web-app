<?php
class Customer extends User {
        public $cid;
        public $firstName;
        public $lastName;
        public $phone;
        public $corp;

        function __construct($cid, $firstName, $lastName, $phone, $corp, $id, $username, $email, $password, $is, $dateOfCreation) {
            parent::__construct($id, $username, $email, $password, $is, $dateOfCreation);
            $this->cid = $cid;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->phone = $phone;
            $this->corp = $corp;
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->is = $is;
            $this->dateOfCreation = $dateOfCreation;

        }

        public function getCid() {
            return $this->cid;
        }

        public function getFirstName() {
            return $this->firstName;
        }

        public function getLastName() {
            return $this->lastName;
        }

        public function getPhone() {
            return $this->phone;
        }

        public function getCorp() {
            return $this->corp;
        }

        public function createRequest($topic1, $type1, $deadline1) {
            $rid = Null;
            $requestedBy =  Null;
            $workingOn = "NONE";
            $topic = $topic1;
            $type = $type1;
            $requestedOn = Null;
            $deadline = $deadline1;
            $request = new Request();
            $status = "REQUESTED";
        }
    }
?>