Tests
=====

## Dependency injection testing

If you need to test dependecy injection service, extend `Publero\Component\Test\ContainerAwareTestCase`
as shown in the example below:

``` php
<?php
use Publero\Component\Test\ContainerAwareTestCase;

class ContainerAwareTestCaseExample extends ContainerAwareTestCase
{
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        // if you need to override setUpBeforeClass(), don't forget to call parent::setUpBeforeClass()
    }

    public static function tearDownAfterClass()
    {
        // if you need to override tearDownAfterClass(), don't forget to call parent::tearDownAfterClass()

        parent::tearDownAfterClass();
    }

    public function testExample()
    {
        $myService = self::getContainer()->get('my_service');

        $this->assertNotNull($myService);
    }
}
```

## Database testing

If you need to test database related functionality, you can extend `Publero\Component\Test\DatabaseTestCase`
and you don't need to worry about modifying the database.

For each test a transaction is started and once the test is finished, the transaction is rolled back.
Therefore the database is consistent even during testing, and tests are isolated (as they should be)
and doesn't affect each other.

**Note: This method works only for implicit
[transaction demarcation](http://doctrine-orm.readthedocs.org/en/2.0.x/reference/transactions-and-concurrency.html).**

If we consider an empty table for entity `Product` these tests will pass:

``` php
<?php
use Publero\Component\Test\DatabaseTestCase;

class DatabaseTestCaseExample extends DatabaseTestCase
{
    /*
     * If you need to override setUpBeforeClass() or tearDownAfterClass(),
     * don't forget to call the corresponding parent method.
     */

    public function testWithEntityManager()
    {
        $product = new Product(...);
        self::$em->persist($product);
        self::$em->flush();

        $products = self::$doctrine
            ->getRepository('AcmeStoreBundle:Product')
            ->findAll()
        ;

        // trasaction has not been rolled back, so our product is still there
        $this->assertNotEmpty($products);
    }

    public function testWithDoctrine()
    {
        $product = self::$doctrine
            ->getRepository('AcmeStoreBundle:Product')
            ->findAll()
        ;

        // trasaction has been rolled back, therefore no products are persisted
        $this->assertEmpty($product);
    }
}
```

## Functional tests

For functional testing we've provided `Publero\Component\Test\WebTestCase`
and `Publero\Component\Test\DatabaseWebTestCase`. They both reuse the same client for all tests in the class
and restarts the client (clears all cookies and the history) at the beginning of each test.

In addition to that `Publero\Component\Test\DatabaseWebTestCase` provides database isolation for tests
as described in `Publero\Component\Test\DatabaseTestCase`.

**For more information on functional testing please refer to
[Symfony 2.1 documentation](http://symfony.com/doc/master/book/testing.html#functional-tests).**

``` php
<?php
use Publero\Component\Test\WebTestCase;

class ContainerAwareTestCaseExample extends ContainerAwareTestCase
{
    /*
     * If you need to override setUpBeforeClass(), setUp() or tearDownAfterClass(),
     * don't forget to call the corresponding parent method.
     */

    public function testExample()
    {
        self::$client->request('GET', self::getRouter('test_route'));

        $this->assertEquals(200, self::$client->getResponse()->getStatusCode());
    }
}
```

## Extensions and configuration testing

You can use `Publero\Component\Test\ExtensionTestCase` for dependency injection extensions tests. Be aware
that container which is used for testing is empty and kernel is not booted.

In order to make extension test you need to load your extension. To load extension use `ExtensionTestCase::loadExtension(Extension $extension, array $configs = array())` method.

``` php
<?php
use Publero\Component\Test\ExtensionTestCase;

class AcmeExampleExtensionTest extends ExtensionTestCase
{
    public function testLoad()
    {
        $this->loadExtension(new AcmeExampleExtension());
        
        $container = $this->getContainer();
        $this->assertTrue($container->has('example_service'));
    }
```

You can access container via `getContainer` method. Test presence of your newly defined *service* or *parameter* via default phpunit asserts.

### Testing extensions configurations

Configuration testing is also possible. You can define your configuration by override `getConfig` method and use `getParsedConfig` to get
your confiruation as array. To load configuration in extension simply pass it to `loadExtension` as second argument.

``` php
<?php
use Publero\Component\Test\ExtensionTestCase;

class AcmeExampleExtensionTest extends ExtensionTestCase
{
    public function testLoad()
    {
        $config = $this->getParsedConfig();
        
        $this->assertArrayHasKey('secure', $config);
        $this->assertArrayHasKey('dbal', $config);
        $this->assertArrayHasKey('nested', $config);
        
        $this->loadExtension(new AcmeExampleExtension(), array($config));
    }

    public function getConfig()
    {
        return <<<EOF
secure: true
dbal: my_dbal_service
nested:
	example: ~ 
EOF;
    }
}
```

You can also set your configuration from array, but by using yaml you show how your bundle can be set up properly.
