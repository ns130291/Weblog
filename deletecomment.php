<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        if ($_POST['id'] != "") {
            $link = mysql_connect('localhost:3306', 'root');
            if (!$link) {
                echo '-1';
            }
            mysql_set_charset('utf8');
            mysql_query('DELETE FROM weblog.comment WHERE id="' . $_POST['id'] . '"');
            echo mysql_error();
        } else {
            echo '-1';
            echo 'id leer';
        }
    } else {
        echo '-1';
        echo 'id nicht gesetzt';
    }
} else {
    echo '-1';
    echo 'kein POST-Request';
}
?>
