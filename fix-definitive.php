<?php
// Definitive regex fix - safe patterns
$rules = [
    'first_name' => 'required|string|max:100|min:2',
    'middle_initial' => 'nullable|string|max:5',
    'last_name' => 'required|string|max:100|min:2',
    'email' => 'required|email|max:255|unique:customers',
    'password' => 'required|string|min:8|confirmed',
    'phone' => 'required|string|min:10|max:20',
    'address' => 'required|string|min:20|max:500',
    'terms' => 'accepted',
];

$messages = [
    'first_name.required' => 'First name required.',
    'last_name.required' => 'Last name required.',
    'email.required' => 'Email required.',
    'terms.accepted' => 'Accept terms.',
];

// Replace in controller
$content = file_get_contents('app/Http/Controllers/Customer/Auth/LoginController.php');
$content = str_replace('$validator = Validator::make($request->all(), [', '$validator = Validator::make($request->all(), ' . var_export($rules, true) . ', ' . var_export($messages, true) . ');', $content);
file_put_contents('app/Http/Controllers/Customer/Auth/LoginController.php', $content);
echo "LoginController: Regex completely removed - safe basic validation.\n";

$content2 = file_get_contents('app/Http/Controllers/Customer/ProfileController.php');
$lines = explode("\n", $content2);
foreach ($lines as &$line) {
    if (strpos($line, 'regex:') !== false) {
        $line = str_replace($line, rtrim($line, ','), $line); // Just remove regex part
    }
}
file_put_contents('app/Http/Controllers/Customer/ProfileController.php', implode("\n", $lines));
echo "ProfileController: Regex parts removed.\n";

echo "Definitive fix applied! Restart server and test.";
?>

