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
          && isset($_POST['speciality'])
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
          $speciality = "'" . $_POST['speciality'] ."'";
          $startDate = "'" . $_POST['startDate'] ."'";
          $endDate = isset($_POST['endDate']) && $_POST['endDate'] != '' ? "'" . $_POST['endDate'] ."'" : "NULL";
          


          $editEmployee = "UPDATE Employee SET employeeID = $employeeID, firstName = $firstName, lastName = $lastName, address = $address, salary = $salary, startDate = $startDate, endDate = $endDate WHERE employeeID = $employeeID;";
          $editDentalStaff = "UPDATE DentalStaff SET certification = $certification WHERE dentalStaffID = $employeeID;";
          $editDentist = "UPDATE Dentist SET speciality = $speciality WHERE dentistID = $employeeID;";
        
          $successToEmployee = $conn->query($editEmployee) === TRUE;
          $successToDentalStaff = $conn->query($editDentalStaff) === TRUE;
          $successToDentist = $conn->query($editDentist) === TRUE;
        
          $success = $successToEmployee && $successToDentalStaff && $successToDentist;

          if (isset($_POST['clinicID'])) {
            $clinicID = $_POST['clinicID'];
            $editWorksAt = "UPDATE WorksAt SET clinicID = $clinicID WHERE employeeID = $employeeID";
            $successWorksAt = $conn->query($editWorksAt);
            $success = $success && $successWorksAt;
          }

          if ($success) {
              echo "<script>window.location = 'DentistProfile.php?dentistID=$employeeID' </script>";
          }

          else {
            echo "Error: " . "<br>" . $conn->error;
            echo $editDentist;
          }
        }

        echo "Something not set";
    }
?>