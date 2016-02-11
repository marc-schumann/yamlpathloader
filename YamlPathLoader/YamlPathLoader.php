<?php

namespace YamlPathLoader;

use Symfony\Component\Translation\Exception\InvalidResourceException;
use Symfony\Component\Yaml\Parser as YamlParser;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class PathLoader
 */
class YamlPathLoader extends YamlFileLoader
{
    /** @var YamlParser $yamlParser */
    private $yamlParser;

    /**
     * {@inheritdoc}
     */
    protected function loadResource($resource)
    {
        if (null === $this->yamlParser) {
            if (!class_exists('Symfony\Component\Yaml\Parser')) {
                throw new \LogicException('Loading translations from the YAML format requires the Symfony Yaml component.');
            }

            $this->yamlParser = new YamlParser();
        }

        if (!is_dir($resource)) {
            throw new InvalidResourceException(sprintf('This is not a valid dir "%s".', $resource));
        }

        $files = scandir($resource);

        if (2 == count($files)) {
            // No files in directory
            return null;
        }

        $messages = [];

        foreach ($files as $file) {
            if (true === in_array($file, ['.', '..'])) {
                continue;
            }

            try {
                $messages = array_merge($messages, $this->yamlParser->parse(file_get_contents($resource . '/' . $file)));
            } catch (ParseException $e) {
                throw new InvalidResourceException(sprintf('Error parsing YAML, invalid file "%s"', $resource), 0, $e);
            }
        }

        return $messages;
    }

}