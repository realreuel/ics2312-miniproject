<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class ErrorHandler
{
    /**
     * Read and return the contents of a file while handling missing or unreadable files safely.
     *
     * The implementation should check whether the file exists and is readable, then return
     * its contents as a string. If the file is missing or cannot be read, the method should
     * throw an appropriate exception with a clear message.
     *
     * @param string $filePath Absolute or relative path to the file to read.
     *
     * @return string File contents.
     */
    public function safeReadFile(string $filePath): string
    {
        // Verify that the file exists before attempting to read it.
        if (!file_exists($filePath)) {
            // Throw a clear exception when the file is missing or unreadable.
            throw new RuntimeException("File does not exist: " . $filePath);
        }

        // Verify that the file is readable.
        if (!is_readable($filePath)) {
            // Throw a clear exception when the file is missing or unreadable.
            throw new RuntimeException("File is not readable: " . $filePath);
        }

        // Read and return the file contents as a string.
        $content = @file_get_contents($filePath);
        if ($content === false) {
            throw new RuntimeException("Failed to read file contents from path: " . $filePath);
        }

        return $content;
    }

    /**
     * Write text content to a file while reporting unwritable destinations safely.
     *
     * The implementation should create or overwrite the target file and return the number
     * of bytes written. If the destination path cannot be written, the method should throw
     * an appropriate exception with a clear message.
     *
     * @param string $filePath Absolute or relative path to the file to write.
     * @param string $content Content to be written to the file.
     *
     * @return int Number of bytes written.
     */
    public function safeWriteFile(string $filePath, string $content): int
    {
        // Attempt to write the full string content to the target path.
        // Detect unwritable paths or failed writes using the error suppression token '@'.
        $bytesWritten = @file_put_contents($filePath, $content);
        
        if ($bytesWritten === false) {
            // Throw a clear exception when the write cannot be completed.
            throw new RuntimeException("Failed to write content to file path: " . $filePath);
        }

        // Return the exact number of bytes written when successful.
        return $bytesWritten;
    }

    /**
     * Divide two numbers safely and reject division by zero.
     *
     * The implementation should return the division result as a float. If the divisor is
     * zero, the method should throw an appropriate exception rather than allowing unsafe
     * behavior to continue.
     *
     * @param int|float $dividend Number being divided.
     * @param int|float $divisor Number to divide by.
     *
     * @return float Result of the division.
     */
    public function safeDivide(int|float $dividend, int|float $divisor): float
    {
        // Check whether the divisor is zero before performing division.
        if ($divisor == 0 || $divisor == 0.0) {
            // Throw a clear exception when division by zero is attempted.
            throw new RuntimeException("Division by zero error encountered.");
        }

        // Perform the division and return the result as a float.
        return (float) ($dividend / $divisor);
    }
}