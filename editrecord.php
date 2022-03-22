<!--
This file is used to display the records from database
Copy this file in C://xampp/htdocs/ and open a browser and run http://localhost/editrecord.php
Before that you should turn on MySQL database server as well as Apache web server.
-->
<?php

$servername = "localhost";// sql server name
$username = "root";// sql username
$password = "";// sql password
$dbname  = "db1";// database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM persons";// embed a select statement in php
$result = $conn->query($sql);// get result

if($result->num_rows > 0){// check for number of rows. If there are records, build a table to show them
 echo "<table style='border: solid 1px black;'>
	<tr style='border: solid 1px black;'>
	    <th style='border: solid 1px black;'>PersonID</th>
	    <th style='border: solid 1px black;'>LastName</th>
	    <th style='border: solid 1px black;'>FirstName</th>
	    <th style='border: solid 1px black;'>City</th>
	    <th style='border: solid 1px black;'>Edit</th>
	</tr>";
}

while ($row = $result -> fetch_assoc()){// Fetch the query result and store them in an array
	echo '<tr style="border: solid 1px black;">
		<td style="border: solid 1px black;">'.$row['PersonID'].'</td>
		<td style="border: solid 1px black;">'.$row['LastName'].'</td>
		<td style="border: solid 1px black;">'.$row['FirstName'].'</td>
		<td style="border: solid 1px black;">'.$row['City'].'</td>

<!-- the core edit operation is done in edit.php. Here, we create only a hyperlink and send parameters to edit.php -->
<!--For each row of the table, we create a hyperlink and include the parameter PerID to be used it in the destination page (edit.php)-->
		<td style="border: solid 1px black;"> <a href="edit.php?PerID='.$row['PersonID'].'">Click </a></td>
		</tr>';
}

echo "</table>";
?>
