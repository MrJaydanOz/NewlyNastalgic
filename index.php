<?php
include_once __DIR__.'/functions/session.php';
include_once __DIR__.'/functions/connect.php';
include_once __DIR__.'/segments/card_container.php';
include_once __DIR__.'/segments/navigation_bar.php';
?>
<?php include __DIR__.'/segments/header.php' ?>
    <title>Newly Nastaligic</title>
</head>
<body>
    <div id="background"></div>
    <main>
        <?php createNavigationBar('index.php'); ?>
        <?php
            createCardContainer('Most Liked Movies', 'More', '#', 'INNER JOIN media_standalone MS ON MS.MediaID = M.MediaID ORDER BY (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID)', CARD_TYPE_MEDIA);
            createCardContainer('Least Liked Movies', 'More', '#', 'INNER JOIN media_standalone MS ON MS.MediaID = M.MediaID ORDER BY (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID) DESC', CARD_TYPE_MEDIA);
        ?>
    </main>
    <?php include __DIR__.'/segments/footer.php' ?>
</body>
</html>