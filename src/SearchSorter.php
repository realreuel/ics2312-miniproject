<?php

declare(strict_types=1);

namespace App;

class SearchSorter
{
    /**
     * Search linearly through an array and return the index of the first matching value.
     *
     * The implementation should inspect elements one by one from left to right. If the
     * target value is found, return its zero-based index. If the target does not exist in
     * the array, return -1.
     *
     * @param array<int, int|string> $items Indexed array to search.
     * @param int|string $target Value being searched for.
     *
     * @return int Zero-based index of the target, or -1 if not found.
     */
    public function linearSearch(array $items, int|string $target): int
    {
        // Loop through the array from index 0 to the last element.
        foreach ($items as $index => $value) {
            // Compare each value to the target using a consistent equality rule.
            if ($value == $target) {
                // Return the matching index immediately when found.
                return (int) $index;
            }
        }
        // Return -1 after the loop if the target is not present.
        return -1;
    }

    /**
     * Search a pre-sorted array using the binary search algorithm.
     *
     * The implementation should repeatedly inspect the middle element and reduce the
     * search range until the target is found or the range becomes empty. The input array
     * is expected to be sorted in ascending order before this method is called.
     *
     * @param array<int, int|string> $items Ascending sorted indexed array.
     * @param int|string $target Value being searched for.
     *
     * @return int Zero-based index of the target, or -1 if not found.
     */
    public function binarySearch(array $items, int|string $target): int
    {
        // Track low and high bounds for the current search range.
        $low = 0;
        $high = count($items) - 1;

        while ($low <= $high) {
            // Compute the middle index and compare the middle value to the target.
            $mid = intdiv($low + $high, 2);
            
            if ($items[$mid] == $target) {
                // Return the index when the target is found
                return $mid;
            } elseif ($items[$mid] < $target) {
                // Narrow the search to the right half
                $low = $mid + 1;
            } else {
                // Narrow the search to the left half
                $high = $mid - 1;
            }
        }
        // Return -1 if the target is not found.
        return -1;
    }

    /**
     * Sort an array in ascending order using bubble sort and count loop iterations.
     *
     * The implementation should return both the sorted array and the total number of
     * comparison iterations performed. The expected return shape for this project is:
     * `['sorted' => [...], 'iterations' => 0]`.
     *
     * @param array<int, int|float|string> $items Array to sort.
     *
     * @return array{sorted: array<int, int|float|string>, iterations: int}
     */
    public function bubbleSort(array $items): array
    {
        $n = count($items);
        $iterations = 0;
        
        // Repeat passes until the array is fully sorted.
        for ($i = 0; $i < $n - 1; $i++) {
            $swapped = false;
            for ($j = 0; $j < $n - $i - 1; $j++) {
                // Count each comparison iteration performed by the algorithm.
                $iterations++;
                
                // Compare adjacent items and swap them when they are out of order.
                if ($items[$j] > $items[$j + 1]) {
                    $temp = $items[$j];
                    $items[$j] = $items[$j + 1];
                    $items[$j + 1] = $temp;
                    $swapped = true;
                }
            }
            // Optimization check to exit early if no items were swapped in a complete pass.
            if (!$swapped) {
                break;
            }
        }

        // Return both the sorted array and the iteration count.
        return ['sorted' => $items, 'iterations' => $iterations];
    }

    /**
     * Sort an array in ascending order using selection sort and count loop iterations.
     *
     * The implementation should repeatedly find the smallest remaining element and move
     * it into its correct position. Return the result using the same structure required
     * for all sorting methods in this project.
     *
     * @param array<int, int|float|string> $items Array to sort.
     *
     * @return array{sorted: array<int, int|float|string>, iterations: int}
     */
    public function selectionSort(array $items): array
    {
        $n = count($items);
        $iterations = 0;

        for ($i = 0; $i < $n - 1; $i++) {
            $minIndex = $i;
            
            // For each position, search the unsorted portion for the minimum value.
            for ($j = $i + 1; $j < $n; $j++) {
                // Count each comparison iteration.
                $iterations++;
                if ($items[$j] < $items[$minIndex]) {
                    $minIndex = $j;
                }
            }
            
            // Swap the minimum value into the current position when needed.
            if ($minIndex !== $i) {
                $temp = $items[$i];
                $items[$i] = $items[$minIndex];
                $items[$minIndex] = $temp;
            }
        }

        // Return the sorted array and total iteration count.
        return ['sorted' => $items, 'iterations' => $iterations];
    }

    /**
     * Sort an array in ascending order using insertion sort and count loop iterations.
     *
     * The implementation should build a sorted portion of the array by taking one value
     * at a time and inserting it into the correct place. Return both the sorted array and
     * the total number of element comparisons made.
     *
     * @param array<int, int|float|string> $items Array to sort.
     *
     * @return array{sorted: array<int, int|float|string>, iterations: int}
     */
    public function insertionSort(array $items): array
    {
        $n = count($items);
        $iterations = 0;

        // Start from the second element and treat earlier elements as the sorted portion.
        for ($i = 1; $i < $n; $i++) {
            $key = $items[$i];
            $j = $i - 1;

            // Shift larger values to the right until the correct insertion point is found.
            while ($j >= 0) {
                // Count each comparison iteration made while searching for the insertion point.
                $iterations++;
                
                if ($items[$j] > $key) {
                    $items[$j + 1] = $items[$j];
                    $j--;
                } else {
                    break;
                }
            }
            $items[$j + 1] = $key;
        }

        // Return the sorted array and total iteration count.
        return ['sorted' => $items, 'iterations' => $iterations];
    }
}