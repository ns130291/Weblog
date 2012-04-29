<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $link = mysql_connect('localhost:3306', 'root');
    mysql_set_charset('utf8');
    if (!$link) {
        echo '-1';
    }
    mysql_set_charset('utf8');
    if (isset($_POST['username']) && isset($_POST['password'])) {        
        $result = mysql_query("SELECT password, status, name FROM weblog.user WHERE email=".$username);
        if (!$result) {
            echo '-1';
        } else {
            $row = mysql_fetch_assoc($result);
            if($_POST['password']==$row[0]){
                echo $row[1].";".$row[2];
            }else{
                echo '-1';
            }            
        }
        mysql_close($link);
    }
}else{
    echo '-1';
}
?>
