<!DOCTYPE html>

<head>
    <title>Appointment</title>
    <style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px
    }

    div {
        padding: 10px
    }
    </style>
</head>

<body>
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
                    
                    $sql = "SELECT * FROM Appointment";
                    
                    if (isset($_GET["Patient"]) && $_GET["Patient"] != "" ){ // Search Patient 
                        $sql .= " WHERE (healthCardID = \"".$_GET["Patient"]."\")";    
                    }

                    elseif (isset($_GET['clinic']) && $_GET['clinic'] != "") {
                        $sql .= " WHERE (clinicID = \"".$_GET["clinic"]."\")";
                    }
                    
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // check if Patient or Clinic
                        
                        // output data of each row
                        echo "<table> <tr> <th>ClinicID</th> <th>healthCardID</th> <th>scheduledTime</th> <th>status</th> <th>note</th> </tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr onclick=\"window.location='.\Patientprofile.php?Patient=".$row["healthCardID"]."&more=true';\"><th>" . $row["clinicID"] ."</th><th>" . $row["healthCardID"]. "</th><th>" . $row["scheduledTime"] . "</th><th>" . $row["status"] . "</th><th>" . $row["note"] . "</th></tr></a>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Appointment found";
                    }
                }
            ?>
    </div>
</body>

</html>