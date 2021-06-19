<?php
    class Database {
        private $connection;
        private $dummy;
    
        //queries
        private $insertExam;
        private $insertQuestion;
        private $insertAnswer;
        private $getAllExams;
        private $getExam;
        private $getQuestions;
        private $getAnswers;


        public function __construct() {
            $config = parse_ini_file('../config/config.ini', true);

            $type = $config['db']['type'];
            $host = $config['db']['host'];
            $name = $config['db']['name'];
            $user = $config['db']['user'];
            $password = $config['db']['password'];

            $this->init($type, $host, $name, $user, $password);
        }

        private function init($type, $host, $name, $user, $password) {
            try {
                $this->connection = new PDO("$type:host=$host;dbname=$name", $user, $password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

                $this->prepareStatements();
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        private function prepareStatements() {
            $sql = "INSERT INTO exams(exam_name, creator_id) VALUES(:exam_name, :creator_id)";
            $this->insertExam = $this->connection->prepare($sql);

            $sql = "INSERT INTO questions(question, exam_id) VALUES(:question, :exam_id)";
            $this->insertQuestion = $this->connection->prepare($sql);

            $sql = "INSERT INTO answers(answer, is_correct, question_id) VALUES(:answer, :is_correct, :question_id)";
            $this->insertAnswer = $this->connection->prepare($sql);

            $sql = "SELECT * FROM exams";
            $this->getAllExams = $this->connection->prepare($sql);

            $sql = "SELECT * FROM exams WHERE id = :id";
            $this->getExam = $this->connection->prepare($sql);

            $sql = "SELECT * FROM questions WHERE exam_id = :exam_id";
            $this->getQuestions = $this->connection->prepare($sql);

            $sql = "SELECT * FROM answers WHERE question_id = :question_id";
            $this->getAnswers = $this->connection->prepare($sql);
        }

        //$data -> ["exam_name" => value, "creator_id" => value]
        public function insertExam($exam) {
            try {
                echo "success";
                $this->insertExam->execute($exam);

                return ["success" => true];
            } catch(PDOException $e) {
                echo $e->getMessage();
                //roolBack to previous state, before the error happened
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        //exam_id of question should be current exam's id
        public function insertQuestion($question) {
            try {
                $this->insertQuestion->execute($question);

                return ["success" => true];
            } catch(PDOException $e) {
                //roolBack to previous state, before the error happened
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        //question_id of answer should be current question's id
        public function insertAnswer($answer) {
            try {
                $this->insertAnswer->execute($answer);

                return ["success" => true];
            } catch(PDOException $e) {
                //roolBack to previous state, before the error happened
                $this->connection->rollBack();
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectAllExams() {
            try {
                $this->getAllExams->execute();

                return ["success" => true, "data" => $this->selectAllExams];
            } catch(PDOException $e) {
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectExam($id) {
            try {
                $this->getExam->execute($id);

                return ["success" => true, "exam" => $this->selectExam];
            } catch(PDOException $e) {
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectQuestions($exam_id) {
            try {
                $this->getQuestions->execute($exam_id);

                return ["success" => true, "exam" => $this->getQuestions];
            } catch(PDOException $e) {
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        public function selectAnswers($question_id) {
            try {
                $this->getAnswers->execute($question_id);

                return ["success" => true, "exam" => $this->getAnswers];
            } catch(PDOException $e) {
                return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
            }
        }

        function __destruct() {
            $this->connection = null;
        }
    }
    
?>