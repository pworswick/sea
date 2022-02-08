<pre>
<?php

$row = 1;

if (($handle = fopen("rubbish.csv", "r")) !== FALSE) {
    while (($arr = fgetcsv($handle, 1000, ",")) !== FALSE) {
        echo "mv ".pathinfo($arr[1],  PATHINFO_BASENAME)." ".$arr[0].".".pathinfo($arr[1], PATHINFO_EXTENSION)."\n";
        }
    
    fclose($handle);
}
?>
</pre>