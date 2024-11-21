<?php
// require_once "mariadb_connect.php";

    $severname = "";
    $username = "";
    $password = "";
    $dbname = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if($conn->connect_error){
        die("Could not connect" . $conn->connect_error);
    }

    echo "Connected successfully";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $formType = $_POST["form_type"];

        if($formType == "FORM_VALUE"){
            $query = "SELECT P.Title, S.Classroom, S.MeetingDays, S.BeginTime, S.EndTime FROM Professors P 
                      JOIN Section S ON P.SSN = S.PSSN WHERE P.SSN = " .$_POST[];
            $result = $conn->query($query);

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                printf("Professor Title: %s<br>\n", $row["ssn"]);
                $result->free_result();
            }
        }

        $conn->close();
    }
?>