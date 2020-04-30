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
        
        if (isset($_POST['clinicID']) 
          && isset($_POST['clinicName'])
          && isset($_POST['address'])
        ) {
          $clinicID = $_POST['clinicID'];
          $clinicName = "'" . $_POST['clinicName'] ."'";
          $address = "'" . $_POST['address'] ."'";

        
          $addToClinic = "INSERT INTO Clinic VALUES ($clinicID, $address, $clinicName);";

      
          $addedSuccessfully = $conn->query($addToClinic) === TRUE;
          
          if ($addedSuccessfully) {
            echo "<script>window.location = 'Clinics.php'</script>";
            } else {
                echo "Error: " . "<br>" . $conn->error;
            }
        }
        
        }