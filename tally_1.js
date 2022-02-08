<script type="text/javascript">

var ct=0;

tableCreate();   // Table
 //draw();

var canvas;

function check_it()
{
if (document.getElementById('answer').value!=="")
    ct=document.getElementById('answer').value;

do_strokes();
}
//    canvas = document.getElementById('canvas');
    
      // JavaScript Document

      
function do_strokes()
{

canvas = document.getElementById('canvas');

var ctx = canvas.getContext("2d");
//ctx.beginPath();
//ctx.moveTo(0, 0);
//ctx.lineTo(300, 150);
//ctx.stroke();
ctx.clearRect(0,0,150,50);

for (x=1;x<=ct;x++)
    {
    if (x % 5 != 0)
        {
        ctx.beginPath();
        ctx.moveTo(x*10,0);
        ctx.lineTo(x*10,50);
        ctx.stroke();
        }
        else
        {
        ctx.beginPath();
        ctx.moveTo((x-4)*10-5,10);
        ctx.lineTo((x-1)*10+5,40);
        ctx.stroke();
        }
    }

document.getElementById("input1").value=ct;
answer_me(ct,0); // Real answer

document.getElementById('answer').value =ct;
}

  
function add_stroke()
{
if (ct<15)
    ct++;

do_strokes();
}

function sub_stroke()
{
if (ct>0)
    ct--;


do_strokes();
}




function tableCreate() {
  //body reference 
  
  var head = [
  ['age','frequency','tally'],
  ['8 years','7',''],
  ['9 years','',''],
  ['10 years','6','']
  ];
  
  var body = document.getElementsByTagName("body")[0];

  // create elements <table> and a <tbody>
  var tbl = document.createElement("table");
  var tblBody = document.createElement("tbody");

  // cells creation
  for (var j = 0; j <= 3; j++) {
    // table row creation
    var row = document.createElement("tr");
    //row.valign="center";

    for (var i = 0; i < 3; i++) {
      // create element <td> and text node 
      //Make text node the contents of <td> element
      // put <td> at end of the table row
      var cell = document.createElement("td");
      var cellText = document.createTextNode(head[j][i]);
      
     

      cell.appendChild(cellText);
      if (j==1 && i==2)
         {
           var img = document.createElement("img");
          img.src = "images/seven_tally.jpg";
          cell.appendChild(img);
          }
       if (j==2 && i==1)
            {
            // Input element
            var input = document.createElement("input");
            input.type="text";
            input.id="input1";
            cell.appendChild(input);
            }   
          
       if (j==3 && i==2)
          {
           var img = document.createElement("img");
          img.src = "images/six_tally.jpg";
          cell.appendChild(img);
          }
       if (j==2 && i==2)
            {
            var canvas = document.createElement("canvas");
            canvas.id="canvas";
            
            canvas.width=150;
            canvas.height=50;
            
            cell.appendChild(canvas);
            
            
            
            var button1 = document.createElement('input');
            button1.type = 'button';
            button1.id = 'sub_button';
            button1.value = '-';
               button1.onclick = function() { sub_stroke(); };
            cell.appendChild(button1);
            
            var button2 = document.createElement('input');
            button2.type = 'button';
            button2.id = 'add_button';
            button2.value = '+';
            //button2.onclick='add_stroke()';
            button2.onclick = function() { add_stroke(); };
            cell.appendChild(button2);
            }
            
      row.appendChild(cell);
    }

    //row added to end of table body
    tblBody.appendChild(row);
  }

  // append the <tbody> inside the <table>
  tbl.appendChild(tblBody);
  // put <table> in the <body>
  body.appendChild(tbl);
  // tbl border attribute to 
  tbl.setAttribute("border", "2");
}


</script>