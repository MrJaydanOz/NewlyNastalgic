<?php
    include_once __DIR__.'/../functions/connect.php';
    include_once __DIR__.'/../functions/session.php';
    function createNavigationBar(string $redirectLink) : void
    {
        $redirectLink = htmlspecialchars($redirectLink);

        ?>
            <nav id="nav-bar">
                <a href="index.php">
                    <?php echo file_get_contents(__DIR__.'/svg/newly_nastalgic_logo_medium.svg'); ?>
                </a>
                <div class="search">
                    <input class="nav-bar-search" type="text">
                    <?php echo file_get_contents(__DIR__.'/svg/search_icon_small.svg'); ?>
                </div>
                <?php
                    if (isLoggedIn())
                    {
                        $result = CONNECTION->query('SELECT FullName FROM accounts WHERE AccountID = '.$_SESSION[SESSION_CURRENT_ACCOUNT].' LIMIT 1');
                        $row = $result->fetch_row();

                        ?>
                            <a href="logout.php?redirect=<?php echo $redirectLink ?>" class="nav-button logout">
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
                            <a href="signin.php?redirect=<?php echo $redirectLink ?>" class="nav-button signin">
                                <h4>Sign In</h4>
                            </a>
                            <a href="login.php?redirect=<?php echo $redirectLink ?>" class="nav-button login">
                                <h4>Login</h4>
                            </a>
                        <?php
                    }
                ?>
            </nav>
        <?php
    }
?>