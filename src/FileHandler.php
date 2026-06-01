<?php

declare(strict_types=1);

namespace App;

class FileHandler
{
    /**
     * Write a complete CSV file using the supplied associative record as the first row.
     *
     * The implementation should create or overwrite the target file, write a header row
     * based on the keys of the provided associative array, and then write the record values
     * in the same order as the header. Students should validate that the record is not empty
     * and handle file-open or file-write failures safely.
     *
     * @param string $filePath Absolute or relative path to the CSV file to create.
     * @param array<string, scalar|null> $record Associative student record to write.
     *
     * @return bool True when the write succeeds, otherwise false or an exception depending on the chosen design.
     */
    public function writeRecord(string $filePath, array $record): bool
    {
        if (empty($record)) {
            return false;
        }

        // Open the file in write mode ('w') so an existing file is replaced.
        $handle = @fopen($filePath, 'w');
        if (!$handle) {
            return false;
        }

        // Write the CSV header using the record keys.
        $headers = array_keys($record);
        if (fputcsv($handle, $headers) === false) {
            fclose($handle);
            return false;
        }

        // Write the record values in the same column order as the header.
        if (fputcsv($handle, array_values($record)) === false) {
            fclose($handle);
            return false;
        }

        // Close the file handle before returning.
        fclose($handle);
        return true;
    }

    /**
     * Read every row from a CSV file and return an array of associative arrays.
     *
     * The implementation should open the file, read the first row as column headers,
     * then map every subsequent row into an associative array using those headers.
     * If the file does not exist, the method should handle the case gracefully in the
     * way defined by the project requirements and tests.
     *
     * @param string $filePath Absolute or relative path to the CSV file to read.
     *
     * @return array<int, array<string, string>> All records as associative arrays.
     */
    public function readAllRecords(string $filePath): array
    {
        // Check whether the target file exists before attempting to open it.
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return [];
        }

        $handle = @fopen($filePath, 'r');
        if (!$handle) {
            return [];
        }

        // Read the first row as CSV headers with fgetcsv().
        $headers = fgetcsv($handle);
        if (!$headers) {
            fclose($handle);
            return [];
        }

        $records = [];
        // Read the remaining rows and combine each row with the headers.
        while (($row = fgetcsv($handle)) !== false) {
            if (count($headers) === count($row)) {
                $records[] = array_combine($headers, $row);
            }
        }

        // Close the file handle in all normal execution paths.
        fclose($handle);
        return $records;
    }

    /**
     * Append one associative record to an existing CSV file, creating headers if needed.
     *
     * The implementation should append a new row without destroying existing data.
     * If the file is empty or missing, it should create the file and write the header
     * row before appending the data row. The header order must match the array key order.
     *
     * @param string $filePath Absolute or relative path to the CSV file to append to.
     * @param array<string, scalar|null> $record Associative student record to append.
     *
     * @return bool True when the append succeeds, otherwise false or an exception depending on the chosen design.
     */
    public function appendRecord(string $filePath, array $record): bool
    {
        if (empty($record)) {
            return false;
        }

        // Detect whether the file exists and whether it is empty.
        $fileExists = file_exists($filePath);
        $fileEmpty = $fileExists ? (filesize($filePath) === 0) : true;

        // Open the file in append mode ('a') so new records are added at the end.
        $handle = @fopen($filePath, 'a');
        if (!$handle) {
            return false;
        }

        // Write headers first if the file is new or empty.
        if ($fileEmpty) {
            $headers = array_keys($record);
            if (fputcsv($handle, $headers) === false) {
                fclose($handle);
                return false;
            }
        }

        // Append the record values in the same order as the header.
        $status = fputcsv($handle, array_values($record));
        
        // Close the handle and report success or failure clearly.
        fclose($handle);
        return $status !== false;
    }
}