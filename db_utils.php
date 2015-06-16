<?php
    function make_link($config) {
        $link = mysql_connect($config['db']['host'], $config['db']['user'],
                              $config['db']['password']);
        mysql_select_db($config['db']['database'], $link);
        if (mysql_errno($link)) {
            echo mysql_errno($link).':'.mysql_error($link);
        }
        return $link;
    }

    function make_query($query, $link) {
        $result = mysql_query($query, $link);
        if (mysql_errno($link))
            echo mysql_errno($link).':'.mysql_error($link);
        return result;
    }

    function make_close($link) {
        mysql_close($link);
    }
