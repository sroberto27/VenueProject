<!--
This file is used to edit the records in table persons. You do not need to run this by yourself.
This is called by the editrecord.php.
-->

<?php
		if (!empty($_GET['PerID'])){
global $pid = $_GET['PerID']; //the value of pid is received from the editrecord.php page
}
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
