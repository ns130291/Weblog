<!DOCTYPE html>
<?php
$link = mysql_connect("localhost:3306", "root");
mysql_set_charset('utf8');
if (!$link) {
    die('Verbindung schlug fehl: ' . mysql_error());
}
mysql_select_db('weblog');

//Session-Verwaltung
session_start();
if ($_SESSION) {
    if (!isset($_SESSION['userstate'])) {
        $_SESSION['userstate'] = -1;
    }
} else {
    $_SESSION['userstate'] = -1;
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Weblog</title>
        <link rel="stylesheet" type="text/css" href="/Weblog/style.css">
        <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'> 
        <link href='http://fonts.googleapis.com/css?family=Belleza' rel='stylesheet' type='text/css'> 
    </head>
    <body>
        <div id="main">
            <header>
                <h1>Weblog</h1>
            </header>
            <nav id="mainnav">
                <div>
                    <a href="/Weblog/article/latest/">Articles</a>
                </div>
                <?php
                $result = mysql_query("SELECT id, name FROM weblog.page ORDER BY position");
                if (!$result) {
                    echo 'Error loading navigation content';
                } else {
                    while ($row = mysql_fetch_row($result)) {
                        ?>
                        <div>
                            <a href="/Weblog/page/<?php echo $row[0] . "/" . strtolower(str_replace(" ", "_", $row[1])); ?>/"><?php echo $row[1]; ?></a>
                        </div>
                        <?php
                    }
                }
                ?>
            </nav>
            <section>
                <?php
                if (!empty($_GET["id"])) {
                    if (is_numeric($_GET["id"])) {
                        $result = mysql_query("SELECT name, content FROM weblog.page WHERE id=" . $_GET["id"]);
                        if (!$result) {
                            echo "Error loading page";
                        } else {
                            $row = mysql_fetch_row($result);
                            if ($row) {
                                ?>
                                <h2>
                                    <?php echo $row[0]; ?>
                                </h2>
                                <div>
                                    <?php echo $row[1]; ?>
                                </div>
                                <?php
                            }
                        }
                    }
                } else {
                    echo "Error loading page";
                }
                ?>
            </section>
            <div class="clear"></div>
                        <footer>
                <?php
//echo $_SESSION['userstate'];
                if ($_SESSION['userstate'] > -1) {
                    ?>
                    <div class="login">You are logged in as <span class="username"><?php echo $_SESSION['username']; ?></span></div>
                    <div class="login">
                        <div class="button" onclick="logout()">
                            <div>logout</div>                            
                        </div>                        
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="login">
                        <input type="email" name="username" id="username" placeholder="email">
                    </div>
                    <div class="login">
                        <input type="password" name="password" id="password" placeholder="password">
                    </div>
                    <div class="login">
                        <div class="button" onclick="login()">
                            <div id="login">login</div>
                        </div>
                    </div>
                    <div id="error">error</div>
                    <div class="login">
                        <div class="button" onclick="register()">
                            <div id="login">register</div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="clear"></div>
            </footer>
        </div>
    </body>
</html>
