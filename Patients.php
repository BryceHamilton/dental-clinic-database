<!DOCTYPE html>


<head>
    <title>Patients</title>
    <link rel='stylesheet' type='text/css' href='dentists.css' />
    <link rel='stylesheet' type='text/css' href='dentist.css' />
    <link rel='stylesheet' type='text/css' href='hover.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body>
    <div class='wrapper'>

        <h3>Patients</h3>


        <!--Search Box-->
        <div>
            <form action="Patients.php" method="GET" id="SearchForm">
                <!--Search input-->
                <input id="Seach_input" name="Seach_input" type="text" placeholder="Search">
                <input id="submit" type="submit" svalue="search">

                <!--Search by-->
                <label> by </label>
                <select id="Searchby" name="option" form="SearchForm">
                    <option value="Name">Name</option>
                    <option value="Health Card ID">Health Card ID</option>
                    <option value="Address">Address</option>
                </select>
            </form>
        </div>

        <?

        function displayEmployeeHeaders() {
            echo "<table>", 
		    "<tr class='row'>",
		    "<th class='cell head'>Health Card ID</th>",
		    "<th class='cell head'>Name</th>",
		    "<th class='cell head'>Address</th>",
		"</tr>";
        }

        function displayEmployeeRow($row) {
            if (isset($_GET['Appt'])) {
                $action = 'Clinics.php?Appt=true&';
            }
            else {
                $action = 'Patientprofile.php?';
            }
            echo "<tr class='row' onClick=\"redirect('$action" . "Patient=" . $row['healthCardID'] ."')\">",
			"<td class='cell'>" . $row['healthCardID'] . "</td>",
            "<td class='cell'>" . $row['firstName'] . " ". $row['lastName'] . "</td>",
			"<td class='cell'>" . $row['address'] . "</td>",
			"</tr>";
        }

        function getEmployeeQuery() {

			$sql = "SELECT * FROM Patient";
		 	
             if (isset($_GET["Seach_input"]) And $_GET["Seach_input"] != "" ) { //Search Employee 
 
             switch ($_GET["option"]) { // by
               case "employeeID":
                     $sql .= " WHERE (healthCardID LIKE \"".$_GET["Seach_input"]."%\")";
                     break;
               case "Name":
                     $sql .= " WHERE (firstName LIKE \"".$_GET["Seach_input"]."%\" ) OR (lastName LIKE \"". $_GET["Seach_input"]."%\" )";
                     break;
               case "Address":
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
            echo "<div style='margin-top: 20px;'>No Patients Found</div>";
		}
}
		$conn->close();
		?>

        <button class='new-dentist-btn' onClick='displayForm()'>New Patient</button>
        <form action='addPatient.php' method='POST' class='add'>
            <div class='add-form'>
                <span class='close' onClick='closeForm()'>&times;</span>
                <div class='grid-cell'>
                    <label for='firstName'>First Name</label>
                    <input id='firstName' name='firstName' type='text' placeholder='Tim' required />
                </div>
                <div class='grid-cell'>
                    <label for='lastName'>Last Name</label>
                    <input id='lastName' name='lastName' type='text' placeholder='Whatley' required />
                </div>
                <div class='grid-cell'>
                    <label for='healthCardID'>Health Card ID</label>
                    <input id='healthCardID' name='healthCardID' type='text' placeholder='1232327566' minlength='10' maxlength='10' required />
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