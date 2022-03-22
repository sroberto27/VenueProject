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
	<?php
	global $pid ;
	global $pidTemp ;
	if (!empty($_GET['PerID'])){
$pid = $_GET['PerID']; //the value of pid is received from the editrecord.php page
$pidTemp=$pid;
}
?>
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
		global $pid;
		    if(isset($_POST['modifytb'])){ //things to do, once the "submit" key is hit
		        $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
		        $username = "root";// mysql username
		        $password = "";// sql password
		        $dbname  = "orgvenue";// database name

		        // Create connection
		        $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);

		        $descrip = $conn->real_escape_string( $_POST['BDescriptb'] );
		        $aid= $conn->real_escape_string( $_POST['Aidtb'] );
		        $rid= $conn->real_escape_string( $_POST['Ridtb'] );
		        $dfrom= $conn->real_escape_string( $_POST['Dfromtb'] );
		        $dto= $conn->real_escape_string( $_POST['Dtotb'] );
		        if (empty($descrip) or empty($aid) or empty($rid) or empty($dfrom) or empty($dto)  ) {

		            echo "<span class='error'>*Something is missed. Make sure to file up all the files before insert</span>";

		        }else {
		            $sql5= "SELECT * FROM rooms";
		            $result5 = $conn->query($sql5);
		            while($row = $result5->fetch_assoc()) {
		            if ($row['roonName']== $rid) {
		            $temp3=$row['roomID'];
		            }
		            }
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

		$sql6= "SELECT * FROM agents";
		$result6 = $conn->query($sql6);
		while($row = $result6->fetch_assoc()) {
		if ($row['name']== $aid) {
		$temp4=$row['agentID'];
		}
		}
		echo "datefrom".$dfrom."date to" .$dto.  "agent id ".$temp4." roomidc" .$temp3." end";
		    //$pid = $_GET['PerID'];

		$s= "SELECT * FROM booking WHERE bookingID='$pid'";
		$res = $conn->query($s);
		$ro = $res -> fetch_row();
		echo "pidd::::";
		echo $pid;
		echo "estatus";
		echo $ro[5] ;
		$sq= "SELECT * FROM bookingstatus WHERE statusID='$ro[5]'";
		$re = $conn->query($sq);
		$row22 = $re -> fetch_row();
		echo "string::::";
		echo $pid;
		        $sql7 = "UPDATE booking SET dateFrom='$_POST[Dfromtb]', dateTo='$_POST[Dtotb]',agentID='$_POST[Aidtb]',roomID='$_POST[Ridtb]' WHERE bookingID='$pid'";//embed insert statement in PHP
		        $result7 = $conn->query($sql7);
		        $sql8 = "UPDATE bookingstatus SET description='$_POST[BDescriptb]' WHERE statusID='$row22[0]'";//embed insert statement in PHP
		        $result8 = $conn->query($sql8);

		        if($result7 AND $result8) //if the update is done successfully
		            {
		            echo "Records updated successfully";
		            }

		    }
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
					<?php
				 $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
				 $username = "root";// mysql username
				 $password = "";// sql password
				 $dbname  = "orgvenue";// database name
				 // Create connection
				 $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				//  if (!empty($_GET['PerID'])){
		 		// 	$pid = $_GET['PerID'];
		 		// }
				 $sql5= "SELECT * FROM booking WHERE bookingID='$pidTemp'";
				 echo "dddddddd";
				 echo $pid;
				 $result5 = $conn->query($sql5);
				 $row = $result5 -> fetch_row();
				 $sql6= "SELECT * FROM clients WHERE clientID='$row[3]'";
				 $result6 = $conn->query($sql6);
				 $row2 = $result6 -> fetch_row();
					echo 	' <label for="cinfo"> Client Info </label><br>';
	   				 echo' <input disabled class="heighttext" type="text" id="cinfo" name="CNametb" placeholder="'.$row2[1].'">';
	   				 echo '<input disabled class="heighttext" type="text" id="cinfo" name="Caddrtb" placeholder="'.$row2[2].'">';
	   				 echo '<input disabled class="heighttext" type="text" id="cinfo" name="CPhtb" placeholder="'.$row2[3].'">';
	   				 echo '<input disabled class="heighttext" type="text" id="cinfo" name="CEmtb" placeholder="'.$row2[4].'"><br><br>';



				 ?>

					<!-- room info form -->
		      <label for="roomservices"> Room and Services Info </label><br>
					  <?php
 				   $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
 				   $username = "root";// mysql username
 				   $password = "";// sql password
 				   $dbname  = "orgvenue";// database name
 				   // Create connection
 				   $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				   $sql5= "SELECT * FROM booking WHERE bookingID='$pid'";
  				 $result5 = $conn->query($sql5);
  				 $row1 = $result5 -> fetch_row();
  				 $sql6= "SELECT * FROM rooms WHERE roomID='$row1[6]'";
  				 $result6 = $conn->query($sql6);
				 $row2 = $result6 -> fetch_row();
				 echo "Room : ".$row2[2];
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
			  $sql5= "SELECT * FROM booking WHERE bookingID='$pid'";
			$result5 = $conn->query($sql5);
			$row1 = $result5 -> fetch_row();
			$sql6= "SELECT * FROM agents WHERE agentID='$row1[4]'";
			$result6 = $conn->query($sql6);
			$row2 = $result6 -> fetch_row();
			echo "Agent : ".$row2[1];
			  echo "<input class= 'heighttext' type='search' list='Alist' name='Aidtb' />";
			  echo "<datalist id='Alist'>";
			  $sql = "SELECT * FROM agents";
			  $Result = $conn->query($sql);
			  foreach ($Result as $row) {
				  echo  "<option>$row[agentName]</option>";
			  }
			  echo "</datalist>";

			  ?>

					<!-- description form -->
				  <label for="description"> Description </label><br>
				  <?php
			   $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
			   $username = "root";// mysql username
			   $password = "";// sql password
			   $dbname  = "orgvenue";// database name
			   // Create connection
			   $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
			  //  if (!empty($_GET['PerID'])){
				//   $pid = $_GET['PerID'];
			  // }
			   $sql5= "SELECT * FROM booking WHERE bookingID='$pid'";
			   $result5 = $conn->query($sql5);
			   $row = $result5 -> fetch_row();
			   $sql6= "SELECT * FROM bookingstatus WHERE statusID='$row[5]'";
			   $result6 = $conn->query($sql6);
			   $row2 = $result6 -> fetch_row();
				  echo 	'<input class="heighttext" type="text" id="description" name="BDescriptb" placeholder="'.$row2[1].'"><br><br>';

			   ?>


					<!-- Date information form -->

				  <label for="dTime"> Date Info </label><br>
				  <label for="dTime"> Date From </label><br>
				  <?php
				 $servername = "localhost";// sql server machine name/IP (if your computer is the server too, then just keep it as "localhost").
				 $username = "root";// mysql username
				 $password = "";// sql password
				 $dbname  = "orgvenue";// database name
				 // Create connection
				 $conn = new mysqli($servername, $username, $password, $dbname) or die("Connect failed: %s\n". $conn -> error);
				//  if (!empty($_GET['PerID'])){
				// 	$pid = $_GET['PerID'];
				// }
				 $sql5= "SELECT * FROM booking WHERE bookingID='$pid'";
				 $result5 = $conn->query($sql5);
				 $row = $result5 -> fetch_row();
				echo' <input class=""  type="date" id="dtime" name="Dfromtb" value="'.$row[1].'"><br>';
				echo'<label for="dTime"> Date To </label><br>';
				echo'<input class=""  type="date" id="dtime" name="Dtotb" value="'.$row[2].'" ><br><br>';
				// echo '<a type="submit" href="edit.php?PerID='.$pid.'">Modify </a></';
			 ?>

				  <!-- modify button -->
				  <input type ="submit" value="Modify" name="modifytb"/>

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
