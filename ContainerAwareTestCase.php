<?php
namespace Publero\Component\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ContainerAwareTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    protected static $kernel;

    public static function setUpBeforeClass()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
    }

    public function tearDown()
    {
    }

    public static function tearDownAfterClass()
    {
        if (null !== static::$kernel) {
            static::$kernel->shutdown();
        }
    }

    /**
     * Get kernel service container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public static function getContainer()
    {
        return static::$kernel->getContainer();
    }
}
