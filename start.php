<?php

session_start();

//print_r($_SESSION);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !$_SESSION['username'])
    {
    header("location:login.php?url=".$_SERVER['REQUEST_URI']);
    exit;
    }

$student_id = $_SESSION['id'];
$exam_id = (int)$_GET['exam_id'];

// echo "Student Id =$student_id";


include 'include/connect.php';
// include 'fixup.php';

// Action form does the following. Creates entry in test table with user_id, start_time and test_id
// Then take the id from that and sticks it next to  the user 

/*
1. Check if there is an ongoing test undr the users name/id
2. Alert that there is an existing test. Ask if they wish to continue
3. If not, start a new test, get a test id, insert into users name with time
4. Add start time and duration to SESSION file
5. Set test_id also to SESSION file
6. Go to test

answers file should not contain exam_id but test_id, test_id should contain exam file
*/

$sqltext = "select test_id from users where id='$student_id'";     // See if there is a test associated with a user

$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));

if ($arr = mysqli_fetch_assoc($res))  // If there is check to see if the test is still in progress
    {
    // Check if the exam is ongoing, jump to exam, else end the exam/ finish the exam
    $sqltext = "select * from test where id='".$arr['test_id']."' and current_timestamp() between start_time and end_time";     
    
    $res = mysqli_query($link,$sqltext);

    if (! $res)
         die("ERROR: Could not connect. $sqltext " .mysqli_error($link));
         
    $_SESSION['test_id']=$arr['test_id'];
    
    if (($arr = mysqli_fetch_assoc($res)))
            {
            header("location: exam.php");  // Continue the exam
            }
    
    
    }


// Still checking to see if the user has an exam, even if it is not recorded under the student's record


$sqltext = "select * from test where users_id='$student_id' and current_timestamp() between start_time and end_time";     

$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));

if (($arr = mysqli_fetch_assoc($res)))
        {
        
        $_SESSION['test_id']=$arr['test_id'];

        header("location: exam.php");
        }







// Create a new test, store test_id

$sqltext = "insert into test (users_id,exam_header_id,start_time,end_time) 
select $student_id,$exam_id,current_timestamp(),date_add(current_timestamp(),interval time minute) from 
    exam_header where id=$exam_id";

// values ($student_id,$exam_id,current_time());";


$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));
     
$last_id = mysqli_insert_id($link);


$_SESSION['test_id']=$last_id;

$sqltext = "update users set test_id=$last_id where id=$student_id";

$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));
     
header("location: exam.php");
     
     


?>