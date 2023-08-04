<?php
// Replace with your actual receiving email address
$receiving_email_address = 'osama.alyadumi74@gmail.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
  include($php_email_form);
} else {
  die('Unable to load the "PHP Email Form" Library!');
}

// Initialize the PHP_Email_Form class
$contact = new PHP_Email_Form();
$contact->ajax = true;

// Set email sending options
$contact->to = $receiving_email_address;
$contact->from_name = isset($_POST['name']) ? $_POST['name'] : '';
$contact->from_email = isset($_POST['email']) ? $_POST['email'] : '';
$contact->subject = isset($_POST['subject']) ? $_POST['subject'] : '';

// Uncomment below code if you want to use SMTP to send emails. Enter your SMTP credentials.
/*
$contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
);
*/

// Add form data to the email message
$contact->add_message(isset($_POST['name']) ? $_POST['name'] : '', 'From');
$contact->add_message(isset($_POST['email']) ? $_POST['email'] : '', 'Email');
$contact->add_message(isset($_POST['message']) ? $_POST['message'] : '', 'Message', 10);

// Send the email and get the result
$result = $contact->send();

// Send a JSON response back to the client
header('Content-Type: application/json');
echo json_encode(array('result' => $result));
?>
