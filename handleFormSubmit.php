<?php
require_once('./postToGooggleSheet.php');

if (isset($_POST['submit'])) {
$name = filter_input(INPUT_POST, 'name', FILTER_UNSAFE_RAW);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_UNSAFE_RAW);
$message =  filter_input(INPUT_POST, 'message', FILTER_UNSAFE_RAW);

insertData('Sheet1', [$name, $email, $phone, $message, date("F j, Y, g:i a", time())]);
}