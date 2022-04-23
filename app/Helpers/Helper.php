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
 * @return false|string
 */
function getGitHEAD()
{
    if ($head = file_get_contents(base_path() . '/.git/HEAD')) {
        return substr($head, 5, -1);
    } else {
        return false;
    }
}

/**
 * @return false|string
 */
function getCurrentGitCommit()
{
    try {
        if ($hash = file_get_contents(base_path() . '/.git/' . getGitHEAD())) {
            return $hash;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return false;
    }
}

/**
 * @return false|string
 */
function getCurrentGitCommitShort()
{
    return substr(getCurrentGitCommit(), 0, 7);
}
