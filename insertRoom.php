<!-- this is a basic sketch of the main page it has none funcionalities, but
it maybe help to start to develop our project -->

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>OrgVenues</title>
	<link rel="stylesheet" href="style.css">
	<!-- <link rel="stylesheet" href="css\style.css" type = "text/css"/> -->
</head>

<body>

	<!-- Starts header-->
	<!-- logo area -->
	<div id="logo"><img id="logo-img" src="pics/icon2.png" alt="Logo"/> <h1 class="label" id="title">OrgVenue</h1></div>
	<!-- ends logo area -->
	<!-- user area -->
	<div id="user"><img class="icon" src="pics/avatar.png" alt="avatar"/><span class="label">User</span></div>
	<!-- ends of user area -->
	<!-- ads area -->
	<div id="ad-space"><span>Ads here</span></div>
	<!-- ends of ads area -->
	<!--ends header-->

	<!-- starts main container -->
	<!--starts sidebar-->
	<div class="sidebar" id="sidebar">
		<!-- start bar of menu -->
		<div id="sidemenu">
			<!--none of the menu button work -->
			<ul>
				<li><a href="index.php" >Home</a></li>
				<li><a href="/project/venueproject/search.php">Search</a></li>
				<li><a href="/project/venueproject/insert.php">Booking Insert/Delete</a></li>
				<li><a href="/project/venueproject/insertPlace.php">Insert Place</a></li>
				<li><a href="/project/venueproject/insertRoom.php"class="active">Insert Room</a></li>
				<li><a href="/project/venueproject/agent.php">Agents</a></li>

			</ul>
		</div>
		<!-- ends bar of menu -->
		<!-- ends side list -->
	</div>
	<!-- ends Sidebar -->

	<!-- starts map container -->
		<!-- I have not figure out how we will make this MAP. I need to do more research -->
	<div id="map-container">
		<?php
			if(isset($_POST['inserttb'])){ //things to do, once the "submit" key is hit
				$servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
				$username = "root";// mysql username
				$password = "";// sql password
				$dbname  = "orgvenue";// database name
				$temp;
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				$cname = $conn->real_escape_string( $_POST['RNametb'] );
				$cdescrip = $conn->real_escape_string( $_POST['Rdescriptb'] );
				$cfloor = $conn->real_escape_string( $_POST['Rfloortb'] );
				$cplaceid = $conn->real_escape_string( $_POST['Rplaceidtb'] );

				if (empty($cname) or empty($cdescrip) or empty($cfloor) or empty($cplaceid) ) {

					echo "<span class='error'>*Something is missed. Make sure to file up all the files before insert</span>";
				}else {

					$sql5= "SELECT * FROM places";
					$result5 = $conn->query($sql5);
					while($row = $result5->fetch_assoc()) {
					if ($row['name']== $cplaceid) {
					$temp=$row['placeID'];
					}
					}
					if (!empty($temp)) {
						$stmt = $conn->prepare( "INSERT INTO rooms ( floor,roonName,roomDescription,placeID) VALUES ( ?, ?,?, ?)");
						$stmt->bind_param("issi", $cfloor, $cname, $cdescrip,$temp);
						$stmt->execute();
						if($stmt )
						{
							echo "room inserted properly";
						}
						$stmt->close();
					}else {

						echo"<span class='error'>*wrong Place try again with a correct one</span>";

					}

			}
		}


			if(isset($_POST['deletetb'])){
				$servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
				$username = "root";// mysql username
				$password = "";// sql password
				$dbname  = "orgvenue";// database name

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				$cname = $conn->real_escape_string( $_POST['RNametb'] );

				if (empty($cname) ) {

					echo "<span class='error'>*Something is missed. Make sure to file up name file before deleting</span>";
				}else {
				$sql3= "SELECT * FROM rooms";
				$result3 = $conn->query($sql3);
				while($row = $result3->fetch_assoc()) {
		  if ($row['roonName']== $cname) {
			$temp1=$row['roomID'];

		  }

		}

		echo $temp1;
				$stmt = $conn->prepare("DELETE FROM rooms WHERE (roomID=?)");
				$stmt->bind_param("i", $temp1);
				$stmt->execute();
				if($stmt )
				{
					echo "room Deleted properly";
				}
				$stmt->close();
			}

			}


	?>





		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<style media="screen">
			.heighttext{

				display:inline-block;
				padding:15px 10px;
				line-height:1%;
				width:100%;
			}
			.error{ color: #FF0000;}
			</style>

					<!-- Room info form -->
				   <label for="roomservices"> Room and Services Info </label><br>
				  <input class="heighttext" type="text" id="cinfo" name="RNametb" placeholder="Room Name">
				  <input class="heighttext" type="text" id="cinfo" name="Rdescriptb" placeholder="Room Description">
				  <input class="heighttext" type="text" id="cinfo" name="Rfloortb" placeholder="Room Foolr">

				  <!-- Place info form -->
				   <label for="roomservices"> Place Info </label><br>
						  <?php
	 				   $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
	 				   $username = "root";// mysql username
	 				   $password = "";// sql password
	 				   $dbname  = "orgvenue";// database name
	 				   // Create connection
	 				   $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
					   echo "<input class= 'heighttext' type='search' list='Rinlist' name='Rplaceidtb' />";
					   echo "<datalist id='Rinlist'>";
					   $sql = "SELECT * FROM places";
	 				   $Result = $conn->query($sql);
					   foreach ($Result as $row) {
						   echo  "<option>$row[name]</option>";
					   }
					   echo "</datalist>";

	 				   ?>
				  <!-- insert button -->
				  <input type ="submit" value="Insert" name="inserttb"/>
				  	<!-- delete button -->
				  <input type ="submit" value="Delete" name="deletetb"/>
				  	<!-- modify button -->
				</form>
	</div>
	<!-- end of mapcontainer -->

	<!-- starts of top 5 container -->
	<div class="sidebar right" id="top5-container">
		<a class="list-header" href="#">Top 5 Events</a>
		<!-- this part is really bad disgned in the future we will need to create and an app
		that collect data fron user then create the top 5 -->
		<ul class="scrollable">
			<?php
			$servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
			$username = "root";// mysql username
			$password = "";// sql password
			$dbname  = "orgvenue";// database name
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
			$result = $conn->query("SELECT * FROM booking ORDER BY bookingID DESC LIMIT 5");
			foreach($result as $row) {
				echo "<li class='top5'>";
				echo "<div class='event-description'>";
				echo "<img class='thumbnail' src='pics/icon1.png' alt='Logo'>";
				echo "<span class='artname'>Event</span>";
				echo "date From: ".$row['dateFrom']."<br>";
				echo "date To: ".$row['dateTo']."<br>";
				$sql3= "SELECT * FROM clients";
				$result3 = $conn->query($sql3);
				while($row2 = $result3->fetch_assoc()) {
		  if ($row2['clientID']==$row['clientID']) {
			$tempn=$row2['name'];
		  }
		}
				echo "Client : ". $tempn."<br>";
				echo "</div>";
				echo "</li>";
			}
			 ?>

		</ul>
	</div>
	<!-- ends of top 5 container -->
	<!-- ends main container -->

</body>
</html>
