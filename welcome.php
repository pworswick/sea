<?php

session_start();

//print_r($_SESSION);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !$_SESSION['username'])
    {
    header("location:login.php?url=".$_SERVER['REQUEST_URI']);
    exit;
    }

$student_id = $_SESSION['id'];

echo "Student Id =$student_id <br/>";
echo "<a href=logout.php>Logout</a>";


include 'include/connect.php';
include 'fixup.php';


$sqltext = "select exam_header_id,description,start_time,end_time,score from test a left outer join exam_header b on (a.exam_header_id=b.id) where users_id='$student_id' ";

//print $sqltext;


$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));
 
print "<br/><br/><b>Past tests</b>\n<table>";   

while ($arr = mysqli_fetch_assoc($res))
    {
     print "<tr><td>".$arr['description']."</td><td>".$arr['score']."</td></tr>";
    }
    
print "</table>";

print "Would you like to take a test ?";


$sqltext= "select * from exam_header order by id";

$res = mysqli_query($link,$sqltext);

if (! $res)
    die("Error = ".mysqli_error($link));

print "<form name=form1 action=\"start.php\">
<select name=exam_id onchange=''>
<option></option>
";

while ($arr = mysqli_fetch_assoc($res))
    {
    print "<option value=".$arr['id'].">".$arr['description']."</option>";
    }

print "</select>
<input type=submit>

</form>";


?>
</body>
</html
