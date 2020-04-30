<?
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

        $clinicID = $_POST['clinicID'];
        $healthCardID = $_POST['healthCardID'];
        $scheduledTime = $_POST['scheduledTime'];
        $dentistID = $_POST['dentistID'];

        $insertApptWith = "INSERT INTO AppointmentWith VALUES ($clinicID, '$healthCardID', '$scheduledTime', $dentistID)";
        $result = $conn->query($insertApptWith);

        if ($result) {
            echo "<script>window.location = '" . "Appointmentprofile.php?ClinicID=$clinicID&healthCardID=$healthCardID&scheduledTime=$scheduledTime" . "'</script>";
        }

        else {
            echo "Error: " , $conn->error;
        }