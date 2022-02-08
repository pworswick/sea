<?php
session_start();

$test_id = $_SESSION['test_id'];


//unset($_SESSION['test_id']);
// Finishes the exam. Puts the end time , or sets all fields that exceed the end time, clears the exam_id from the user
include 'include/connect.php';

$sqltext = "select 
    a.question_no,a.question_no_sub,question,
    ifnull( b.answer,'') as my_answer, a.answer
from exam_questions_math  a 
    left outer join answers b on (a.question_no=b.question_no and  test_id='".$test_id."') 
where   exam_header=(select exam_header_id from test where id='$test_id') 
    order by question_no,a.question_no_sub";

$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));

print "<table>";
$ans = 0;
$ctr=0;
while ($arr = mysqli_fetch_assoc($res))
    {
    print "<tr><td>".$arr['question_no']."</td><td>".$arr['my_answer']."</td><td>".$arr['answer']."</td></tr>\n";
    
    if ($arr['my_answer']!='' && ($arr['my_answer'] == $arr['answer']))
        $ans++;
    $ctr++;
    }
print "</table>";

print "Results = $ans / $ctr or ";

$sqltext = "update test set score=".($ans/$ctr)." where id='$test_id' and score=''";


$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));


//unset($_SESSION['test_id']);
?>
<br/>

Marking the test and telling the user time is up.<br/> 
removing test_id from user<br/>
Clearing test_id from session<br/>

if you click finish before time, can you go back into the test ? <br/>
Store a percentage or total correct ?    <br/>
Tags

