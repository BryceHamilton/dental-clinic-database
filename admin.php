<!DOCTYPE html>
    <head>
        <title>Admin</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
     
        <?php 
            if(isset($_POST["username"]) && isset($_POST["password"]) && ($_POST["username"] == "Admin" && $_POST["password"] == "DBApass$") ){
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
                        $out = "";
                        if(isset($_POST["ConsoleInput"])){
                            $sql = "".$_POST["ConsoleInput"].""; 
                            if(!($sql == "")){   
                                $result = $conn->query($sql);
                                if($result){
                                    while($row = $result->fetch_assoc()) {
                                        $out = $out.implode(" | ", $row)."\n";
                                    }
                                }else{
                                    $out = "".$conn->error;
                                }
                            }
                        }
                        // terminal
                        echo "<div id=\"terminal\">";
                        echo "<h2>Database terminal</h2>";
                        echo "<form id=\"TerminalForm\" action=\"\" method=\"post\">";
                        echo "<input type=\"hidden\" id=\"username\" name=\"username\" value=\"Admin\">";
                        echo "<input type=\"hidden\" id=\"password\" name=\"password\" value=\"DBApass$\">";
                        echo "<textarea rows=\"15\" cols=\"100\" name=\"Console\" style=\"resize: none\" readonly >".$out."</textarea><br>";
                        echo "<textarea rows=\"1\" cols=\"100\" id=\"ConsoleInput\" name=\"ConsoleInput\"  form=\"TerminalForm\" style=\"resize: none\"></textarea>";
                        echo "<input type=\"submit\" value=\"RUN\">";
                        echo "</form>";
                        echo "</div>";
                }
            }else{
                // Login in panel
                echo "<div id='Loginpanel'>";
                echo "<h2>Admin panel</h2>";
                echo "<form id=\"LoginForm\" action=\"\" method=\"post\">";
                echo "<label>username: </label>";
                echo "<input type=\"text\" id=\"username\" name=\"username\"><br><br>";
                echo "<label>password: </label>";
                echo "<input type=\"password\" id=\"password\" name=\"password\"><br><br>";
                echo "<input type=\"submit\" value=\"Login\">";
                echo "</form>";
                echo "</div>";
            }

            echo "    <div class='center' style='margin: 10px; font-size: 32px; color: #4caf50 !important; cursor: pointer'><i",
            " class='fa fa-home' onclick='window.location = \"Home.php\"')></i>",
    "</div>";
        ?>
    </body>
</html>