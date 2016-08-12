<?php
namespace Fixtures\Console\Command;

use Fixtures\FixtureLoader;
use Nelmio\Alice\Fixtures;
use Pimcore\Console\AbstractCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesCommand extends AbstractCommand
{

    protected function configure()
    {
        $this->setName('fixtures:load')
            ->setDescription(
                'Imports yml fixtures'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Currently we have calculated fields without any class attached
        $this->disableLogging();

        $fixturesFiles = FixtureLoader::getFixturesFiles();
        $progress = new ProgressBar($output, count($fixturesFiles));
        $progress->start();
        $progress->setFormat(" %current%/%max% [%bar%] %percent:3s%% Loading %filename%\n");
        foreach(FixtureLoader::getFixturesFiles() as $fixtureFile){
            FixtureLoader::load($fixtureFile);
            $progress->setMessage($fixtureFile, 'filename');
            $progress->advance();
        }
        $progress->finish();
        $progress->clear();
        $this->dump('Done');
    }

}
