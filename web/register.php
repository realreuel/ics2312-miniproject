<?php
declare(strict_types=1);

/**
 * Students must build a registration form on this page.
 *
 * Required behavior:
 * 1. Display an HTML form that collects at least name, email, and age.
 * 2. Use the POST method and submit to process.php.
 * 3. Preserve submitted values where appropriate after validation errors.
 * 4. Show user-friendly validation feedback near the relevant fields.
 * 5. Keep presentation markup in this file and business validation logic in src/FormValidator.php.
 */

// Start session at the very top to catch any validation feedback passed from process.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Retrieve old input and errors from session if they exist, then clear them
$old = $_SESSION['old_input'] ?? [
    'name'  => '',
    'email' => '',
    'age'   => '',
];

$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old_input'], $_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            margin-top: 0;
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #4b5563;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        input.input-error {
            border-color: #dc2626;
            background-color: #fef2f2;
        }
        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 500;
        }
        button {
            width: 100%;
            background-color: #2563eb;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Student Registration</h1>
        
        <form action="process.php" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" 
                       class="<?= isset($errors['name']) ? 'input-error' : '' ?>" 
                       value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?php if (isset($errors['name'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       class="<?= isset($errors['email']) ? 'input-error' : '' ?>" 
                       value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" 
                       class="<?= isset($errors['age']) ? 'input-error' : '' ?>" 
                       value="<?= htmlspecialchars($old['age'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                <?php if (isset($errors['age'])): ?>
                    <div class="error-message"><?= htmlspecialchars($errors['age'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>

            <button type="submit">Submit Registration</button>
        </form>
    </div>

</body>
</html>