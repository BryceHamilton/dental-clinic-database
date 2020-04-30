<!DOCTYPE html>

<head>
    <title>Patient Profile</title>
    <link rel='stylesheet' type='text/css' href='hover.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        
    table,
    th,
    td {
        /* border: 1px solid black; */
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
                //update
                if( isset($_POST["EditName"]) && isset($_POST["EditName"]) && isset($_POST["EditLastName"]) && isset($_POST["EdithealthCardID"]) && isset($_POST["Editaddress"])) {
                
                    $sql = "UPDATE Patient Set healthCardID = \"".$_POST["EdithealthCardID"]."\", firstName = \"".$_POST["EditName"]."\", lastName =  \"".$_POST["EditLastName"]."\", address = \"".$_POST["Editaddress"]."\" WHERE healthCardID = \"".$_GET["Patient"]."\"";
                    $conn->query($sql);
                    echo "<script> window.location.href  = \"Patientprofile.php?Patient=".$_POST["EdithealthCardID"]."&Name=".$_POST["EditName"]."&LastName=".$_POST["EditLastName"]."&address=".$_POST["Editaddress"]."&Edit=false\"; </script>;";
                //delete
                }elseif(isset($_POST["delete"])){
                    $sql = "DELETE FROM Patient WHERE healthCardID = \"".$_GET["Patient"]."\"";
                    $result = $conn->query($sql);
                    echo "<script> window.location.href  = \"Patients.php\"; </script>";
                }elseif(isset($_GET["Patient"]) && !isset($_GET["Name"])){
                //fetch details  
                    $sql = "SELECT * FROM Patient WHERE healthCardID = \"".$_GET["Patient"]."\"";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo "<script> window.location.href  = 'Patientprofile.php?Patient=".$row["healthCardID"]."&Name=".$row["firstName"]."&LastName=".$row["lastName"]."&address=".$row["address"]."'; </script>";
                }
                
                $healthCardID = $_GET['Patient'];
                $findMissedAppt = "SELECT COUNT(*) as numOfMissed FROM Appointment WHERE healthCardID = $healthCardID AND status = 'Missed';";
                $result = $conn->query($findMissedAppt);
                $numOfMissed = $result->fetch_assoc()['numOfMissed'];


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
    <!-- Patient details -->
    <div id="DisplayDetails" style="border-style: solid; width: 50%">
        <?php
                echo "<h2>".$_GET["Name"]." ".$_GET["LastName"]."</h2>";
                echo "<br>";
                echo "<label>healthCardID: </label><br><label>".$_GET["Patient"]."</label><br><br><label>Address:</label><address>".$_GET["address"]."</address>";
                echo "<span class=\"button edit\" onclick='Edit()'>edit</span>";
        ?>
        <br>
    </div>
    <!-- Patient Edit form -->
    <div id="EditDetails" style="border-style: solid; width: 50%; display: none">
        <?php
                echo "<form id=\"PatientChange\"action=\"\" method=\"post\">";
                echo "<br>";
                echo "<label>First name:</label>";
                echo "<input type=\"text\" id=\"EditName\" name=\"EditName\" value=\"".$_GET["Name"]."\"><br><br>";
                echo "<label>Last name:</label>";
                echo "<input type=\"text\" id=\"EditLastName\" name=\"EditLastName\" value=\"".$_GET["LastName"]."\"><br><br>";
                echo "<label>healthCardID: </label>";
                echo "<input type=\"text\" id=\"EdithealthCardID\" name=\"EdithealthCardID\" value=\"".$_GET["Patient"]."\"><br><br>";
                echo "<label>Adresse:</label>";
                echo "<input type=\"text\" id=\"Editaddress\" name=\"Editaddress\" value=\"".$_GET["address"]."\"><br><br>";
                echo "<span class=\"button save\" onclick='Edit(); document.getElementById(\"PatientChange\").submit();'>save</span>";
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
    <!-- Patient Appointment and bill -->
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

                    //Appointments
                    echo "<h3>Appointments</h3>";
                    $sql = "SELECT * FROM Appointment WHERE (healthCardID = \"".$_GET["Patient"]."\")";       
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        echo "<table> <tr class='row'> <th>ClinicID</th> <th>healthCardID</th> <th>scheduledTime</th> <th>status</th> <th>note</th> </tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='row' onclick=\"window.location='\Appointmentprofile.php?ClinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."';\"><td>".$row["clinicID"]."</td><td>".$row["healthCardID"]."</td><td>".$row["scheduledTime"]."</td><td>".$row["status"]."</td><td>".$row["note"]."</td></tr></a>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Appointment found";
                    }

                    if ($numOfMissed > 0) {

                        echo "<br /> Number of Missed Appointments: " , $numOfMissed;
                    }

                    //Bills
                    echo "<br><br><h3>Bills</h3>";
                    $sql = "SELECT * FROM Bill WHERE (healthCardID = \"".$_GET["Patient"]."\")";       
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        echo "<table> <tr class='row'> <th>ClinicID</th> <th>healthCardID</th> <th>scheduledTime</th> <th>receptionistID</th> <th>amount</th> <th>receiptNumber</th> <th>status</th> </tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='row' onclick=\"window.location='\Billprofile.php?ClinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."';\"><td>" . $row["clinicID"] ."</td><td>" . $row["healthCardID"]. "</td><td>" . $row["scheduledTime"] . "</td><td>" . $row["receptionistID"] . "</td><td>" . $row["amount"] . "</td><td>" . $row["receiptNumber"] . "</td><td>" . $row["status"] . "</td></tr></a>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Appointment found";
                    }
                }
                echo "    <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i",
                " class='fa fa-home' onclick='window.location = \"Home.php\"')></i>",
        "</div>";
            ?>
    </div>
</body>

</html>