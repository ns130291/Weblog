<?php

session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $link = mysql_connect('localhost:3306', 'root');
    if (!$link) {
        echo '-1';
    }
    mysql_set_charset('utf8');
    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] != "" && $_POST['password'] != "") {
            //echo $_POST['username'];
            $result = mysql_query("SELECT password, status, name FROM weblog.user WHERE email='" . $_POST['username'] . "'");
            if (!$result) {
                echo '-1';
                //echo "kein result";
            } else {
                $row = mysql_fetch_array($result);
                if ($_POST['password'] == $row[0]) {
                    //echo $row[1].";".$row[2];
                    echo "1";
                    $_SESSION['userstate'] = $row[1];
                    $_SESSION['username'] = $row[2];
                    $_SESSION['useremail'] = $_POST['username'];
                } else {
                    echo '-1';
                    //echo $row[0];
                    //echo "pw falsch";
                }
            }
            mysql_close($link);
        } else {
            echo '-1';
        }
    } else {
        echo '-1';
    }
} else {
    echo '-1';
}
?>
