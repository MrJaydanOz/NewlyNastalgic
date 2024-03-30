<?php
include_once __DIR__.'/functions/session.php';
include_once __DIR__.'/functions/connect.php';
include_once __DIR__.'/segments/navigation_bar.php';

$redirectLink = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
unset($_SESSION[SESSION_CURRENT_ACCOUNT]);
?>
<?php include __DIR__.'/segments/header.php' ?>
    <title>Newly Nastaligic</title>
</head>
<body>
    <script>
        window.location.replace("<?php echo $redirectLink ?>");
    </script>
</body>
</html>