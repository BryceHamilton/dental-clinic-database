<!DOCTYPE html>

<head>
    <title>Patient page - work in progress </title>
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
    <link rel='stylesheet' type='text/css' href='dentists.css' />
    <link rel='stylesheet' type='text/css' href='dentist.css' />
</head>

<body>

    <!--Search Box-->
    <div>
        <form action="Patient.php" method="GET" id="SearchForm">
            <!--Search input-->
            <input id="Seach_input" name="Seach_input" type="text" placeholder="Search">
            <input id="submit" type="submit" value="search">

            <!--Search by-->
            <label> by </label>
            <select id="Searchby" name="option" form="SearchForm">
                <option value="Name">Name</option>
                <option value="healthCardID">healthCardID</option>
                <option value="Address">Address</option>
            </select>
        </form>
    </div>


    <!--Result-->
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
                    
                    if (isset($_GET["Seach_input"]) And $_GET["Seach_input"] != "" ){ //Search Patient 

                        switch ($_GET["option"]) { // by
                            case "healthCardID":
                                $sql = "SELECT * FROM Patient WHERE (healthCardID LIKE \"".$_GET["Seach_input"]."%\")";
                                break;
                            case "Name":
                                $sql = "SELECT * FROM Patient WHERE (firstName LIKE \"".$_GET["Seach_input"]."%\" ) OR (lastName LIKE \"". $_GET["Seach_input"]."%\" )";
                                break;
                            case "Address":
                                $sql = "SELECT * FROM Patient WHERE (`address` LIKE \"".$_GET["Seach_input"]."%\")";
                            break;
                        }
                    }else{ //else print all Patient
                        $sql = "SELECT * FROM Patient";
                    }
                    
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        echo "<table> <tr> <th>healthCardID</th> <th>Name</th> <th>Address</th> </tr>";

                        while($row = $result->fetch_assoc()) {
                            echo "<tr onclick=\"window.location='\Patientprofile.php?Patient=".$row["healthCardID"]."&Name=".$row["firstName"]."&LastName=".$row["lastName"]."&address=".$row["address"]."&Edit=false';\"><th>".$row["healthCardID"]."</th><th>".$row["firstName"]." ".$row["lastName"]."</th><th>".$row["address"]."</th></tr></a>";
                        }
                        echo "</table>";
                    }else{
                        echo "No Patient found";
                    }
                }
            ?>
    </div>


</body>

</html>