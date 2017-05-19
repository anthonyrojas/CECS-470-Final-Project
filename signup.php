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
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="styles.css">
		<link rel="stylesheet" href="signup_styles.css">
		<script type="text/javascript" src="signup.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src='signup.js'></script>
		<title>Pride All Star</title>
	</head>
	<body>	
		<!--Begin header section-->
		<header>
			<div id="header-inner">
				<div id="logo">
					<a href="index.html">PRIDE ALL STAR</a>
				</div>
				<nav>
					<a href="#" id="menu-icon"><img src="menu-icon.png" alt="menu icon"></a>
					<ul>
						<li><a href="index.html"><strong>Home</strong></a></li>
						<li><a href="class.html"><strong>Classes</strong></a></li>
						<li><a href="calendar.html"><strong>Calendar</strong></a></li>
						<li><a href="media.html"><strong>Media</strong></a></li>
						<li><a href="contactus.html"><strong>Contact Us</strong></a></li>
					</ul>
				</nav>
			</div>
		</header>
		<!--End header section-->
		<!--main content section-->
		<div id="wrapper">
			<div id="signup">
				<h1>Signup Form</h1>
				<?php
					$error_flag = false;
					function test_input ($data){
						$data = trim($data);
						$data = stripslashes($data);
						$data = htmlspecialchars($data);
						return $data;
					}
					if ($_SERVER[REQUEST_METHOD]=="POST"){
						if(empty($_POST['firstName'])){
							$error_flag = true;
							$firstnameErr = "Enter a first name";
						}
						else {
							$fname = test_input($_POST["firstName"]);
							// check if name only contains letters and whitespace
							if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
								$error_flag = true;
								$firstnameErr = "Only letters and white space allowed";
							}
						}
						if(empty($_POST['lastName'])){
							$error_flag = true;
							$lastnameErr = "Enter a last name";
						}
						else {
							$lname = test_input($_POST["lastName"]);
							// check if name only contains letters and whitespace
							if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
								$error_flag = true;
								$lastnameErr = "Only letters and white space allowed";
							}
						}
						if(empty($_POST['phone'])){
							$error_flag = true;
							$phoneErr = "Enter a phone number";
						}
						else{
							$number = test_input($_POST['phone']);
							if(!preg_match("/^[0-9]{10}$/", $number)){
								$error_flag = true;
								$phoneErr = "Phone number must be 10 digits.";
							}
						}
						if(!isset($_POST['dance_class'])){
							$classErr = 'Select at least one class.';
							$error_flag = true;
						}
						if($error_flag == false){
							$user_exists_query = 'SELECT * FROM students WHERE firstName = "'  .$_POST['firstName']. '" AND lastName = "' .$_POST['lastName']. '" AND phone="' .$_POST['phone'] . '";';
							$user_exists_result = mysqli_query($connection, $user_exists_query);
							if(mysqli_num_rows($user_exists_result) == 0){
								$user_insert_query = 'INSERT INTO students VALUES ("' .$fname. '","' . $lname . '","' . $number. '")';
								mysqli_query($connection, $user_insert_query); 
							}
							$class_nums = Array();
							if(isset($_POST['dance_class'])){
								if(is_array($_POST['dance_class'])){
									foreach($_POST['dance_class'] as $c){
										array_push($class_nums, $c);
										$class_num = test_input($c);
										$signup_query = 'INSERT INTO class_signups VALUES(' .(int)$c. ',"' .$fname. '","' .$lname. '","' .$number. '");';
										mysqli_query($connection, $signup_query);
									}
								}
							}
							$class_prices = Array();
							$total_price = 0;
							$invoice_output = '<h1>Your Invoice</h1><h1>Name: ' .$fname .' '. $lname . '</h1><br/><table><tr><th>Class Title</th><th>Price</th></tr><br/>';
							foreach($class_nums as $c){
								$class_query = 'SELECT price, title FROM classes WHERE id=' .$c;
								$class_result = mysqli_query($connection, $class_query);
								while ($row=mysqli_fetch_assoc($class_result)){
									$invoice_output = $invoice_output .'<tr><td>'. $row["title"] .'</td><td>$'. $row["price"] . '</td></tr>';
									$total_price = $total_price + (int)$row["price"];
								}
							}
							$invoice_output = $invoice_output . '<tr><td>Total Due at Dance Studio:</td><td>$' .$total_price. '</td></tr>';
							$invoice_output = $invoice_output . '</table>';
							echo $invoice_output;

							echo '<h1>Enter another signup: </h1>';
						}
					}
				?>
				<form  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onclick="validateForm()">
					<div class="container">
						<label for="fn">First Name<br/></label>
						<input id="fn" name="firstName" type="text" size="25" placeholder="First Name" />
						<span style="color:#990000"> *<?php echo $firstnameErr;?></span> 
						
						<br><br>
						<label for="ln">Last Name<br/></label>
						<input type="text" id="ln" name="lastName" size="25" placeholder="Last Name" />
						<span style="color:#990000"> *<?php echo $lastnameErr;?></span>
						<br><br>
						<label for="phone">Phone Number<br/></label>
						<input type="text" id="phone" name="phone" size="9" placeholder="xxxxxxxxx" />
						<span style="color:#990000"> *<?php echo $phoneErr;?></span>
						<br><br>
						<?php
							$class_ids_result = mysqli_query($connection, "SELECT id FROM classes;");
							$class_ids = Array();
							echo '<p>' .$classErr. '</p>';
							echo "<table>";
							echo "<tr><th>Class #</th><th>Title</th><th>Price</th></tr>";
							while ($row=mysqli_fetch_assoc($class_ids_result)){
								echo "<tr>";
								
								$title_query = "SELECT title FROM classes WHERE id=" .$row["id"]. ";";
								$class_title_result = mysqli_query($connection, $title_query);
								$class_title = mysqli_fetch_assoc($class_title_result);
								
								$price_query = "SELECT price FROM classes WHERE id=" .$row["id"]. ";";
								$price_result = mysqli_query($connection, $price_query);
								$price = mysqli_fetch_assoc($price_result);
								
								echo "<td><input type='checkbox' name='dance_class[]' value=". $row["id"]." >".$row["id"] . "</td>";
								echo "<td>" . $class_title["title"] . "</td>";
								echo "<td>$" .$price["price"]. "</td>";
								echo "</tr>";
							}
							echo "</table>";
							//would need a query to get price for each class title
							//then create a list of options/checkboxes
							//prices would be incrementing in a total price variable
						?>
						<div class="clearfix">
							<input type="button" name="cancel" class="cancelbtn" value="Cancel"/>
							<input type="submit" name="submit" class="signupbtn" value="Sign Up"/>
						</div>
					</div>
				</form>
				<p>By enrolling class you agree to our Terms & Privacy Policy.</p>
				<p>
					This page informs you of our policies regarding the collection, use and disclosure of
					Personal Information we receive from users of the Site.
					We use your Personal Information only for providing and improving the Site. By using the Site, you
					agree to the collection and use of information in accordance with this policy.
				</p>
			</div>
		</div>
		<!--End main content section-->
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
					<a class="social-icon" href="facebook"><img class="social-icon" src="./facebook.jpg" alt="facebook site"></a>
					<a class="social-icon" href="twitter"><img class="social-icon" src="./instagram.jpg" alt="instagram site"></a>
					<a class="social-icon" href="instagram"><img class="social-icon" src="./youtube.jpg" alt="youtube site"></a>
					<a style="margin:0;font-size:0.8em;" href="http://www.freepik.com/free-vector/9-social-networking_1080503.htm">Designed by Freepik</a>
				</div>
			</div>
		</footer>
		<!--End footer section-->
	</body>
</html>