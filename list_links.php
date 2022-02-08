

<?php
  $a = fopen("list.txt","r");
  
  if (! $a)
      die("File error");
   while (!feof($a))
      {   
      $line = fgets($a);
      
      echo "<a href=$line>$line</a><br/>";
      
      }

?>