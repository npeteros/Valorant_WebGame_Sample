<?php
    define('LOBBY', 3);
    define('TITLE', 'Career | VALORANT');
    include('includes/header.html');
    include('includes/navbar.html');
    if(!isset($_SESSION['user'])) header("Location: index.php");

    include('includes/mysql_connect.php');
    
    $id = $_SESSION['user']['id'];

    $query = "SELECT * FROM accounts WHERE id = '$id'";
    $user = mysqli_fetch_array(mysqli_query($dbc, $query));

    $user_rank = $user['rank_id'];
    $wins = $user['wins'];
    $losses = $user['losses'];
    $draws = $user['draws'];
    $level = $user['level'];
    $matchmaking_rating = 0;
?>


<div class="container" style="margin-top: -100px;">
    <div class="valorant-form" style="text-align: center;">
        <h2>CAREER</h2>
    </div>
    <div class="container text-center">
        <div class="row">
            <div class="col valorant-form">
                <p><b>RANK</b></p>
                <?php
                    if($losses > 0) { // avoid Uncaught DivisionByZeroError
                        $matchmaking_rating = (($draws * 0.5) + $wins) / $losses;
                        
                        $query = "SELECT * FROM ranks";
                        $r = mysqli_query($dbc, $query);
                        while($ranks = mysqli_fetch_array($r)) {
                            if($matchmaking_rating >= $ranks['matchmaking_rating']) {
                                $rank_id = $ranks['id'];
                                $user_rank = $rank_id;
                            }
                        }

                        mysqli_query($dbc, "UPDATE accounts SET rank_id = '$rank_id' WHERE id ='$id'");
                    }
                    

                    if($user_rank != null) {
                        $rank = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM ranks WHERE id = '$user_rank'"));

                        print '
                            <img src = "' . $rank['img_loc'] . '" style = "width: 100px; height: 100px;">
                            <p><h4>' . $rank['name'] . '</h4></p>
                        ';
                    } else {
                        if($matchmaking_rating <= 0 || $level < 20) {
                            print '
                                <img src = "img/ranks/unranked.jpeg" style = "width: 100px; height: 100px;">
                                <p><h4>UNRANKED</h4></p>
                                ';
                        }
                    }
                ?>
            </div>
            <div class="col valorant-form">
                <p>
                    <b>MMR</b>
                </p>
                <?php
                    if ($losses > 0 && $level >= 20){
                        print floor($matchmaking_rating);
                    } else {
                ?>
                <p>
                    <h4>LOCKED</h4>
                </p>
                <?php
                    }
                ?>
            </div>
            <div class="col valorant-form">
                <b>LEVEL</b>
                <p>
                    <h4>
                        <?php print $level; ?>
                    </h4>
                </p>
            </div>
        </div>
    </div>
    
    <div class="container text-center">
        <div class="row">
            <div class="col valorant-form">
                <b>WINS</b>
                <p>
                    <h4>
                        <?php print $wins; ?>
                    </h4>
                </p>
            </div>
            <div class="col valorant-form">
                <b>LOSSES</b>
                <p>
                    <h4>
                        <?php print $losses; ?>
                    </h4>
                </p>
            </div>
            <div class="col valorant-form">
                <b>DRAWS</b>
                <p>
                    <h4>
                        <?php print $draws; ?>
                    </h4>
                </p>
            </div>
        </div>
    </div>
</div>