<!DOCTYPE html>


<head>
    <title>Bills</title>
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
        <h3>Bills</h3>


        <!--Search Box-->
        <div>
            <form action="Bills.php" method="GET" id="SearchForm">
                <!--Search input-->
                <input id="Seach_input" name="Seach_input" type="text" placeholder="Search">
                <input id="submit" type="submit" value="search">

                <!--Search by-->
                <label> by </label>
                <select id="Searchby" name="option" form="SearchForm">
                    <option value="healthCardID">Health Card ID</option>
                    <option value="employeeID">Receptionist ID</option>
                </select>

                <label> Status </label>
                <select id="status" name="status" form="SearchForm">
                    <option selected>All</option>
                    <option value="Paid">Paid</option>
                    <option value="Unpaid">Unpaid</option>
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

        function displayReceptionHeaders() {
            echo "<table>", 
		    "<tr class='row'>",
            isset($_GET['clinicID']) ? "" :  "<th class='cell head'>Clinic ID</th>",
		    "<th class='cell head'>Health Card ID</th>",
		    "<th class='cell head'>Scheduled Time</th>",
		    "<th class='cell head'>Receptionist ID</th>",
		    "<th class='cell head'>Amount</th>",
		    "<th class='cell head'>Receipt Number</th>",
		    "<th class='cell head'>Status</th>",
		"</tr>";
        }

        function displayReceptionRow($row) {
            $healthCardID = $row['healthCardID'];
            $clinicID = $row['clinicID'];
            $scheduledTime = $row['scheduledTime'];
            echo "<tr class='row' onClick=\"redirect('Billprofile.php?healthCardID=$healthCardID&ClinicID=$clinicID&scheduledTime=$scheduledTime')\">",
			isset($_GET['clinicID']) ? "" :  "<td class='cell'>" . $row['clinicID'] . "</td>",
            "<td class='cell'>" . $row['healthCardID'] . "</td>",
            "<td class='cell'>" . $row['scheduledTime'],
			"<td class='cell'>" . $row['receptionistID'] . "</td>",
			"<td class='cell'>" . $row['amount'] . "</td>",
			"<td class='cell'>" . $row['receiptNumber'] . "</td>",
			"<td class='cell'>" . $row['status'] . "</td>",
			"</tr>";
        }

        function getReceptionQuery() {

			$sql = "SELECT * From Bill";
		 	
             if (isset($_GET["Seach_input"]) And $_GET["Seach_input"] != "" ) { //Search Dentist 
 
             switch ($_GET["option"]) { // by
               case "healthCardID":
                     $sql .= " WHERE (healthCardID = " . $_GET["Seach_input"].")";
                     break;
               case "receptionistID":
                $sql .= " WHERE (receptionistID = " . $_GET["Seach_input"] . ")";
                     break;
                
                
             }

             if (isset($_GET['status']) && $_GET['status'] != 'All') {
                    $status = $_GET['status'];
                    $sql .= " AND status = '$status'";
                }

             if (isset($_GET['clinicID'])) {
                 $clinicID = $_GET['clinicID'];
                 $sql .= " AND clinicID = $clinicID)";
               }
           }

           elseif (isset($_GET['clinicID'])) {
            $clinicID = $_GET['clinicID'];
            $sql .= " WHERE clinicID = $clinicID";

            if (isset($_GET['status']) && $_GET['status'] != 'All')  {
                    $status = $_GET['status'];
                    $sql .= " AND status = '$status'";
                }
           }

           elseif (isset($_GET['status']) && $_GET['status'] != 'All')  {
                    $status = $_GET['status'];
                    $sql .= " WHERE status = '$status'";
                }


           return $sql;
        }

	
        
        $receptionQuery = getReceptionQuery();
		
		$result = $conn->query($receptionQuery);

		if ($result->num_rows > 0) {
          
          displayReceptionHeaders();
		  
          while($row = $result->fetch_assoc()) {
            displayReceptionRow($row);    
		}
			echo "</table>";

		} else {
			echo "<div style='margin-top: 20px;'>No Bills Found</div>";
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

        <!-- Add Dentist Form -->
        <!-- <button class='new-dentist-btn' onClick='displayForm()'>New Receptionist</button> -->
        <form action='addReceptionist.php' method='POST' class='add'>
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
                    <label for='employeeID'>Receptionist ID</label>
                    <input id='employeeID' name='employeeID' type='text' placeholder='1337' required />
                </div>
                <div class='grid-cell'>
                    <label for='salary'>Salary</label>
                    <input id='salary' name='salary' type='text' placeholder='100000' required />
                </div>
                <div class='grid-cell address'>
                    <label for='address'>Address</label>
                    <input id='address' name='address' type='text' placeholder='23 Jordan Rd' required />
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
                }elseif (isset($clinicsArr)) {
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