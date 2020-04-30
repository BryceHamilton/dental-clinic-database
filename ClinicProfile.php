<!DOCTYPE html>

<head>
    <title>Clinic Profile</title>
    <link rel='stylesheet' type='text/css' href='ClinicProfile.css' />
    <link rel='stylesheet' type='text/css' href='hover.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
    .data-row:hover {
    cursor: pointer;
    
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

    .Clickable {
        cursor: pointer;
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
                
                $clinicID = $_GET['clinicID'];
                $clinicQuery = "SELECT * FROM Clinic WHERE clinicID = $clinicID;";
                $dentistResult = $conn->query($clinicQuery);
                if ($dentistResult->num_rows > 0) {
                if ($row = $dentistResult->fetch_assoc()) {
                    $clinicName = $row['clinicName'];
                    $clinicID = $row['clinicID'];
                    $address = $row['address'];
                    
                }

                // update
                if( isset($_POST["EditName"]) && isset($_POST["EditName"]) && isset($_POST["EditLastName"]) && isset($_POST["EdithealthCardID"]) && isset($_POST["Editaddress"])) {
                    $sql = "UPDATE Dentist Set = \"".$_POST["EdithealthCardID"]."\", firstName = \"".$_POST["EditName"]."\", lastName =  \"".$_POST["EditLastName"]."\", address = \"".$_POST["Editaddress"]."\" WHERE healthCardID = \"".$_GET["Patient"]."\"";
                    $conn->query($sql);
                    echo "<script> window.location.href  = \"https://users.encs.concordia.ca/~vuc353_4/Patientprofile.php?Patient=".$_POST["EdithealthCardID"]."&Name=".$_POST["EditName"]."&LastName=".$_POST["EditLastName"]."&address=".$_POST["Editaddress"]."&Edit=false\"; </script>;";
                // delete
                }elseif(isset($_POST["delete"])){
                    $sql = "DELETE FROM Dentist WHERE dentistID = '$dentistID'";
                    $result = $conn->query($sql);
                    echo "<script> location.replace('Dentists.php') </script>";
                }  
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
                echo "<h2> $clinicName </h2>";
                echo "<br>";
                echo "<label>Clinic ID: </label><br><label> $clinicID </label><br><br><label>Address:</label><address>$address</address><br>";
                echo "<span class=\"button edit\" onclick='Edit()'>edit</span>";
        ?>
        <br>
    </div>
    <!-- Dentist Edit form -->
    <div id="EditDetails" style="border-style: solid; width: 50%; display: none">
        <?php
                echo "<form id=\"PatientChange\" action='editClinic.php' method=\"post\">";
                echo "<br>";
                echo "<label>Clinic Name:</label>";
                echo "<input type='text' id='clinicName' name='clinicName' value='$clinicName'><br><br>";
                echo "<label>Clinic ID: </label>";
                echo "<input type='text' id='clinicID' name='clinicID' value='$clinicID'><br><br>";
                echo "<label>Address: </label>";
                echo "<input type='text' id='address' name='address' value='$address'><br><br>";

                echo "<span class='button save' onclick=\"Edit(); document.getElementById('PatientChange').submit();\">save</span>";
                echo "<span class='button discard' onclick='Edit()'>discard</span>";
                echo "<span class='button delete' onclick='document.getElementById('deleteConfirm').style.display='block';'>delete</span>";
                echo "</form>"
        ?>
        <br>
    </div>

    <!-- confirm delete -->
    <div id="deleteConfirm" class="modal">
        <span onclick="document.getElementById('deleteConfirm').style.display='none'" class="close">×</span>
        <form class="modal-content" action="/action_page.php">
            <div class="container">
                <h1>Delete Clinic</h1>
                <p>Are you sure you want to delete this Clinic?</p>
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
    <!-- Patient Appointment and bill -->
    <div>
        <?php
                    $date = new DateTime(); // Date object using current date and time
                    $from_dt = $date->format('Y-m-d\TH:i:s');
                    $one_week = DateInterval::createFromDateString('1 week');
                    $date->add($one_week); 
                    $to_dt = $date->format('Y-m-d\TH:i:s');
                    echo "<h3>Appointments</h3>";
                    echo "<form id=\"filterTime\"action=\"\" method=\"post\">";
                    echo "<label>from:</label>";
                    echo "<input type=\"datetime-local\" id=\"fromTime\" name=\"fromTime\" value='$from_dt' required>";
                    echo "<label> to:</label>";
                    echo "<input type=\"datetime-local\" id=\"toTime\" name=\"toTime\" value='$to_dt' required>";
                    echo "<span class='Clickable' onclick='document.getElementById(\"filterTime\").submit();'>↻</span>";
                    echo "</form><br>";

                    if(isset($_POST["fromTime"]) && isset($_POST["toTime"])){
                        $from = str_replace("T"," ","".$_POST["fromTime"]."").":00";
                        $to = str_replace("T"," ","".$_POST["toTime"]."").":00";
                        $sql = "SELECT * FROM AppointmentWith NATURAL JOIN Appointment WHERE scheduledTime BETWEEN '$from' AND '$to' AND clinicID = $clinicID";
                    }else{
                        $sql = "SELECT * FROM AppointmentWith NATURAL JOIN Appointment WHERE clinicID = $clinicID";
                    } 
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        echo "<table> <tr class='row'><th>healthCardID</th> <th>scheduledTime</th> <th>status</th> <th>note</th> </tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='row data-row' onclick=\"window.location='\Appointmentprofile.php?ClinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."';\"><td>".$row["healthCardID"]."</td><td>".$row["scheduledTime"]."</td><td>".$row["status"]."</td><td>".$row["note"]."</td></tr></a>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Appointment found";
                    }

                    // Bills
                    echo "<br><br>",
                    "<div style='display: flex;'><div><h3>Bills</h3>",
                     "<button class='new-dentist-btn' onClick=redirect('Bills.php?clinicID=$clinicID')>Clinic Bills</button></div>";
                     
                     echo "    <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i",
                     " class='fa fa-home' onclick='window.location = \"Home.php\"')></i>",
             "</div>";
            ?>
    <div>
        <h3>Employees</h3>
        <button class='new-dentist-btn' onClick="redirect('Employees.php?clinicID=<?echo $clinicID;?>')">Clinic
                Employees</button></div></div>
            </div>
    <script>
    const redirect = url => {
        location.replace(url)
    }
    </script>
</body>

</html>