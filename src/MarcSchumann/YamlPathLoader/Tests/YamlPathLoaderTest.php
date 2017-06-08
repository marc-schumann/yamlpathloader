<?php

namespace MarcSchumann\YamlPathLoader\YamlPathLoader\Tests;

use MarcSchumann\YamlPathLoader\YamlPathLoader;

/**
 * Class YamlPathLoaderTest
 */
class YamlPathLoaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Prophecy\Prophet $prophet */
    protected $prophet;

    /** @var \Symfony\Component\Yaml\Parser $yamlParser */
    protected $yamlParser;

    /**
     * Test - Setup
     */
    public function setUp()
    {
        $this->prophet    = new \Prophecy\Prophet;
        $this->yamlParser = $this->prophet->prophesize(
            'Symfony\Component\Yaml\Parser'
        );
    }

    /**
     * Teardown Test
     */
    public function tearDown()
    {
        $this->prophet->checkPredictions();
    }

    /**
     * Tests YamlPathLoader::loadResource
     *
     * @dataProvider testData
     */
    public function testLoadResource($resource, $locale, $exception)
    {
        if (null != $exception) {
            $this->expectException($exception);
        }

        $loader    = new YamlPathLoader;
        $catalogue = $loader->load($resource, $locale);

        $this->assertEquals($locale, $catalogue->getLocale());
    }

    /**
     * @return array
     */
    public function testData()
    {
        return [
            [
                'directory' => __DIR__.'/../fixtures/en/',
                'locale' => 'en',
                'exception' => null
            ],
            [
                'directory' => __DIR__.'/../fixtures/de/',
                'locale' => 'de',
                'exception' => null
            ],
            [
                'directory' => __DIR__.'/../fixtures/fr/',
                'locale' => 'fr',
                'exception' => 'Symfony\Component\Translation\Exception\NotFoundResourceException'
            ]
        ];
    }
}
