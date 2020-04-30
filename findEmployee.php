<?php

if (isset($_GET['employeeID'])){
    $employeeID = $_GET['employeeID'];

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
        
        $dentistQuery = "SELECT dentistID FROM Dentist WHERE dentistID = $employeeID";
        $dentistResult = $conn->query($dentistQuery);

        if ($dentistResult->num_rows > 0) {
            echo "<script>window.location = 'DentistProfile.php?dentistID=$employeeID'</script>";
        }

        $assistantQuery = "SELECT assistantID FROM DentistAssistant WHERE assistantID = $employeeID";
        $assistantResult = $conn->query($assistantQuery);

        if ($assistantResult->num_rows > 0) {
            echo "<script>window.location = 'AssistantProfile.php?assistantID=$employeeID'</script>";
        }

        $receptionistQuery = "SELECT receptionistID FROM Receptionist WHERE receptionistID = $employeeID";
        $receptionistResult = $conn->query($receptionistQuery);

        if ($receptionistResult->num_rows > 0) {
            echo "<script>window.location = 'ReceptionistProfile.php?receptionistID=$employeeID'</script>";
        }

        

}

else {
    echo "<script>window.location = 'Employees.php'</script>";
}
?>