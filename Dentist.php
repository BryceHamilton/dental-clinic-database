<!DOCTYPE html>

<head>
    <title>DB Kings</title>
    <link rel='stylesheet' type='text/css' href='dentist.css' />
</head>

<body>
    <?

		function displayProile($dentistRow, $clinicID) {
      echo "<div>". $dentistRow['employeeID'] . "</div>",
        "<div>" . $dentistRow['firstName'] . " " . $dentistRow['lastName'] . "</div>" ,
        "<div>" . $dentistRow['address'] . "</div>" ,
        "<div>" . $dentistRow['salary'] . "</div>" ,
        "<div>" . $dentistRow['startDate'] . "</div>" ,
        "<div>" . $dentistRow['endDate'] . "</div>" ,
        "<div>" . $dentistRow['speciality'] . "</div>",
        "<div> Clinic ID: $clinicID </div>";
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

		 	
		if (isset($_GET['employeeID'])) {  
			  
        $dentistQuery = "SELECT dentistID as employeeID, firstName, lastName, address, salary, startDate, endDate, speciality FROM Employee E INNER JOIN Dentist D ON E.employeeID = D.dentistID WHERE E.employeeID = " . $_GET["employeeID"] . ";";           
        $dentistResult = $conn->query($dentistQuery);

        if ($dentistRow = $dentistResult->fetch_assoc()) {
          $clinicQuery = "SELECT clinicID FROM WorksAt WHERE WorksAt.employeeID = " . $_GET['employeeID'] . ";"; 
          $clinicResult = $conn->query($clinicQuery);
          $clinicRow = $clinicResult->fetch_assoc();
          displayProile($dentistRow, $clinicRow['clinicID']);
        }
        
        $appointmentsQuery = "SELECT healthCardID, scheduledTime, status, note FROM Appointment NATURAL JOIN AppointmentWith AppW WHERE AppW.dentistID = " . $_GET['employeeID'] ." ";
                
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
        echo "<script>window.location = 'dentists.php'</script>";
        $conn->close();
        exit();
    }
    }
    $conn->close();
            ?>


</body>