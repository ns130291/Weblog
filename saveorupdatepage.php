<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['articleid']) && (isset($_POST['text']) || isset($_POST['title']))) {
        if ($_POST['articleid'] != "" && ($_POST['text'] != "" || $_POST['title'] != "")) {
            $link = mysql_connect('localhost:3306', 'root');
            if (!$link) {
                echo '-1';
            }
            mysql_set_charset('utf8');
            if ($_POST['text'] != "") {
                mysql_query('UPDATE weblog.article SET text="' . $_POST['text'] . '" WHERE id="' . $_POST['articleid'] . '"');
            } else {
                mysql_query('UPDATE weblog.article SET title="' . $_POST['title'] . '" WHERE id="' . $_POST['articleid'] . '"');
            }
        } else {
            echo '-1';
            echo 'irgendwas nicht gesetzt';
        }
    } else {
        echo '-1';
        echo 'irgendwas nicht vorhanden';
    }
} else {
    echo '-1';
    echo 'kein POST-Request';
}
?>
