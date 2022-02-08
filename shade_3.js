
 <canvas id="canvas" width="500" height="200"></canvas>
 
<script type="text/javascript">

var ct = 50;
var th = 1;

var arr=[0,0,0,0,0,0];
var canvas;

var ctx;


draw();


function check_it()
{
var q=0;

if (document.getElementById("raw_answer").value!==0)
    {
    q = document.getElementById("raw_answer").value;
    for (z=6;z>0;z--)
        {
        if (q>=Math.pow(2,z))
            {
            arr[z]=1;
            q=q-Math.pow(2,z);
            }
        }
    }

//draw();

}


      // JavaScript Document
function draw()
  {
   canvas = document.getElementById('canvas');
   
 //  check_it();

 
canvas.addEventListener("mousedown", function (e) { getCursorPosition(canvas, e);});
  
if (canvas.getContext) 
    {
    ctx = canvas.getContext('2d');
    
 

   // ctx.fillRect(25, 25, 100, 100);
   // ctx.clearRect(45, 45, 60, 60);
    ctx.strokeRect(ct, ct, ct, ct);
    
    for (z=1;z<6;z++)
        {
        ctx.strokeRect(z*ct,2*ct,ct,ct);    
        
        }
    
  
    }
  }
  
function getCursorPosition(canvas, event) {
    const rect = canvas.getBoundingClientRect()
    const x = event.clientX - rect.left
    const y = event.clientY - rect.top
  //  console.log("x: " + x + " y: " + y)
    
    if (x>=50 && x<=100 && y>=50 && y<=100)
        {
        if (arr[0]==0)
            {
              ctx.fillRect(50+th,50+th,50-2*th,50-2*th);
              arr[0] =1;
             }
              else
              {
              ctx.clearRect(50+th,50+th,50-2*th,50-2*th);
              arr[0]=0;
              }
        }
        
    for (z=1;z<6;z++)
        {
        if (x>=ct*z && x<=ct*(z+1) && y>100 && y<=150)
            {
            if (arr[z]==0)
                {
                  ctx.fillRect(ct*z+th,ct*2+th,ct-2*th,ct-2*th);
                  arr[z] =1;
                 }
                  else
                  {
                  ctx.clearRect(ct*z+th,ct*2+th,ct-2*th,ct-2*th);
                  arr[z]=0;
                  }
            }
        
        }
    tot=tot1=0;
    for (z=0; z<6; z++)
        {
        tot =tot + arr[z]*Math.pow(2,z);
        tot1 =tot1 + arr[z];
        }
        
    document.getElementById('raw_answer').value =tot;
    document.getElementById('answer').value =tot1;
    
    answer_me(tot1,0); // Real answer
    answer_me(tot,1);  // raw answer
    
}



</script>
