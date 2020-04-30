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

		else {
        
        if (isset($_POST['healthCardID']) 
          && isset($_POST['firstName'])
          && isset($_POST['lastName'])
          && isset($_POST['address'])
        ) {
          $healthCardID = $_POST['healthCardID'];
          $firstName = "'" . $_POST['firstName'] ."'";
          $lastName = "'" . $_POST['lastName'] ."'";
          $address = "'" . $_POST['address'] ."'";

        
          $addToPatient = "INSERT INTO Patient(healthCardID, firstName, lastName, address) VALUES ($healthCardID, $firstName, $lastName, $address);";

      
          $addedSuccessfully = $conn->query($addToPatient) === TRUE;
          
          if ($addedSuccessfully) {
            echo "<script>window.location = 'Patients.php'</script>";
            } else {
                echo "Error: " . "<br>" . $conn->error;
            }
        }
        
        }