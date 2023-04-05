<?php
    define('LOBBY', 4);
    define('TITLE', 'Agents | VALORANT');
    include('includes/header.html');
    include('includes/navbar.html');
    if(!isset($_SESSION['user'])) header("Location: index.php");
?>

<div class="container">
    <div class="valorant-form">
        <h1 style="text-align: center;">Agents</h1>
    </div>

<?php
    include('includes/mysql_connect.php');
    $query = "SELECT * FROM agents";
    $r = mysqli_query($dbc, $query);
    while($row = mysqli_fetch_array($r)) {
    ?>

    <div class="valorant-form">
        <div class="row">
            <div class="col-md-4">
                <img src="
                    <?php print $row['img_loc']; ?>
                " style="width: 100%;">
            </div>
            <div class="col-md-8">
                <b>NAME:</b> 
                    <?php print $row['name']; ?> <br />
                <b>TYPE:</b> 
                    <?php print $row['type']; ?> <br />
                <hr />
                <b>SKILLS:</b><br />
                - <?php print $row['1st_skill']; ?><br />
                - <?php print $row['2nd_skill']; ?><br />
                - <?php print $row['3rd_skill']; ?><br />
                - <?php print $row['ultimate_skill']; ?><br />
            </div>
        </div>
    </div>
        
    <?php
    }
?>

</div>

<?php
    include('includes/footer.html');
?>