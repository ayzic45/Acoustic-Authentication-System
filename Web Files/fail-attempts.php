<?php
	session_start();
// variable declaration
$username = $_SESSION['username'];

           include "database.php";
           
            $result = mysqli_query($conn, "SELECT * FROM authentication  WHERE username='".$_SESSION['username']."'");
            if($row = mysqli_fetch_array($result))
            {
                $count = $row["fail_attempts"];
                if($count<10)
                {
                    $countbal = $count + 1;
                    mysqli_query($conn,"UPDATE authentication set fail_attempts= $countbal  WHERE username='" . $_SESSION['username'] . "'");
                    
                    if($count==2)
                    {
                        $current_time = date('Y-m-d H:i:s');
                        $suspension_time = date("Y-m-d H:i:s", strtotime("+1 minutes", strtotime($current_time)));
                        $status="Temporarily locked for 60 seconds";
                        
                        mysqli_query($conn,"UPDATE authentication set status='1' , lock_time='$current_time', suspension_time='$suspension_time', control='1'  WHERE username='$username'");

                        mysqli_query($conn,"UPDATE ac_users set status='$status',control='1' WHERE username='$username'");
                        
                       
        		        header("location: first-warning-message.php");
        		    } 
                    else if($count==5)
                    {
                        $current_time = date('Y-m-d H:i:s');
                        $suspension_time = date("Y-m-d H:i:s", strtotime("+5 minutes", strtotime($current_time)));
                        $status="Temporarily locked for 5 minutes";
                        
                        mysqli_query($conn,"UPDATE authentication set status= '$status' ,locked= '2', lock_time='$current_time', suspension_time='$suspension_time', control='1'  WHERE username='" . $_SESSION['username'] . "'");

                        mysqli_query($conn,"UPDATE ac_users set status='$status', control= '1'  WHERE username='" . $_SESSION['username'] . "'");
                        
        		        header("location: second-warning-message.php");
        		    } 
                     else if($count==8)
                    {
                        $current_time = date('Y-m-d H:i:s');
                        $suspension_time = date("Y-m-d H:i:s", strtotime("+90 minutes", strtotime($current_time)));
                        $status="Temporarily locked for 90 minutes";
                        
                        mysqli_query($conn,"UPDATE authentication set status='$status',locked= '3', lock_time='$current_time', suspension_time='$suspension_time', control='1'  WHERE username='" . $_SESSION['username'] . "'");
                        
                        mysqli_query($conn,"UPDATE ac_users set status='$status', control= '1'  WHERE username='" . $_SESSION['username'] . "'");
                        
        		        header("location: last-warning-message.php");
        		    } 
                     else if($count==9)
                    {
                        $current_time = date('Y-m-d H:i:s');
                        $status="Recovery Phase";
                        mysqli_query($conn,"UPDATE authentication set status='$status', locked= '4', lock_time='$current_time', control='1'  WHERE username='" . $_SESSION['username'] . "'");

                        mysqli_query($conn,"UPDATE ac_users set status='$status', control= '1'  WHERE username='" . $_SESSION['username'] . "'");
                        
        		        header("location: recovery-warning-message.php");
        		    }
        		    else
        		    {
        		        header("location: reciever.php?user=$username");
        		    }
        		    
        		    
		        }
		        else
		        {
		           header("location: locked.php"); 
		        }
      }
?>

