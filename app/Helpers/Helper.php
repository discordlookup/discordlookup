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
