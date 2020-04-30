<!DOCTYPE html>

<head>
    <title>DB Kings</title>
    <link rel='stylesheet' type='text/css' href='dentist.css' />
</head>

<body>
    <?php

function displayClinicProfile($clinicRow) {
  echo "<div> Clinic ID: " . $clinicRow['clinicID'] . "</div>",
  "<div> Address: " . $clinicRow['address'] . "</div>",
  "<div> Clinic Name: " . $clinicRow['clinicName'] .  "</div>";
}

function displayApptHeaders() {
    echo "<table>",
          "<tr class='row'>",
            "<th class='cell head'>Patient ID</th>",
            "<th class='cell head'>Scheduled Time</th>",
            "<th class='cell head'>Status</th>",
            "<th class='cell head'>Note</th>",
      "</tr>";
  }

function displayApptRow($row) {
  echo "<tr class='row')>",
  "<td class='cell'>" . $row['healthCardID'] . "</td>",
  "<td class='cell'>" . $row['scheduledTime'] . "</td>",
  "<td class='cell'>" . $row['status'] . "</td>",
  "<td class='cell'>" . $row['note'] . "</td></tr>";
}  

/* Connect to DB */
$servername = "vuc353.encs.concordia.ca";
$username = "vuc353_4";
$password = "4DBKings";
$dbname = "vuc353_4";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

else {
    if (isset($_GET['clinicID'])) {
        $clinicQuery = "SELECT * from Clinic WHERE Clinic.clinicID = " . $_GET['clinicID'] . ";";           
        $clinicResult = $conn->query($clinicQuery);

        if($clinicRow = $clinicResult->fetch_assoc()) {
           displayClinicProfile($clinicRow);
        }

        $appointmentsQuery = "SELECT healthCardID, scheduledTime, status, note FROM Appointment App WHERE App.clinicID = " . $_GET['clinicID'] ." ";
        $result = $conn->query($appointmentsQuery);
        if ($result->num_rows > 0) {
          displayApptHeaders();

          while($row = $result->fetch_assoc()) {
            displayApptRow($row);
		  }
			
          echo "</table>";
        }
		else {
			echo "No Appointments during this time";
        }
        
        
        
    }

    else {
        echo "<script>window.location = 'clinics.php'</script>";
        $conn->close();
        exit();
    }
}

?>