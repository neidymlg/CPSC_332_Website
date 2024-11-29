<?php
    //Connecting to server
    //REMINDER: CHANGE THIS BEFORE SUBMISSION (The one I used was a wamp so this is not going to look like the discord pic)
    $servername = "localhost";
    $username = "root";
    $password = '';
    $dbname = "college";
    $port = 3307;
    
    // $servername = "mariadb";
    // $username = "cs332h13";
    // $password = "B9UaM29z";
    // $dbname = "cs332h13";
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if($conn->connect_error){
        die("Could not connect" . $conn->connect_error);
    }

    //Since we are processing in one php file, please use value name to differentiate
    //Also use conn->prepare, bind_param, execute for safer sqli injections 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $formType = $_POST["form_type"];

        switch ($formType) {
        case "Professor_Info": {
            $stmt = $conn->prepare("SELECT P.Title, S.Classroom, S.MeetingDays, S.BeginTime, S.EndTime
            FROM Professors P 
            JOIN Section S ON P.SSN = S.PSSN
            WHERE P.SSN = ?;");
            $stmt->bind_param("i", $_POST["ssn"]);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                printf("Professor Title: %s<br>\n", $row["Title"]);
                printf("Classroom: %s<br>\n", $row["Classroom"]);
                printf("Meeting Days: %s<br>\n", $row["MeetingDays"]);
                printf("Start Time: %s<br>\n", $row["BeginTime"]);
                printf("End Time: %s<br><br>\n", $row["EndTime"]);

                while ($row = $result->fetch_assoc()) {
                    printf("Classroom: %s<br>\n", $row["Classroom"]);
                    printf("Meeting Days: %s<br>\n", $row["MeetingDays"]);
                    printf("Start Time: %s<br>\n", $row["BeginTime"]);
                    printf("End Time: %s<br><br>\n", $row["EndTime"]);
                }
                $result->free_result();
            }
            else{
                echo "This is not a valid SSN\n";
            }
            break;
        }
        case "P_Grade_Count": {
            $stmt = $conn->prepare("SELECT E.Grade, Count(*) AS 'Grade Count' 
            FROM Enrollment E 
            WHERE E.CID = ? AND E.SID = ? 
            GROUP BY E.Grade 
            ORDER BY E.Grade;");
            $stmt->bind_param("ii", $_POST["cno"], $_POST["sno"]);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {
                    printf("Grade: %s<br>\n", $row["Grade"]);
                    printf("Grade Count: %s<br><br>\n", $row["Grade Count"]);
                }
                $result->free_result();
            }
            else{
                echo "This is not a valid Section and/or Course Number\n";
            }
            break;
        }
        default:
            break;
        }
    }

    //connection closed
    $conn->close();
?>