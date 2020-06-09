<?php

$servername = "localhost";
$username = "westchn1_admin";
$password = "Keeponpunching127!";
$dbname = "westchn1_contactForm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



//Scrub incoming Data for Injection Characters
function input_scrub($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

//Holds Scrubbed variables
$name = input_scrub($_POST["name"]);
$email = input_scrub($_POST["email"]);
$cellPhone = input_scrub($_POST["cellPhone"]);
$message = input_scrub($_POST["message"]);

// use wordwrap() if lines are longer than 70 characters
$msg = "This person reached out via website contact form. \nPlease contact as soon as possible. \n\nName: $name \nCellPhone: $cellPhone \nMessage: $message";

$msg = wordwrap($msg,70);

//Setup SQL statement for insert
$sql = "INSERT INTO messages (name, email, cellPhone, message)
VALUES ('$name', '$email', '$cellPhone', '$message')";

//Execute Query
if ($conn->query($sql) === TRUE) {
  
    $to = "westchesterboxingclub@gmail.com";
    $subject = "Website Contact Form";
    $headers = "From: wbc-johnny-5-bot@westchesterboxing.com";

    // send email
    mail($to, $subject, $msg, $headers);

    echo "Your Message Has Been Sent";

} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>