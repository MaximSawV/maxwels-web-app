<?php
class Request {
        public $rid;
        public $requestedBy;
        public $workingOn;
        public $topic;
        public $type;
        public $requestedOn;
        public $deadline;
        public $status;

        function __construct($rid, $requestedBy, $workingOn, $topic, $type, $requestedOn, $deadline, $status, $satisfied) {
            $this->rid = $rid;
            $this->requestedBy = $requestedBy;
            $this->workingOn = $workingOn;
            $this->topic = $topic;
            $this->type = $type;
            $this->requestedOn = $requestedOn;
            $this->deadline = $deadline;
            $this->status = $status;
            $this->satisfied =$satisfied;
        }

        public function getRid() {
            return $this->rid;
        }

        public function getRequestedBy() {
            return $this->requestedBy;
        }

        public function getWorkingOn() {
            return $this->workingOn;
        }

        public function getTopic() {
            return $this->topic;
        }

        public function getType() {
            return $this->type;
        }

        public function getRequestedOn() {
            return $this->requestedOn;
        }

        public function getDeadline() {
            return $this->deadline;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getSatisfied() {
            return $this->satisfied;
        }
    }
?>