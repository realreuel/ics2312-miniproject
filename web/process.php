<?php
declare(strict_types=1);

/**
 * Students must implement this form-processing page.
 *
 * Required behavior:
 * 1. Accept data submitted from register.php using the POST method.
 * 2. Validate submitted fields using App\FormValidator.
 * 3. Reject invalid input and return clear feedback to the user.
 * 4. Escape all rendered output with htmlspecialchars().
 * 5. On success, display a confirmation summary without exposing raw unvalidated input.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\FormValidator;

$validator = new FormValidator();
$data = $_POST;
$errors = [];
$submitted = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($submitted) {
    // Validate all submitted data using the FormValidator component
    $errors = $validator->validateAll($data);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Processing</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .error-box { background-color: #ffe6e6; border-left: 5px solid #ff3333; padding: 15px; margin-bottom: 20px; }
        .success-box { background-color: #e6ffe6; border-left: 5px solid #33cc33; padding: 15px; margin-bottom: 20px; }
        .error-msg { color: #cc0000; font-weight: bold; }
        .back-link { display: inline-block; margin-top: 20px; text-decoration: none; color: #0066cc; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Form Processing</h1>

    <?php if (!$submitted): ?>
        <div class="error-box">
            <p>No form data has been submitted yet. Go back to <a href="register.php">register.php</a>.</p>
        </div>
    <?php elseif (!empty($errors)): ?>
        <div class="error-box">
            <h2>Validation Failed</h2>
            <p>Please review and fix the following errors:</p>
            <ul>
                <?php foreach ($errors as $field => $message): ?>
                    <li><span class="error-msg"><?php echo htmlspecialchars(ucfirst($field), ENT_QUOTES, 'UTF-8'); ?>:</span> <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <p>Go back to <a href="register.php" class="back-link">register.php</a> to correct your details.</p>
    <?php else: ?>
        <div class="success-box">
            <h2>Registration Successful!</h2>
            <p>Your account details have been securely processed.</p>
            <h3>Submitted Summary:</h3>
            <ul>
                <li><strong>Username:</strong> <?php echo htmlspecialchars($data['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?></li>
                <li><strong>Email:</strong> <?php echo htmlspecialchars($data['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></li>
            </ul>
        </div>
        <p>Proceed to the <a href="login.php" class="back-link">Login Page</a>.</p>
    <?php endif; ?>
</body>
</html>