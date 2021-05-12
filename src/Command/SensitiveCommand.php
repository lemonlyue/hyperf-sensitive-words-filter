<?php


namespace Lemonlyue\HyperfSensitiveWordsFilter\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Swoole\Coroutine\System;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
class SensitiveCommand extends HyperfCommand
{
    /**
     * 执行命令行
     * @var string
     */
    protected $name = 'sensitive:publish';

    public function configure()
    {
        parent::configure();
        $this->addArgument('generate', InputArgument::OPTIONAL, '生成');
    }
    
    /**
     * @inheritDoc
     */
    public function handle()
    {
        // 获取命令行参数
        $argument = $this->input->getOptions();
        if ($argument['config']) {
            $this->copySource(__DIR__ . '/../../publish/sensitive.php', BASE_PATH . '/config/autoload/sensitive.php');
            $this->line('The hyperf-sensitive-words-filter configuration file has been generated', 'info');
        }
        if ($argument['generate']) {
            $this->generateSensitiveCache();
            $this->line('The sensitive words has been generated', 'info');
        }
    }

    protected function getOptions()
    {
        return [
            ['config', NULL, InputOption::VALUE_NONE, 'Publish the configuration for hyperf-sensitive-words-filter'],
            ['generate', NULL, InputOption::VALUE_NONE, 'Generate sensitive words'],
        ];
    }

    /**
     * 复制文件到指定的目录中
     * @param $copySource
     * @param $toSource
     */
    protected function copySource($copySource, $toSource)
    {
        copy($copySource, $toSource);
    }

    /**
     * 生成敏感词缓存
     */
    protected function generateSensitiveCache()
    {
        $config = config('sensitive');
        $path = $config['file']['path'];
        $fp = fopen($path, 'rb+');
        $content = System::fread($fp);
        $words = explode(PHP_EOL, $content);

        $redisConfig = config('redis');
    }
}