<html>
<head>
    <title>LA Spots!</title>
    <link rel="icon" type="image/x-icon" href="la-spots/public/favicon.ico">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<div class="navbar">
    <a href="frontpage.html" class="logo">&nbsp;</a>
    <a href="la-spots/src/PHP files/search-spots.php">Search</a>
    <a href="login.php" class="profile green">&nbsp;</a>
</div>
<div class="margins">
<?php

if(empty($_REQUEST['type'])) {
    header("Location: search-spots.php");
}

$host = "webdev.iyaserver.com";
$userid = "sandmanl";
$userpw = "Ace-sweden-sonority89!";
$db = "sandmanl_la_spots";

$mysql = new mysqli(
    $host,
    $userid,
    $userpw,
    $db
); //

if($mysql->connect_errno) {
    echo "db connection error : " . $mysql->connect_error;
    exit();
}

$sql = 	"SELECT * FROM spot_view2 WHERE 1=1";
if(!empty($_REQUEST['name'])) {
    $sql .= " AND name LIKE '%" . $_REQUEST["name"] . "%'";
}
if(!empty($_REQUEST['address'])) {
    $sql .= " AND address LIKE '%" . $_REQUEST["address"] . "%'";
}
if($_REQUEST['type'] != "ALL") {
    $sql .=		" AND type = '" . $_REQUEST["type"] . "'";
}

if($_REQUEST['interest'] != "ALL") {
    $sql .=		" AND interest = '" . $_REQUEST["interest"] . "'";
}
if($_REQUEST['price'] != "ALL") {
    $sql .=		" AND price = '" . $_REQUEST["price"] . "'";
}
//$sql .= " AND price < '" . $_REQUEST["max_price"] . "'";
//$sql .= " AND price > '" . $_REQUEST["min_price"] . "'\n";


$results = $mysql->query($sql);

if(!$results) {
    echo "<hr>Your SQL:<br> " . $sql . "<br><br>";
    echo "SQL Error: " . $mysql->error . "<hr>";
    exit();
}

echo "<em>Found <strong>" .
    $results->num_rows .
    "</strong> results.</em>";
echo "<br><br>";

//while($currentrow = $results->fetch_assoc()) {
//    echo "<img alt='" . $currentrow['name'] . "' src='" . $currentrow['photo'] . "' width=100px> " .
//        "<strong><a href='details-spots.php?id=" . $currentrow['spot_id'] . "'" .
//        $currentrow['name'] . "</strong></a>" .
//        $currentrow['address'] . "<em>" .
//        $currentrow['type'] . "</em>" .
//        $currentrow['interest'] .
//        $currentrow['price'];
//}

?>

<div class="gallery">

    <?php while($currentrow = $results->fetch_assoc()): ?>

        <div class="gallery-item">

            <div class="image" style="background-image: url('<?php echo $currentrow['photo_url']; ?>')"></div>

            <div class="details">
                <div class="overlay">
                <h3><?php echo $currentrow['name']; ?></h3>
                <p class="address"><?php echo $currentrow['address']; ?></p>
                <p><em><?php echo $currentrow['type']; ?></em></p>
                <p><?php echo $currentrow['interest']; ?></p>
                <p><?php echo $currentrow['price']; ?></p>
                </div>
            </div>

        </div>

    <?php endwhile; ?>

</div>
</div>

</body>
</html>

