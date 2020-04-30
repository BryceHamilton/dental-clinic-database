<!DOCTYPE html>


<head>
    <title>Employees</title>
    <link rel='stylesheet' type='text/css' href='dentists.css' />
    <link rel='stylesheet' type='text/css' href='dentist.css' />
    <link rel='stylesheet' type='text/css' href='hover.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class='wrapper'>
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


        if (isset($_GET['clinicID'])) {
          $clinicID = $_GET['clinicID'];
        
          $clinicQuery = "SELECT clinicName FROM Clinic WHERE clinicID = $clinicID;";
          $clinicResult = $conn->query($clinicQuery);
          $clinicRow = $clinicResult->fetch_assoc();
          $clinicName = $clinicRow['clinicName'];

          echo "<h2 onClick=redirect('ClinicProfile.php?clinicID=$clinicID')>$clinicName</h2>";
        }
        ?>
        <h3>Employees</h3>


        <!--Search Box-->
        <div>
            <form action="Employees.php" method="GET" id="SearchForm">
                <!--Search input-->
                <input id="Seach_input" name="Seach_input" type="text" placeholder="Search">
                <input id="submit" type="submit" value="search">

                <!--Search by-->
                <label> by </label>
                <select id="Searchby" name="option" form="SearchForm">
                    <option value="Name">Name</option>
                    <option value="employeeID">Employee ID</option>
                    <option value="Address">Address</option>
                </select>
                <?
                if (isset($_GET['clinicID'])) {

                  $clinicID = $_GET['clinicID'];
                  echo "<input type='hidden' name='clinicID' value='$clinicID' />";
                }
                ?>
            </form>
        </div>

        <?
        $clinicID = isset($_GET['clinicID']) ? "?clinicID=" . $_GET['clinicID'] : "";

        function displayEmployeeHeaders() {
            echo "<table>", 
		    "<tr class='row'>",
		    "<th class='cell head'>Employee ID</th>",
		    "<th class='cell head'>Name</th>",
		    "<th class='cell head'>Address</th>",
		    "<th class='cell head'>Salary</th>",
		    "<th class='cell head'>Start Date</th>",
		    "<th class='cell head'>End Date</th>",
		"</tr>";
        }

        function displayEmployeeRow($row) {
            echo "<tr class='row' onClick=\"redirect('findEmployee.php?employeeID=" . $row['employeeID'] ."')\">",
			"<td class='cell'>" . $row['employeeID'] . "</td>",
            "<td class='cell'>" . $row['firstName'] . " ". $row['lastName'] . "</td>",
			"<td class='cell'>" . $row['address'] . "</td>",
			"<td class='cell'>" . $row['salary'] . "</td>",
			"<td class='cell'>" . $row['startDate'] . "</td>",
			"<td class='cell'>" . $row['endDate'] . "</td>",
			"</tr>";
        }

        function getEmployeeQuery() {

			$sql = "SELECT employeeID, firstName, lastName, address, salary, startDate, endDate FROM Employee";
		 	
             if (isset($_GET["Seach_input"]) And $_GET["Seach_input"] != "" ) { // Search Employee 
 
             switch ($_GET["option"]) { // by
               case "employeeID":
                     $sql .= " WHERE (employeeID LIKE \"".$_GET["Seach_input"]."%\")";
                     break;
               case "Name":
                     $sql .= " WHERE ((firstName LIKE \"".$_GET["Seach_input"]."%\" ) OR (lastName LIKE \"". $_GET["Seach_input"]."%\" ))";
                     break;
               case "Address":
                     $sql .= " WHERE (`address` LIKE \"".$_GET["Seach_input"]."%\")";
               break;
             }

             if (isset($_GET['clinicID'])) {
                 $clinicID = $_GET['clinicID'];
                 $sql .= " AND employeeID IN (SELECT employeeID FROM WorksAt WHERE clinicID = $clinicID)";
             }
           }

           elseif (isset($_GET['clinicID'])) {
            $clinicID = $_GET['clinicID'];
            $sql .= " WHERE employeeID IN (SELECT employeeID FROM WorksAt WHERE clinicID = $clinicID)";
           }

           return $sql;
        }
        
        $employeeQuery = getEmployeeQuery();
		
		$result = $conn->query($employeeQuery);

		if ($result->num_rows > 0) {
          
          displayEmployeeHeaders();
		  
          while($row = $result->fetch_assoc()) {
            displayEmployeeRow($row);    
		}
			echo "</table>";

		} else {
            echo "<div style='margin-top: 20px;'>No Employees Found</div>";
		}



		$conn->close();

        $clinicID = isset($_GET['clinicID']) ? "?clinicID=" . $_GET['clinicID'] : "";

		?>
        <div>
            <button class='new-dentist-btn' onClick='redirect("DentalStaff.php<? echo $clinicID; ?>")'>Dental
                Staff</button>
            <button class='new-dentist-btn' onClick='redirect("Reception.php<? echo $clinicID; ?>")'>Reception</button>
        </div>

        <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i
                class='fa fa-home' onclick="redirect('Home.php')"></i>
        </div>

    </div>
    <!-- wrapper end -->


    <script>
    const redirect = url => {
        location.replace(url)
    }
    </script>

</body>