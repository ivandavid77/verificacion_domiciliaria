<?php
function createLink($host, $user, $password, $database)
{
    $link = mysqli_connect($host, $user, $password, $database);
    if (mysqli_connect_errno()) {
        echo mysqli_connect_errno() . ':' .  mysqli_connect_error();
    }
    return $link;
}

function getNumRows($result)
{
    return mysqli_num_rows($result);
}

function doQuery($query, $link, &$err)
{
    $result = mysqli_query($link, $query);
    if (mysqli_connect_errno()) {
        $err = mysqli_connect_errno() . ':' .  mysqli_connect_error();
    }
    return $result;
}

function doClose($link)
{
    mysqli_close($link);
}

function getDict($result)
{
    return mysqli_fetch_assoc($result);
}

function escape($text, $link)
{
    return mysqli_real_escape_string($link, strval($text));
}

function sanitizeString($text)
{
    return $text;
}
