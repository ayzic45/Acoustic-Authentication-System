<?php
	session_start();
// variable declaration
$username = $_SESSION['username'];

           include "database.php";
           
            $result = mysqli_query($conn, "SELECT * FROM authentication  WHERE username='".$_SESSION['username']."'");
            if($row = mysqli_fetch_array($result))
            {
                $count = $row["fail_attempts"];
                
                $current_time = date('Y-m-d H:i:s');
                $suspension_time =$row["suspension_time"];
                $ctrl =$row["control"];
                $a = strtotime($current_time);
                $b = strtotime($suspension_time);
                $period= ceil(($b - $a));
                if(!empty($ctrl) && $period<0 && $suspension_time !='0000-00-00 00:00:00')
                {
                 mysqli_query($conn,"UPDATE authentication set status='Active',locked='',control='', lock_time='', suspension_time='' WHERE username='" . $_SESSION['username'] . "'");

                 mysqli_query($conn,"UPDATE ac_users set status='Active',control= '0'  WHERE username='" . $_SESSION['username'] . "'");
                        
        		 header("location: login.php");
                }                
                else 
                {
                    if($count<10)
                    {
                        if($count==2)
                        {
            		        header("location: first-warning-message.php");
            		    } 
                        else if($count==5)
                        {
            		        header("location: second-warning-message.php");
            		    } 
                         else if($count==8)
                        {
            		        header("location: last-warning-message.php");
            		    } 
                         else if($count==9)
                        {
            		        header("location: recovery-warning-message.php");
            		    }
        		        else
        		        {
        		           header("location: temporally-locked.php"); 
        		        }
    		        }
    		        else
    		        {
    		           header("location: locked.php"); 
    		        }
                }
             }
?>

