<?php
session_start();



//print_r($_SESSION);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !$_SESSION['username'])
    {
    header("location:login.php?url=".$_SERVER['REQUEST_URI']);
    exit;
    }
    



//$exam_id = (int)$_GET['exam_id'];
$student_id = $_SESSION['id'];
$test_id = @$_SESSION['test_id'];

if (! $test_id)
    header("location: welcome.php");
    
include 'include/connect.php';
include 'fixup.php';

$sqltext = "select end_time from test where id='$test_id'";   // Start Time, End Time 

//echo $sqltext;
    
    
$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));
     
$arr = mysqli_fetch_assoc($res);

?>


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


echo "Student Id =$student_id";
echo "Test Id = $test_id";



?>

 <a href=logout.php>Logout</a>




<?php

list_all();

?>

<tr><td>
<?php


field('question');

print "</td><td>";

print "</td></tr>
</table>\n";

