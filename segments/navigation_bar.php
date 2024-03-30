<?php
    include_once __DIR__.'/../functions/connect.php';
    include_once __DIR__.'/../functions/session.php';
    function createNavigationBar(string $redirectLink) : void
    {
        ?>
            <nav>
                <a href="index.php">
                    <h1>Newly Nastalgic</h1>
                </a>
                <input type="text">
                <?php 
                
                if (isLoggedIn())
                {
                    $result = CONNECTION->query('SELECT FullName FROM accounts WHERE AccountID = '.$_SESSION[SESSION_CURRENT_ACCOUNT].' LIMIT 1');
                    $row = $result->fetch_row();

                    ?>
                        <a href="logout.php?redirect=<?php echo $redirectLink ?>" class="logout">
                            <h4>Logout</h4>
                        </a>
                        <a class="profile">
                            <h2>Logged in as <?php echo $row[0] ?></h2>
                        </a>
                    <?php
                }
                else
                {
                    ?>
                        <a href="signin.php?redirect=<?php echo $redirectLink ?>" class="signin">
                            <h4>Sign In</h4>
                        </a>
                        <a href="login.php?redirect=<?php echo $redirectLink ?>" class="login">
                            <h4>Login</h4>
                        </a>
                    <?php 
                }
                ?>
            </nav>
        <?php
    }
?>