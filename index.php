<?php
    /*
        AUTHOR: Neal Andrew B. Peteros
        TIME STARTED: 03/27/2023 - 2100 H
        TIME ENDED:
    */
    define('TITLE', 'VALORANT | Sign In');
    include('includes/header.html');
    if(isset($_SESSION['user'])) header("Location: lobby.php");
?>    

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 valorant-form">
            <form action="" method="post">
                <h4>Sign In | VALORANT</h4>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        include('includes/mysql_connect.php');

                        $user = $_POST['username'];

                        $query = "SELECT * FROM accounts WHERE username = '$user' OR email = '$user'";

                        if($r = mysqli_query($dbc, $query)) {
                            if(mysqli_num_rows($r) >= 1) {
                                $row = mysqli_fetch_array($r);
                                if($row['password'] == sha1(trim($_POST['password']))) {
                                    $_SESSION['user'] = $row;
                                    header("Location: lobby.php");
                                }
                            } else {
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    The account does not exist! 
                                    <a href="register.php" style="color: darkred;"><b>SIGN UP</b></a>
                                    <button type="button" class="btn-close"></button>
                              </div><?php
                            }
                        }
                        mysqli_close($dbc);
                    }
                ?>
                <hr>
                <div class="mb-3">
                    <label for="username" class="form-label">Username or Email Address</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter username or email address" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-dark" type="submit" name="login">LOG IN</button>
                    <button class="btn btn-light" type="button" name="register" onclick="window.location.href='register.php';">CREATE AN ACCOUNT</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.html') ?>