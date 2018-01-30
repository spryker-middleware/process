<?php
namespace SprykerMiddleware\Zed\Process\Communication\Console;

use Generated\Shared\Transfer\AggregatorSettingsTransfer;
use Generated\Shared\Transfer\IteratorSettingsTransfer;
use Generated\Shared\Transfer\LoggerSettingsTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\WriterConfigTransfer;
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
    const COMMAND_NAME = 'middleware:process:run';
    const DESCRIPTION = 'Run middleware process';
    const OPTION_PROCESS_NAME = 'process';
    const OPTION_ITERATOR_OFFSET = 'skip';
    const OPTION_ITERATOR_LIMIT = 'limit';
    const OPTION_LOG_LEVEL = 'flagLogLevel';
    const OPTION_INPUT = 'input';
    const OPTION_OUTPUT = 'output';
    const OPTION_PROCESS_NAME_SHORTCUT = 'p';
    const OPTION_ITERATOR_OFFSET_SHORTCUT = 's';
    const OPTION_ITERATOR_LIMIT_SHORTCUT = 'l';
    const OPTION_LOG_LEVEL_SHORTCUT = 'f';
    const OPTION_INPUT_SHORTCUT = 'i';
    const OPTION_OUTPUT_SHORTCUT = 'o';

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
        $processSettingsTransfer->setAggregatorSettings(new AggregatorSettingsTransfer());
        $processSettingsTransfer->getAggregatorSettings()->setWriterConfig(new WriterConfigTransfer());
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
        $processSettingsTransfer->setIteratorSettings(new IteratorSettingsTransfer());
        $offset = $input->getOption(static::OPTION_ITERATOR_OFFSET) ?: 0;
        $limit = $input->getOption(static::OPTION_ITERATOR_LIMIT) ?: -1;
        $processSettingsTransfer->getIteratorSettings()->setOffset($offset);
        $processSettingsTransfer->getIteratorSettings()->setLimit($limit);
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
        $logLevel = $input->getOption(static::OPTION_LOG_LEVEL);
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
