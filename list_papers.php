<?php
session_start();


?>
<html>
<head>


</head>
<body>
<?php

include 'include/connect.php';


$sqltext= "select * from exam_header order by id";

$res = mysqli_query($link,$sqltext);

if (! $res)
    die("Error = ".mysqli_error($link));


print "
<h2>List of papers</h2>
<table>";

while ($arr = mysqli_fetch_assoc($res))
    {
    print "<tr><td><a href=exam.php?exam_id=".$arr['id'].">".$arr['description']."</a></td></tr>";
    }

print "</table>";




?>
</body>
</html>
