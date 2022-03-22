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
				<li><a href="/project/venueproject/insert.php"class="active">Booking Insert/Delete</a></li>
				<li><a href="/project/venueproject/insertPlace.php">Insert Place</a></li>
				<li><a href="/project/venueproject/insertRoom.php">Insert Room</a></li>
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

			if(isset( $_POST['inserttb'])){ //things to do, once the "submit" key is hit
				$servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
				$username = "root";// mysql username
				$password = "";// sql password
				$dbname  = "orgvenue";// database name
				$temp4;
				 $temp3;
				  $temp1;
				   $temp2;
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				$cname = $conn->real_escape_string( $_POST['CNametb'] );
				$caddress = $conn->real_escape_string( $_POST['Caddrtb'] );
				$cphone = $conn->real_escape_string( $_POST['CPhtb'] );
				$cemail = $conn->real_escape_string( $_POST['CEmtb'] );
				$descrip = $conn->real_escape_string( $_POST['BDescriptb'] );
				$aid= $conn->real_escape_string( $_POST['Aidtb'] );
				$rid= $conn->real_escape_string( $_POST['Ridtb'] );
				$dfrom= $conn->real_escape_string( $_POST['Dfromtb'] );
				$dto= $conn->real_escape_string( $_POST['Dtotb'] );
				if (empty($cname) or empty($caddress) or empty($cphone) or empty($cemail) or empty($descrip) or empty($aid) or empty($rid) or empty($dfrom) or empty($dto)  ) {

					echo "<span class='error'>*Something is missed. Make sure to file up all the files before insert</span>";
				}else {
					$sql5= "SELECT * FROM rooms";
					$result5 = $conn->query($sql5);
					while($row = $result5->fetch_assoc()) {
					if ($row['roonName']== $rid) {
					$temp3=$row['roomID'];
					}
					}
					if (!empty($temp3)) {
						$sql0 = "SELECT FROM booking WHERE (dateFrom='$dfrom' AND dateTo= '$dto'AND roomID= '$temp3')";//embed insert statement in PHP
						$result0 = $conn->query($sql0);
						$sqlC = "SELECT COUNT(*) FROM booking";//embed insert statement in PHP
						$resultC= $conn->query($sqlC);
					if ($dfrom>$dto OR ( $dfrom<=date("Y-m-d")AND $dto<=date("Y-m-d"))) {
						echo "<span class='error'>*Date From must be greater or equal to date To and older then today </span>";
					}else
					if ($result0 AND $resultC!=0) {
						echo "<span class='error'>*Dates and room are already booked try a different room or diferent dates</span>";
					}else {


				$stmt = $conn->prepare( "INSERT INTO clients ( name,address,phone,email) VALUES ( ?, ?, ?,?)");
				$stmt->bind_param("ssss", $cname, $caddress, $cphone,$cemail);
				$stmt->execute();
				$stmt->close();

					$stmt = $conn->prepare( "INSERT INTO bookingstatus ( description) VALUES (?)");
					$stmt->bind_param("s", $descrip);
					$stmt->execute();
					$stmt->close();



				$sql3= "SELECT * FROM clients";
				$result3 = $conn->query($sql3);
				while($row = $result3->fetch_assoc()) {
		  if ($row['email']== $cemail) {
			$temp1=$row['clientID'];
		  }
		}
				$sql4= "SELECT * FROM bookingstatus";
				$result4 = $conn->query($sql4);
				while($row = $result4->fetch_assoc()) {
		  if ($row['description']== $descrip) {
			$temp2=$row['statusID'];
		  }
		}

		$sql6= "SELECT * FROM agents";
		$result6 = $conn->query($sql6);
		while($row = $result6->fetch_assoc()) {
		if ($row['name']== $aid) {
		$temp4=$row['agentID'];
		}
		}
		if (!empty($temp4) AND !empty($temp3) AND !empty($temp1) AND !empty($temp2)) {
			echo "datefrom".$dfrom."date to" .$dto. " ic client".$temp1. "agent id ".$temp4." statusid " .$temp2." roomidc" .$temp3." end";
			$stmt = $conn->prepare( "INSERT INTO booking ( dateFrom,dateTo,clientID,agentID,statusID,roomID) VALUES ( ?, ?, ?,?,?,?)");
			$stmt->bind_param("ssssss", $dfrom, $dto, $temp1, $temp4,$temp2,$temp3);
			$stmt->execute();
			if($stmt )
			{
				echo "booked properly";
			}
			$stmt->close();
		}else {

			if (!empty($temp4)) {
			echo"<span class='error'>*wrong description try again with a correct one</span>";
			}
			if (!empty($temp2)) {
			echo"<span class='error'>*wrong agent try again with a correct one</span>";
			}
			if (!empty($temp1)) {
			echo"<span class='error'>*wrong client try again with a correct one</span>";
			}

		}


			}
		}else {
			echo"<span class='error'>*wrong room try again with a correct one</span>";
		}
		}
			}

			if(isset( $_POST['deletetb'])){
				$servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
				$username = "root";// mysql username
				$password = "";// sql password
				$dbname  = "orgvenue";// database name

				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				$cname = $conn->real_escape_string( $_POST['CNametb'] );
				$cemail = $conn->real_escape_string( $_POST['CEmtb'] );
				$rid= $conn->real_escape_string( $_POST['Ridtb'] );
				$dfrom= $conn->real_escape_string( $_POST['Dfromtb'] );
				$dto= $conn->real_escape_string( $_POST['Dtotb'] );
				if (empty($cname) or empty($cemail)or empty($rid) or empty($dfrom) or empty($dto)  ) {

					echo "<span class='error'>*To delete you must fill the name, email, room, and both  dates files</span>";
				}else {
				$sql3= "SELECT * FROM clients";
				$result3 = $conn->query($sql3);
				while($row = $result3->fetch_assoc()) {
		  if ($row['email']== $cemail) {
			$temp1=$row['clientID'];

		  }

		}
		$sql4= "SELECT * FROM rooms";
		$result4 = $conn->query($sql4);
		while($row = $result4->fetch_assoc()) {
  if ($row['roonName']== $rid) {
	$temp2=$row['roomID'];

  }

}
		echo $temp1;
		echo $dfrom;
		echo $dto;

				$stmt = $conn->prepare("DELETE FROM booking WHERE (clientID=? AND dateFrom=? AND dateTo=? AND roomID=? )");
				$stmt->bind_param("issi", $temp1,$dfrom,$dto,$temp2);
				$stmt->execute();
				if($stmt )
				{
					echo "booking Deleted properly";
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

					<!-- client info form -->
				  <label for="cinfo"> Client Info </label><br>
				  <input class="heighttext" type="text" id="cinfo" name="CNametb" placeholder="Name">
				  <input class="heighttext" type="text" id="cinfo" name="Caddrtb" placeholder="Address">
				  <input class="heighttext" type="text" id="cinfo" name="CPhtb" placeholder="Phone">
				  <input class="heighttext" type="text" id="cinfo" name="CEmtb" placeholder="Email"><br><br>


					<!-- room info form -->
		      <label for="roomservices"> Room and Services Info </label><br>
					  <?php
 				   $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
 				   $username = "root";// mysql username
 				   $password = "";// sql password
 				   $dbname  = "orgvenue";// database name
 				   // Create connection
 				   $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				   echo "<input class= 'heighttext' type='search' list='Rlist' name='Ridtb' />";
				   echo "<datalist id='Rlist'>";
				   $sql = "SELECT * FROM rooms";
 				   $Result = $conn->query($sql);
				   foreach ($Result as $row) {
					   echo  "<option>$row[roonName]</option>";
				   }
				   echo "</datalist>";

 				   ?>
				<label for="roomservices"> Agent Info </label><br>
				 <?php
			  $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
			  $username = "root";// mysql username
			  $password = "";// sql password
			  $dbname  = "orgvenue";// database name

			  // Create connection
			  $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
			  echo "<input class= 'heighttext' type='search' list='Alist' name='Aidtb' />";
			  echo "<datalist id='Alist'>";
			  $sql2 = "SELECT * FROM agents";
			  $Result2 = $conn->query($sql2);
			  foreach ($Result2 as $row2) {
				  echo  "<option>$row2[agentName]</option>";
			  }
			  echo "</datalist>";

			  ?>

					<!-- description form -->
				  <label for="description"> Description </label><br>
				  <input class="heighttext" type="text" id="description" name="BDescriptb" placeholder="description:"><br><br>

					<!-- Date information form -->
				  <label for="dTime"> Date From </label><br>
				  <input  type="date" id="dtime" name="Dfromtb" ><br>
				   <label for="dTime"> Date To </label><br>
				  <input  type="date" id="dtime" name="Dtotb"  ><br><br>
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
