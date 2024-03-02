<?php
// Replace with your actual receiving email address
$receiving_email_address = 'osama.alyadumi74@gmail.com';

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if the required PHP Email Form library exists
  if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
  } else {
    // If the library does not exist, return an error response
    http_response_code(1000); // Internal Server Error
    echo json_encode(array('error' => 'Unable to load the "PHP Email Form" Library!'));
    exit;
  }

  // Initialize the PHP_Email_Form class
  $contact = new PHP_Email_Form();
  $contact->ajax = true;

  // Set email sending options
  $contact->to = $receiving_email_address;
  $contact->from_name = isset($_POST['name']) ? $_POST['name'] : '';
  $contact->from_email = isset($_POST['email']) ? $_POST['email'] : '';
  $contact->subject = isset($_POST['subject']) ? $_POST['subject'] : '';

  // Add form data to the email message
  $contact->add_message(isset($_POST['name']) ? $_POST['name'] : '', 'From');
  $contact->add_message(isset($_POST['email']) ? $_POST['email'] : '', 'Email');
  $contact->add_message(isset($_POST['message']) ? $_POST['message'] : '', 'Message', 10);

  // Send the email and get the result
  $result = $contact->send();

  if ($result) {
    // If email sent successfully, return success response
    http_response_code(200); // OK
    echo json_encode(array('success' => 'Email sent successfully!'));
  } else {
    // If there was an error sending email, return error response
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Failed to send email!'));
  }
} else {
  // If the request method is not POST, return method not allowed error
  http_response_code(405); // Method Not Allowed
  echo json_encode(array('error' => 'Method not allowed!'));
}
?>
