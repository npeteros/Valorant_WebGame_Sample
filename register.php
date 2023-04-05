<?php
    define('TITLE', 'Create an account | VALORANT');
    include('includes/header.html');
?>

<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 valorant-form">
            <form action="" method="post">
                <h4>Register | VALORANT</h4>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        include('includes/mysql_connect.php');

                        $username = $_POST['username'];
                        $password = sha1(trim($_POST['password']));
                        $email = $_POST['email'];
                        $birthdate = $_POST['birthdate'];

                        $query = "SELECT * FROM accounts WHERE username = '$username' OR email = '$email'";
                        
                        if($r = mysqli_query($dbc, $query)) {
                            if(mysqli_num_rows($r) >= 1) {
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    An account with the same username or email already exists! 
                                    <a href="register.php" style="color: darkred;"><b>SIGN UP</b></a>
                                    <button type="button" class="btn-close"></button>
                                </div><?php
                                exit();                         
                            } 
                        }
                        $query = "INSERT INTO accounts (username, email, password, birthdate, account_type, status) VALUES('$username', '$email', '$password', '$birthdate', 'player', 'active')";
                                        
                            if(mysqli_query($dbc, $query)) {
                                ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    Welcome to <b>VALORANT!</b>
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <script>
                                    window.setTimeout(function(){ window.location.href = "index.php"; }, 3000);
                                </script><?php
                            } else {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    Something went wrong!
                                    <a href="register.php" style="color: darkred;"><b>SIGN UP</b></a>
                                    <button type="button" class="btn-close"></button>
                                </div><?php
                            }
                            mysqli_close($dbc);
                        }
                ?>
                <hr>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-dark" type="submit" name="register">REGISTER</button>
                    <button class="btn btn-light" type="button" name="login" onclick="window.location.href='index.php';">I already have an account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.html'); ?>