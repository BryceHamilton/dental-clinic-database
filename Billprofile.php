<!DOCTYPE html>
    <head>
        <title>Bill Profile</title>
        <link rel='stylesheet' type='text/css' href='hover.css' />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
        .treatment:hover {
            cursor: auto;
        }
            table, th, td {  border-collapse: collapse; padding: 10px}
            hr {margin: 0px; margin-top: 40px; margin-left: 10px}
            input {margin-left: 20px}
            div {padding: 10px}
            input:invalid {border: red solid 3px;}
            .button {color: white; padding: 5px; cursor: pointer;}
            .edit {background-color: #e7e7e7; color: black; float: right;} 
            .delete {background-color: #f44336; float: right;}
            .save {background-color: #4CAF50; float: right;}
            .discard {background-color: #ff9800; float: right;} 
            .centerDiv { width: 60%; height:200px; border-color: black; float: center}
            .modal {display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(71,78,93,0.6); padding-top: 50px; margin: 0 auto;}
            .modal-content {background-color: #fefefe; margin: 5% auto 15% auto; border: 1px solid #888; width: 30%;}
            .close {position: absolute; right: 35px; top: 15px; font-size: 40px; font-weight: bold; color: #f1f1f1}
         
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

.data-row:hover {
    cursor: pointer;
    
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
                if( isset($_POST["EditreceptionistID"]) && isset($_POST["Editamount"]) && isset($_POST["EditreceiptNumber"]) && isset($_POST["Editstatus"])) {
                    //update
                    $sql = "UPDATE Bill Set receptionistID = \"".$_POST["EditreceptionistID"]."\", amount = \"".$_POST["Editamount"]."\", receiptNumber =  \"".$_POST["EditreceiptNumber"]."\", status = \"".$_POST["Editstatus"]."\" WHERE healthCardID = \"".$_GET["healthCardID"]."\" AND ClinicID = \"".$_GET["ClinicID"]."\" AND scheduledTime = \"".$_GET["scheduledTime"]."\"";
                    $result = $conn->query($sql);
                    echo "<script> window.location.href  = '\Billprofile.php?ClinicID=".$_GET["ClinicID"]."&healthCardID=".$_GET["healthCardID"]."&scheduledTime=".$_GET["scheduledTime"]."';</script>";
                }elseif(isset($_POST["delete"])){
                    //delete
                    $sql = "DELETE FROM Bill WHERE healthCardID = \"".$_GET["healthCardID"]."\" AND ClinicID = \"".$_GET["ClinicID"]."\" AND scheduledTime = \"".$_GET["scheduledTime"]."\"";
                    $result = $conn->query($sql);
                    echo "<script> window.location  = \"/Bills.php\"; </script>";
                }elseif(isset($_GET["ClinicID"]) && isset($_GET["healthCardID"]) && isset($_GET["scheduledTime"]) && !isset($_GET["status"])){
                    //fetch details
                    $sql = "SELECT * FROM Bill WHERE healthCardID = \"".$_GET["healthCardID"]."\" AND ClinicID = \"".$_GET["ClinicID"]."\" AND scheduledTime = \"".$_GET["scheduledTime"]."\"";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo "<script> window.location.href  = '\Billprofile.php?ClinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."&status=".$row["status"]."&receptionistID=".$row["receptionistID"]."&amount=".$row["amount"]."&receiptNumber=".$row["receiptNumber"]."'; </script>";
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
    <!-- Bill details -->
    <div id="DisplayDetails" style="border-style: solid; width: 50%">
        <?php
                echo "<label>Clinic ID: </label><label>".$_GET["ClinicID"]."</label><br>";
                echo "<label>Patient healthCardID: </label><label>".$_GET["healthCardID"]."</label><br>";
                echo "<label>ScheduledTime: </label><label>".$_GET["scheduledTime"]."</label><br><br>";
                echo "<label>ReceptionistID: </label><label>".$_GET["receptionistID"]."</label><br>";
                echo "<label>Amount: </label><label>".$_GET["amount"]."</label><br>";
                echo "<label>ReceiptNumber: </label><label>".$_GET["receiptNumber"]."</label><br><br>";
                echo "<label>Status: </label><label>".$_GET["status"]."</label><br>";
                // echo "<span class=\"button edit\" onclick='Edit()'>edit</span>";
        ?>
        <br>
    </div>
    <!-- Bill Edit form -->
    <div id="EditDetails" style="border-style: solid; width: 50%; display: none">
        <?php
                echo "<form id=\"BillChange\"action=\"\" method=\"post\">";
                echo "<br>";
                //none editable (edit appoitment and change will cascade)
                echo "<label>Clinic ID: </label><label>".$_GET["ClinicID"]."</label><br>";
                echo "<label>Patient healthCardID: </label><label>".$_GET["healthCardID"]."</label><br>";
                echo "<label>ScheduledTime: </label><label>".$_GET["scheduledTime"]."</label><br><br>";
                //edit
                echo "<label>ReceptionistID: </label>";
                echo "<input type=\"text\" id=\"EditreceptionistID\" name=\"EditreceptionistID\" value=\"".$_GET["receptionistID"]."\"><br><br>";
                echo "<label>Amount: </label>";
                echo "<input type=\"text\" id=\"Editamount\" name=\"Editamount\" value=\"".$_GET["amount"]."\"><br><br>";
                echo "<label>ReceiptNumber: </label>";
                echo "<input type=\"text\" id=\"EditreceiptNumber\" name=\"EditreceiptNumber\"  value=\"".$_GET["receiptNumber"]."\" pattern=\"[A-Z]{3}[0-9]{10}\"><br><br>";
                echo "<label>Status: </label><select id=\"Editstatus\" name=\"Editstatus\"><option value=\"Paid\">Paid</option><option value=\"Unpaid\">Unpaid</option></select><br><br>";
                echo "<span class=\"button save\" onclick='Edit(); document.getElementById(\"BillChange\").submit();'>save</span>";
                echo "<span class=\"button discard\" onclick='Edit()'>discard</span>";
                echo "<span class=\"button delete\" onclick=\"document.getElementById('deleteConfirm').style.display='block';\">delete</span>";
                echo "</form>";
        ?>
        <br>
    </div>

    <!-- confirm delete -->        
    <div id="deleteConfirm" class="modal">
        <span onclick="document.getElementById('deleteConfirm').style.display='none'" class="close" >×</span>
        <form class="modal-content" action="/action_page.php">
            <div class="container">
                <h1>Delete Patient</h1>
                <p>Are you sure you want to delete this patient?</p>
                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('deleteConfirm').style.display='none'" class="cancelbtn">Cancel</button>
                    <button type="button" onclick="document.getElementById('deleteConfirm').style.display='none'; document.getElementById('form-delete').submit();" class="deletebtn">Delete</button>
                </div>
             </div>
       </form>
    </div>        


    <hr style="width: 50%">
    <!-- Bill Appointment and Treatments -->
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
                    echo "<h3>Appointment</h3>";
                    $sql = "SELECT * FROM Appointment WHERE (healthCardID = \"".$_GET["healthCardID"]."\") AND (ClinicID = \"".$_GET["ClinicID"]."\") AND  (scheduledTime = \"".$_GET["scheduledTime"]."\")";       
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        echo "<table> <tr class='row'> <th>ClinicID</th> <th>healthCardID</th> <th>scheduledTime</th> <th>status</th> <th>note</th> </tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='row data-row'onclick=\"window.location='\Appointmentprofile.php?ClinicID=".$row["clinicID"]."&healthCardID=".$row["healthCardID"]."&scheduledTime=".$row["scheduledTime"]."';\"><td>".$row["clinicID"]."</td><td>".$row["healthCardID"]."</td><td>".$row["scheduledTime"]."</td><td>".$row["status"]."</td><td>".$row["note"]."</td></tr></a>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Appointment found";
                    }

                    //Treatements
                    echo "<h3>Treatements</h3>";
                    $sql = "SELECT * FROM Treatment WHERE (healthCardID = \"".$_GET["healthCardID"]."\") AND (ClinicID = \"".$_GET["ClinicID"]."\") AND  (scheduledTime = \"".$_GET["scheduledTime"]."\")";       

                    $result = $conn->query($sql);
                      
                    if ($result->num_rows > 0) {
                        // output data of each row
                        echo "<table> <tr class='row'> <th>ClinicID</th> <th>healthCardID</th> <th>scheduledTime</th> <th>dentalStaffID</th> <th>type</th> <th>cost</th></tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='row treatment'><td>".$row["clinicID"]."</td><td>".$row["healthCardID"]."</td><td>".$row["scheduledTime"]."</td><td>".$row["dentalStaffID"]."</td><td>".$row["type"]."</td><td>".$row["cost"]."</td></tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Treatments found";
                    }

                    echo $_GET['status'] == 'Unpaid' ? "<div><button class='new-dentist-btn' onclick=\"window.location = 'payBill.php?clinicID=".$_GET["ClinicID"]."&healthCardID=".$_GET["healthCardID"]."&scheduledTime=".$_GET["scheduledTime"]."';\">Pay Bill</button></div>": "";
                }
                echo "    <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i",
                " class='fa fa-home' onclick='window.location = \"Home.php\"')></i>",
        "</div>";
            ?>  
        </div>
    </body>
    </html>