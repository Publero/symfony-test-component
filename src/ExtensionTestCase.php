<?php
namespace Publero\Component\Test;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Parser;

abstract class ExtensionTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
    }

    /**
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function loadExtension(Extension $extension, array $configs = array())
    {
        $extension->load($configs, $this->getContainer());
    }

    /**
     * @return array
     */
    public function getParsedConfig()
    {
        return (new Parser())->parse($this->getConfig());
    }

    /**
     * @return string
     */
    public function getConfig()
    {
        return '';
    }
}
