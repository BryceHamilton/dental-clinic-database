<!DOCTYPE html>


<head>
    <title>Clinics</title>
    <link rel='stylesheet' type='text/css' href='dentists.css' />
    <link rel='stylesheet' type='text/css' href='dentist.css' />
    <link rel='stylesheet' type='text/css' href='hover.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>
    <div class='wrapper'>

        <h3>Clinics</h3>


        <!--Search Box-->
        <div>
            <form action="Clinics.php" method="GET" id="SearchForm">
                <!--Search input-->
                <input id="Seach_input" name="Seach_input" type="text" placeholder="Search">
                <input id="submit" type="submit" value="search">

                <!--Search by-->
                <label> by </label>
                <select id="Searchby" name="option" form="SearchForm">
                    <option value="clinicName">Clinic Name</option>
                    <option value="clinicID">Clinic ID</option>
                    <option value="address">Address</option>
                </select>
            </form>
        </div>

        <?

        function displayEmployeeHeaders() {
            echo "<table>", 
		    "<tr class='row'>",
		    "<th class='cell head'>Clinic ID</th>",
		    "<th class='cell head'>Clinic Name</th>",
		    "<th class='cell head'>Address</th>",
		"</tr>";
        }

        function displayEmployeeRow($row) {
            if (isset($_GET['Appt']) && isset($_GET['Patient'])) {
                $action = "Dentists.php?Appt=true&Patient=" . $_GET['Patient'] . "&";
            }

            else {
                $action = "ClinicProfile.php?";
            }
            echo "<tr class='row' onClick=\"redirect('$action" . "clinicID=" . $row['clinicID'] ."')\">",
			"<td class='cell'>" . $row['clinicID'] . "</td>",
            "<td class='cell'>" . $row['clinicName'] . "</td>",
			"<td class='cell'>" . $row['address'] . "</td>",
			"</tr>";
        }

        function getEmployeeQuery() {

			$sql = "SELECT * FROM Clinic";
		 	
             if (isset($_GET["Seach_input"]) And $_GET["Seach_input"] != "" ) { //Search Employee 
 
             switch ($_GET["option"]) { // by
               case "clinicID":
                     $sql .= " WHERE (clinicID LIKE \"".$_GET["Seach_input"]."%\")";
                     break;
               case "clinicName":
                     $sql .= " WHERE (clinicName LIKE \"".$_GET["Seach_input"]."%\" )";
                     break;
               case "address":
                     $sql .= " WHERE (`address` LIKE \"".$_GET["Seach_input"]."%\")";
               break;
             }
           }

           return $sql;
        }

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
        
        $employeeQuery = getEmployeeQuery();
		
		$result = $conn->query($employeeQuery);

		if ($result->num_rows > 0) {
          
          displayEmployeeHeaders();
		  
          while($row = $result->fetch_assoc()) {
            displayEmployeeRow($row);    
		}
			echo "</table>";

		} else {
            echo "<div style='margin-top: 20px;'>No Clinics Found</div>";
		}
}
		$conn->close();
        
        if (!isset($_GET['Appt'])) {

        echo "<button class='new-dentist-btn' onClick='displayForm()'>New Clinic</button>";
        }
		?>


        <form action='addClinic.php' method='POST' class='add'>
            <div class='add-form'>
                <span class='close' onClick='closeForm()'>&times;</span>
                <div class='grid-cell'>
                    <label for='clinicName'>Clinic Name</label>
                    <input id='clinicName' name='clinicName' type='text' placeholder='Alpha Dental' required />
                </div>
                <div class='grid-cell'>
                    <label for='clinicID'>Clinic ID</label>
                    <input id='clinicID' name='clinicID' type='text' placeholder='202' required />
                </div>
                <div class='grid-cell address'>
                    <label for='address'>Address</label>
                    <input id='address' name='address' type='text' placeholder='23 Jordan Rd' required />
                </div>

                <input id="submit" type="submit" value="ADD">
            </div>
        </form>
        <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i
                class='fa fa-home' onclick="redirect('Home.php')"></i>
        </div>

    </div>
    <!-- wrapper end -->


    <script>
    const redirect = url => {
        location.replace(url)
    }
    const displayForm = () => {
        const formDiv = document.querySelector('form.add');
        const addButton = document.querySelector('.new-dentist-btn');
        formDiv.style.display = "flex";
        addButton.style.display = "none";
    }

    const closeForm = () => {
        const formDiv = document.querySelector('form.add');
        const addButton = document.querySelector('.new-dentist-btn');
        formDiv.style.display = "none";
        addButton.style.display = "block";
    }
    </script>

</body>