#!/usr/local/php5/bin/php-cgi
<?php
	$connection = mysqli_connect("cecs-db01.coe.csulb.edu","cecs470m15","boab1d","cecs470og1");
	$error = mysqli_connect_error();
	if ($error != null){
		$output = "<p>Unable to connect to database<p>" . $error;
		exit($output);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Classes</title>
		<link rel="stylesheet" href="styles.css">
		<link href="calendar.css" rel="stylesheet">
		<link rel="stylesheet" href="class.css">
	</head>
	<body>
		<!--Begin header section-->
		<header>
			<div id="header-inner">
				<div id="logo">
					<a href="index.html">PRIDE ALL STAR</a>
				</div>
				<nav>
					<ul>
						<li><a href="index.html"><strong>Home</strong></a></li>
						<li><a href="class.html"><strong>Classes</strong></a></li>
						<li><a href="calendar.php"><strong>Calendar</strong></a></li>
						<li><a href="media.html"><strong>Media</strong></a></li>
						<li><a href="contactus.html"><strong>Contact Us</strong></a></li>
					</ul>
				</nav>
			</div>
		</header>
		<!--End header section-->
		<h1 id='contentHeader'>CALENDAR</h1>
		<!--Start of main content-->
		<div id="wrapper">
			<div id="calendar-section">
			<table>
				<tr>
					<th>Date</th>
					<th>Event</th>
					<th>Location</th>
				</tr>
				<?php
					$sql = "SELECT date,event,location FROM event order by date";					
					if ($result=mysqli_query($connection,$sql)){
						while ($row=mysqli_fetch_assoc($result)){
							echo '<tr><td>'.$row["date"].'</td><td>'.$row["event"].'</td><td>'.$row["location"].'</td></tr>';
							}
						mysqli_free_result($result);
						}
					else { echo "no result<br>";}
				?>
			</table>
		</div>
		</div>
		<!--End of main content-->
		<!--Begin footer section-->
		<footer>
			<div id="footer-inner">
				<div id="about">
					<h1>About Us</h1>
					<p>California Pride All-Stars is an organization of cheerleading teams that offers athletes the opportunity to participate in competitive cheerleading through a fun and safe environment.</p>
				</div>
				<div id="contact">
					<h1>Contact Us</h1>
					<p>Email: prideallstars@gmail.com<br><br>Address: 4123 Medford St, #1220<br>Los Angeles, California<br></p>
				</div>
				<div id="quicklink">
					<h1>&copy Copyright</h1>
					<p>Copyright 2017-2018 by Pride All Star.<br>All Rights Reserved.<br>Powered by CECS470 Group 1.</p>
				</div>
				<div id="social-site">
					<a target="_blank" class="social-icon" href="https://www.facebook.com/prideallstars"><img class="social-icon" src="facebook.jpg" alt="facebook site"></a>
					<a target="_blank" class="social-icon" href="https://www.instagram.com/caprideallstars/"><img class="social-icon" src="instagram.jpg" alt="instagram site"></a>
					<a target="_blank" class="social-icon" href="https://www.youtube.com/channel/UC4b-aRi98roociDGs32WQhw"><img class="social-icon" src="youtube.jpg" alt="youtube site"></a>
					<a target="_blank" style="margin:0;font-size:0.8em;" href="http://www.freepik.com/free-vector/9-social-networking_1080503.htm">Designed by Freepik</a>
				</div>
			</div>
		</footer>
		<!--End footer section-->
		<?php
	echo "Last modified: " . date ("F d Y H:i:s.", getlastmod())."<br/>";
	?>
		</body>
	</html>	