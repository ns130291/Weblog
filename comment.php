<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['comment']) && isset($_POST['id'])) {
        if ($_POST['comment'] != "" && $_POST['id'] != "") {
            $link = mysql_connect('localhost:3306', 'root');
            if (!$link) {
                echo '-1';
            }
            mysql_set_charset('utf8');
            if (isset($_POST['email'])) {
                if ($_POST['email'] != "") {
                    mysql_query('INSERT INTO weblog.comment (email, article, text, date) VALUES ("' . $_POST['email'] . '","' . $_POST['id'] . '","' . $_POST['comment'] . '","' . date("Y-m-d") . '")');
                    echo 'INSERT INTO weblog.comment (email, article, text, date) VALUES ("' . $_POST['email'] . '","' . $_POST['id'] . '","' . $_POST['comment'] . '","' . date("Y-m-d") . '")';
                }
            } else {
                mysql_query('INSERT INTO weblog.comment (author, article, text, date) VALUES ("' . $_SESSION['useremail'] . '","' . $_POST['id'] . '","' . $_POST['comment'] . '","' . date("Y-m-d") . '")');
                echo 'INSERT INTO weblog.comment (author, article, text, date) VALUES ("' . $_SESSION['useremail'] . '","' . $_POST['id'] . '","' . $_POST['comment'] . '","' . date("Y-m-d") . '")';
            }
            //echo date("Y-m-d");
            echo mysql_error();
        } else {
            echo '-1';
            echo 'comment oder id nicht gesetzt';
        }
    } else {
        echo '-1';
        echo 'comment oder id nicht gesetzt';
    }
} else {
    echo '-1';
    echo 'kein POST-Request';
}
?>
