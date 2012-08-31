<?php
namespace Publero\Component\Test;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
interface WebTestCaseInterface extends \PHPUnit_Framework_Test, \PHPUnit_Framework_SelfDescribing
{
    /**
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public static function getClient();

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public static function getContainer();

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Routing\Router
     */
    public static function getRouter();

    /**
     * @return \Symfony\Component\Translation\IdentityTranslator
     */
    public static function getTranslator();
}
