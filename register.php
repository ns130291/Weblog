<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $link = mysql_connect('localhost:3306', 'root');
    if (!$link) {
        echo '-1';
    }
    mysql_set_charset('utf8');
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name'])) {
        if ($_POST['username'] != "" && $_POST['password'] != "" && $_POST['name'] != "") {
            //echo $_POST['username'];
            $result = mysql_query('INSERT INTO weblog.user (email, name, password, status) VALUES ("' . $_POST['username'] . '","' . $_POST['password'] . '","' . $_POST['name'] . '","0")');
            echo 'INSERT INTO weblog.user (email, name, password, status) VALUES ("' . $_POST['username'] . '","' . $_POST['password'] . '","' . $_POST['name'] . '","0")';
            //$result = mysql_query("SELECT password, status, name FROM weblog.user WHERE email='" . $_POST['username'] . "'");
            if (!$result) {
                echo '-1';
                echo "kein result";
            } else {
                $_SESSION['userstate'] = 0;
                $_SESSION['username'] = $_POST['name'];
                $_SESSION['useremail'] = $_POST['username'];
            }
            mysql_close($link);
        } else {
            echo '-1';
            echo 'irgendwas leer';
        }
    } else {
        echo '-1';
        echo 'irgendwas nicht da';
    }
} else {
    echo '-1';
    echo 'kein post';
}
?>
