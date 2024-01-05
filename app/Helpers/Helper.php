<?php

/**
 * @param $int
 * @return bool
 */
function validateInt($int): bool
{
    return filter_var($int, FILTER_VALIDATE_INT);
}

/**
 * @param $count
 * @param $total
 * @param $decimals
 * @return string
 */
function calcPercent($count, $total, int $decimals = 1)
{
    if($total == 0) return 0;
    return round($count / $total * 100, $decimals);
}

/**
 * @return false|string
 */
function getGitHEAD()
{
    if ($head = file_get_contents(base_path() . '/.git/HEAD'))
        return substr($head, 5, -1);
    return false;
}

/**
 * @return false|string
 */
function getCurrentGitCommit()
{
    try {
        if ($hash = file_get_contents(base_path() . '/.git/' . getGitHEAD()))
            return $hash;
    } catch (Exception $e) { }
    return false;
}

/**
 * @return false|string
 */
function getCurrentGitCommitShort()
{
    return substr(getCurrentGitCommit(), 0, 7);
}

/**
 * @param $inputString
 * @param $maxLength
 * @return string
 */
function cutString($inputString, $maxLength) {
    if (mb_strlen($inputString) > $maxLength)
        return mb_substr($inputString, 0, $maxLength - 1) . '…';
    return $inputString;
}

/**
 * Get default keywords
 *
 * @return string
 */
function getDefaultKeywords()
{
    $keywords = [
        'discord',
        'discord lookup',
        'discordlookup',
        'lookup',
        'snowflake',
        'toolbox',
        'tool box',
        'guild count',
        'invite info',
        'user info',
        'discord tools',
        'tools',
        'experiments',
        'rollouts',
        'search',
        'discord search',
    ];

    return implode(', ', $keywords);
}
