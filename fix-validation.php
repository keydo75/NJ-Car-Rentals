<?php
// Temporary fix - run once to test
require 'vendor/autoload.php';

$controllerCode = file_get_contents('app/Http/Controllers/Customer/Auth/LoginController.php');
$controllerCode = str_replace("regex:/^[a-zA-Z -\\.]+$/","regex:/^[a-zA-Z -\\.]+$/", $controllerCode);
$controllerCode = str_replace("regex:/^[A-Z. ]+$/","regex:/^[A-Z. ]+$/", $controllerCode);
file_put_contents('app/Http/Controllers/Customer/Auth/LoginController.php', $controllerCode);

echo "Fixed LoginController regex.\n";

$profileCode = file_get_contents('app/Http/Controllers/Customer/ProfileController.php');
$profileCode = str_replace("regex:/^[a-zA-Z -\\.]+$/","regex:/^[a-zA-Z -\\.]+$/", $profileCode);
$profileCode = str_replace("regex:/^[A-Z. ]+$/","regex:/^[A-Z. ]+$/", $profileCode);
file_put_contents('app/Http/Controllers/Customer/ProfileController.php', $profileCode);

echo "Fixed ProfileController regex.\n";

echo "Done. Restart server and test registration.";
?>

