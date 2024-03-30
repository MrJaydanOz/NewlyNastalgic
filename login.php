<?php
include_once __DIR__.'/functions/session.php';
include_once __DIR__.'/functions/connect.php';
include_once __DIR__.'/segments/navigation_bar.php';

$redirectLink = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
?>
<?php include __DIR__.'/segments/header.php' ?>
    <title>Newly Nastaligic</title>
</head>
<body>
    <?php
    if (
        isset($_POST) &&
        isset($_POST['accname']) &&
        isset($_POST['accpassword']))
    {
        $stmt = CONNECTION->prepare('SELECT AccountID, PasswordHash FROM accounts WHERE FullName = ? OR Email = ? LIMIT 1');
        $stmt->bind_param("ss", $_POST['accname'], $_POST['accname']);
        if ($stmt->execute())
        {
            $row = $stmt->get_result()->fetch_row();

            if ($row !== null && password_verify($_POST['accpassword'], $row[1]))
            {
                $_SESSION[SESSION_CURRENT_ACCOUNT] = $row[0];
            }
        }
    }

    if (isLoggedIn())
    {
        ?>
            <script>
                window.location.replace("<?php echo $redirectLink ?>");
            </script>
        <?php
    }
    else
    {
        ?>
            <div id="background"></div>
            <div id="application">
                <?php createNavigationBar('index.php'); ?>
                <div class="gap"></div>
                <section>
                    <a href="<?php echo $redirectLink ?>">
                        <h5>Back</h5>
                    </a>
                    <form method="POST" action="<?php echo 'login.php?redirect='.$_GET['redirect'];?>">
                        <label for="accname">Name or Email:</label>
                        <input id="accname" name="accname" type="text">
                        <br>
                        <label for="accpassword">Password:</label>
                        <input id="accpassword" name="accpassword" type="password">
                        <br>
                        <input type="submit" value="Login">
                    </form>
                    <a href="signin.php?redirect=<?php echo $redirectLink ?>">
                        <p>Go to sign in...</p>
                    </a>
                </section>
                <?php include __DIR__.'/segments/footer.php' ?>
            </div>
        <?php
    }
    ?>
</body>
</html>