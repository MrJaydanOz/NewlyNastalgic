<?php
include_once __DIR__.'/functions/connect.php';
include_once __DIR__.'/segments/card_container.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__.'/segments/header.php' ?>
    <title>Newly Nastaligic</title>
</head>
<body>
    <div id="background"></div>
    <div id="application">
        <?php include __DIR__.'/segments/navigation_bar.php' ?>
        <section>
            <?php
            createCardContainer($connection, 'Most Liked Movies', 'More', '#', 'INNER JOIN media_standalone MS ON MS.MediaID = M.MediaID ORDER BY (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID)', CARD_TYPE_MEDIA);
            createCardContainer($connection, 'Least Liked Movies', 'More', '#', 'INNER JOIN media_standalone MS ON MS.MediaID = M.MediaID ORDER BY (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID) DESC', CARD_TYPE_MEDIA);
            ?>
        </section>
        <?php include __DIR__.'/segments/footer.php' ?>
    </div>
</body>
</html>