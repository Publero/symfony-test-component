<?php
namespace Publero\Component\Test;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\DependencyInjection\Container;

abstract class ConsoleCommandTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function setUp()
    {
        $this->container = new Container();
    }

    /**
     * @param Command $command
     * @param array $input
     * @return string
     */
    protected function runCommand(Command $command, array $input)
    {
        array_unshift($input, '');
        $fp = tmpfile();

        $input = new ArgvInput($input, $command->getDefinition());
        $output = new StreamOutput($fp);
        if ($command instanceof ContainerAwareCommand) {
            $command->setContainer($this->getContainer());
        }

        $command->run($input, $output);

        fseek($fp, 0);
        $outputString = '';
        while (!feof($fp)) {
            $outputString = fread($fp, 4096);
        }
        fclose($fp);
        return $outputString;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
