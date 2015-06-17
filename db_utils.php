<?php
    function make_link($host, $user, $password, $database) {
        $link = mysql_connect($host, $user, $password);
        mysql_select_db($database, $link);
        if (mysql_errno($link)) {
            echo mysql_errno($link).':'.mysql_error($link);
        }
        return $link;
    }

    function make_query($query, $link) {
        $result = mysql_query($query, $link);
        if (mysql_errno($link))
            echo mysql_errno($link).':'.mysql_error($link);
        return $result;
    }

    function make_close($link) {
        mysql_close($link);
    }

    function get_dict($result) {
        return mysql_fetch_assoc($result);
    }

    function escape($text) {
        return mysql_real_escape_string(strval($text));
    }

    function sanitize_string($text) {
        return $text;
    }
