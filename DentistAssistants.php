<!DOCTYPE html>


<head>
    <title>Dentist Assistants</title>
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
        <h3>Dentist Assistants</h3>


        <!--Search Box-->
        <div>
            <form action="DentistAssistants.php" method="GET" id="SearchForm">
                <!--Search input-->
                <input id="Seach_input" name="Seach_input" type="text" placeholder="Search">
                <input id="submit" type="submit" value="search">

                <!--Search by-->
                <label> by </label>
                <select id="Searchby" name="option" form="SearchForm">
                    <option value="Name">Name</option>
                    <option value="employeeID">Assistant ID</option>
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

        function displayAssistantHeaders() {
            echo "<table>", 
		    "<tr class='row'>",
		    "<th class='cell head'>Assistant ID</th>",
		    "<th class='cell head'>Name</th>",
		    "<th class='cell head'>Address</th>",
		    "<th class='cell head'>Salary</th>",
		    "<th class='cell head'>Start Date</th>",
		    "<th class='cell head'>End Date</th>",
		    "<th class='cell head'>Certification</th>",
		"</tr>";
        }

        function displayAssistantRow($row) {
            echo "<tr class='row' onClick=\"redirect('AssistantProfile.php?assistantID=" . $row['employeeID'] ."')\">",
			"<td class='cell'>" . $row['employeeID'] . "</td>",
            "<td class='cell'>" . $row['firstName'] . " ". $row['lastName'] . "</td>",
			"<td class='cell'>" . $row['address'] . "</td>",
			"<td class='cell'>" . $row['salary'] . "</td>",
			"<td class='cell'>" . $row['startDate'] . "</td>",
			"<td class='cell'>" . $row['endDate'] . "</td>",
			"<td class='cell'>" . $row['certification'] . "</td>",
			"</tr>";
        }

        function getAssistantsQuery() {

			$sql = "SELECT dentalStaffID as employeeID, firstName, lastName, address, salary, startDate, endDate, certification FROM DentalStaff DS INNER JOIN (SELECT assistantID as employeeID, firstName, lastName, address, salary, startDate, endDate FROM Employee E INNER JOIN DentistAssistant D ON E.employeeID = D.assistantID) t2 ON DS.dentalStaffID = employeeID" ;
		 	
             if (isset($_GET["Seach_input"]) And $_GET["Seach_input"] != "" ) { //Search Assistant 
 
             switch ($_GET["option"]) { // by
               case "employeeID":
                     $sql .= " WHERE (employeeID LIKE \"".$_GET["Seach_input"]."%\")";
                     break;
               case "Name":
                     $sql .= " WHERE (firstName LIKE \"".$_GET["Seach_input"]."%\" ) OR (lastName LIKE \"". $_GET["Seach_input"]."%\" )";
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

        
        $assistantsQuery = getAssistantsQuery();
		
		$result = $conn->query($assistantsQuery);

		if ($result->num_rows > 0) {
          
          displayAssistantHeaders();
		  
          while($row = $result->fetch_assoc()) {
            displayAssistantRow($row);    
		}
			echo "</table>";

		} else {
			echo "<div style='margin-top: 20px;'>No Dentist Assistants Found</div>";
		}

        $clinicsQuery = "SELECT clinicID, clinicName from Clinic;";
        $result = $conn->query($clinicsQuery);

        if ($result->num_rows > 0) {
            $clinicsArr = [];
            while($row = $result->fetch_assoc()) {
                $cliniObj = new stdClass();
                $cliniObj->clinicID = $row['clinicID'];
                $cliniObj->clinicName = $row['clinicName'];
                
                $clinicsArr[] = $cliniObj;
		    }
        }
		$conn->close();
		?>

        <!-- Add Assistant Form -->
        <button class='new-dentist-btn' onClick='displayForm()'>New Assistant</button>
        <form action='addAssistant.php' method='POST' class='add'>
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
                    <label for='employeeID'>Assistant ID</label>
                    <input id='employeeID' name='employeeID' type='text' placeholder='1337' required />
                </div>
                <div class='grid-cell'>
                    <label for='certificateNumber'>Certificate Number</label>
                    <input id='certificateNumber' name='certificateNumber' type='text' placeholder='123' required />
                </div>
                <div class='grid-cell address'>
                    <label for='address'>Address</label>
                    <input id='address' name='address' type='text' placeholder='23 Jordan Rd' required />
                </div>
                <div class='grid-cell'>
                    <label for='salary'>Salary</label>
                    <input id='salary' name='salary' type='text' placeholder='100000' required />
                </div>
                <div class='grid-cell'>
                    <label for='startDate'>Start Date</label>
                    <input id='startDate' name='startDate' type='text' placeholder='2020-04-20' required />
                </div>
                <div class='grid-cell'>
                    <label for='endDate'>End Date (Optional)</label>
                    <input id='endDate' name='endDate' type='text' placeholder='2021-04-20' />
                </div>
                <? 

                   
                if (isset($_GET['clinicID'])) {
                    $clinicID = $_GET['clinicID'];
                    echo "<input type='hidden' name='clinicID' value='$clinicID' />";
                }
                
                elseif (isset($clinicsArr)) {
                    echo "<div class='grid-cell' style='grid-column-start: span 2;'>",
                    "<label for='clinicID'>Clinic</label>",
                    "<select id='clinicID' name='clinicID' style='margin-left: 20px;' required >";

                    $str = "<option value='' disabled selected>Choose a Clinic</option>";

                    foreach($clinicsArr as $clinic) {
                        $str .= "<option value='" . $clinic->clinicID . "'>" . $clinic->clinicName . "</option>";
                    }

                    echo $str;
                    
                    echo "</select></div>";
                }
                ?>
                <input id="submit" type="submit" value="ADD">
            </div>
        </form>
        <?  $setClinic = isset($_GET['clinicID']) ? "?clinicID=" . $_GET['clinicID'] : ""; ?>
        <a href='./DentalStaff.php<?echo $setClinic;?>'> <button class='new-dentist-btn'>Back to Dental Staff</button></a>

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
        const formDiv = document.querySelector(' form.add');
        const
            addButton = document.querySelector('.new-dentist-btn');
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