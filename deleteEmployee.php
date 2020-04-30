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


            if (isset($_POST['employeeID'])) {
				$employeeID = $_POST['employeeID'];
				
				$deleteQuery = "DELETE FROM WorksAt WHERE employeeID = $employeeID";
				$deleteResult = $conn->query($deleteQuery);

				$deleteQuery = "DELETE FROM Supervision WHERE supervisedID = $employeeID OR supervisorID = $employeeID";
				$deleteResult = $conn->query($deleteQuery);
				
				if ($deleteResult) {
					echo "<script> window.location = 'Employees.php' </script>";
				}

				else {
					echo "Error: " . "<br>" . $conn->error;
				}

            }



        ?>