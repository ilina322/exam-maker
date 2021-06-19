<?php
    require_once 'db.php';
    
    class Exam{
        private $id;
        private $exam_name;
        private $creator_id;

        private $db;

        public function __construct($exam_name, $creator_id) {
            $this->db = new Database();

            $this->exam_name = $exam_name;
            $this->creator_id = $creator_id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setName($name) {
            $this->exam_name = $name;
        }

        public function getName() {
            return $this->exam_name;
        }

        public function setCreatorId($id) {
            $this->creator_id = $id;
        }

        public function getCreatorId() {
            return $this->creator_id;
        }

        public function getAllExams() {
            $query = $this->db->selectAllExams();

            if ($query["success"]) {
                return $query["data"]->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $query;
            }
        }

        public function addExam() {
            $query = $this->db->insertExam(["exam_name" => $this->exam_name, "creator_id" => $this->creator_id]);
        }
    }
?>