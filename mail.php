<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit;
}

function clean_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, "UTF-8");
}

function is_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

$form_name = isset($_POST["form_name"]) ? clean_input($_POST["form_name"]) : "";
$email = isset($_POST["email"]) ? clean_input($_POST["email"]) : "";
$phone = isset($_POST["phone"]) ? clean_input($_POST["phone"]) : "";
$no_of_persons = isset($_POST["no_of_persons"]) ? clean_input($_POST["no_of_persons"]) : "";
$date_picker = isset($_POST["date-picker"]) ? clean_input($_POST["date-picker"]) : "";
$time_picker = isset($_POST["time-picker"]) ? clean_input($_POST["time-picker"]) : "";
$preferred_food = isset($_POST["preferred_food"]) ? clean_input($_POST["preferred_food"]) : "";
$occasion = isset($_POST["occasion"]) ? clean_input($_POST["occasion"]) : "";

if ($form_name === "") {
    echo '<div class="error_message">Attention! You must enter your name.</div>';
    exit;
}

if ($email === "") {
    echo '<div class="error_message">Attention! Please enter your email address.</div>';
    exit;
}

if (!is_email($email)) {
    echo '<div class="error_message">Attention! You entered an invalid email address.</div>';
    exit;
}

if ($phone === "") {
    echo '<div class="error_message">Attention! Please enter your phone number.</div>';
    exit;
}

if ($date_picker === "") {
    echo '<div class="error_message">Attention! Please enter your reservation date.</div>';
    exit;
}

if ($time_picker === "") {
    echo '<div class="error_message">Attention! Please enter your reservation time.</div>';
    exit;
}

/*
|--------------------------------------------------------------------------
| Change this email
|--------------------------------------------------------------------------
| This is where reservation messages will be sent.
*/
$address = "nameNyo@gmail.com";

$subject = "New reservation request from " . $form_name;

$message = "New reservation request" . PHP_EOL . PHP_EOL;
$message .= "Name: " . $form_name . PHP_EOL;
$message .= "Email: " . $email . PHP_EOL;
$message .= "Phone: " . $phone . PHP_EOL;
$message .= "Number of Persons: " . $no_of_persons . PHP_EOL;
$message .= "Date: " . $date_picker . PHP_EOL;
$message .= "Time: " . $time_picker . PHP_EOL;
$message .= "Preferred Food: " . $preferred_food . PHP_EOL;
$message .= "Occasion: " . $occasion . PHP_EOL;

$headers = "From: " . $email . PHP_EOL;
$headers .= "Reply-To: " . $email . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-Type: text/plain; charset=UTF-8" . PHP_EOL;

if (mail($address, $subject, $message, $headers)) {
    echo "<fieldset>";
    echo "<div id='success_page'>";
    echo "<h1>Email Sent Successfully.</h1>";
    echo "<p>Thank you <strong>" . $form_name . "</strong>, your reservation request has been submitted.</p>";
    echo "</div>";
    echo "</fieldset>";
} else {
    echo '<div class="error_message">Sorry, your message could not be sent. Please try again later.</div>';
}

?>