<?php
session_start();

include 'include/connect.php';

//print_r($_SESSION);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !$_SESSION['username'])
    {
    header("location:login.php?url=".$_SERVER['REQUEST_URI']);
    exit;
    }
    
    
?>
<!DOCTYPE html>
<html>
<head>



</head>
<body>

<?php  
  
  
$exam_id = (int)@$_GET['exam_id'];

if (!$exam_id)
    $exam_id = (int)@$_POST['exam_id'];
    
$add = @$_POST['add'];
    
$student_id = (int)$_SESSION['id'];


if ($add)
    {
   // print_r($_POST);
    $answer = @$_POST['answer'];
    $question = @$_POST['question'];
    $question_no = @$_POST['question_no'];
    
    $sqltext = "insert into exam_questions_math (exam_header,question_no,question,answer) values ($exam_id,$question_no,'$question','$answer')";
    
     $res = mysqli_query($link,$sqltext);
      
      if (! $res)
          die("Error = ".mysqli_error($link));
    
    
    print "Item inserted";
    }

function drop_down($exam_id)
{
global $link;




if (! $exam_id)
    {
    print "<form name=form1><select name=exam_id onchange='document.form1.submit();'>\n<option></option>\n";
    
      $sqltext = "select * from exam_header";
      
      
      $res = mysqli_query($link,$sqltext);
      
      if (! $res)
          die("Error = ".mysqli_error($link));
          
      
      while ($arr = mysqli_fetch_assoc($res))
          {
          print "<option value=".$arr['id'].">".$arr['description']."</option>\n";
          }
      
      
      
      print "</select>\n</form>\n";
      }
      else
      {
      $sqltext = "select * from exam_header where id='$exam_id'";
      
       $res = mysqli_query($link,$sqltext);
      
      if (! $res)
          die("Error = ".mysqli_error($link));
          
      $arr = mysqli_fetch_array($res);
      
      print "<table><tr><td>".$arr['description']."</td></tr></table>";
      
      
      }

}


    drop_down($exam_id);
    
if (!$exam_id)
    die();
    
$sqltext = "select max(question_no)+1 from exam_questions_math where exam_header='$exam_id'";



$res = mysqli_query($link,$sqltext);
    
    if (! $res)
        die("Error = ".mysqli_error($link));
        
    $arr = mysqli_fetch_array($res);
    
    $max = $arr[0];

print "
<form name=form2 method=\"post\">
<input type=hidden name=add value=1>
<input type=hidden name=exam_id value=$exam_id>
<input type=hidden name=question_no value='$max'>
<table><tr><td>Question No</td><td>".$arr[0]."</td></tr>
<tr><td><textarea id=\"question\" name=\"question\" rows=\"4\" cols=\"50\"></textarea></td></tr>
<tr><td><input type=text name=answer ></td></tr>
<tr><td><button onclick='document.form2.submit();'>Submit</td></tr>
</table>
</form>
"
    
    
    
?>
</form>
</body>
</html>