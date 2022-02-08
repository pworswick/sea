<?php

if (!@$_POST['action'])
    @$action= $_GET['action'];
    else
    @$action =$_POST['action'];


// action can be insert, delete, edit or list (LIED)
// print "Action = $action";
 
 //print_r($_POST);
      /*
foreach ($table as $key=> $arr)    // Read all the variables 
    {
    eval("@\$".$key."=\$_GET['".$key."'];");
 //   $name[]=$key;
   // $values[]=$key;   // ?????
    }
    
    */
  

if (!$action && @$question_id)
    $action = "edit";

    
function comma($arr,$b)
{



}


function list_all()

/*  
List all the questions associated with the exam_id and should list all the answers associated with the test_id 
of the currently running exam !!!!
*/

{
global $link,$test_id,$student_id;


$sqltext = "select 
    a.question_no,a.question_no_sub,question,
    ifnull( b.answer,'') as answer 
from exam_questions_math  a 
    left outer join answers b on (a.question_no=b.question_no and  test_id='".$test_id."') 
where   exam_header=(select exam_header_id from test where id='$test_id') 
    order by question_no,a.question_no_sub";

/*
select a.question_no,
question,
ifnull( b.answer,'') 
from exam_questions_math a 
 left  join answers b on (a.question_no=b.question_no and student_id=1 and exam_id=1) 
where 
-- student_id='1' and 
-- exam_id=1 and 
exam_header=1 order by id
*/

//print $sqltext;

$res = mysqli_query($link,$sqltext);

if (! $res)
     die("ERROR: Could not connect. $sqltext " .mysqli_error($link));
 
print "<table>";   


/*
foreach ($table as $key=>$arr)
    {
    
    if ($key!="id")
        print "<th>".$arr[0]."</th>";
    }
  */  

while ($arr = mysqli_fetch_assoc($res))
    {
    print "<tr valign=top>";
    $ctr=0;
    
    print "<td>".$arr['question_no']."</td>";
    
    print "<td><a href=answer.php?test_id=$test_id&question_id=".$arr['question_no']."&question_no_sub=".$arr['question_no_sub'].">".$arr['question']."</a></td><td>".
        "</td><td>".$arr['answer']."</td>";
    
    /*
     foreach ($arr as $arr2)
        {
        if ($ctr==0)
            $question_id= $arr2;
        
            
        print "<td><a href=answer.php?exam_id=$exam_id&question_id=$question_id>$arr2</a></td>";
        $ctr++;
        }
        */
    print "</tr>\n";
    }
    
print "
</table>";

mysqli_free_result($res);
}


function field($a)
{
global $_GET,$html;
// Displays field depending on action. For an insert it's blank, for an edit retrieve the value, also adds a label tag for errors

print @$html[$a];
}



    
function submit_it()
{
global $action,$id;

if ($action == "edit")
    print "<button type=\"button\" onclick='document.form1.submit();'>Delete</button>";
    
    
print "<button type=\"button\" onclick='document.form1.submit();'>Submit</button>";

}



if ($action == "edit")
    {
    $html['header']="<form name=form1 method=post>";
    
    $sqltext = "select * from $tablename where id=$id";
    
    $res=mysqli_query($link,$sqltext);
    
    if ($arr = mysqli_fetch_assoc($res))
        {
        foreach ($table as $key=>$arr2)
            {
            if (@$arr2[4]!='I')
                   $html[$key]="<label for=\"$key\">".$arr2[0]."</label> </td><td> <input type=\"text\" id=\"$key\" name=\"$key\" value=\"".
                        $arr[$key]."\" maxlength=".$arr2[2]." size=".$arr2[2]."><div id=err_$key></id>";
                   else
                   $html[$key]="  <input type=\"hidden\" id=\"$key\" name=\"$key\" value=\"".$arr[$key]."\">";
                   
            }
        }
    
    }



if ($action == "insert")
    {
   // $sqltext = "insert into $tablename values ('"."".')";
   $html['header']="<form name=form1 method=post>\n<input type=hidden name=action value='submit_insert'>";
   
   foreach ($table as $key=>$arr)
        {
        switch ($arr[1])
            {
            case 'char': $x = "[a-zA-Z0-9]";
                break;
            case 'int': $x = "[0-9]";
                break;
            
            }
            
        if ($arr[4]!='I') // Hidden index no
           $html[$key]="<label for=\"$key\">".$arr[0]."</label> </td><td> <input type=\"text\" id=\"$key\" name=\"$key\" pattern=\"$x+".
                "\" size=".$arr[2]." maxlength=".$arr[2]."><div id=err_$key></id>";
        
        }
        
    $html['footer']='</form>';
    }
  
  
  
    
if ($action=="submit_insert")
    {
    //echo "Hello";
    $fields = '';
    $values = '';
    foreach ($table as $key =>$arr)
        {
        if ($arr[4]!='I')
            if ($fields == '')
                $fields = $key;
            else
                $fields.=",".$key;
            
        if ($arr[4]!='I')
            if ($values == '')
                    $values = "'".$_POST[$key]."'";
                else
                    $values.=",'".$_POST[$key]."'";
            
        }
        
        
        
        
        
    $sqltext = "insert into $tablename ($fields) values ($values)";
    
   // print $sqltext;
    
    $res=mysqli_query($link,$sqltext);
    
    if (!$res)
      die("Error message: %s\n". mysqli_error($link));
      
    }

    


// phpinfo();

//mysqli_close($link);
    
//print_r($html);    

?>