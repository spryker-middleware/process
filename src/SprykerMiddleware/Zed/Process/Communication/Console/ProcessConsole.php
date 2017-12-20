<?php
namespace SprykerMiddleware\Zed\Process\Communication\Console;

use Generated\Shared\Transfer\IteratorSettingsTransfer;
use Generated\Shared\Transfer\LoggerSettingsTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Monolog\Logger;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacade getFacade()
 */
class ProcessConsole extends Console
{
    const COMMAND_NAME = 'middleware:process:run';
    const DESCRIPTION = 'Run middleware process';
    const OPTION_PROCESS_NAME = 'process';
    const OPTION_ITERATOR_OFFSET = 'offset';
    const OPTION_ITERATOR_LIMIT = 'limit';
    const OPTION_LOG_LEVEL = 'flagLogLevel';

    /**
     * @var int
     */
    protected $exitCode = self::CODE_SUCCESS;

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION);

        $this->addOption(
            static::OPTION_PROCESS_NAME,
            'p',
            InputOption::VALUE_REQUIRED,
            'Name of middleware process.'
        );

        $this->addOption(
            static::OPTION_ITERATOR_OFFSET,
            'o',
            InputOption::VALUE_OPTIONAL,
            'Count of items that should be skipped during processing'
        );

        $this->addOption(
            static::OPTION_ITERATOR_LIMIT,
            'l',
            InputOption::VALUE_OPTIONAL,
            'Count of items that should be processed'
        );

        $this->addOption(
            static::OPTION_LOG_LEVEL,
            'f',
            InputOption::VALUE_OPTIONAL,
            'Flag of Log level [Critical, Error, Warning, Info, Debug]'
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $processSettingsTransfer = $this->processArgs($input, $output);
        if ($this->hasError()) {
            return $this->exitCode;
        }
        $this->getFacade()
            ->process($processSettingsTransfer);

        return $this->exitCode;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \Generated\Shared\Transfer\ProcessSettingsTransfer
     */
    protected function processArgs(InputInterface $input, OutputInterface $output): ProcessSettingsTransfer
    {
        $processSettingsTransfer = new ProcessSettingsTransfer();
        if ($input->getOption(self::OPTION_PROCESS_NAME)) {
            $processSettingsTransfer->setName($input->getOption(self::OPTION_PROCESS_NAME));
            $this->setIteratorOptions($input, $processSettingsTransfer);
            $this->setLoggerOptions($input, $output, $processSettingsTransfer);

            return $processSettingsTransfer;
        }
        $this->exitCode = self::CODE_ERROR;
        $this->error('Process name is required.');
        return $processSettingsTransfer;
    }

    /**
     * @return bool
     */
    protected function hasError()
    {
        return $this->exitCode !== self::CODE_SUCCESS;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return void
     */
    protected function setIteratorOptions(InputInterface $input, ProcessSettingsTransfer $processSettingsTransfer): void
    {
        $processSettingsTransfer->setIteratorSettings(new IteratorSettingsTransfer());
        $offset = $input->getOption(self::OPTION_ITERATOR_OFFSET) ?: 0;
        $limit = $input->getOption(self::OPTION_ITERATOR_LIMIT) ?: -1;
        $processSettingsTransfer->getIteratorSettings()->setOffset($offset);
        $processSettingsTransfer->getIteratorSettings()->setLimit($limit);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return void
     */
    protected function setLoggerOptions(
        InputInterface $input,
        OutputInterface $output,
        ProcessSettingsTransfer $processSettingsTransfer
    ): void {
        $processSettingsTransfer->setLoggerSettings(new LoggerSettingsTransfer());
        $processSettingsTransfer->getLoggerSettings()->setIsQuiet($output->isQuiet());
        $logLevel = $input->getOption(self::OPTION_LOG_LEVEL);
        if ($logLevel) {
            $verboseLevel = Logger::toMonologLevel($logLevel);
            $processSettingsTransfer->getLoggerSettings()->setVerboseLevel($verboseLevel);
            return;
        }
        $verboseLevel = Logger::ERROR;
        if ($output->isVerbose()) {
            $verboseLevel = Logger::WARNING;
        }
        if ($output->isVeryVerbose()) {
            $verboseLevel = Logger::INFO;
        }
        if ($output->isDebug()) {
            $verboseLevel = Logger::DEBUG;
        }
        $processSettingsTransfer->getLoggerSettings()->setVerboseLevel($verboseLevel);
    }
}
