<?php

/*
 * This file is part of the Publero Test package.
 *
 * (c) Tomáš Pecsérke <tomas.pecserke@publero.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Publero\Component\Test;

use Publero\Component\Test\Traits\WebTestCaseTrait;

/**
 * @author Tomáš Pecsérke <tomas.pecserke@publero.com>
 */
abstract class DatabaseWebTestCase extends DatabaseTestCase implements WebTestCaseInterface
{
    use WebTestCaseTrait;
}
