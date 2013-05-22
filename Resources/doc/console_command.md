Testing console commands
========================

To test console command you have to extend `Publero\Component\Test\ConsoleCommandTestCase`. By doing so you will not initialize whole kernel.
Instead only container is created and passed to your command. You can set any service or parameter in the container to fit your needs.

To run command use `ConsoleCommandTestCase::runCommand` method. You will get printed result of command as a result. Arguments are passed as an
array where zero argument with script filepath is ommited.

``` php
<?php
namespace Publero\ExampleBundle\Tests\Command;

use Publero\ExampleBundle\Command\ExampleCommand;

class ExampleCommandTest extends \Publero\Component\Test\ConsoleCommandTestCase
{
    public function testExecute()
    {
        $command = new ExampleCommand();
        $arguments = [
            'first_argument' => 'passed first',
            'second_argument' => 'passed second',
            '-f option_value' => '1'
        ];

        $output = $this->runCommand($command, $arguments);
        
        $this->assertEquals($expected = 'Data imported', $output);
    }
}
```
