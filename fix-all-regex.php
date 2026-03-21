<?php
$content = file_get_contents('app/Http/Controllers/Customer/Auth/LoginController.php');

$content = preg_replace('/regex:\\/\\^[a-zA-Z[ \\-\\\\.]*\\$\\//', 'regex:/^[a-zA-Z -\\.]+$/ ', $content);
$content = preg_replace('/regex:\\/\\^[A-Z[ .]*\\$\\//', 'regex:/^[A-Z. ]+$/ ', $content);

file_put_contents('app/Http/Controllers/Customer/Auth/LoginController.php', $content);
echo "LoginController fixed.\n";

$content2 = file_get_contents('app/Http/Controllers/Customer/ProfileController.php');
$content2 = preg_replace('/regex:\\/\\^[a-zA-Z[ \\-\\\\.]*\\$\\//', 'regex:/^[a-zA-Z -\\.]+$/ ', $content2);
$content2 = preg_replace('/regex:\\/\\^[A-Z[ .]*\\$\\//', 'regex:/^[A-Z. ]+$/ ', $content2);

file_put_contents('app/Http/Controllers/Customer/ProfileController.php', $content2);
echo "ProfileController fixed.\n";

echo "All regex fixed. Restart server!";
?>

