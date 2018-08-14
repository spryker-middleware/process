<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Console;

use Generated\Shared\Transfer\IteratorConfigTransfer;
use Generated\Shared\Transfer\LoggerConfigTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Monolog\Logger;
use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
class ProcessConsole extends Console
{
    protected const COMMAND_NAME = 'middleware:process:run';
    protected const DESCRIPTION = 'Run middleware process';
    protected const OPTION_PROCESS_NAME = 'process';
    protected const OPTION_ITERATOR_OFFSET = 'skip';
    protected const OPTION_ITERATOR_LIMIT = 'limit';
    protected const OPTION_LOG_LEVEL = 'flagLogLevel';
    protected const OPTION_INPUT = 'input';
    protected const OPTION_OUTPUT = 'output';
    protected const OPTION_PROCESS_NAME_SHORTCUT = 'p';
    protected const OPTION_ITERATOR_OFFSET_SHORTCUT = 's';
    protected const OPTION_ITERATOR_LIMIT_SHORTCUT = 'l';
    protected const OPTION_LOG_LEVEL_SHORTCUT = 'f';
    protected const OPTION_INPUT_SHORTCUT = 'i';
    protected const OPTION_OUTPUT_SHORTCUT = 'o';

    /**
     * @var int
     */
    protected $exitCode = self::CODE_SUCCESS;

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION);

        $this->addOption(
            static::OPTION_PROCESS_NAME,
            static::OPTION_PROCESS_NAME_SHORTCUT,
            InputOption::VALUE_REQUIRED,
            'Name of middleware process.'
        );

        $this->addOption(
            static::OPTION_ITERATOR_OFFSET,
            static::OPTION_ITERATOR_OFFSET_SHORTCUT,
            InputOption::VALUE_OPTIONAL,
            'Count of items that should be skipped during processing'
        );

        $this->addOption(
            static::OPTION_ITERATOR_LIMIT,
            static::OPTION_ITERATOR_LIMIT_SHORTCUT,
            InputOption::VALUE_OPTIONAL,
            'Count of items that should be processed'
        );

        $this->addOption(
            static::OPTION_LOG_LEVEL,
            static::OPTION_LOG_LEVEL,
            InputOption::VALUE_OPTIONAL,
            'Flag of Log level [Critical, Error, Warning, Info, Debug]'
        );

        $this->addOption(
            static::OPTION_INPUT,
            static::OPTION_INPUT_SHORTCUT,
            InputOption::VALUE_REQUIRED,
            'Input Stream'
        );

        $this->addOption(
            static::OPTION_OUTPUT,
            static::OPTION_OUTPUT_SHORTCUT,
            InputOption::VALUE_REQUIRED,
            'Output Stream'
        );
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
        if ($input->getOption(static::OPTION_PROCESS_NAME)) {
            $processSettingsTransfer->setName($input->getOption(static::OPTION_PROCESS_NAME));
            $this->processStreamArgs($input, $processSettingsTransfer);
            $this->setIteratorOptions($input, $processSettingsTransfer);
            $this->setLoggerOptions($input, $output, $processSettingsTransfer);

            return $processSettingsTransfer;
        }
        $this->exitCode = static::CODE_ERROR;
        $this->error('Process name is required.');
        return $processSettingsTransfer;
    }

    /**
     * @return bool
     */
    protected function hasError()
    {
        return $this->exitCode !== static::CODE_SUCCESS;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return void
     */
    protected function setIteratorOptions(InputInterface $input, ProcessSettingsTransfer $processSettingsTransfer): void
    {
        $processSettingsTransfer->setIteratorConfig(new IteratorConfigTransfer());
        $offset = $input->getOption(static::OPTION_ITERATOR_OFFSET) ?: 0;
        $limit = $input->getOption(static::OPTION_ITERATOR_LIMIT) ?: -1;
        $processSettingsTransfer->getIteratorConfig()->setOffset($offset);
        $processSettingsTransfer->getIteratorConfig()->setLimit($limit);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output): ?int
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
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return void
     */
    protected function setLoggerOptions(
        InputInterface $input,
        OutputInterface $output,
        ProcessSettingsTransfer $processSettingsTransfer
    ): void {
        $processSettingsTransfer->setLoggerConfig(new LoggerConfigTransfer());
        $processSettingsTransfer->getLoggerConfig()->setIsQuiet($output->isQuiet());
        $logLevel = $input->getOption(static::OPTION_LOG_LEVEL);
        if ($logLevel) {
            $verboseLevel = Logger::toMonologLevel($logLevel);
            $processSettingsTransfer->getLoggerConfig()->setVerboseLevel($verboseLevel);
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
        $processSettingsTransfer->getLoggerConfig()->setVerboseLevel($verboseLevel);
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return void
     */
    protected function processStreamArgs(InputInterface $input, ProcessSettingsTransfer $processSettingsTransfer): void
    {
        $inputPath = 'php://stdin';
        $outputPath = 'php://stdout';
        if ($input->getOption(self::OPTION_INPUT)) {
            $inputPath = $input->getOption(self::OPTION_INPUT);
        }
        if ($input->getOption(self::OPTION_OUTPUT)) {
            $outputPath = $input->getOption(self::OPTION_OUTPUT);
        }
        $processSettingsTransfer->setInputPath($inputPath);
        $processSettingsTransfer->setOutputPath($outputPath);
    }
}
