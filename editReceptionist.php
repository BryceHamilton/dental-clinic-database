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
        
        if (isset($_POST['employeeID']) 
          && isset($_POST['firstName'])
          && isset($_POST['lastName'])
          && isset($_POST['address'])
          && isset($_POST['salary'])
          && isset($_POST['startDate']) 
        //   && isset($_POST['clinicID'])

        ) {
          $employeeID = $_POST['employeeID'];
          $firstName = "'" . $_POST['firstName'] ."'";
          $lastName = "'" . $_POST['lastName'] ."'";
          $address = "'" . $_POST['address'] ."'";
          $salary = $_POST['salary'];
          $startDate = "'" . $_POST['startDate'] ."'";
          $endDate = isset($_POST['endDate']) && $_POST['endDate'] != '' ? "'" . $_POST['endDate'] ."'" : "NULL";
          
        //   $clinicID = $_POST['clinicID'];

          $editEmployee = "UPDATE Employee SET employeeID = $employeeID, firstName = $firstName, lastName = $lastName, address = $address, salary = $salary, startDate = $startDate, endDate = $endDate WHERE employeeID = $employeeID;";
        
          $successToEmployee = $conn->query($editEmployee) === TRUE;

          if (isset($_POST['clinicID'])) {
            $clinicID = $_POST['clinicID'];
            $editWorksAt = "UPDATE WorksAt SET clinicID = $clinicID WHERE employeeID = $employeeID";
            $successWorksAt = $conn->query($editWorksAt);
            $success = $success && $successWorksAt;
          }
          if ($successToEmployee) {
              echo "<script>window.location = 'ReceptionistProfile.php?receptionistID=$employeeID' </script>";
          }

          else {
            echo "Error: " . "<br>" . $conn->error;
          }
        }

        echo "Something not set";
    }
?>