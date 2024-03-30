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
        isset($_POST['accemail']) &&
        isset($_POST['accpassword']))
    {
        include_once __DIR__.'/functions/uuid_generate.php';

        $stmt = CONNECTION->prepare('SELECT AccountID FROM accounts WHERE FullName = ? OR Email = ? LIMIT 1');
        $stmt->bind_param("ss", $_POST['accname'], $_POST['accemail']);
        if ($stmt->execute() && $stmt->get_result()->fetch_row() === null)
        {
            $stmt->close();
            $uuid = generateUUID();

            $stmt = CONNECTION->prepare('INSERT INTO uuitems (UUID) VALUES (?)');
            $stmt->bind_param("s", $uuid);
            if ($stmt->execute())
            {
                $stmt->close();
                $stmt = CONNECTION->prepare('INSERT INTO accounts (AccountUUID, Email, FullName, PasswordHash) VALUES (?, ?, ?, ?)');
                $passwordHash = password_hash($_POST['accpassword'], PASSWORD_BCRYPT);
                $stmt->bind_param("ssss", $uuid, $_POST['accemail'], $_POST['accname'], $passwordHash);
                if ($stmt->execute())
                {
                    $stmt->close();
                    $_SESSION[SESSION_CURRENT_ACCOUNT] = CONNECTION->query('SELECT AccountID FROM accounts WHERE AccountUUID = \''.$uuid.'\' LIMIT 1')->fetch_row()[0];
                }
                else
                {
                    $stmt->close();
                    $stmt = CONNECTION->prepare('DELETE FROM uuitems WHERE UUID = ?');
                    $stmt->bind_param("s", $uuid);
                    $stmt->execute();
                }
            }
            else
            {
                $stmt->close();
            }
        }
        else
        {
            $stmt->close();
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
                    <form method="POST" action="<?php echo 'signin.php?redirect='.$_GET['redirect'];?>">
                        <label for="accname">Name:</label>
                        <input id="accname" name="accname" type="text">
                        <br>
                        <label for="accemail">Email:</label>
                        <input id="accemail" name="accemail" type="email">
                        <br>
                        <label for="accpassword">Password:</label>
                        <input id="accpassword" name="accpassword" type="password">
                        <br>
                        <input type="submit" value="Sign In">
                    </form>
                    <a href="login.php?redirect=<?php echo $redirectLink ?>">
                        <p>Go to Login...</p>
                    </a>
                </section>
                <?php include __DIR__.'/segments/footer.php' ?>
            </div>
        <?php
    }
    ?>
</body>
</html>