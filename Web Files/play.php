<?php
session_start();

	if (!isset($_SESSION['username'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: ../transmitter.php");
	}
	
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: ../transmitter.php");
	}
?>

<!doctype html>
<html lang="en-us">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <title>UKZN ACOUSTIC AUTHENTICATION - SECOND LAYER TRANSMITTER</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="ukzn-acoustic-authentication.png" rel="icon">

<style>
html { 
  background: url(geometric-background-2675011_1920.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  overflow: hidden;
}

img{
  display: block;
  margin: auto;
  width: 100%;
  height: auto;
}

#login-button{
  cursor: pointer;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  padding: 30px;
  margin: auto;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: rgba(3,3,3,.8);
  overflow: hidden;
  opacity: 0.4;
  box-shadow: 10px 10px 30px #000;}

/* Login container */
#container{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  width: 260px;
  height: 180px;
  border-radius: 5px;
  background: rgba(3,3,3,0.25);
  box-shadow: 1px 1px 50px #000;
  display: none;
}

.close-btn{
  position: absolute;
  cursor: pointer;
  font-family: 'Open Sans Condensed', sans-serif;
  line-height: 18px;
  top: 3px;
  right: 3px;
  width: 20px;
  height: 20px;
  text-align: center;
  border-radius: 10px;
  opacity: .2;
  -webkit-transition: all 2s ease-in-out;
  -moz-transition: all 2s ease-in-out;
  -o-transition: all 2s ease-in-out;
  transition: all 0.2s ease-in-out;
}

.close-btn:hover{
  opacity: .5;
}

/* Heading */
h1{
  font-family: 'Open Sans Condensed', sans-serif;
  position: relative;
  margin-top: 0px;
  text-align: center;
  font-size: 40px;
  color: #ddd;
  text-shadow: 3px 3px 10px #000;
}

/* Inputs */
a,
input{
  font-family: 'Open Sans Condensed', sans-serif;
  text-decoration: none;
  position: relative;
  width: 80%;
  display: block;
  margin: 9px auto;
  font-size: 17px;
  color: #fff;
  padding: 8px;
  border-radius: 6px;
  border: none;
  background: rgba(3,3,3,.1);
  -webkit-transition: all 2s ease-in-out;
  -moz-transition: all 2s ease-in-out;
  -o-transition: all 2s ease-in-out;
  transition: all 0.2s ease-in-out;
}

input:focus{
  outline: none;
  box-shadow: 3px 3px 10px #333;
  background: rgba(3,3,3,.18);
}

/* Placeholders */
::-webkit-input-placeholder {
   color: #ddd;  }
:-moz-placeholder { /* Firefox 18- */
   color: red;  }
::-moz-placeholder {  /* Firefox 19+ */
   color: red;  }
:-ms-input-placeholder {  
   color: #333;  }

/* Link */
a{
  font-family: 'Open Sans Condensed', sans-serif;
  text-align: center;
  padding: 4px 8px;
  background: rgba(107,255,3,0.3);
}

a:hover{
  opacity: 0.7;
}

#remember-container{
  position: relative;
  margin: -5px 20px;
}

.checkbox {
  position: relative;
  cursor: pointer;
	-webkit-appearance: none;
	padding: 5px;
	border-radius: 4px;
  background: rgba(3,3,3,.2);
	display: inline-block;
  width: 16px;
  height: 15px;
}

.checkbox:checked:active {
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
}

.checkbox:checked {
  background: rgba(3,3,3,.4);
	box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.5);
	color: #fff;
}

.checkbox:checked:after {
	content: '\2714';
	font-size: 10px;
	position: absolute;
	top: 0px;
	left: 4px;
	color: #fff;
}

#remember{
  position: absolute;
  font-size: 13px;
  font-family: 'Hind', sans-serif;
  color: rgba(255,255,255,.5);
  top: 7px;
  left: 20px;
}

#forgotten{
  position: absolute;
  font-size: 12px;
  font-family: 'Hind', sans-serif;
  color: rgba(255,255,255,.2);
  right: 0px;
  top: 8px;
  cursor: pointer;
  -webkit-transition: all 2s ease-in-out;
  -moz-transition: all 2s ease-in-out;
  -o-transition: all 2s ease-in-out;
  transition: all 0.2s ease-in-out;
}

#forgotten:hover{
  color: rgba(255,255,255,.6);
}

#forgotten-container{
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  width: 260px;
  height: 180px;
  border-radius: 10px;
  background: rgba(3,3,3,0.25);
  box-shadow: 1px 1px 50px #000;
  display: none;
}

.orange-btn{
  background: rgba(87,198,255,.5);
}
</style>
    </head>
    <body>
        <div id="main-container">
        <div id="login-button" onclick="action()">
          <img src="2191536_key_login_pad_secret_secure_icon.svg">
        </div>
        <div id="container">
            <br>
          <h1 style="font-size:18pt">Secure Code</h1>
          <a href="transmitter.php" style="color:red" class="close-btn">X</a>
          <h1 name="text" id="text2"  style="font-size:14pt">Second Layer</h1>
          <h1 name="text1" id="text3" style="font-size:12pt">Signal...</h1>
                            <!-- mysql enquiries -->
                            <!-- Retrieved securcode from databased, as per the current logged in user -->
                            <?php 
                        	session_start(); 
                        
                        	if (!isset($_SESSION['username']) || $_GET["user"] =="" ) 
                        	{
                        		header('location: login-required.php');
                        	}
                        
                        	if (isset($_GET['logout']) || $_GET["user"] =="") 
                        	{
                        		session_destroy();
                        		unset($_SESSION['username']);
                        		header("location: login.php");
                        	}                            
                            $_SESSION['username']= $_GET["user"];
                            
                            include "database.php"; 
                            $code="";
                            $query = "SELECT * FROM authentication WHERE username = '". $_GET["user"]."' ";  
                            $result = mysqli_query($conn, $query); 
                            if(mysqli_num_rows($result) > 0)  
                             {  
                               if($row = mysqli_fetch_array($result))  
                                {
                                     $code = $row["securecode"];
                                }
                             }

                            ?>

            <input type="text" hidden name="data" id="payload_tx" value="<?php echo $code; ?>">
            <a><button style="color:green" onclick="onSend();">Send</button></a>
        </div>
        
            <button id="btn_start" hidden>Play</button>
            <button id="btn_stop" hidden>Cancel</button>
        </div>

        <script type="text/javascript" src="acousticlib.js"></script>
        <script type='text/javascript'>
            window.AudioContext = window.AudioContext || window.webkitAudioContext;
            window.OfflineAudioContext = window.OfflineAudioContext || window.webkitOfflineAudioContext;

            var context = null;
            var recorder = null;

            //  acoustica  instance
            var acoustica = null;
            var parameters = null;
            var instance = null;

            // instantiate the acoustica instance
            // acoustica_hub is from the acoustica.js 
            acoustica_hub().then(function(obj) {
                acoustica = obj;
            });

            var payload_tx = document.getElementById("payload_tx");
            var payload_rx = document.getElementById("payload_rx");
            var btn_start = document.getElementById("btn_start");
            var btn_stop = document.getElementById("btn_stop");

            // helper function
            function convertTypedArray(src, type) {
                var buffer = new ArrayBuffer(src.byteLength);
                var baseView = new src.constructor(buffer).set(src);
                return new type(buffer);
            }

            // initialize audio context and acoustica
            function init() {
                if (!context) {
                    context = new AudioContext({sampleRate: 48000});

                    parameters = acoustica.getDefaultParameters();
                    parameters.sampleRateInp = context.sampleRate;
                    parameters.sampleRateOut = context.sampleRate;
                    instance = acoustica.init(parameters);
                }
            }

            //
            // Traansmitter
            //

            function onSend() {
                init();

                // pause audio capture during transmission
                btn_stop.click();

                // generate audio waveform
                var waveform = acoustica.encode(instance, payload_tx.value, acoustica.TxProtocolId.GGWAVE_TX_PROTOCOL_AUDIBLE_FAST, 10)

                // play audio
                var buf = convertTypedArray(waveform, Float32Array);
                var buffer = context.createBuffer(1, buf.length, context.sampleRate);
                buffer.getChannelData(0).set(buf);
                var source = context.createBufferSource();
                source.buffer = buffer;
                source.connect(context.destination);
                source.start(0);
            }

            //
            // Reciever Side
            //

            btn_start.addEventListener("click", function () {
                init();

                let constraints = {
                    audio: {
                        // ...
                    }
                };

                navigator.mediaDevices.getUserMedia(constraints).then(function (e) {
                    mediaStream = context.createMediaStreamSource(e);

                    var bufferSize = 16*1024;
                    var numberOfInputChannels = 1;
                    var numberOfOutputChannels = 1;

                    if (context.createScriptProcessor) {
                        recorder = context.createScriptProcessor(
                                bufferSize,
                                numberOfInputChannels,
                                numberOfOutputChannels);
                    } else {
                        recorder = context.createJavaScriptNode(
                                bufferSize,
                                numberOfInputChannels,
                                numberOfOutputChannels);
                    }

                    recorder.onaudioprocess = function (e) {
                        var source = e.inputBuffer;
                        var res = acoustica.decode(instance, convertTypedArray(new Float32Array(source.getChannelData(0)), Int8Array));
                        if (res) {
                            payload_rx.value = res;
                        }

                    }

                    mediaStream.connect(recorder);
                    recorder.connect(context.destination);
                }).catch(function (e) {
                    console.error(e);
                });

                payload_rx.value = 'Waiting ...';
                btn_start.hidden = true;
                btn_stop.hidden = false;
            });

            btn_stop.addEventListener("click", function () {
                if (recorder) {
                    recorder.disconnect(context.destination);
                    mediaStream.disconnect(recorder);
                    recorder = null;
                }

                payload_rx.value = 'Paused';
                btn_start.hidden = false;
                btn_stop.hidden = true;
            });

            btn_stop.click();
        </script>
        <script>
//autoclick for icon when user clicks "Not A Member Button"
document.getElementById("login-button").click();
function action(){
  $('#login-button').fadeOut("slow",function(){
    $("#container").fadeIn();
    TweenMax.from("#container", .4, { scale: 0, ease:Sine.easeInOut});
    TweenMax.to("#container", .4, { scale: 1, ease:Sine.easeInOut});
  });
};

$(".close-btn").click(function(){
  TweenMax.from("#container", .4, { scale: 1, ease:Sine.easeInOut});
  TweenMax.to("#container", .4, { left:"0px", scale: 0, ease:Sine.easeInOut});
  $("#container, #forgotten-container").fadeOut(800, function(){
    $("#login-button").fadeIn(800);
  });
});

/* Forgotten Password */
$('#forgotten').click(function(){
  $("#container").fadeOut(function(){
    $("#forgotten-container").fadeIn();
  });
});
</script>
    </body>
</html>
