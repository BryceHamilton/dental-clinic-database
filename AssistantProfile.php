<!DOCTYPE html>

<head>
    <title>Assistant Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
    table,
    th,
    td {
        border-collapse: collapse;
        padding: 10px
    }

    hr {
        margin: 0px;
        margin-top: 40px;
        margin-left: 10px
    }

    input {
        margin-left: 20px
    }

    div {
        padding: 10px
    }

    .button {
        color: white;
        padding: 5px;
        cursor: pointer;
    }

    .edit {
        background-color: #e7e7e7;
        color: black;
        float: right;
    }

    .delete {
        background-color: #f44336;
        float: right;
    }

    .save {
        background-color: #4CAF50;
        float: right;
    }

    .discard {
        background-color: #ff9800;
        float: right;
    }

    .centerDiv {
        width: 60%;
        height: 200px;
        border-color: black;
        float: center
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(71, 78, 93, 0.6);
        padding-top: 50px;
        margin: 0 auto;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto;
        border: 1px solid #888;
        width: 30%;
    }

    .close {
        position: absolute;
        right: 35px;
        top: 15px;
        font-size: 40px;
        font-weight: bold;
        color: #f1f1f1
    }

                /* Table CSS */

table {
  border-collapse: collapse;
  margin: 15px 0;
}

.cell, .row > * {
  font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ddd;
  padding: 8px;
}

.cell div:nth-child(even) {
  background-color: #f2f2f2;
}

.row:hover {
  background-color: #f2f2f2;
}

.head, .row > th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4caf50;
  color: white;
}
    </style>

    <!-- fetch all datails if only healthcard -->


    <!-- delete post request -->
    <form id="form-delete" method="post" action="">
        <input type="hidden" name="delete" value="true">
    </form>

    <!--Update/delete/fecthdetails -->
    <?php
            $servername = "vuc353.encs.concordia.ca";
            $username = "vuc353_4";
            $password = "4DBKings";
            $dbname = "vuc353_4";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection  
            if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }else{
                
                $assistantID = $_GET['assistantID'];
                $dentistQuery = "SELECT dentalStaffID as employeeID, firstName, lastName, address, salary, startDate, endDate, certification FROM DentalStaff DS INNER JOIN (SELECT assistantID as employeeID, firstName, lastName, address, salary, startDate, endDate FROM Employee E INNER JOIN DentistAssistant D ON E.employeeID = D.assistantID) t2 ON DS.dentalStaffID = employeeID WHERE employeeID = $assistantID;";
                $dentistResult = $conn->query($dentistQuery);
                if ($dentistResult->num_rows > 0) {
                if ($row = $dentistResult->fetch_assoc()) {
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $name = $firstName . " " . $lastName;
                    $assistantID = $row['employeeID'];
                    $address = $row['address'];
                    $salary = $row['salary'];
                    $startDate = $row['startDate'];
                    $endDate = $row['endDate'];
                    $certification = $row['certification'];
                    $speciality = $row['speciality'];
                }

                // update
                // if( isset($_POST["EditName"]) && isset($_POST["EditName"]) && isset($_POST["EditLastName"]) && isset($_POST["EdithealthCardID"]) && isset($_POST["Editaddress"])) {
                //     $sql = "UPDATE Dentist Set = \"".$_POST["EdithealthCardID"]."\", firstName = \"".$_POST["EditName"]."\", lastName =  \"".$_POST["EditLastName"]."\", address = \"".$_POST["Editaddress"]."\" WHERE healthCardID = \"".$_GET["Patient"]."\"";
                //     $conn->query($sql);
                //     echo "<script> window.location.href  = \"https://users.encs.concordia.ca/~vuc353_4/Patientprofile.php?Patient=".$_POST["EdithealthCardID"]."&Name=".$_POST["EditName"]."&LastName=".$_POST["EditLastName"]."&address=".$_POST["Editaddress"]."&Edit=false\"; </script>;";
                // // delete
                // }elseif(isset($_POST["delete"])){
                //     $sql = "DELETE FROM Dentist WHERE assistantID = '$assistantID'";
                //     $result = $conn->query($sql);
                //     echo "<script> location.replace('Dentists.php') </script>";
                // }  
            }
            }
        ?>


    <script>
    function Edit() {
        var ED = document.getElementById("EditDetails");
        var DD = document.getElementById("DisplayDetails");
        if (ED.style.display === "none") {
            ED.style.display = "block";
            DD.style.display = "none";
        } else {
            ED.style.display = "none";
            DD.style.display = "block";
        }
    }
    </script>
</head>

<body>
    <!-- Dentist details -->
    <div id="DisplayDetails" style="border-style: solid; width: 50%">
        <?php
                $supervisorQuery = "SELECT firstName, lastName, employeeID FROM Employee WHERE employeeID IN (SELECT supervisorID FROM Supervision WHERE supervisedID = $assistantID)";

                $supervisorResult = $conn->query($supervisorQuery);     
                $clinicQuery = "SELECT clinicID, clinicName FROM WorksAt NATURAL JOIN Clinic WHERE employeeID = $assistantID";
                $clinicResult = $conn->query($clinicQuery);

                if ($supervisorResult->num_rows > 0) {
                    $row = $supervisorResult->fetch_assoc();
                    $currentSupervisor = $row['firstName'] . " " . $row['lastName'];
                } 

                else {
                    $currentSupervisor = "None";
                }
               
               
               
                $currentSupervisorID = $supervisorResult->num_rows > 0 ? $supervisorResult->fetch_assoc()['employeeID'] : "None";
                $clinicName = $clinicResult->num_rows > 0 ? $clinicResult->fetch_assoc()['clinicName'] : "No Clinic";
                echo "<h2> $name </h2>";
                echo "<br>";
                echo "<label>Assistant ID: </label><br><label> $assistantID </label><br><br><label>Address:</label><address>$address</address><br>";
                echo "<label>Certification: </label><label>$certification</label><br><br>";
                echo "<label>Salary: </label><label>$salary</label><br><br>";
                echo "<label>Start Date: </label><label>$startDate</label><br><br>";
                echo "<label>End Date: </label><label>$endDate</label><br><br>";
                echo "<label>Current Clinic: </label>";
                echo "<label>$clinicName</label><br><br>";

                echo "<label>Current Supervisor: </label>";
                echo "<label>$currentSupervisor</label>";
                echo "<span class=\"button edit\" onclick='Edit()'>edit</span>";
                
        ?>
        <br>
    </div>
    <!-- Dentist Edit form -->
    <div id="EditDetails" style="border-style: solid; width: 50%; display: none">
        <?php

$allClinics = "SELECT clinicID, clinicName FROM Clinic";
        
$allClinicsResult = $conn->query($allClinics);
$clinicQuery = "SELECT clinicID, clinicName FROM WorksAt NATURAL JOIN Clinic WHERE employeeID = $assistantID";
    $clinicResult = $conn->query($clinicQuery);
    $supervisorQuery = "SELECT firstName, lastName, employeeID FROM Employee WHERE employeeID IN (SELECT supervisorID FROM Supervision WHERE supervisedID = $assistantID)";

                $supervisorResult = $conn->query($supervisorQuery); 
                $currentSupervisorID = $supervisorResult->num_rows > 0 ? $supervisorResult->fetch_assoc()['employeeID'] : "None";    
                echo "<form id=\"PatientChange\"action='editAssistant.php' method=\"post\">";
                echo "<br>";
                echo "<label>First name:</label>";
                echo "<input type='text' id='firstName' name='firstName' value='$firstName'><br><br>";
                echo "<label>Last name:</label>";
                echo "<input type='text' id='lastName' name='lastName' value='$lastName'><br><br>";
                echo "<label>Assistant ID: </label>";
                echo "<input type='text' id='employeeID' name='employeeID' value='$assistantID'><br><br>";
                echo "<label>Address: </label>";
                echo "<input type='text' id='address' name='address' value='$address'><br><br>";
                echo "<label>Certification: </label>";
                echo "<input type='text' id='certification' name='certification' value='$certification'><br><br>";
                echo "<label>Salary </label>";
                echo "<input type='text' id='salary' name='salary' value='$salary'><br><br>";
                echo "<label>Start Date: </label>";
                echo "<input type='text' id='startDate' name='startDate' value='$startDate'><br><br>";
                echo "<label>End Date: </label>";
                echo "<input type='text' id='endDate' name='endDate' value='$endDate'><br><br>";
                echo "<label>Current Clinic: </label>";
                if ($clinicResult->num_rows > 0) {

                    $dentClinic = $clinicResult->fetch_assoc()['clinicID'];
                    echo "<select name='clinicID' id='clinicID'>";
                    while ($row = $allClinicsResult->fetch_assoc()) {
                        $clinicID = $row['clinicID'];
                        $clinicName = $row['clinicName'];
                        echo "<option value='$clinicID'";
                        echo $dentClinic == $clinicID ? "selected" : "";
                        echo ">$clinicName</option>";

                    }
                    echo "</select><br><br>";

                    echo "<label>Current Supervisor: </label>";
                    echo "<select name='supervisorID' id='supervisorId'>";
                    $getDentistsAtClinic = "SELECT firstName, lastName, employeeID FROM Employee NATURAL JOIN WorksAt WHERE clinicID = $dentClinic";
                    $dentistsAtClinicResult = $conn->query($getDentistsAtClinic);
                    echo "<option value='None'";
                    echo $currentSupervisorID == "None" ? "selected" : "";
                    echo ">None</option>";
                    while ($row = $dentistsAtClinicResult->fetch_assoc()) {
                        $name = $row['firstName'] ." " . $row['lastName'];
                        $dentistID = $row['employeeID'];
                        echo "<option value='$dentistID'";
                        echo $dentistID == $currentSupervisorID ? "selected" : "";
                        echo ">$name</option>";
                    }
                    echo "</select>";
                }
                
                else {
                    echo "No Clinic";
                }

               

                echo "<span class='button save' onclick=\"Edit(); document.getElementById('PatientChange').submit();\">save</span>";
                echo "<span class='button discard' onclick='Edit()'>discard</span>";
                echo $clinicResult->num_rows > 0 ? "<span class='button delete' onclick=\"document.getElementById('deleteConfirm').style.display='block';\">delete</span>" : "";
                echo "</form>";
        ?>
        <br>
    </div>

    <!-- confirm delete -->
    <div id="deleteConfirm" class="modal">
        <span onclick="document.getElementById('deleteConfirm').style.display='none'" class="close">×</span>
        <form class="modal-content" id='form-delete' action="deleteEmployee.php" method='post'>
            <input type='hidden' name='employeeID' value='<? echo $assistantID; ?>' />
            <div class="container">
                <h1>Delete Assistant</h1>
                <p>Are you sure you want to delete this Assistant?</p>
                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('deleteConfirm').style.display='none'"
                        class="cancelbtn">Cancel</button>
                    <button type="submit"
                        onclick="document.getElementById('deleteConfirm').style.display='none'; document.getElementById('form-delete').submit();"
                        class="deletebtn">Delete</button>
                </div>
            </div>
        </form>
    </div>


    <hr style="width: 50%">
    <!-- Patient Appointment and bill -->
    <div>
        <?php

                    // Treatments
                    echo "<br><br><h3>Treatments</h3>";
                    $sql = "SELECT * FROM Treatment WHERE (dentalStaffID = $assistantID)";       
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        echo "<table> <tr class='row'> <th>healthCardID</th> <th>scheduledTime</th> <th>type</th> <th>cost</th> </tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='row' onclick=\"window.location='\Billprofile.php?CliniID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."';\"><td>" . $row["healthCardID"]. "</td><td>" . $row["scheduledTime"] . "</td><td>" . $row["type"] . "</td><td>" . $row["cost"] . "</td></tr></a>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Treatments found";
                    }

                    echo "    <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i",
                    " class='fa fa-home' onclick='window.location = \"Home.php\"')></i>",
            "</div>";
                
            ?>
    </div>
</body>

</html>