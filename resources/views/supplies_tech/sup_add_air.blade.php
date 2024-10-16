<!DOCTYPE html>
<html>

<head>
    <title>laravel webcam capture image and save from camera - ItSolutionStuff.com</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <style type="text/css">
        #results {
            padding: 20px;
            border: 1px solid;
            background: #ccc;
        }
    </style>
</head>

<body onload="startTime();">

    <div class="container">
        <h1 class="text-center">webcam capture image</h1>
        <br>
        <div class="time-container">
        <h1 id="displayTime"></h1>
        <div id="time"></div>
        </div>
        <form method="POST" action="{{ route('webcam.capture') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div id="my_camera"></div>
                    <br />
                    <input type=button value="Take Snapshot" onClick="take_snapshot()">
                    <input type="hidden" name="image" class="image-tag">
                </div>
                <div class="col-md-6">
                    <div id="results">Your captured image will appear here...</div>
                </div>
                <div class="col-md-12 text-center">
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                    <br />
                    <button class="btn btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script type="text/javascript">
     

    Webcam.set("constraints", {
        optional: [{ minWidth: 600 }]
    });
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false,
        flip_horiz: true,
        fps: 45
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }

        function chkmunny(ele){
var vchar = String.fromCharCode(event.keyCode);
if ((vchar<'0' || vchar>'9' )&& (vchar != '.')) return false;
ele.onKeyPress=vchar;
}


        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById("displayTime").innerHTML = h + ":" + m + ":" + s;
            document.getElementById('time').innerHTML = '<input type="hidden" name="time" id="time" value="' + h + ":" + m +
                ":" + s + '">';
            var t = setTimeout(startTime, 500);

            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i
                }
                return i;
            }
        }
        
    </script>
<!-- Configure a few settings and attach camera -->
{{-- <script language="JavaScript">

    function check(){
      navigator.getUserMedia=navigator.getUserMedia||navigator.webkitGetUserMedia||navigator.mozGetUserMedia||navigator.msGetUserMedia;
      if(navigator.getUserMedia)
      {
        Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
      });
      Webcam.attach( '#my_camera' );
         
      }else{
       
      }
    }
     
    
    
    </script> --}}
</body>

</html>
