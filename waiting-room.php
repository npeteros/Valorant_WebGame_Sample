<?php
    define('LOBBY', 2);
    define('TITLE', 'Waiting Room | VALORANT');
    include('includes/header.html');
    include('includes/navbar.html');
    if(!isset($_SESSION['user'])) header("Location: index.php");   
?>

<div class="container text-center">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 valorant-form">
            <form action="" method="post">
                <h4>FIND MATCH</h4>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        
                        $mode = $_POST['mode'];
                        $map = $_POST['map'];
                        $agent = $_POST['agent'];
                        $team = $_POST['team'];

                        if($mode != "default" || $map != "default" || $agent != "default" || $team != "default") {
                            include('includes/mysql_connect.php');

                            $query = "SELECT * FROM accounts";
                            $r = mysqli_query($dbc, $query);
                            $rows = mysqli_num_rows($r);

                            $i = 0;
                            if($rows > 1) {
                                while ($row = mysqli_fetch_array($r)) {
                                    if($row['id'] != $_SESSION['user']['id']) {
                                        $player_list[$i] = $row;
                                        $i++;
                                    }
                                }
                            }

                            $opponent = array_rand($player_list, 1);
                            
                            $result = mt_rand(1, 3); // 1 - heads, 2 - tails, 3 - draw

                            switch ($result) {
                                case 1: // heads
                                    switch ($team) {
                                        case "ATTACKER":
                                            $winner = "ATTACKER";
                                            $attacker = $_SESSION['user'];
                                            $defender = $player_list[$opponent];
                                            break;
                                        
                                        case "DEFENDER":
                                            $winner = "DEFENDER";
                                            $attacker = $player_list[$opponent];
                                            $defender = $_SESSION['user'];
                                            break;
                                    }
                                    break;
                                
                                case 2: // tails
                                    switch ($team) {
                                        case "ATTACKER":
                                            $winner = "DEFENDER";
                                            $attacker = $_SESSION['user'];
                                            $defender = $player_list[$opponent];
                                            break;
                                        
                                        case "DEFENDER":
                                            $winner = "ATTACKER";
                                            $attacker = $player_list[$opponent];
                                            $defender = $_SESSION['user'];
                                            break;
                                    }
                                    break;
                                
                                case 3: //draw
                                    switch($team) {
                                        case "ATTACKER":
                                            $attacker = $_SESSION['user'];
                                            $defender = $player_list[$opponent];
                                            break;
                                        
                                        case "DEFENDER":
                                            $attacker = $player_list[$opponent];
                                            $defender = $_SESSION['user'];
                                            break;
                                    }
                                    $winner = "DRAW";
                                    break;

                                default:
                                    break;
                            }

                            $attacker_id = $attacker['id'];
                            $defender_id = $defender['id'];

                            $attacker_wins = $attacker['wins'];
                            $attacker_level = $attacker['level'];
                            $attacker_losses = $attacker['losses'];
                            $attacker_draws = $attacker['draws'];

                            $defender_wins = $defender['wins'];
                            $defender_level = $defender['level'];
                            $defender_losses = $defender['losses'];
                            $defender_draws = $defender['draws'];

                            switch ($winner) {
                                case 'ATTACKER':
                                    $attacker_wins++;
                                    $attacker_level++;
                                    $query = "UPDATE accounts SET wins = '$attacker_wins', level = '$attacker_level' WHERE id = '$attacker_id'";
                                    mysqli_query($dbc, $query);

                                    $defender_losses++;
                                    $query = "UPDATE accounts SET losses = '$defender_losses' WHERE id = '$defender_id'";
                                    mysqli_query($dbc, $query);
                                    break;
                                
                                case 'DEFENDER':
                                    $defender_wins++;
                                    $defender_level++;
                                    $query = "UPDATE accounts SET wins = '$defender_wins', level = '$defender_level' WHERE id = '$defender_id'";
                                    mysqli_query($dbc, $query);

                                    $attacker_losses++;
                                    $query = "UPDATE accounts SET losses = '$attacker_losses' WHERE id = '$attacker_id'";
                                    mysqli_query($dbc, $query);
                                    break;

                                case 'DRAW':
                                    $attacker_draws++;
                                    $query = "UPDATE accounts SET draws = '$attacker_draws' WHERE id = '$attacker_id'";
                                    mysqli_query($dbc, $query);

                                    $defender_draws++;
                                    $query = "UPDATE accounts SET draws = '$defender_draws' WHERE id = '$defender_id'";
                                    mysqli_query($dbc, $query);
                                
                                default:
                                    break;
                            }


                            $query = "INSERT INTO games (id, map_id, mode, attacker_id, defender_id, winner, status) VALUES (0, '$map', '$mode', '" . $attacker["id"] . "', '" . $defender["id"] . "', '$winner', 'PENDING')";
                            
                            if(mysqli_query($dbc, $query)) {
                                $id = mysqli_insert_id($dbc);
                                $query = "SELECT * FROM agents ORDER BY RAND() LIMIT 1";
                                $opponent_agent = mysqli_fetch_array(mysqli_query($dbc, $query));
                                $opponent_agent_id = $opponent_agent['id'];
                                
                                ?>

                                <div class="alert alert-success alert-dismissible fade show">
                                    <b>MATCH FOUND!</b>
                                    <button type="button" class="btn-close"></button>
                                </div>

                                <?php print '<script>
                                    window.setTimeout(function(){ window.location.href = "game-result.php?game_id=' . $id . '&user_agent=' . $agent . '&opponent_agent=' . $opponent_agent_id .'"; }, 3000);
                                </script>';
                                

                            }

                            /*$query = "SELECT * FROM accounts";
                            $r = mysqli_query($dbc, $query);
                            $rows = mysqli_num_rows($r);
                            if($rows >= 1) {
                                if($rand = mt_rand(0, $rows) != $_SESSION['user']['id']) { // create random number and check if it's not the same as user's ID
                                    $query = "SELECT * FROM account WHERE id = '$rand'"; // select all from accounts where id is equal to random number
                                    if($r = mysqli_query($dbc, $query)) {
                                        while ($row = mysqli_fetch_array($r)) {
                                            
                                        }
                                    }
                                }
                            }*/
                            
                            mysqli_close($dbc);
                        }
                        
                    }
                ?>
                <hr>
                <div class="mb-3">
	        	    <label for="mode" class="form-label">Mode</label>
	        		<select name="mode" id="mode" class="form-select">
					    <option value="default" selected>-- Select --</option>
						<option value="UNRATED" disabled>UNRATED</option>
						<option value="COMPETITIVE">COMPETITIVE</option>
						<option value="SWIFTPLAY" disabled>SWIFTPLAY</option>
						<option value="SPIKE RUSH" disabled>SPIKE RUSH</option>
						<option value="DEATHMATCH" disabled>DEATHMATCH</option>
						<option value="ESCALATION" disabled>ESCALATION</option>
						<option value="CUSTOM GAME" disabled>CUSTOM GAME</option>
					</select>
				</div>
                <div class="mb-3">
                    <label for="map" class="form-label">Map</label>
                    <select name="map" id="map" class="form-select">
                        <option value="default" selected>-- Select --</option>
                        <?php
                            include('includes/mysql_connect.php');
                            
                            $query = "SELECT * FROM maps";
                            $r = mysqli_query($dbc, $query);
                            while($row = mysqli_fetch_array($r)) {
                                print '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                            }
                            mysqli_close($dbc);
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="agent" class="form-label">Agent</label>
                    <select name="agent" id="agent" class="form-select">
                        <option value="default" selected>-- Select --</option>
                        <?php
                            include('includes/mysql_connect.php');

                            $query = "SELECT * FROM agents";
                            $r = mysqli_query($dbc, $query);
                            while($row = mysqli_fetch_array($r)) {
                                print '<option value=' . $row['id'] . '>' . $row['name'] . '</option>';
                            }
                            mysqli_close($dbc);
                        ?>
                    </select>
                </div>
				<div class="mb-3">
	        		<label for="team" class="form-label">Team</label>
                    <select name="team" id="team" class="form-select">
						<option value="default" selected>-- Select --</option>
						<option value="ATTACKER">ATTACKER</option>
						<option value="DEFENDER">DEFENDER</option>
					</select>
				</div>
				<div class="d-grid gap-2">
				  <button class="btn btn-danger" type="submit" name="find_match">FIND MATCH</button>
				</div>
            </form>
        </div>
    </div>
</div>

<?php
    include('includes/footer.html');  
?>