<?php

namespace Abbatis\Unhack\Service;

use Symfony\Component\Console\Input\InputInterface;
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
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     */
    public function clean($dir, OutputInterface $output, InputInterface $input)
    {
        $files = $this->getDirContents($dir);
        $patterns = $this->getPatterns();

        foreach ($files as $file) {
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array(strtolower($fileExtension), $input->getOption('exclude'))) {
                continue;
            }

            $output->writeln("- $file");

            foreach ($patterns as $pattern) {
                $fileContent = file_get_contents($file);
                $fileContent = preg_replace("/{$pattern}/", "", $fileContent);
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
