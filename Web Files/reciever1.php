<?php
	session_start();

	if (!isset($_SESSION['username'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login-required.php");
	}
		
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login-required.php");
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
        <title>UKZN ACOUSTIC AUTHENTICATION - RECIEVED SIGNAL</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="ukzn-acoustic-authentication.png" rel="icon">


<!-- Additional JS for rec-->
        <style type="text/css">
            body {
                position: absolute;
                display: -webkit-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-pack: center;
                -webkit-justify-content: center;
                    -ms-flex-pack: center;
                        justify-content: center;
                -webkit-box-align: center;
                -webkit-align-items: center;
                    -ms-flex-align: center;
                        align-items: center;
                height: 100%;
                width: 100%;
                margin: 0;
            }
            .holder {
                background-color: #4c474c;
                background-image: -webkit-gradient(linear, left bottom, left top, from(#4c474c), to(#141414));
                background-image: -o-linear-gradient(bottom, #4c474c 0%, #141414 100%);
                background-image: linear-gradient(0deg, #4c474c 0%, #141414 100%);
                border-radius: 50px;
            }
            [data-role="controls"] > button {
                margin: 1px auto;
                outline: none;
                display: block;
                border: none;
                background-color: #D9AFD9;
                background-image: -webkit-gradient(linear, left bottom, left top, from(#D9AFD9), to(#97D9E1));
                background-image: -o-linear-gradient(bottom, #D9AFD9 0%, #97D9E1 100%);
                background-image: linear-gradient(0deg, #D9AFD9 0%, #97D9E1 100%);
                width: 10px;
                height: 10px;
                border-radius: 1%;
                text-indent: -1000em;
                cursor: pointer;
                -webkit-box-shadow: 0px 2px 2px 1px rgba(0,0,0,0.3) inset, 
                    0px 0px 0px 30px #fff, 0px 0px 0px 35px #333;
                        box-shadow: 0px 2px 2px 1px rgba(0,0,0,0.3) inset, 
                    0px 0px 0px 30px #fff, 0px 0px 0px 35px #333;
            }
            [data-role="controls"] > button:hover {
                background-color: #ee7bee;
                background-image: -webkit-gradient(linear, left bottom, left top, from(#ee7bee), to(#6fe1f5));
                background-image: -o-linear-gradient(bottom, #ee7bee 0%, #6fe1f5 100%);
                background-image: linear-gradient(0deg, #ee7bee 0%, #6fe1f5 100%);
            }
            [data-role="controls"] > button[data-recording="true"] {
                background-color: #ff2038;
                background-image: -webkit-gradient(linear, left bottom, left top, from(#ff2038), to(#b30003));
                background-image: -o-linear-gradient(bottom, #ff2038 0%, #b30003 100%);
                background-image: linear-gradient(0deg, #ff2038 0%, #b30003 100%);
            }
            [data-role="recordings"] > .row {
                width: auto;
                height: auto;
                padding: 20px;
            }
            [data-role="recordings"] > .row > audio {
                outline: none;
            }
            [data-role="recordings"] > .row > a {
                display: inline-block;
                text-align: center;
                font-size: 20px;
                line-height: 50px;
                vertical-align: middle;
                width: 50px;
                height: 50px;
                border-radius: 20px;
                color: #fff;
                font-weight: bold;
                text-decoration: underline;
                background-color: #0093E9;
                background-image: -webkit-gradient(linear, left bottom, left top, from(#0093E9), to(#80D0C7));
                background-image: -o-linear-gradient(bottom, #0093E9 0%, #80D0C7 100%);
                background-image: linear-gradient(0deg, #0093E9 0%, #80D0C7 100%);
                float: right;
                margin-left: 20px;
                cursor: pointer;
            }
            [data-role="recordings"] > .row > a:hover {
                text-decoration: none;
            }
            [data-role="recordings"] > .row > a:active {
                background-image: -webkit-gradient(linear, left top, left bottom, from(#0093E9), to(#80D0C7));
                background-image: -o-linear-gradient(top, #0093E9 0%, #80D0C7 100%);
                background-image: linear-gradient(180deg, #0093E9 0%, #80D0C7 100%);
            }
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>
        <script src="https://markjivko.com/dist/recorder.js"></script>
        <script>
            jQuery(document).ready(function () {
                var $ = jQuery;
                var myRecorder = {
                    objects: {
                        context: null,
                        stream: null,
                        recorder: null
                    },
                    init: function () {
                        if (null === myRecorder.objects.context) {
                            myRecorder.objects.context = new (
                                    window.AudioContext || window.webkitAudioContext
                                    );
                        }
                    },
                    start: function () {
                        var options = {audio: true, video: false};
                        navigator.mediaDevices.getUserMedia(options).then(function (stream) {
                            myRecorder.objects.stream = stream;
                            myRecorder.objects.recorder = new Recorder(
                                    myRecorder.objects.context.createMediaStreamSource(stream),
                                    {numChannels: 1}
                            );
                            myRecorder.objects.recorder.record();
                        }).catch(function (err) {});
                    },
                    stop: function (listObject) {
                        if (null !== myRecorder.objects.stream) {
                            myRecorder.objects.stream.getAudioTracks()[0].stop();
                        }
                        if (null !== myRecorder.objects.recorder) {
                            myRecorder.objects.recorder.stop();

                            // Validate object
                            if (null !== listObject
                                    && 'object' === typeof listObject
                                    && listObject.length > 0) {
                                // Export the WAV file
                                myRecorder.objects.recorder.exportWAV(function (blob) {
                                    var url = (window.URL || window.webkitURL)
                                            .createObjectURL(blob);

                                    // Prepare the playback
                                    var audioObject = $('<audio controls></audio>')
                                            .attr('src', url);

                                    // Prepare the download link
                                    var downloadObject = $('<a>&#9660;</a>')
                                            .attr('href', url)
                                            .attr('download', new Date().toUTCString() + '.wav');

                                    // Wrap everything in a row
                                    var holderObject = $('<div class="row"></div>')
                                            .append(audioObject)
                                            .append(downloadObject);

                                    // Append to the list
                                    listObject.append(holderObject);
                                });
                            }
                        }
                    }
                };
                // Prepare the recordings list
                var listObject = $('[data-role="recordings"]');

                // Prepare the record button
                $('[data-role="controls"] > button').click(function () {
                    // Initialize the recorder
                    myRecorder.init();

                    // Get the button state 
                    var buttonState = !!$(this).attr('data-recording');

                    // Toggle
                    if (!buttonState) {
                        $(this).attr('data-recording', 'true');
                        myRecorder.start();
                    } else {
                        $(this).attr('data-recording', '');
                        myRecorder.stop(listObject);
                    }
                });
            });
        </script>
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
  width: 400px;
  height: 260px;
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
          <img src="717747921601363730.svg">
        </div>
        <div id="container">
            <br>
          <h1 style="font-size:18pt">Recieved Signal</h1>
          <a href="reciever1.php" style="color:red" class="close-btn">X</a>
          <h1 name="text1" id="text3" hidden style="font-size:12pt">Device Permission</h1>
            <input type="text" name="DATA" id="payload_rx" readonly>
            <input type="text" name="DATA1" id="payload_rx1" readonly>

            <a>
            <button id="btn_start" style="color:green">Grant Access</button>
           <button id="btn_stop" hidden style="color:green">Cancel</button> 
            </a>
            
        
        </div>
           <!-- 
            <button id="btn_start" hidden>Grant Access</button>
            <button id="btn_stop" hidden>Cancel</button>
            -->
         <br>         <br>
         <br>
         <br>
         <br>
         <br>
         <br>         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
         <br>
            <!-- Rec Button-->
            <div class="holder">
                <div data-role="controls">
                    <button>Record</button>
                </div>
                <div data-role="recordings"></div>
            </div>

        </div>

        <script type="text/javascript" src="acousticlib.js"></script>
        <script type='text/javascript'>
            window.AudioContext = window.AudioContext || window.webkitAudioContext;
            window.OfflineAudioContext = window.OfflineAudioContext || window.webkitOfflineAudioContext;

            var context = null;
            var recorder = null;

            // the acoustica module instance
            var acoustica = null;
            var parameters = null;
            var instance = null;

            // instantiate the acoustica instance
            // acoustica_hub comes from the acoustica.js module
            acoustica_hub().then(function(obj) {
                acoustica = obj;
            });

            var payload_tx = document.getElementById("payload_tx");
            var payload_rx = document.getElementById("payload_rx");
            var payload_rx1 = document.getElementById("payload_rx1");
            var btn_start = document.getElementById("btn_start");
            var username = document.getElementById("username");
            var password = document.getElementById("password");
            var text3 = document.getElementById("text3");
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
            // Transmitter
            //

            function onSend() {
                init();

                // pause audio capture during transmission
                btn_stop.click();

                // generate audio waveform
                var waveform = acoustica.encode(instance, payload_tx.value, acoustica.TxProtocolId.GGWAVE_TX_PROTOCOL_ULTRASOUND_NORMAL, 10)

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
            // Reciever
            //

            btn_start.addEventListener("click", function () {
                init();

                let constraints = {
                    audio: {

                    }
                };
                //check emtpty field
               /* if ((username.value == "") || (password.value  == ""))
                {
                    window.alert("Username or Password Required !!!");
                    window.location.href = "reciever.php";
                }
                           
               if(!(username.value == "") && !(password.value  == ""))
                {
                    //window.alert("contained text!!!");
                            user=username.value;
                            pass=password.value;

                        
                            //mysql enquiries
                            <?php 
                            include "database.php"; 
                           
                            
                            
                            $query = "SELECT * FROM ac_users WHERE username = $user"; 
                            $result = mysqli_query($conn, $query); 
                            if(mysqli_num_rows($result) > 0)  
                             {  
                                $password = $row["password"];
                             }
                             else 
                             {
                            ?>
                              window.alert("Could not find the record from the database!");   
                            <?php
                             }
                            ?>
                            
                            if(pass=="<?php echo $password ?>")
                            {
                              window.alert("Access granted!");   
                            }
                            else 
                            {
                                window.location.href = "access_denied.php";
                            }
                }
               */   
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
                        
                        //save waveform and download
                        
                        if (res) {
                            payload_rx.value = res;
                            
                            //mysql enquiries
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
                            
                            $query = "SELECT * FROM authentication WHERE username = '". $_GET["user"]."' ";  
                            $result = mysqli_query($conn, $query); 
                            if(mysqli_num_rows($result) > 0)  
                             {  
                               while($row = mysqli_fetch_array($result))  
                                {
                                     $code = $row["securecode"];
                                }
                             }

                            ?>
                            
                            if(res=="<?php echo $code ?>")
                            {
                                payload_rx.value = "Granted with code:";
                                payload_rx1.value = res;
                                //window.location.href = "Home/Home-page.php";
                            }
                            else 
                            {
                                payload_rx.value = "Denied with code:";
                                payload_rx1.value = res;
                                //window.location.href = "access_denied.php";
                                
                            }
                        }
                    }

                    mediaStream.connect(recorder);
                    recorder.connect(context.destination);
                }).catch(function (e) {
                    console.error(e);
                });
                //initialazation on recieving
                                payload_rx.hidden = false;
                                text3.hidden = true;
                                payload_rx.value = 'Waiting ...';
                                //username.hidden = true;
                                //password.hidden = true;
                                btn_start.hidden = true;
                                btn_stop.hidden = false;
                            
               
            });

            btn_stop.addEventListener("click", function () {
                if (recorder) {
                    recorder.disconnect(context.destination);
                    mediaStream.disconnect(recorder);
                    recorder = null;
                }

                payload_rx.hidden = false;
                payload_rx.value = 'Paused !!!';
                payload_rx1.value = '...';
                text3.hidden = false;
                //username.hidden = false;
                //password.hidden = false;
                btn_start.hidden = false;
                btn_stop.hidden = true;
            });

            btn_stop.click();
            
        </script>

        <script>
//autoclick for icon from login to reciever
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
