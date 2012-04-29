<!DOCTYPE html>
<?php
//MySQL-Verbindung aufbauen und Datenbank wählen
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
        <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
        <script type="text/javascript" src="/Weblog/script.js"></script>
    </head>
    <body>
        <div id="main">
            <header>
                <h1>Weblog</h1>
            </header>
            <nav id="mainnav">
                <div>
                    <a href="/Weblog/article/latest/">article</a>
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
                        $result = mysql_query('SELECT date,author,title,text,`previous-link`,`next-link`,id FROM weblog.article WHERE id=' . $_GET["id"]);
                    }
                } else {
                    $result = mysql_query('SELECT date,author,title,text,`previous-link`,`next-link`,id FROM weblog.article,(SELECT MAX(date) as maxdate FROM weblog.article) maxi WHERE maxi.maxdate = date AND `next-link` IS NULL');
                }
                if (!$result) {
                    echo 'Artikel konnte nicht geladen werden';
                } else {
                    echo mysql_error();
                    $row = mysql_fetch_row($result);
                    $next = $row[5];
                    $previous = $row[4];
                    $id = $row[6];
                    //Autor abfragen
                    $result = mysql_query('SELECT name FROM weblog.user WHERE email="' . $row[1] . '"');
                    $row2 = mysql_fetch_row($result);
                    $author = $row2[0];
                    ?>
                    <article>
                        <h2><?php echo $row[2]; ?></h2>
                        <figure>
                        </figure>
                        <div id="author">posted by <?php echo $author; ?> on <?php echo $row[0]; ?></div>   
                        <div id="line">
                            <div></div>
                        </div>
                        <div id="article"><?php echo $row[3]; ?></div>
                        <div id="articlenav">
                            <div id="next" class="button"><?php
                if ($next != 0) {
                    $result = mysql_query("SELECT id, title FROM weblog.article WHERE id=" . $next);
                    if ($result) {
                        $row = mysql_fetch_row($result);
                            ?>
                                        <a href="/Weblog/article/<?php echo $row[0] . "/" . strtolower(str_replace(" ", "_", $row[1])); ?>/">next</a>
                                        <?php
                                    }
                                }
                                ?></div>
                            <div id="previous" class="button"><?php
                            if ($previous != 0) {
                                $result = mysql_query("SELECT id, title FROM weblog.article WHERE id=" . $previous);
                                if ($result) {
                                    $row = mysql_fetch_row($result);
                                        ?>
                                        <a href="/Weblog/article/<?php echo $row[0] . "/" . strtolower(str_replace(" ", "_", $row[1])); ?>/">previous</a>
                                        <?php
                                    }
                                }
                                ?></div>
                            <div class="clear"></div>
                        </div>
                    </article>
                    <div id="comments">
                        <div id="newcomment">
                            <div class="tablecell">
                                <?php
                                if ($_SESSION['userstate'] == -1) {
                                    ?>                            
                                    <div id="emailwrapper">
                                        <label id="l_email" for="email">email</label>
                                        <input name="email" type="email" id="email"/>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div>
                                    <textarea id="comment" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="tablecell" id="postbutton">
                                <div class="button" onclick="postcomment(<?php echo $id; ?>)"><div>POST</div></div>
                            </div>
                        </div>
                        <div id="commentcontainer">
                            <?php
                            $result = mysql_query("SELECT author, email, date, text FROM weblog.comment WHERE article=" . $id . " ORDER BY id");
                            if ($result) {
                                if (mysql_num_rows($result)) {
                                    while ($row = mysql_fetch_row($result)) {
                                        ?>
                                        <div>
                                            <div class="left">
                                                <div class="comauth">
                                                    <?php
                                                    echo $row[0];
                                                    echo $row[1];
                                                    ?>
                                                </div>
                                                <div class="date">
                                                    on <?php echo $row[2]; ?>
                                                </div>
                                            </div>
                                            <div class="comment">
                                                <span>
                                                    <?php
                                                    echo $row[3];
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div>
                                        <?php
                                        echo "no comments";
                                        ?>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "no comments";
                            }
                        }
                        ?>
                    </div>
                </div>
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
                        <input type="email" name="username" id="username">
                    </div>
                    <div class="login">
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="login">
                        <div class="button" onclick="login()">
                            <div id="login">login</div>
                        </div>
                    </div>
                    <div id="error">error</div>
                    <?php
                }
                ?>
            </footer>
        </div>
    </body>
</html>
