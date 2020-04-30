<?php
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
        
        if (isset($_POST['clinicID']) 
          && isset($_POST['clinicName'])
          && isset($_POST['address'])

        ) {
          $clinicID = $_POST['clinicID'];
          $clinicName = "'" . $_POST['clinicName'] ."'";
          $address = "'" . $_POST['address'] ."'";
          

          $editEmployee = "UPDATE Clinic SET clinicID = $clinicID, clinicName = $clinicName, address = $address WHERE clinicID = $clinicID;";
        
          $successToEmployee = $conn->query($editEmployee) === TRUE;


          if ($successToEmployee) {
              echo "<script>window.location = 'ClinicProfile.php?clinicID=$clinicID' </script>";
          }

          else {
            echo "Error: " . "<br>" . $conn->error;
          }
        }

        echo "Something not set";
    }
?>