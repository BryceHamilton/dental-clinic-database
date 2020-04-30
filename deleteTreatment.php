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
        $type = $_GET['type'];

        $deleteTreatment = "DELETE FROM Treatment WHERE clinicID = $clinicID AND healthCardID = '$healthCardID' AND scheduledTime = '$scheduledTime' and type = '$type'";

        $successToTreatment = $conn->query($deleteTreatment);

        if ($successToTreatment) {
            echo "<script>window.location = '" . "Appointmentprofile.php?ClinicID=$clinicID&healthCardID=$healthCardID&scheduledTime=$scheduledTime" . "'</script>";
        }

        else {
            echo "Error: " , $conn->error;
        }


?>