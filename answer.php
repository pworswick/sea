<?php
session_start();

$question_no=@$_GET['question_id'];
//$exam_id=@$_GET['exam_id'];
//$student_id = $_SESSION['id'];
$test_id = $_SESSION['test_id'];




include 'include/connect.php';


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !$_SESSION['username'])
    {
    header("location:login.php?url=".$_SERVER['REQUEST_URI']);
    exit;
    }
    
    
$sqltext = "select end_time from test where id='$test_id'";   // Start Time, End Time 
    
    
$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));
     
$arr = mysqli_fetch_assoc($res);

?>
<html>
<head>  

<script type='text/javascript'>    

function  answer_me(a,b)
{
  const xhttp = new XMLHttpRequest();
  if (b==0)
    {
    xhttp.open("GET", "update_api.php?question_no=<?php echo $question_no; ?>&test_id=<?php echo $test_id; ?>&answer="+a, true);
    }
    else
    {
    xhttp.open("GET", "update_api.php?question_no=<?php echo $question_no; ?>&test_id=<?php echo $test_id; ?>&raw_answer="+a, true);
    
    }
  xhttp.send();

}



</script>
</head>
<body onload="check_it();">


<p id="demo">&nbsp;</p>

<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $arr['end_time']; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  document.getElementById("demo").innerHTML =  hours + "h "
    + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    //document.getElementById("demo").innerHTML = "EXAM OVER";
    window.location.href = "finish.php"; 
  }
}, 1000);

</script>

    

<?php



$sqltext = "select * from exam_questions_math a inner join test b on (b.exam_header_id=a.exam_header and b.id='$test_id')
     where question_no='$question_no' ";
     
//echo $sqltext;

$res = mysqli_query($link,$sqltext);

if (! $res)
    die("Error".mysqli_error($res));

    
$arr = mysqli_fetch_assoc($res);
    
    
$sqltext = "select answer,raw_answer from answers where question_no='$question_no' and test_id='$test_id'";

$res = mysqli_query($link,$sqltext);

if (! $res)
    die("Error".mysqli_error($link));
    
$arr2 = mysqli_fetch_assoc($res);


$sqltext = "select max(question_no) as max from exam_questions_math where exam_header=(select exam_header_id from test where id=$test_id)";

$res = mysqli_query($link,$sqltext);

if (! $res)
    die("Error".mysqli_error($link));

    
$arr3 = mysqli_fetch_assoc($res);
        //        echo $sqltext;
//echo $arr3['max'];
    

    
print "<table>
<tr><td><a href=exam.php>Index</a></td></tr>
<tr><td>".($arr['image']=='' ? "" : "<img src=images/".$arr['image'].">")."</td></tr>";
if ($arr['include']=='')
     echo ""; 
     else
     include $arr['include'];

echo "<tr><td valign=top><b>".$question_no."</b></td><td>".$arr['question']."</td></tr>";

print "<form name=form1>
<table>
<tr><td><input type=text onkeyup='answer_me(this.value,0);' name=answer id=answer value='".$arr2['answer']."'></td></tr>
<input type=hidden name=raw_answer id=raw_answer onchange='answer_me(this.value,1);' value='".$arr2['raw_answer']."'>
</table>
</form>

";

// $sqltext = ""

print "<tr><td>".($question_no==1 ? "" : "<a href=?question_id=".($question_no-1)."> <<<< Previous question </a>" ).
     "</td><td>".($question_no==$arr3['max'] ? "" : "<a href=?question_id=".($question_no+1)."> >>>> Next question </a>" )."</td></tr>";




?>
</body>
</html>