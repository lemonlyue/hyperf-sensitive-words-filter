<?php

declare(strict_types=1);

namespace Lemonlyue\HyperfSensitiveWordsFilter\Contracts;

/**
 * Interface Factory
 * @package Lemonlyue\HyperfSensitiveWordsFilter\Contracts
 */
interface Factory
{
    /**
     * 敏感词过滤
     * @param string $content 需要过滤的字符串
     * @param string $level high 只要顺序包含都屏蔽 | middle 中间间隔skipDistance个字符就屏蔽 | low 全词匹配即屏蔽
     * @param int $skipDistance 允许敏感词跳过的最大距离，如笨aa蛋a傻瓜等等
     * @param bool $isReplace 是否需要替换，不需要的话，返回是否有敏感词，否则返回被替换的字符串
     * @param string $replace 替换字符
     * @return bool|string
     */
    public function filter($content, $level = 'middle', $skipDistance = 4, $isReplace = true, $replace = '*');
}