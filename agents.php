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
            $agents = $row;
    ?>

    <div class="valorant-form">
        <div class="row">
            <div class="col-md-4">
                <img src="
                    <?php
                        print $agents['img_loc']; 
                    ?>
                " style="width: 100%;">
            </div>
            <div class="col-md-8">
                <p>
                    <b>NAME:</b> 
                    <?php 
                        print $agents['name']; 
                    ?>
                </p>
                <p>
                    <b>TYPE:</b> 
                    <?php 
                        print $agents['type']; 
                    ?>
                </p>
                <hr />
                <p><b>SKILLS:</b></p>
                <p>- 
                    <?php 
                        print $agents['1st_skill']; 
                    ?>
                </p>
                <p>- 
                    <?php 
                        print $agents['2nd_skill']; 
                    ?>
                </p>
                <p>- 
                    <?php 
                        print $agents['3rd_skill']; 
                    ?>
                </p>
                <p>- 
                    <?php 
                        print $agents['ultimate_skill']; 
                    ?>
                </p>
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