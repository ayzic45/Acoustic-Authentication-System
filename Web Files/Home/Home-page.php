<?php

session_start();
$username =$_SESSION['username'];
		include "../database.php";

	if (!isset($_SESSION['username'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: ../login.php");
	}
		
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: https://ukznacousticauth.site/login-required.php");
	}
	
	if (isset($_GET['delete'])) {

		mysqli_query($conn, "DELETE FROM ac_users WHERE username='".$_SESSION['username']."'");
		mysqli_query($conn, "DELETE FROM authentication WHERE username='".$_SESSION['username']."'");
				session_destroy();
		unset($_SESSION['username']);
        echo '<script>alert("Your account has been removed from the system, It was nice having seeing you around.!")</script>';
		header("location: ../register.php");
	}
	
	
	if (isset($_GET['report'])) {	
	    
	           $query = "SELECT * FROM ac_users WHERE username = '$username'";  
                 $result = mysqli_query($conn, $query); 
                    if(mysqli_num_rows($result) > 0)  
                    {
                      $row = mysqli_fetch_array($result);
                      $userID =$row["user_id"];
                      $email =$row["email_address"];
                      $fullname =$row["fullname"];
                      $mobile =$row["mobile_number"];
                    }
        
                    //set enquiry to database before sending and email, but it all happends in a short peiod of time
                    mysqli_query($conn,"UPDATE authentication set review='Action Required' WHERE username='$username'");
                    //report unusual activity so that our admin will update your details and secure your account
                    //this is beacuse the code is not being shared even with users since they are bieng used to authenticate only

                        ini_set( 'display_errors', 1 );
                        error_reporting( E_ALL );
                        $from = $email;
                        $to  = "accounts@ukznacousticauth.site";
                        $subject = "UKZN ACOUSTIC AUTHENTICATION-UNUSUAL ACTIVITY";
                        
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

            			$message .= "<h1 >Greetings, Admin </h1>";
                        $message .= '<p style="color:#080;font-size:18px;">Please kindly review my account, there have been login attempts that i do not recognise</p>';
                        $message .= '<p style="color:#080;font-size:18px;">Below are the summary details of my account</p>';                        
            			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            			$message .= "<tr style='background: #eee;'><td><strong>Full Name:</strong> </td><td>" . $fullname . "</td></tr>";            			
            			$message .= "<tr style='background: #eee;'><td><strong>User ID:</strong> </td><td>" . $userID . "</td></tr>";
            			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $email. "</td></tr>";
            			$message .= "<tr><td><strong>Mobile No:</strong> </td><td>" .$mobile. "</td></tr>";
            			
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
                        
                		header("location: ../reported.php");
                	}
                	
	if (isset($_GET['cancel'])) {	
	    
	           $query = "SELECT * FROM ac_users WHERE username = '$username'";  
                 $result = mysqli_query($conn, $query); 
                    if(mysqli_num_rows($result) > 0)  
                    {
                      $row = mysqli_fetch_array($result);
                      $userID =$row["user_id"];
                      $email =$row["email_address"];
                      $fullname =$row["fullname"];
                      $mobile =$row["mobile_number"];
                    }
        
                    //set enquiry to database before sending and email, but it all happends in a short peiod of time
                    mysqli_query($conn,"UPDATE authentication set review='' WHERE username='$username'");
                    //report unusual activity so that our admin will update your details and secure your account
                    //this is beacuse the code is not being shared even with users since they are bieng used to authenticate only

                        ini_set( 'display_errors', 1 );
                        error_reporting( E_ALL );
                        $from = $email;
                        $to  = "accounts@ukznacousticauth.site";
                        $subject = "UKZN ACOUSTIC AUTHENTICATION-REVIEW CANCELLED";
                        
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

            			$message .= "<h1 >Greetings, Admin </h1>";
                        $message .= '<p style="color:#080;font-size:18px;">Please kindly not that i have cancelled the account review</p>';
                        $message .= '<p style="color:#080;font-size:18px;">Below are the summary details of my account</p>';                        
            			$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            			$message .= "<tr style='background: #eee;'><td><strong>Full Name:</strong> </td><td>" . $fullname . "</td></tr>";            			
            			$message .= "<tr style='background: #eee;'><td><strong>User ID:</strong> </td><td>" . $userID . "</td></tr>";
            			$message .= "<tr><td><strong>Email:</strong> </td><td>" . $email. "</td></tr>";
            			$message .= "<tr><td><strong>Mobile No:</strong> </td><td>" .$mobile. "</td></tr>";
            			
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
                        
                		header("location: ../cancelled.php");
                	}				
                    if(count($_POST)>0) 
                    {
                        mysqli_query($conn,"UPDATE ac_users set mobile='" . $_POST['mobile'] . "', full_name= '" . $_POST['full_name'] . "',address= '" . $_POST['address'] . "' WHERE username='" . $_SESSION['username'] . "'");
                        $message = "Record Modified Successfully";
                    }
            
                    
$result = mysqli_query($conn, "SELECT * FROM ac_users where username='$username'");
$resulta = mysqli_query($conn, "SELECT * FROM authentication where username='$username'");
$row = mysqli_fetch_array($result);
$rowa = mysqli_fetch_array($resulta);
$fullname = $row["fullname"];
$email = $row["email_address"];
$number = $row["mobile_number"];
$date = $row["date_created"];
$securecode = $rowa["securecode"];
$loginft = $rowa["fail_attempts"];
$rev = $rowa["review"];
$status= $row["status"];
$user_id =$row["user_id"];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>UKZN ACOUSTIC AUTHENTICATION - HOME PAGE</title>
<!--

Template 2102 Constructive

http://www.tooplate.com/view/2102-constructive

Last Modified by Ayanda Mdluli @14 November 2021

--> <link href="ukzn-acoustic-authentication.png" rel="icon">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">  <!-- Google web font "Open Sans" -->
	<link rel="stylesheet" href="css/fontawesome-all.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/magnific-popup.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick.css"/>
	<link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
	<link rel="stylesheet" href="css/tooplate-style.css">
  <link rel="stylesheet" type="text/css" href="listuser.css" />
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<script>
		var renderPage = true;

	if(navigator.userAgent.indexOf('MSIE')!==-1
		|| navigator.appVersion.indexOf('Trident/') > 0){
   		/* Microsoft Internet Explorer detected in. */
   		alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
   		renderPage = false;
	}
	</script>
</head>

<body>
	<!-- Loader -->
	<div id="loader-wrapper">
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
		<div class="loader-section section-right"></div>
	</div>
	
	<!-- Page Content -->
	<div class="container-fluid tm-main">
		<div class="row tm-main-row">

			<!-- Sidebar -->
			<div id="tmSideBar" class="col-xl-3 col-lg-4 col-md-12 col-sm-12 sidebar">

				<button id="tmMainNavToggle" class="menu-icon">&#9776;</button>

				<div class="inner">
					<nav id="tmMainNav" class="tm-main-nav">
						<ul>
							<li>
								<a href="#intro" id="tmNavLink1" class="scrolly active" data-bg-img="constructive_bg_01.jpg" data-page="#tm-section-1">
									<i class="fas fa-home tm-nav-fa-icon"></i>
									<span>Dashboard</span>
								</a>
							</li>
							<li>
								<a href="#products" id="tmNavLink2" class="scrolly" data-bg-img="constructive_bg_02.jpg" data-page="#tm-section-2" data-page-type="carousel">
									<i class="fas fa-map tm-nav-fa-icon"></i>
									<span>View Profile</span>
								</a>
							</li>
							<li>
								<a href="#products" id="tmNavLink2" class="scrolly" data-bg-img="constructive_bg_02.jpg" data-page="#tm-section-3" data-page-type="carousel">
									<i class="fas fa-map tm-nav-fa-icon"></i>
									<span>Notifications</span>
								</a>
							</li>
							<li>
							    
								<a href="#company" class="scrolly" data-bg-img="constructive_bg_03.jpg" data-page="#tm-section-4">
									<i class="fas fa-users tm-nav-fa-icon"></i>
									<span>Personal Details</span>
								</a>
							</li>
							<li>
								<a href="#contact" class="scrolly" data-bg-img="constructive_bg_04.jpg" data-page="#tm-section-5">
									<i class="fas fa-comments tm-nav-fa-icon"></i>
									<span>Delete Account</span>
								</a>
							</li>
						<li>
								<a  class="scrolly" data-bg-img="constructive_bg_02.jpg"  data-page="#tm-section-6">
									<i class="fas fa-map tm-nav-fa-icon"></i>
									<span>Logout</span>
								</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>

			<div class="col-xl-9 col-lg-8 col-md-12 col-sm-12 tm-content">

					<!-- section 1 -->
					<section id="tm-section-1" class="tm-section">
						<div class="ml-auto">
							<header class="mb-4"><h1 class="tm-text-shadow">UKZN ACOUSTIC AUTHENTICATION BOARD</h1></header>
							 
							<p class="mb-5 tm-font-big">Hi, <p1 style="color:blue"><?php echo $fullname?></p1> Latest News and Update will appear here</p>
						<!--	<input class="btn tm-btn tm-font-big" data-nav-link="#tmNavLink2"> </a> -->
							<!-- data-nav-link holds the ID of nav item, which means this link should behave the same as that nav item  -->
							
								<div class="tm-bg-transparent-black tm-contact-box-pad">
							<div class="row mb-4">
								<div class="col-sm-12">
	                        <header class="mb-4"><h1 style="color:white; font-size:14pt" class="tm-text-shadow">LOGIN FAIL ATTEMPTS: <?php if($loginft<=3){?> <p1 style="color:green"> <?php echo $loginft?> </p1> <?php } else if($loginft>3 && $loginft<=6) {?><p1 style="color:orange"> <?php echo $loginft?></p1> <br> <a style="color:orange" href="Home-page.php?report='1'" class="mb-5 tm-font-big">Your account is in danger, Report this? </a><?php } else if($loginft>6 && $rev=="") {?><p1 style="color:red"> <?php echo $loginft?></p1> <br> <a style="color:red" href="Home-page.php?report='1'" class="mb-5 tm-font-big">Your account is in danger, Report this? </a><?php } else {?> <p1 style="color:red"> <?php echo $loginft?></p1> <br> <a style="color:red" class="mb-5 tm-font-big">Your account is under review </a> <br> <a style="color:orange" href="Home-page.php?cancel='1'" class="mb-5 tm-font-big">Click To Cancel ! </a><?php } ?></h1></header>
								</div>
							</div>

						</div>
							
						</div>
					</section>

					<!-- section 2 -->
					<section id="tm-section-2" class="tm-section tm-section-carousel">
							<div class="ml-auto">
							<header class="mb-4"><h1 class="tm-text-shadow">USER PROFILE</h1></header>
						<!--	<input class="btn tm-btn tm-font-big" data-nav-link="#tmNavLink2"> </a> -->
							<!-- data-nav-link holds the ID of nav item, which means this link should behave the same as that nav item  -->
							
								<div class="tm-bg-transparent-black tm-contact-box-pad">
							<div class="row mb-4">
								<div class="col-sm-12">
	                        <header class="mb-4">
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Full Name    : <?php echo $fullname?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Secure Code  : <?php echo $securecode?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Phone Number : <?php echo $number?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Email        : <?php echo $email?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Date Opened  : <?php echo $date?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Status       : <?php echo $status?></h1>
	                        </header>
								</div>
							</div>

						</div>
							
						</div>    		          	
					</section>

					<!-- section 3 -->
								
					<section id="tm-section-3" class="tm-section">
	<div class="ml-auto">
							<header class="mb-4"><h1 class="tm-text-shadow">NOTIFICATIONS</h1></header>
							 
							<p class="mb-5 tm-font-big" style="color:red"><?php if($loginft>0){?> Hi, <?php echo $fullname?> you have <?php echo $loginft?> login failed atempts, we suspect that someone might have been trying to use your accoun, remember not to give anyone your phone or PIN code, if this was not you urgently report to us. <?php } else { ?> <p1 style="color:green">Your account has no issues</p1> <?php }?></p>
						<!--	<input class="btn tm-btn tm-font-big" data-nav-link="#tmNavLink2"> </a> -->
							<!-- data-nav-link holds the ID of nav item, which means this link should behave the same as that nav item  -->
							
								<div class="tm-bg-transparent-black tm-contact-box-pad">
							<div class="row mb-4">
								<div class="col-sm-12">
	                        <header class="mb-4"><h1 style="color:white; font-size:14pt" class="tm-text-shadow">LOGIN FAIL ATTEMPTS: <?php if($loginft<=3){?> <p1 style="color:green"> <?php echo $loginft?> </p1> <?php } else if($loginft>3 && $loginft<=6) {?><p1 style="color:orange"> <?php echo $loginft?></p1> <br> <a style="color:orange" href="Home-page.php?report='1'" class="mb-5 tm-font-big">Your account is in danger, Report this? </a><?php } else {?><p1 style="color:red"> <?php echo $loginft?></p1> <br> <a style="color:red" href="Home-page.php?report='1'" class="mb-5 tm-font-big">Your account is in danger, Report this? </a><?php } ?> </h1></header>
								</div>
							</div>

						</div>
							
						</div>
					</section>

					<!-- section 4 -->
				 <form name="frmUser" method="post" action="">			
					<section id="tm-section-4" class="tm-section">
<div class="ml-auto">
							<header class="mb-4"><h1 class="tm-text-shadow">Personal Details</h1></header>
						<!--	<input class="btn tm-btn tm-font-big" data-nav-link="#tmNavLink2"> </a> -->
							<!-- data-nav-link holds the ID of nav item, which means this link should behave the same as that nav item  -->
							
								<div class="tm-bg-transparent-black tm-contact-box-pad">
							<div class="row mb-4">
								<div class="col-sm-12">
	                        <header class="mb-4">
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Full Name    : <?php echo $fullname?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Secure Code  : <?php echo $securecode?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Phone Number : <?php echo $number?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Email        : <?php echo $email?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">User ID      : <?php echo $user_id?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Date Opened  : <?php echo $date?></h1>
	                            <h1 style="color:white; font-size:14pt" class="tm-text-shadow">Status       : <?php echo $status?></h1>
	                        </header>
								</div>
							</div>

						</div>
							
						</div>             		
										               
					</section>
                    </form>
                    
						<!-- section 5 -->
					<section id="tm-section-5" class="tm-section">
						<div class="tm-bg-transparent-black tm-contact-box-pad">
							<div class="row mb-4">
								<div class="col-sm-12">
	                        <header class="mb-4"><h1 style="color:red" class="tm-text-shadow">ARE YOU SURE YOU WANT TO DELETE YOUR ACCOUNT PERMANENTLY?</h1></header>
							<a style="color:red" href="Home-page.php?delete='1'" class="mb-5 tm-font-big">Click Here To Confirm !</a>
								</div>
							</div>

						</div>
					</section>		

					<!-- section 6 -->
					<section id="tm-section-6" class="tm-section">
						<div class="tm-bg-transparent-black tm-contact-box-pad">
							<div class="row mb-4">
								<div class="col-sm-12">
	                        <header class="mb-4"><h1 style="color:red" class="tm-text-shadow">ARE YOU SURE YOU WANT TO LOGOUT?</h1></header>
							<a style="color:red" href="Home-page.php?logout='1'" class="mb-5 tm-font-big">Click Here To Confirm !</a>
								</div>
							</div>

						</div>
					</section>
					
				</div>	<!-- .tm-content -->							
				<footer class="footer-link">
					<p class="tm-copyright-text">Copyright &copy; 2021 UKZN ACOUSTIC AUTHENTICATION</p>
				</footer>
			</div>	<!-- row -->			
		</div>
		<div id="preload-01"></div>
		<div id="preload-02"></div>
		<div id="preload-03"></div>
		<div id="preload-04"></div>

		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
		<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
		<script type="text/javascript" src="slick/slick.min.js"></script> <!-- Slick Carousel -->

		<script>

		var sidebarVisible = false;
		var currentPageID = "#tm-section-1";

		// Setup Carousel
		function setupCarousel() {

			// If current page isn't Carousel page, don't do anything.
			if($('#tm-section-2').css('display') == "none") {
			}
			else {	// If current page is Carousel page, set up the Carousel.

				var slider = $('.tm-img-slider');
				var windowWidth = $(window).width();

				if (slider.hasClass('slick-initialized')) {
					slider.slick('destroy');
				}

				if(windowWidth < 640) {
					slider.slick({
	              		dots: true,
	              		infinite: false,
	              		slidesToShow: 1,
	              		slidesToScroll: 1
	              	});
				}
				else if(windowWidth < 992) {
					slider.slick({
	              		dots: true,
	              		infinite: false,
	              		slidesToShow: 2,
	              		slidesToScroll: 1
	              	});
				}
				else {
					// Slick carousel
	              	slider.slick({
	              		dots: true,
	              		infinite: false,
	              		slidesToShow: 3,
	              		slidesToScroll: 2
	              	});
				}

				// Init Magnific Popup
				$('.tm-img-slider').magnificPopup({
				  delegate: 'a', // child items selector, by clicking on it popup will open
				  type: 'image',
				  gallery: {enabled:true}
				  // other options
				});
      		}
  		}

  		// Setup Nav
  		function setupNav() {
  			// Add Event Listener to each Nav item
	     	$(".tm-main-nav a").click(function(e){
	     		e.preventDefault();
		    	
		    	var currentNavItem = $(this);
		    	changePage(currentNavItem);
		    	
		    	setupCarousel();
		    	setupFooter();

		    	// Hide the nav on mobile
		    	$("#tmSideBar").removeClass("show");
		    });	    
  		}

  		function changePage(currentNavItem) {
  			// Update Nav items
  			$(".tm-main-nav a").removeClass("active");
     		currentNavItem.addClass("active");

	    	$(currentPageID).hide();

	    	// Show current page
	    	currentPageID = currentNavItem.data("page");
	    	$(currentPageID).fadeIn(1000);

	    	// Change background image
	    	var bgImg = currentNavItem.data("bgImg");
	    	$.backstretch("img/" + bgImg);		    	
  		}

  		// Setup Nav Toggle Button
  		function setupNavToggle() {

			$("#tmMainNavToggle").on("click", function(){
				$(".sidebar").toggleClass("show");
			});
  		}

  		// If there is enough room, stick the footer at the bottom of page content.
  		// If not, place it after the page content
  		function setupFooter() {
  			
  			var padding = 100;
  			var footerPadding = 40;
  			var mainContent = $("section"+currentPageID);
  			var mainContentHeight = mainContent.outerHeight(true);
  			var footer = $(".footer-link");
  			var footerHeight = footer.outerHeight(true);
  			var totalPageHeight = mainContentHeight + footerHeight + footerPadding + padding;
  			var windowHeight = $(window).height();		

  			if(totalPageHeight > windowHeight){
  				$(".tm-content").css("margin-bottom", footerHeight + footerPadding + "px");
  				footer.css("bottom", footerHeight + "px");  			
  			}
  			else {
  				$(".tm-content").css("margin-bottom", "0");
  				footer.css("bottom", "20px");  				
  			}  			
  		}

  		// Everything is loaded including images.
      	$(window).on("load", function(){

      		// Render the page on modern browser only.
      		if(renderPage) {
				// Remove loader
		      	$('body').addClass('loaded');

		      	// Page transition
		      	var allPages = $(".tm-section");

		      	// Handle click of "Continue", which changes to next page
		      	// The link contains data-nav-link attribute, which holds the nav item ID
		      	// Nav item ID is then used to access and trigger click on the corresponding nav item
		      	var linkToAnotherPage = $("a.tm-btn[data-nav-link]");
			    
			    if(linkToAnotherPage != null) {
			    	
			    	linkToAnotherPage.on("click", function(){
			    		var navItemToHighlight = linkToAnotherPage.data("navLink");
			    		$("a" + navItemToHighlight).click();
			    	});
			    }
		      	
		      	// Hide all pages
		      	allPages.hide();

		      	$("#tm-section-1").fadeIn();

		     	// Set up background first page
		     	var bgImg = $("#tmNavLink1").data("bgImg");
		     	
		     	$.backstretch("img/" + bgImg, {fade: 500});

		     	// Setup Carousel, Nav, and Nav Toggle
			    setupCarousel();
			    setupNav();
			    setupNavToggle();
			    setupFooter();

			    // Resize Carousel upon window resize
			    $(window).resize(function() {
			    	setupCarousel();
			    	setupFooter();
			    });
      		}	      	
		});

		</script>
		<script src="listuser.js"></script>
	</body>
</html>