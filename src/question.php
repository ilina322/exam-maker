<?php
    require_once 'db.php';
    
    class Question{
        private $id;
        private $question;
        private $exam_id;

        private $db;

        public function __construct($question, $exam_id) {
            $this->db = new Database();

            $this->question = $question;
            $this->exam_id = $exam_id;
        }

        public function setId($id) {
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        public function setQuestion($query) {
            $this->question = $question;
        }

        public function getQuestion() {
            return $this->question;
        }

        public function setExamId($id) {
            $this->exam_id = $id;
        }

        public function getExamId() {
            return $this->exam_id;
        }

        public function getAnswers() {
            $query = $this->db->selectAnswers($this->exam_id);

            if ($query["success"]) {
                return $query["data"]->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $query;
            }
        }

        public function addQuestion() {
            $query = $this->db->insertExam(["exam_name" => $this->exam_name, "creator_id" => $this->creator_id]);
        }
    }
?>