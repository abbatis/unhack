<?php

namespace Abbatis\Unhack\Service;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RegexCleanService
 * @author Imad Kada i.kada@abbatis.nl
 */
class RegexCleanService
{
    /**
     * @param string                                            $dir
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function clean($dir, OutputInterface $output)
    {
        $files = $this->getDirContents($dir);
        $patterns = $this->getPatterns();

        foreach ($files as $file) {
            foreach ($patterns as $pattern) {
                $fileContent = file_get_contents($file);
                $fileContent = preg_replace("/{$pattern}/", "", $fileContent);
                $output->writeln($pattern." ".$file);
                file_put_contents($file, trim($fileContent));
            }
        }
    }

    /**
     * @return array
     */
    public function getPatterns()
    {
        $path = "./stubs/malicious_strings";
        $files = scandir($path);
        $patterns = [];
        foreach ($files as $file) {
            if (!is_dir($file)) {
                $file = "$path/$file";
                $patterns[] = trim(file_get_contents($file));
            }
        }

        return $patterns;
    }

    /**
     * @param string $dir
     * @param array  $results
     *
     * @return array
     */
    public function getDirContents($dir, &$results = [])
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else {
                if ($value != "." && $value != "..") {
                    $this->getDirContents($path, $results);
                }
            }
        }

        return $results;
    }
}
