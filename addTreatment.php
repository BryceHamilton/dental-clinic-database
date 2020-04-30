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

        $clinicID = $_GET['clinicID'];
        $healthCardID = $_GET['healthCardID'];
        $scheduledTime = $_GET['scheduledTime'];
        $dentalStaffID = $_POST['dentalStaffID'];
        $type = $_POST['type'];
        $cost = $_POST['cost'];


        $checkAppointment = "SELECT status FROM Appointment WHERE clinicID = $clinicID AND healthCardID = $healthCardID AND scheduledTime = '$scheduledTime' AND (status = 'Completed' OR status = 'Missed')";
        $apptResult = $conn->query($checkAppointment);

        if ($apptResult->num_rows > 0) {
            $row = $apptResult->fetch_assoc();
            $status = $row['status'];
              
            echo "<script>alert('Cannot Add Treatments to Completed or Missed Appointments'); ",
            "window.location = '" . "Appointmentprofile.php?ClinicID=$clinicID&healthCardID=$healthCardID&scheduledTime=$scheduledTime" . "'</script>";


        }

        else {

            $insertTreatment = "INSERT INTO Treatment VALUES ($clinicID, '$healthCardID', '$scheduledTime', $dentalStaffID, '$type', $cost" . ".00)";
            $successToTreatment = $conn->query($insertTreatment);


            if ($successToTreatment) {
                echo "<script>window.location = '" . "Appointmentprofile.php?ClinicID=$clinicID&healthCardID=$healthCardID&scheduledTime=$scheduledTime" . "'</script>";
            }

            else {
                echo "Error: " , $conn->error;
            }
        }




?>