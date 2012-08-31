<?php
namespace Publero\Component\Test;

use Publero\Component\Test\Traits\WebTestCaseTrait;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
abstract class WebTestCase extends ContainerAwareTestCase implements WebTestCaseInterface
{
    use WebTestCaseTrait;
}
