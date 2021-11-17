<?php
	session_start();
// variable declaration
$username = $_SESSION['username'];

           include "database.php";
           
            $result = mysqli_query($conn, "SELECT * FROM authentication  WHERE username='".$_SESSION['username']."'");
            if($rowb = mysqli_fetch_array($resultb))
            {
                $count = $row["fail_attempts"];
                if($count<=10)
                {
                    $countbal = $count + 1;
                    mysqli_query($conn,"UPDATE authentication set fail_attempts= $countbal  WHERE username='" . $_SESSION['username'] . "'");
           
                    if($count==3)
                    {
        		        header("location: first-warning.php");
        		    } 
                    if($count==6)
                    {
        		        header("location: second-warning.php");
        		    } 
                     if($count==9)
                    {
        		        header("location: last-warning.php");
        		    } 
                     if($count==10)
                    {
        		        header("location: recovery-phase.php");
        		    }
		        }
		        else
		        {
		           header("location: locked.php"); 
		        }
      }
?>

