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

        else {

            function generateCode($limit){
                $code = '';
                for($i = 0; $i < $limit; $i++) { $code .= mt_rand(0, 9); }
                return $code;
            }


            function randLetter()
            {
                $int = rand(0,25);
                $a_z = "abcdefghijklmnopqrstuvwxyz";
                $rand_letter = $a_z[$int];
                return $rand_letter;
            }

            function getRandom() {
                return strtoupper(randLetter() . randLetter() . randLetter() . "") . generateCode(10);
            }

            function checkUnique($num, $conn) {
                $query = "SELECT * FROM Bill WHERE receiptNumber = '$num'";

                $result = $conn->query($query);
                return $result->num_rows == 0;
            }

            function getReceiptNumber($conn) {
                $num = getRandom();
                while (!checkUnique($num, $conn)) {
                $num = getRandom();
                }
                return $num;

            }


            $clinicID = $_GET['clinicID'];
            $healthCardID = $_GET['healthCardID'];
            $scheduledTime = $_GET['scheduledTime'];
            $receptionistID = $_POST['receptionistID'];
            $treatmentsQuery = "SELECT SUM(cost) as amount FROM Treatment WHERE clinicID = $clinicID AND healthCardID = $healthCardID AND scheduledTime = '$scheduledTime'";

            $status = $_GET['status'];

            $amount = $status == 'Completed' ? $conn->query($treatmentsQuery)->fetch_assoc()['amount'] : 20.00;
            $receiptNumber = getReceiptNumber($conn);
            $createBill = "INSERT INTO Bill VALUES ($clinicID, '$healthCardID', '$scheduledTime', $receptionistID, $amount, '$receiptNumber', 'Unpaid')";

            $success = $conn->query($createBill);
            if ($success) {
                echo "<script>window.location = '" . "Appointmentprofile.php?ClinicID=$clinicID&healthCardID=$healthCardID&scheduledTime=$scheduledTime" . "'</script>";
            }

            else {
                echo "Error: " , $conn->error;
            }

            




        }


        ?>