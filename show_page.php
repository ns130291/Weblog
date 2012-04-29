<!DOCTYPE html>
<?php
$link = mysql_connect("localhost:3306", "root");
mysql_set_charset('utf8');
if (!$link) {
    die('Verbindung schlug fehl: ' . mysql_error());
}
mysql_select_db('weblog');
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
        </div>
    </body>
</html>
