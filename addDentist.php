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
        
        if (isset($_POST['employeeID']) 
          && isset($_POST['firstName'])
          && isset($_POST['lastName'])
          && isset($_POST['address'])
          && isset($_POST['salary'])
          && isset($_POST['speciality'])
          && isset($_POST['certificateNumber'])
          && isset($_POST['startDate']) 
          && isset($_POST['clinicID'])

        ) {
          $employeeID = $_POST['employeeID'];
          $firstName = "'" . $_POST['firstName'] ."'";
          $lastName = "'" . $_POST['lastName'] ."'";
          $address = "'" . $_POST['address'] ."'";
          $salary = $_POST['salary'];
          $certificateNumber = $_POST['certificateNumber'];
          $speiality = "'" . $_POST['speciality'] ."'";
          $startDate = "'" . $_POST['startDate'] ."'";
          $endDate = isset($_POST['endDate']) && $_POST['endDate'] != '' ? "'" . $_POST['endDate'] ."'" : "NULL";
          $clinicID = $_POST['clinicID'];
        
          $addToEmployee = "INSERT INTO Employee(employeeID, firstName, lastName, address, salary, startDate, endDate) VALUES ($employeeID, $firstName, $lastName, $address, $salary, $startDate, $endDate);";
          $addToDentalStaff = "INSERT INTO DentalStaff(dentalStaffID, certification) VALUES ($employeeID, $certificateNumber);";
          $addToDentist = "INSERT INTO Dentist(dentistID, speciality) VALUES ($employeeID, $speiality);";
          $addtoWorksAt = "INSERT INTO WorksAt VALUES ($employeeID, $clinicID)";
      
          $successToEmployee = $conn->query($addToEmployee) === TRUE;
          $successToDentalStaff = $conn->query($addToDentalStaff) === TRUE;
          $successToDentist = $conn->query($addToDentist) === TRUE;
          $successToWorksAt = $conn->query($addtoWorksAt) === TRUE;
          $addedSuccessfully = $successToEmployee && $successToDentalStaff && $successToDentist && $successToWorksAt;
          
          if ($addedSuccessfully) {
            echo "<script>window.location = 'Dentists.php?clinicID=$clinicID'</script>";
            } else {
                echo "Error: " . "<br>" . $conn->error;
            }
        }
        
        }