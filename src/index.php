<?php
require_once "exam.php";

$exam = new Exam("test", 1);

function dosmth() {
    global $exam;

    $exam->addExam();
}

dosmth();

?>