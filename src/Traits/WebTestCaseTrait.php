<?php
namespace Publero\Component\Test\Traits;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
trait WebTestCaseTrait
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    protected static $client;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        static::$client = static::createClient();
    }

    public function setUp()
    {
        self::$client->restart();
    }

    public static function tearDownAfterClass()
    {
        static::$client = null;

        parent::tearDownAfterClass();
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public static function getClient()
    {
        return static::$client;
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    public static function getRouter()
    {
        return static::getContainer()->get('router');
    }

    /**
     * @return \Symfony\Component\Translation\IdentityTranslator
     */
    public static function getTranslator()
    {
        return static::getContainer()->get('translator');
    }
}
