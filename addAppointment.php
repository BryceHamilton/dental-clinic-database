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
        $scheduledTime = str_replace("T", " ", $scheduledTime) . ":00";
        $note = $_POST['note'];

        $insertAppt = "INSERT INTO Appointment VALUES ($clinicID, '$healthCardID', '$scheduledTime', 'Upcoming', '$note');";

        $successAddAppt = $conn->query($insertAppt);
        
        $successDent = TRUE;
        if (isset($_POST['dentistID'])) {
            $dentistID = $_POST['dentistID'];
            $insertApptWith = "INSERT INTO AppointmentWith VALUES ($clinicID, $healthCardID, '$scheduledTime', $dentistID)";
            $successDent = $conn->query($insertApptWith);
        }

        $success = $successDent && $successAddAppt;
        if ($success) {

            echo "<script>window.location = 'Patientprofile.php?Patient=$healthCardID'</script>";
        }
        else {

            echo "<script>alert('Appointment already exists at this time'); ",
                "window.location = 'Home.php'",
            "</script>";
             
            }