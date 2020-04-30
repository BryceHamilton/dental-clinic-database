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
          && isset($_POST['certification'])
          && isset($_POST['startDate']) 
        //   && isset($_POST['clinicID'])

        ) {
          $employeeID = $_POST['employeeID'];
          $firstName = "'" . $_POST['firstName'] ."'";
          $lastName = "'" . $_POST['lastName'] ."'";
          $address = "'" . $_POST['address'] ."'";
          $salary = $_POST['salary'];
          $certification = $_POST['certification'];
          $startDate = "'" . $_POST['startDate'] ."'";
          $endDate = isset($_POST['endDate']) && $_POST['endDate'] != '' ? "'" . $_POST['endDate'] ."'" : "NULL";
          

          $editEmployee = "UPDATE Employee SET employeeID = $employeeID, firstName = $firstName, lastName = $lastName, address = $address, salary = $salary, startDate = $startDate, endDate = $endDate WHERE employeeID = $employeeID;";
          $editDentalStaff = "UPDATE DentalStaff SET certification = $certification WHERE dentalStaffID = $employeeID;";
        
          $successToEmployee = $conn->query($editEmployee) === TRUE;
          $successToDentalStaff = $conn->query($editDentalStaff) === TRUE;
        
          $success = $successToEmployee && $successToDentalStaff;
          
          if (isset($_POST['clinicID'])) {
            $clinicID = $_POST['clinicID'];
            $editWorksAt = "UPDATE WorksAt SET clinicID = $clinicID WHERE employeeID = $employeeID";
            $successWorksAt = $conn->query($editWorksAt);
            $success = $success && $successWorksAt;
          }

          if (isset($_POST['supervisorID'])) {
            $supervisorID = $_POST['supervisorID'];

            $checkIfPresent = "SELECT * FROM Supervision WHERE supervisedID = $employeeID";
            $result = $conn->query($checkIfPresent);


            if ($supervisorID == "None") {
              $query = "DELETE FROM Supervision WHERE supervisedID = $employeeID";
            }
            elseif ($result->num_rows > 0) {
              $supervisorID = $_POST['supervisorID'];
             
              $query = "UPDATE Supervision SET supervisorID = $supervisorID WHERE supervisedID = $employeeID";
            }

            else {
              $query = "INSERT INTO Supervision VALUES ($employeeID, $supervisorID)";
            }

            $successSuper  = $conn->query($query);
            $success = $success && $successSuper;
          }

          if ($success) {
              echo "<script>window.location = 'AssistantProfile.php?assistantID=$employeeID' </script>";
          }

          else {
            echo "Error: " . "<br>" . $conn->error;
          }
        }

        echo "Something not set";
    }
?>