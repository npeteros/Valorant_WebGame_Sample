<?php
    define('LOBBY', 5);
    define('TITLE', 'Game Result | VALORANT');
    include('includes/header.html');
    include('includes/navbar.html');
    if(!isset($_SESSION['user'])) header("Location: index.php");

    $game_id = $_GET['game_id'];
    $user_agent = $_GET['user_agent'];
    $opp_agent = $_GET['opponent_agent'];

    if($game_id != null && $user_agent != null && $opp_agent != null) {

        include('includes/mysql_connect.php');

        $query = "SELECT * FROM agents WHERE id = '$user_agent'";
        $u_agent = mysqli_fetch_array(mysqli_query($dbc, $query));

        $query = "SELECT * FROM agents WHERE id = '$opp_agent'";
        $o_agent = mysqli_fetch_array(mysqli_query($dbc, $query));

        $query = "SELECT * FROM games WHERE id = '$game_id'";
        $game = mysqli_fetch_array(mysqli_query($dbc, $query));
        
        $map_id = $game['map_id'];
        $query = "SELECT * FROM maps WHERE id = '$map_id'";
        $map = mysqli_fetch_array(mysqli_query($dbc, $query));

        $attacker_id = $game['attacker_id'];
        $query = "SELECT * FROM accounts WHERE id = '$attacker_id'";
        $attacker = mysqli_fetch_array(mysqli_query($dbc, $query));

        $defender_id = $game['defender_id'];
        $query = "SELECT * FROM accounts WHERE id = '$defender_id'";
        $defender = mysqli_fetch_array(mysqli_query($dbc, $query));

        $mode = $game['mode'];
        $map_name = $map['name'];
        $map_desc = $map['description'];
        $winner = $game['winner'];
        
        if($attacker['username'] == $_SESSION['user']['username']) $attacker_img = $u_agent['img_loc'];
        else $attacker_img = $o_agent['img_loc'];

        if($defender['username'] == $_SESSION['user']['username']) $defender_img = $u_agent['img_loc'];
        else $defender_img = $o_agent['img_loc'];

        $attacker_wins = $attacker['wins'];
        $attacker_level = $attacker['level'];
        $attacker_losses = $attacker['losses'];
        $attacker_draws = $attacker['draws'];

        $defender_wins = $defender['wins'];
        $defender_level = $defender['level'];
        $defender_losses = $defender['losses'];
        $defender_draws = $defender['draws'];

        $query = "UPDATE games SET status = 'processed' WHERE id = '$game_id'";
        mysqli_query($dbc, $query);

    } else {
        header("Location: waiting-room.php");
    }
?>

<div class="container text-center" style="margin-top: 10px;">
    <div class="alert alert-dark" role="alert">
        <h4>• <?php print strtoupper($mode); ?> •</h4>
        <hr>
        <h2><?php print $map_name; ?></h2>
        <?php print $map_desc; ?>
    </div>
</div>

<div class="container text-center" style="margin-top: 10px;">
    <div class="row">
        <?php
            if($winner == 'attacker') {
        ?>
            <div class="col-md-6">
                <div class="alert alert-success" role="alert">
                    <h4>VICTORY</h4>
                    <hr>
                    <h2><?php print $attacker["username"]; ?> [ATTACKER]</h2>
                    <img src="
                        <?php print $attacker_img; ?>" 
                        style="width: 100%;">
                    <h4>LEVEL: 
                        <?php print $attacker_level; ?>
                    </h4>
                    <h4>WINS: 
                        <?php print $attacker_wins; ?>
                    </h4>
                    <h4>LOSSES: 
                        <?php print $attacker_losses; ?>
                    </h4>
                    <h4>DRAWS: 
                        <?php print $attacker_draws; ?>
                    </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert">
                    <h4>DEFEAT</h4>
                    <hr>
                    <h2><?php print $defender["username"]; ?> [DEFENDER]</h2>
                    <img src="
                        <?php print $defender_img; ?>" 
                        style="width: 100%;">
                    <h4>LEVEL: 
                        <?php print $defender_level; ?>
                    </h4>
                    <h4>WINS: 
                        <?php print $defender_wins; ?>
                    </h4>
                    <h4>LOSSES: 
                        <?php print $defender_losses; ?>
                    </h4>
                    <h4>DRAWS: 
                        <?php print $defender_draws; ?>
                    </h4>
                </div>
            </div>
        <?php
            } else if($winner == 'defender') { // stop here
        ?>
            <div class="col-md-6">
                <div class="alert alert-success" role="alert">
                    <h4>VICTORY</h4>
                    <hr>
                    <h2><?php print $defender["username"]; ?> [DEFENDER]</h2>
                    <img src="
                        <?php print $defender_img; ?>" 
                        style="width: 100%;">
                    <h4>LEVEL: 
                        <?php print $defender_level; ?>
                    </h4>
                    <h4>WINS: 
                        <?php print $defender_wins; ?>
                    </h4>
                    <h4>LOSSES: 
                        <?php print $defender_losses; ?>
                    </h4>
                    <h4>DRAWS: 
                        <?php print $defender_draws; ?>
                    </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert">
                    <h4>DEFEAT</h4>
                    <hr>
                    <h2><?php print $attacker["username"]; ?> [ATTACKER]</h2>
                    <img src="
                        <?php print $attacker_img; ?>" 
                        style="width: 100%;">
                    <h4>LEVEL: 
                        <?php print $attacker_level; ?>
                    </h4>
                    <h4>WINS: 
                        <?php print $attacker_wins; ?>
                    </h4>
                    <h4>LOSSES: 
                        <?php print $attacker_losses; ?>
                    </h4>
                    <h4>DRAWS: 
                        <?php print $attacker_draws; ?>
                    </h4>
                </div>
            </div>
        <?php
            } else {
        ?>
        <div class="alert alert-warning" role="alert">
            <h4>DRAW</h4>
        </div>
        <div class="col-md-6">
            <div class="alert alert-warning" role="alert">
                <h2><?php print $attacker["username"]; ?> [ATTACKER]</h2>
                <img src="
                        <?php print $attacker_img; ?>" 
                        style="width: 100%;">
                    <h4>LEVEL: 
                        <?php print $attacker_level; ?>
                    </h4>
                    <h4>WINS: 
                        <?php print $attacker_wins; ?>
                    </h4>
                    <h4>LOSSES: 
                        <?php print $attacker_losses; ?>
                    </h4>
                    <h4>DRAWS: 
                        <?php print $attacker_draws; ?>
                    </h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-warning" role="alert">
                <h2><?php print $defender["username"]; ?> [DEFENDER]</h2>
                <img src="
                        <?php print $defender_img; ?>" 
                        style="width: 100%;">
                    <h4>LEVEL: 
                        <?php print $defender_level; ?>
                    </h4>
                    <h4>WINS: 
                        <?php print $defender_wins; ?>
                    </h4>
                    <h4>LOSSES: 
                        <?php print $defender_losses; ?>
                    </h4>
                    <h4>DRAWS: 
                        <?php print $defender_draws; ?>
                    </h4>
            </div>
        </div>
        <?php
            }
        ?>
    </div>
    <div class="d-grid gap-2" style="margin-bottom: 10px;">
        <button class="btn btn-danger" type="button" onclick="window.location='waiting-room.php'">PLAY AGAIN</button>
        <button class="btn btn-light" type="button" onclick="window.location='lobby.php'">EXIT</button>
    </div>
</div>