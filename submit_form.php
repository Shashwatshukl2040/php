<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "valorque";
    $password = "Valor@123";
    $dbname = "valorque_registrations";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $teamname = $_POST['teamname'];
    $phone = $_POST['phone'];
    $college = $_POST['college'];
    $email = $_POST['email'];
    $upi_id = $_POST['upi_id'];
    $transaction_id = $_POST['transaction'];
    $member1 = $_POST['member1'];
    $member2 = $_POST['member2'];
    $member3 = $_POST['member3'];
    $member4 = $_POST['member4'];
    $member5 = $_POST['member5'];
    $smember = isset($_POST['member']) ? $_POST['member'] : '';

    // Check if the user is already registered
    $email = mysqli_real_escape_string($conn, $email);
    $check_sql = "SELECT id FROM registrations WHERE email='$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "You are already registered.";
        $conn->close();
        exit;
    }

    // Determine if it's a team registration
    $is_team = isset($_POST['team']) && $_POST['team'] == 'team' ? 1 : 0;

    // SQL injection prevention
    $teamname = mysqli_real_escape_string($conn, $teamname);
    $phone = mysqli_real_escape_string($conn, $phone);
    $college = mysqli_real_escape_string($conn, $college);
    $email = mysqli_real_escape_string($conn, $email);
    $upi_id = mysqli_real_escape_string($conn, $upi_id);
    $transaction_id = mysqli_real_escape_string($conn, $transaction_id);
    $member1 = mysqli_real_escape_string($conn, $member1);
    $member2 = mysqli_real_escape_string($conn, $member2);
    $member3 = mysqli_real_escape_string($conn, $member3);
    $member4 = mysqli_real_escape_string($conn, $member4);
    $member5 = mysqli_real_escape_string($conn, $member5);
    $smember = mysqli_real_escape_string($conn, $smember);
    $target_file = isset($_POST['screenshot']) ? $_POST['screenshot'] : '';

    // Insert data into registrations table
    $sql = "INSERT INTO registrations (teamname, phone, college, email, upi_id, transaction_id, is_team, member1, member2, member3, member4, member5, smember, screenshot)
            VALUES ('$teamname', '$phone', '$college', '$email', '$upi_id', '$transaction_id', '$is_team', '$member1', '$member2', '$member3', '$member4', '$member5', '$smember', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        // Email sending block
        $to = $email;
        $subject = "Registration Successful";
        $message = "Dear $teamname,\n\nYour registration for the event has been successful.\n\nThank you!";
        $headers = "From: info@valorquest.in" . "\r\n" .
            "CC: info@valorquest.in";

        mail($to, $subject, $message, $headers);

        // Redirect to success page
        header("Location: success.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
