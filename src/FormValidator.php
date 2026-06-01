<?php

declare(strict_types=1);

namespace App;

class FormValidator
{
    /**
     * Validate a student's name according to the project rules.
     *
     * A valid name should contain at least 2 visible characters after trimming and should
     * contain alphabetic characters, spaces, apostrophes, or hyphens only. Return null
     * when the value is valid, otherwise return a human-readable error message.
     *
     * @param string $name Raw name input from the form.
     *
     * @return string|null Null when valid, otherwise an error message.
     */
    public function validateName(string $name): ?string
    {
        // Trim surrounding whitespace before checking length.
        $trimmedName = trim($name);

        // Reject names shorter than 2 characters.
        if (strlen($trimmedName) < 2) {
            return "Name must be at least 2 characters long.";
        }

        // Reject names that contain digits or unsupported symbols.
        if (!preg_match("/^[A-Za-z\s'-]+$/", $trimmedName)) {
            return "Name contains invalid characters.";
        }

        // Return null when the name satisfies all rules.
        return null;
    }

    /**
     * Validate an email address using server-side rules.
     *
     * The implementation should reject malformed email addresses and return a clear error
     * message. Return null for a valid email address.
     *
     * @param string $email Raw email input from the form.
     *
     * @return string|null Null when valid, otherwise an error message.
     */
    public function validateEmail(string $email): ?string
    {
        // Trim the email string before validation.
        $trimmedEmail = trim($email);

        // Use a dependable validation approach such as filter_var().
        // Return an error message when the address is malformed.
        if (!filter_var($trimmedEmail, FILTER_VALIDATE_EMAIL)) {
            return "The email format is invalid.";
        }

        // Return null for valid email addresses.
        return null;
    }

    /**
     * Validate an age value against the project range requirements.
     *
     * A valid age must be between 18 and 100 inclusive. Return null when the value is
     * accepted, otherwise return a human-readable error message.
     *
     * @param int $age Student age from the form submission.
     *
     * @return string|null Null when valid, otherwise an error message.
     */
    public function validateAge(int $age): ?string
    {
        // Check whether the age is below the minimum allowed value of 18.
        if ($age < 18) {
            return "Age must be between 18 and 100.";
        }

        // Check whether the age is above the maximum allowed value of 100.
        if ($age > 100) {
            return "Age must be between 18 and 100.";
        }

        // Return null if the age falls within the inclusive valid range.
        return null;
    }

    /**
     * Validate all required form fields and return an associative error list.
     *
     * The implementation should validate at least the `name`, `email`, and `age` fields.
     * Return an empty array when all fields are valid. When one or more fields fail
     * validation, return an associative array where the keys are field names and the
     * values are the related error messages.
     *
     * @param array<string, mixed> $input Submitted form data.
     *
     * @return array<string, string> Associative array of validation errors.
     */
    public function validateAll(array $input): array
    {
        $errors = [];

        // Extract the required fields from the input array safely.
        $name = isset($input['name']) ? (string)$input['name'] : '';
        $email = isset($input['email']) ? (string)$input['email'] : '';
        $age = isset($input['age']) ? (int)$input['age'] : 0;

        // Call validateName(), validateEmail(), and validateAge().
        // Add only the failing fields to the returned errors array.
        $nameError = $this->validateName($name);
        if ($nameError !== null) {
            $errors['name'] = $nameError;
        }

        $emailError = $this->validateEmail($email);
        if ($emailError !== null) {
            $errors['email'] = $emailError;
        }

        $ageError = $this->validateAge($age);
        if ($ageError !== null) {
            $errors['age'] = $ageError;
        }

        // Return an empty array when all validations pass.
        return $errors;
    }
}