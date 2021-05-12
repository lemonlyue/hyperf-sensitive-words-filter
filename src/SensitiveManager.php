<?php


namespace Lemonlyue\HyperfSensitiveWordsFilter;

use Hyperf\Contract\ConfigInterface;
use Lemonlyue\HyperfSensitiveWordsFilter\Contracts\Factory;
use Psr\Container\ContainerInterface;

/**
 * Class SensitiveManager
 * @package Lemonlyue\HyperfSensitiveWordsFilter
 */
class SensitiveManager implements Factory
{
    /**
     * @var ContainerInterface
     */
    protected $app;

    /**
     * @var array
     */
    protected $driver = [];

    /**
     * SensitiveManager constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->app = $container;
    }

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->{$method}(...$parameters);
    }

    /**
     * @return mixed
     */
    public function driver()
    {
        $driver = $this->getDefaultDriver();
        return $this->driver[$driver] = $this->get($driver);
    }

    /**
     * 敏感词过滤
     *
     * @param string $content 需要过滤的字符串
     * @param string $level high 只要顺序包含都屏蔽 | middle 中间间隔skipDistance个字符就屏蔽 | low 全词匹配即屏蔽
     * @param int $skipDistance 允许敏感词跳过的最大距离，如笨aa蛋a傻瓜等等
     * @param bool $isReplace 是否需要替换，不需要的话，返回是否有敏感词，否则返回被替换的字符串
     * @param string $replace 替换字符
     * @return bool|string
     */
    public function filter($content, $level = 'middle', $skipDistance = 4, $isReplace = true, $replace = '*')
    {

    }

    /**
     * get default driver
     *
     * @return mixed
     */
    public function getDefaultDriver()
    {
        return $this->app->get(ConfigInterface::class)->get('sensitive.default', 'redis');
    }

    /**
     * set default driver
     *
     * @param $driver
     * @return mixed
     */
    public function setDefaultDriver($driver)
    {
        return $this->app->get(ConfigInterface::class)->set('sensitive.default', $driver);
    }

    /**
     * @param $driver
     * @return mixed|void
     */
    public function get($driver)
    {
        return $this->driver[$driver] ?? $this->resolve($driver);
    }

    /**
     * @param $driver
     * @return mixed
     */
    public function resolve($driver)
    {
        $config = $this->getConfig($driver);

        if (is_null($config)) {
            throw new \InvalidArgumentException("Cache driver config [{$driver}] is not defined.");
        }

        $driverMethod = 'create' . ucfirst($config['driver']) . 'Driver';
        if (method_exists($this, $driverMethod)) {
            return $this->{$driverMethod}($config);
        }

        throw new \InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
    }

    public function getConfig($driver)
    {
        if ($driver !== 'null' && !is_null($driver)) {
            return $this->app->get(ContainerInterface::class)->get("sensitive.driver.{$driver}");
        }
        return [
            'driver' => 'null'
        ];
    }
}