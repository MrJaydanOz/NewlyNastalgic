<?php
    include_once __DIR__.'/../functions/connect.php';
    include_once __DIR__.'/../functions/session.php';
    function createNavigationBar(string $redirectLink) : void
    {
        $redirectLink = htmlspecialchars($redirectLink);

        ?>
            <nav id="nav-bar">
                <div class="contents">
                    <a class="logo" href="index.php">
                        <?php echo file_get_contents(__DIR__.'/svg/newly_nastalgic_logo_medium.svg'); ?>
                    </a>
                    <div class="search">
                        <form method="GET" action="search.php">
                            <div class="search-type-menu">
                                <div class="item">
                                    <label for="search-type-menu-all">All</label>
                                    <input id="search-type-menu-all" type="radio" name="search-type-menu" hidden>
                                </div>
                                <div class="item">
                                    <label for="search-type-menu-movie">Movie</label>
                                    <input id="search-type-menu-movie" type="radio" name="search-type-menu" hidden>
                                </div>
                                <div class="item">
                                    <label for="search-type-menu-tvshow">TV Show</label>
                                    <input id="search-type-menu-tvshow" type="radio" name="search-type-menu" hidden>
                                </div>
                                <div class="separator"></div>
                                <div class="link">
                                    <label for="search-type-menu-all">All</label>
                                    <input id="search-type-menu-all" type="radio" name="search-type-menu" hidden>
                                </div>
                            </div>
                            <label class="menu-toggle" for="nav-bar-menu-toggle">
                                <input id="nav-bar-menu-toggle" type="checkbox" hidden>
                            </label>
                            <input class="search-input" id="nav-bar-search" type="text" name="q" autocomplete="off" autocapitalize="off" autocorrect="off" placeholder="Search...">
                            <button class="search-button" type="submit">
                                <?php echo file_get_contents(__DIR__.'/svg/search_icon_small.svg'); ?>
                            </button>
                        </form>
                    </div>
                    <?php
                        if (isLoggedIn())
                        {
                            $result = CONNECTION->query('SELECT FullName FROM accounts WHERE AccountID = '.$_SESSION[SESSION_CURRENT_ACCOUNT].' LIMIT 1');
                            $row = $result->fetch_row();

                            ?>
                                <a class="nav-link logout" href="logout.php?redirect=<?php echo $redirectLink ?>">
                                    Logout
                                </a>
                                <a class="profile">
                                    Logged in as <?php echo $row[0] ?>
                                </a>
                            <?php
                        }
                        else
                        {
                            ?>
                                <a class="nav-link signin" href="signin.php?redirect=<?php echo $redirectLink ?>">
                                    Sign In
                                </a>
                                <a class="nav-button login" href="login.php?redirect=<?php echo $redirectLink ?>">
                                    Login
                                </a>
                            <?php
                        }
                    ?>
                </div>
            </nav>
        <?php
    }
?>