<?php

namespace ROBOAMP\Utils;

class Filename_helper {
	/**
	 * Get all files in the given directory that have the specified number of words in their names.
	 * If $up_to is true, return files with names containing up to the specified number of words.
	 *
	 * @param string $directory The directory to scan.
	 * @param int $total_words The desired number of words in the file names.
	 * @param bool $up_to Whether to include files with names containing up to the specified number of words.
	 * @return array An array of filtered file names.
	 */
	public function get_files_with_total_words($directory, $total_words, $up_to = false) {
		$directory = rtrim($directory, '/') . '/';
		$files = scandir($directory);

		$filteredFiles = array_filter($files, function($file) use ($directory, $total_words, $up_to) {
			return is_file($directory . $file) && $this->is_valid_filename($file, $total_words, $up_to);
		});

		return $filteredFiles;
	}

	/**
	 * Check if a file name is valid based on the specified number of words and the $up_to parameter.
	 *
	 * @param string $file The file name to check.
	 * @param int $total_words The desired number of words in the file names.
	 * @param bool $up_to Whether to include files with names containing up to the specified number of words.
	 * @return bool True if the file name is valid, false otherwise.
	 */
	private function is_valid_filename($file, $total_words, $up_to, $separator = '__') {
		$parts = preg_split('/' . preg_quote($separator, '/') . '/', $file); // Split the file name using the separator

		// Count the words in each part of the file name
		$total_word_count = 0;
		foreach ($parts as $part) {
			$word_count = $this->count_words_in_filename($part);
			$total_word_count += $word_count + 1; // Add 1 for each part to account for words separated by the separator
		}
		$total_word_count--; // Subtract 1 to exclude the file extension

		// Check the word count
		if ($up_to) {
			return $total_word_count > 0 && $total_word_count <= $total_words;
		} else {
			return $total_word_count === $total_words;
		}
	}

	/**
	 * Count the number of words in a file name.
	 *
	 * @param string $file The file name to count words in.
	 * @return int The number of words in the file name.
	 */
	private function count_words_in_filename($file) {

		preg_match_all('/\w+/', $file, $matches);
		return count($matches[0]) - 1; // Subtract 1 to exclude the file extension

	}
}