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
        if (isset($_POST['text']) && isset($_POST['title'])) {
            if ($_POST['text'] != "" && $_POST['title'] != "") {
                $link = mysql_connect('localhost:3306', 'root');
                if (!$link) {
                    echo '-1';
                }
                mysql_set_charset('utf8');
                $result = mysql_query('SELECT max(id) FROM weblog.article');
                $row = mysql_fetch_row($result);
                mysql_query('INSERT INTO weblog.article (title, text, author, `previous-link`, date) VALUES ("' . $_POST['title'] . '","' . $_POST['text'] . '","' . $_SESSION['useremail'] . '","' . $row[0]  . '","' . date("Y-m-d") . '")');
                mysql_error();
                $result = mysql_query('SELECT max(id) FROM weblog.article');
                $row2 = mysql_fetch_row($result);
                mysql_query('UPDATE weblog.article SET `next-link`="' . $row2[0] . '" WHERE id="' . $row[0] . '"');
                mysql_error();
            }
        } else {
            echo '-1';
            echo 'irgendwas nicht vorhanden';
        }
    }
} else {
    echo '-1';
    echo 'kein POST-Request';
}
?>
