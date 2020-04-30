<!DOCTYPE html>

<head>
    <title>Appointment Profile</title>
    <link rel='stylesheet' type='text/css' href='hover.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

    .bill:hover {
        cursor: pointer;
    }
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

    .del-btn:hover {
        cursor: pointer;
        color: white;
        background-color: #4caf50;
        border-radius: 5px;
    }

    .del-btn:focus {
        outline: none;
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
        font-size: 20px;
        font-weight: bold;
        color: #f1f1f1
    }

    /* Table CSS */

    table {
        border-collapse: collapse;
        margin: 15px 0;
    }

    .cell,
    .row>* {
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

    .treatment:hover {
        cursor: auto;
    }

    h2:hover, h4:hover, .dent:hover {
        cursor: pointer;
    }

    .head,
    .row>th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4caf50;
        color: white;
    }

    .close {
        position: absolute;
        top: 14px;
        right: 20px;
        color: #949494;
    }

    .close:hover {
        cursor: pointer;
        opacity: 0.5;
    }

    form.add {
        display: none;
        justify-content: center;
        margin-top: 20px;
        position: relative;
    }

    .add-form>input[type='submit'] {
        width: 100%;
        background-color: #4caf50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        grid-column-start: span 2;
    }

    .add-form>input[type='submit']:focus {
        outline: none;
    }

    .new-dentist-btn:hover {
        background-color: #45a049;
    }

    .new-dentist-btn {
        background-color: #4caf50;
        color: white;
        padding: 14px 20px;
        margin: 20px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .new-dentist-btn:focus {
        outline: none;
    }

    .add {
        width: 453px;
    }
    </style>

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
                if( isset($_POST["EditClinicID"]) && isset($_POST["EdithealthCardID"]) && isset($_POST["EditscheduledTime"]) && isset($_POST["Editstatus"]) && isset($_POST["Editnote"])) {
                //update
                    //scheduledTime =  \"".$_POST["EditscheduledTime"]."\",
                    $newdate= str_replace("T"," ","".$_POST["EditscheduledTime"]."").":00";
                    if($newdate == ":00"){
                        $newdate = "".$_GET["scheduledTime"];
                    }
                    $sql = "UPDATE Appointment Set scheduledTime = '$newdate', healthCardID = \"".$_POST["EdithealthCardID"]."\", clinicID = \"".$_POST["EditClinicID"]."\", status = \"".$_POST["Editstatus"]."\", note = \"".$_POST["Editnote"]."\" WHERE (healthCardID = \"".$_GET["healthCardID"]."\") AND (clinicID = \"".$_GET["ClinicID"]."\") AND (scheduledTime = \"".$_GET["scheduledTime"]."\")";
                    
                    $conn->query($sql);
                    
                    echo "<script> window.location  = \"/Appointmentprofile.php?ClinicID=".$_POST["EditClinicID"]."&healthCardID=".$_POST["EdithealthCardID"]."&scheduledTime=$newdate&status=".$_POST["Editstatus"]."&note=".$_POST["Editnote"]."\"; </script>;";
                }elseif(isset($_POST["delete"])){
                //delete
                    $sql = "DELETE FROM Appointment WHERE (healthCardID = \"".$_GET["healthCardID"]."\") AND (clinicID = \"".$_GET["ClinicID"]."\") AND (scheduledTime = \"".$_GET["scheduledTime"]."\")";
                    $result = $conn->query($sql);
                    echo "<script> window.location  = \"/Appointment.php\"; </script>";
                }elseif(isset($_GET["ClinicID"]) && isset($_GET["healthCardID"]) && isset($_GET["scheduledTime"]) && !isset($_GET["status"])){
                //fetch details
                        $sql = "SELECT * FROM Appointment WHERE healthCardID = \"".$_GET["healthCardID"]."\" AND ClinicID = \"".$_GET["ClinicID"]."\" AND scheduledTime = \"".$_GET["scheduledTime"]."\"";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo "<script> window.location = '\Appointmentprofile.php?ClinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."&status=".$row["status"]."&note=".$row["note"]."'; </script>";
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
    <!-- Appointment details -->
    <div id="DisplayDetails" style="border-style: solid; width: 50%">
        <?php
                   
                   $clinicQuery = "SELECT clinicName, clinicID FROM Clinic WHERE clinicID = " . $_GET["ClinicID"];
                   $result = $conn->query($clinicQuery);
                   $row = $result->fetch_assoc();

                   $clinicID = $row['clinicID'];
                   $clinicName = $row['clinicName'];

                   $patientQuery = "SELECT firstName, lastName, healthCardID FROM Patient WHERE healthCardID = " . $_GET["healthCardID"]; 
                   $result = $conn->query($patientQuery);
                   $row = $result->fetch_assoc();

                   $healthCardID = $row['healthCardID'];    
                   $patientName = $row['firstName'] ." " . $row['lastName'];

                   $dentistApptQuery = "SELECT * FROM Employee WHERE employeeID IN (SELECT dentistID FROM AppointmentWith WHERE (healthCardID = \"".$_GET["healthCardID"]."\") AND (ClinicID = \"".$_GET["ClinicID"]."\") AND  (scheduledTime = \"".$_GET["scheduledTime"]."\"));";
                   $result = $conn->query($dentistApptQuery);

      

                    echo "<h2 onclick='window.location = \"ClinicProfile.php?clinicID=$clinicID\"'>$clinicName</h2>";
                    echo "<h4 onclick='window.location = \"Patientprofile.php?Patient=$healthCardID\"'><span style='font-style: italic;'>Appointment For: </span>$patientName</h4>";
                    echo "<label>Scheduled Time: </label><label>".$_GET["scheduledTime"]."</label><br><br>";
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $dentistID = $row['employeeID'];
                        $dentistName = $row['firstName'] . " " . $row['lastName'];
 
                        echo "<label class='dent' onclick=\"window.location='\DentistProfile.php?dentistID=".$row["employeeID"]."';\">With: $dentistName</label><br>";
                    }
                    echo "<label>Status: </label><label>".$_GET["status"]."</label><br>";
                    echo "<label>Note: </label><label  readonly=\"True\" rows=\"4\" cols=\"50\">".$_GET["note"]."</label><br>";
                    echo "<span class=\"button edit\" onclick='Edit()'>edit</span>";
                    ?>
        <br>
    </div>
    <!-- Appointment Edit form -->
    <div id="EditDetails" style="border-style: solid; width: 50%; display: none">
        <?php
                    echo "<form id=\"AppointmentChange\"action=\"\" method=\"post\">";
                    echo "<br>";
                    echo "<label>Clinic ID: </label>";
                    echo "<input type=\"text\" id=\"EditClinicID\" name=\"EditClinicID\" value=\"".$_GET["ClinicID"]."\"><br><br>";
                    echo "<label>Patient healthCardID: </label>";
                    echo "<input type=\"text\" id=\"EdithealthCardID\" name=\"EdithealthCardID\" value=\"".$_GET["healthCardID"]."\"><br><br>";
                    echo "<label>ScheduledTime: </label>";
                    echo "<input type=\"datetime-local\" id=\"EditscheduledTime\" name=\"EditscheduledTime\" value=\"".$_GET["scheduledTime"]."\"><br><br>";
                    echo "<label>Status: </label>";
                    // echo "<input type=\"text\" id=\"Editstatus\" name=\"Editstatus\" value=\"".$_GET["status"]."\"><br><br>";
                    echo "<select name='Editstatus' id='Editstatus'>";
                    echo $_POST['status'] == 'Upcoming' ? "<option value='Upcoming' selected>Upcoming</option>" : "<option value='Upcoming'>Upcoming</option>";
                    echo $_GET['status'] == 'Missed' ? "<option value='Missed' selected>Missed</option>" : "<option value='Missed'>Missed</option>";
                    echo $_GET['status'] == 'Completed' ? "<option value='Completed' selected>Completed</option>" : "<option value='Completed'>Completed</option>";
                    echo "</select><br><br>";
                    echo "<label>Note: </label><br>";
                    echo "<textarea rows=\"4\" cols=\"50\" name=\"Editnote\" form=\"AppointmentChange\" maxlength=\"512\">".$_GET["note"]."</textarea>";
                    echo "<span class=\"button save\" onclick='Edit(); document.getElementById(\"AppointmentChange\").submit();'>save</span>";
                    echo "<span class=\"button discard\" onclick='Edit()'>discard</span>";
                    echo "<span class=\"button delete\" onclick=\"document.getElementById('deleteConfirm').style.display='block';\">delete</span>";
                    echo "</form>"
            ?>
        <br>
    </div>

    <!-- confirm delete -->
    <div id="deleteConfirm" class="modal">
        <span onclick="document.getElementById('deleteConfirm').style.display='none'" class="close">×</span>
        <form class="modal-content" action="/action_page.php">
            <div class="container">
                <h1>Delete Patient</h1>
                <p>Are you sure you want to delete this patient?</p>
                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('deleteConfirm').style.display='none'"
                        class="cancelbtn">Cancel</button>
                    <button type="button"
                        onclick="document.getElementById('deleteConfirm').style.display='none'; document.getElementById('form-delete').submit();"
                        class="deletebtn">Delete</button>
                </div>
            </div>
        </form>
    </div>


    <hr style="width: 50%">
    <!-- Appointment Treatement and  -->
    <div>
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

                    //Treatements
                    echo "<h3>Treatements</h3>";
                    $sql = "SELECT * FROM Treatment WHERE (healthCardID = \"".$_GET["healthCardID"]."\") AND (ClinicID = \"".$_GET["ClinicID"]."\") AND  (scheduledTime = \"".$_GET["scheduledTime"]."\")";       

                    $result = $conn->query($sql);
                      
                    if ($result->num_rows > 0) {

                        $status = $_GET['status'];
                        // output data of each row
                        echo "<table> <tr class='row treatment'> <th>Clinic ID</th> <th>HealthCard ID</th> <th>Scheduled Time</th> <th>DentalStaff ID</th> <th>Type</th> <th>Cost</th>";
                        echo $status == 'Upcoming' ? "<th></th>" : "";
                        echo "</tr>";

                        while($row = $result->fetch_assoc()) {
                            $clinicID = $row['clinicID'];
                            $healthCardID = $row['healthCardID'];
                            $scheduledTime = $row['scheduledTime'];
                            $type = $row['type'];

                            echo "<tr class='row treatment'><td>".$row["clinicID"]."</td><td>".$row["healthCardID"]."</td><td>".$row["scheduledTime"]."</td><td>".$row["dentalStaffID"]."</td><td>".$row["type"]."</td><td>".$row["cost"]."</td>";
                            echo $status == 'Upcoming' ? "<td><button class='del-btn' onclick=\"window.location = 'deleteTreatment.php?clinicID=$clinicID&healthCardID=$healthCardID&scheduledTime=$scheduledTime&type=$type'\">Delete</button></td></tr>": "</tr>";
                        }
                        echo "</table>";
                    }else{

                        echo "<div>No Treatments found</div>";
                    }
                        $healthCardID = $_GET["healthCardID"];
                        $clinicID = $_GET["ClinicID"];
                        $scheduledTime = $_GET["scheduledTime"];

                        $sql = "SELECT * FROM  AppointmentWith WHERE (healthCardID = $healthCardID) AND (clinicID = $clinicID) AND  (scheduledTime = '$scheduledTime')";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) { // has a dentist, needs to be able to add treatments
                          
                          $row = $result->fetch_assoc();
                    
                          $dentistID = $row['dentistID'];
                        
                          $sql = "SELECT employeeID, firstName, lastName FROM Employee WHERE employeeID = $dentistID OR employeeID IN (SELECT supervisedID FROM Supervision WHERE supervisorID = $dentistID)";
                          $result = $conn->query($sql);

                          if ($result->num_rows > 0) { 
                            echo $_GET['status'] === 'Upcoming' ? "<button class='new-dentist-btn' onClick='displayForm()'>Add Treatment</button>" : "";
                            echo "<form action='addTreatment.php?healthCardID=$healthCardID&clinicID=$clinicID&scheduledTime=$scheduledTime' method='POST' class='add'>
                                    <div class='add-form'>
                                        <span class='close' onClick='closeForm()'>&times;</span>
                                        <div class='grid-cell'>
                                            <label for='dentalStaffID'>Dental Staff</label>
                                            <select id='dentalStaffID' name='dentalStaffID' required style='margin-left: 20px;'>";

                            while($row = $result->fetch_assoc()) {
                                $dentalStaff = $row['employeeID'];
                                $name = $row['firstName'] . " " . $row['lastName'];
                                echo "<option value='$dentalStaff'>$name</option>";
                            }
                                            
                            echo "</select>
                            </div>
                                        <div class='grid-cell'>
                                            <label for='type'>Treatment Type</label>
                                            <select id='type' name='type' required>
                                              <option>Teeth Whitening</option>
                                              <option>Root Canal</option>
                                              <option>Extraction</option>
                                              <option>Gum Surgery</option>
                                              <option>Filling and Repair</option>
                                              <option>Dentures</option>
                                              <option>Braces</option>
                                            </select>
                                        </div>
                                        <div class='grid-cell'>
                                            <label for='cost'>Cost</label>
                                            <input id='cost' name='cost' type='number' placeholder='50.00' required min='10.00' max='10000.00' step='10.00'/>
                                        </div>
                                        <input id='submit' type='submit' value='Add Treatment'>
                                    </div>
                                </form>";
                            

                        }
                        
                    }else{
                        echo "<form action='addAppointmentWith.php' method='post' name='add-dent'>
                        <select id='dentistID' name='dentistID' required>
                        <option selected disabled value=''>Select a Dentist</option>";
                        $clinicID = $_GET["ClinicID"];
                        $dentistsAtClinic = "SELECT * from Employee where employeeID IN (SELECT employeeID from WorksAt WHERE clinicID = $clinicID) AND employeeID IN (SELECT dentistID FROM Dentist)";
                        $result = $conn->query($dentistsAtClinic);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $optionID = $row['employeeID'];
                                $optionName = $row['firstName'] . " " . $row['lastName'];
                                echo "<option value='$optionID'>$optionName</option>";
                            }
                        }

                        echo "</select>
                        <input type='hidden' name='clinicID' value='$clinicID'/>
                        <input type='hidden' name='scheduledTime' value='$scheduledTime'/>
                        <input type='hidden' name='healthCardID' value='$healthCardID'/>

                        <div><input type='submit' class='new-dentist-btn' value='Add a Dentist To Schedule Treatments'></input>
                        </div>
                        </form>";
                    }

                        
                        
                    

                    //Bills
                    if ($_GET['status'] != 'Upcoming') {
                        echo "<br><br><h3>Bill</h3>";
                        $sql = "SELECT * FROM Bill WHERE (healthCardID = \"".$_GET["healthCardID"]."\") AND (ClinicID = \"".$_GET["ClinicID"]."\") AND  (scheduledTime = \"".$_GET["scheduledTime"]."\")";
        
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // output data of each row
                            echo "<table> <tr class='row treatment'> <th>ClinicID</th> <th>healthCardID</th> <th>scheduledTime</th> <th>receptionistID</th> <th>amount</th> <th>receiptNumber</th> <th>status</th></tr>";

                            if ($row = $result->fetch_assoc()) {
                                $status = $row['status'];
                                echo "<tr class='row bill' onclick=\"window.location='\Billprofile.php?ClinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."';\"><td>" . $row["clinicID"] ."</td><td>" . $row["healthCardID"]. "</td><td>" . $row["scheduledTime"] . "</td><td>" . $row["receptionistID"] . "</td><td>" . $row["amount"] . "</td><td>" . $row["receiptNumber"] . "</td><td>" . $row["status"] . "</td></tr></a>";
                                
                                echo "</table>";
                                echo $status == 'Unpaid' ? "<button class='new-dentist-btn' onclick=\"window.location = 'payBill.php?clinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."&Appt=true';\">Pay Bill</button>": "";
                            }   
                        }else{

                            $receptionistQuery = "SELECT employeeID, firstName, lastName FROM Employee WHERE (employeeID IN (SELECT receptionistID FROM Receptionist)) AND (employeeID IN (SELECT employeeID from WorksAt WHERE clinicID = " . $_GET['ClinicID'] . "))";

                            $receptResult = $conn->query($receptionistQuery);
                            $status = $_GET['status'];

                            echo "<form action='createBill.php?clinicID=$clinicID&healthCardID=$healthCardID&scheduledTime=$scheduledTime&status=$status' method='POST'>
                                <label>Choose a Receptionist: </label>
                                <select id='receptionistID' name='receptionistID' required><option value='' disabled selected>Select One</option>";
                                while($row = $receptResult->fetch_assoc()) {
                                    $receptionistID = $row['employeeID'];
                                    $name = $row['firstName'] . " " . $row['lastName'];
                                    echo "<option value='$receptionistID'>$name</option>";
                                }
                            echo "</select>
                            <div>
                            <button class='new-dentist-btn' type='submit'>Create Bill</button>
                            </div>
                            </form>";
                        

                        
                           
                        }

                    }

                    echo "    <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i",
                    " class='fa fa-home' onclick=redirect('Home.php')></i>",
            "</div>";
                   
                }
            ?>
    </div>
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