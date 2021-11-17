<?php
	session_start();
// variable declaration
//$_SESSION['username'] = "";
if(count($_POST)>0) 
{
           include "database.php";
           $username = mysqli_real_escape_string($conn, $_POST["username"]);
           $mobile = mysqli_real_escape_string($conn, $_POST["mobile"]);
           $email = mysqli_real_escape_string($conn, $_POST["email"]);
           $password = mysqli_real_escape_string($conn, $_POST["password"]);
           $password1 = mysqli_real_escape_string($conn, $_POST["password1"]);

          //generate 24 character unique code || secure code for each user
            function Random24($code_length = 24) 
            {
            return substr(str_shuffle(str_repeat($var='@#&-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($code_length/strlen($var)) )),1,$code_length);
            }
            $code = Random24(); 

          //generate 4 PIN DIGITS|| for user transmitter app
            function Random4($code_length = 4) 
            {
            return substr(str_shuffle(str_repeat($var='0123456789', ceil($code_length/strlen($var)) )),1,$code_length);
            }
            $PIN = Random4();
         
           $query = "SELECT * FROM ac_users WHERE username = '$username'";
           $query1 = "SELECT * FROM ac_users WHERE username = '$mobile'";
           $query2 = "SELECT * FROM ac_users WHERE username = '$email'";
           $query3 = "SELECT * FROM authentication WHERE securecode = '$code'";

           $result = mysqli_query($conn, $query); 
           $result1 = mysqli_query($conn, $query1);
           $result2 = mysqli_query($conn, $query2);
           $result3 = mysqli_query($conn, $query3);
           
           if(mysqli_num_rows($result) > 0)  
           {
             echo '<script>alert("Username already exist!")</script>'; 
           }
           else if(mysqli_num_rows($result1) > 0)
           {  
              echo '<script>alert("Mobile Number already exist!")</script>';
           }    
           else if(mysqli_num_rows($result2) > 0)
           {  
              echo '<script>alert("Email Address already exist!")</script>';
           }
           else if($password != $password1)
           {  
              echo '<script>alert("Password and Re-Password does not match!")</script>';
           }
           else if(mysqli_num_rows($result3) > 0)
           {  
              echo '<script>alert("Technical error with code:0001 occupied, please try again!")</script>';
           }
           else
           {
               //create profile
               include "database1.php";
             
               $username =  $_POST["username"];
               $fullname = $_POST["fullname"];
               $mobile =  $_POST["mobile"];
               $email = $_POST["email"];
               $password = $_POST["password"];
               //$PIN = $_POST["PIN"];
               $status="Active";
               $current_date = date('Y-m-d H:i:s');
                
                try {
                    $con = new PDO("mysql:host=$servername;dbname=$DBname", $DBuser, $DBpassword);
                    //set the PDO error mode to exception
                    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    //insert into first database || ac_users                       
                    $sql1 = "INSERT INTO ac_users (username, fullname, mobile_number, email_address, password,PIN,status , date_created)VALUES ('". $username ."','". $fullname ."', '". $mobile ."', '". $email ."', '". $password ."', '". $PIN ."', '". $status ."', '". $current_date ."')";
                    
                    
                    //insert into second database || authentication
                    $sql2 = "INSERT INTO authentication (username, email_address, status , securecode, fail_attempts)VALUES ('". $username ."','". $email ."', '". $status ."', '". $code ."', '0')";
                    //  exec() 
                    $con->exec($sql1);
                    $con->exec($sql2);
                    
                    //send 4 PIN digits to user email, so they can be able to login to the transmitter app
                    //this can be changed in the home page afer first login

                        ini_set( 'display_errors', 1 );
                        error_reporting( E_ALL );
                        $from = "noreply@ukznacousticauth.site";
                        $to = $email;
                        $subject = "UKZN ACOUSTIC AUTHENTICATION-PIN";
                        
                        //headers
                        // To send HTML mail, the Content-type header must be set
                        
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                         
                        // Create email headers
                        $headers .= 'From: '.$from."\r\n".
                            'Reply-To: '.$from."\r\n" .
                            'X-Mailer: PHP/' . phpversion();
 
                        
                        //MESSAGE
                        $message = '<html><body>';

            			$message .= "<h1 >Hello, ".$fullname." </h1>";
                        $message .= '<p style="color:#080;font-size:18px;">Kindly note that your UKZN ACOUSTC AUTHENTICATION account was created successfully, below is the summary details of your account.</p>';
                        $message .= '<p style="color:#080;font-size:18px;">Keep your PIN safe and use it to grant access to our secure system.</p>';                        
            			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            			
            			$message .= "<tr style='background: #eee;'><td><strong>User Name:</strong> </td><td>" . $username . "</td></tr>";
            			$message .= "<tr style='background: #eee;color:red'><td><strong>PIN:</strong> </td><td>" . $PIN . "</td></tr>";
            			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $email. "</td></tr>";
            			$message .= "<tr><td><strong>Mobile No:</strong> </td><td>" .$mobile. "</td></tr>";
            			$url="https://ukznacousticauth.site/transmitter.php";
            			$url1 ="https://ukznacousticauth.site/";
            			$message .= "<tr><td><strong>Transmitter App (url):</strong> </td><td>" . $url. "</td></tr>";
            			
            			 $message .= "<tr><td><strong>Reciever (url):</strong> </td><td>". strip_tags($url1) . "</td></tr>";
            			$message .= '</table>';
            			$message .= '</body></html>';                        
                    
                        if(mail($to,$subject,$message, $headers))
                        {
                            echo '<script>alert("Email Sent & Account Created !!!")</script>';
                            //show message for opened account and go to login
                            
                        }
                        else 
                        {
                        echo '<script>alert("OOPS, Message not Sent !!!")</script>';
                        }          
                        
                        header("location: account-opened.php");     
                                                     
                    }
                catch(PDOException $e)
                    {
                        ;
                        echo $message ="Something went wrong, Please try again later". "<br>" . $e->getMessage();
                    }
                    
                $con = null;                
           }
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
        <title>UKZN ACOUSTIC AUTHENTICATION - REGISTRATION</title>
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
  height: 470px;
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
          <h1 style="font-size:18pt">Secure System</h1>
          <form class="form-signup" runat="server" action="" method="post" name="form"> 
          <h1 name="text" id="text"  style="font-size:14pt">Registration</h1>
          <input type="text" required placeholder="Full Name" name="fullname" id="fullname" minlength="10" maxlength="120">
            <input type="text" required placeholder="Username" name="username" id="username" minlength="6" maxlength="60">
            <input type="text" required placeholder="Mobile No" name="mobile" id="mobile" maxlength="13">
            <input type="email" required placeholder="Email Address" name="email" id="email" maxlength="150">
            <input type="password" required name="password" placeholder="Password" id="password" minlength="8" maxlength="16">
            <input type="password" required name="password1" placeholder="Re-Password" id="password1" minlength="8" maxlength="16">
            <a>
            <button id="captureStart" type="submit" name="submit" style="color:green">Save</button>
            </a>
             <a href="login.php" style="font-size:10pt;color:#00FF00" >Already A Member?</a>
            </form> 
        </div>
        </div>

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
	</script>
    <script>

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
