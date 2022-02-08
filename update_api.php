<?php
session_start();

/*
INSERT INTO table (id, name, age) VALUES(1, "A", 19) ON DUPLICATE KEY UPDATE    
name="A", age=19
*/

include 'include/connect.php';

 // student_id, question_no, answer, time
$student_id = $_SESSION['id'];

$question_no = (int)$_GET['question_no'];
//$exam_id = (int)$_GET['exam_id'];
$test_id=$_SESSION['test_id'];
$answer = @$_GET['answer'];
$raw_answer = @$_GET['raw_answer'];


if ($raw_answer)
    $sqltext = "insert into answers (question_no, test_id, raw_answer, time) values ($question_no,$test_id,'$raw_answer',current_time()) on duplicate key update raw_answer='$raw_answer', time=current_time() ";
else
    $sqltext = "insert into answers (question_no, test_id, answer, time) values ($question_no,$test_id,'$answer',current_time()) on duplicate key update answer='$answer', time=current_time() ";

$res = mysqli_query($link,$sqltext);

if (! $res)
    die("Error".mysqli_error($link));

?>