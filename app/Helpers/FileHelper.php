<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Helper to copy folder recursively
     *
     * @param string $source
     * @param string $destination
     * @return void
     */
    public function recursive_copy(string $source, string $destination): void
    {
        $directory = opendir($source);
        @mkdir($destination);
        while ($file = readdir($directory)) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($source . '/' . $file)) {
                    $this->recursive_copy($source . '/' . $file, $destination . '/' . $file);
                } else {
                    copy($source . '/' . $file, $destination . '/' . $file);
                }
            }
        }
        closedir($directory);
    }

    /**
     * Helper to get directories and subdirectories content
     *
     * @param string $dir
     * @param array $results
     * @return array of file names
     */
    public function getDirectoryContent(string $directory, array &$results = []): array
    {
        $files = scandir($directory);

        foreach ($files as $value) {
            $path = realpath($directory . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } elseif ($value != '.' && $value != '..') {
                $this->getDirectoryContent($path, $results);
                $results[] = $path;
            }
        }
        return $results;
    }

    /**
     * Replace files content
     *
     * @param string $search_regex
     * @param string $replace
     * @param string $directory
     * @return void
     */
    public function rename_file_content(string $search_regex, string $replace, string $directory): void
    {
        $fileList = $this->getDirectoryContent($directory);

        foreach ($fileList as $file) {
            if (strpos($file, '.') !== false) {
                $content = file_get_contents($file);
                $content = preg_replace($search_regex, $replace, $content);
                file_put_contents($file, $content);
            }
        }
    }
}
