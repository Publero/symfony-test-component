<?php
namespace Publero\Component\Test;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
abstract class DatabaseTestCase extends ContainerAwareTestCase
{
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    protected static $doctrine;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $em;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        static::$doctrine = static::getContainer()->get('doctrine');
        static::$em = static::$doctrine->getManager();
    }

    public static function tearDownAfterClass()
    {
        self::$em->close();

        static::$doctrine = null;
        static::$em = null;

        parent::tearDownAfterClass();
    }

    /**
     * Runs a test in transaction and rolls back changes after the test is completed.
     *
     * @return mixed
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    protected function runTest()
    {
        self::$em->getConnection()->beginTransaction();
        try {
            $result = parent::runTest();
        } catch (\Exception $e) {
            self::$em->getConnection()->rollback();

            throw $e;
        }

        self::$em->getConnection()->rollback();
        self::$em->clear();

        return $result;
    }
}
