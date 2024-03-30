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
    <div id="application">
        <?php createNavigationBar('index.php'); ?>
        <div class="gap"></div>
        <?php
            if (isset($_GET['id']))
            {
                $stmt = CONNECTION->prepare('SELECT M.MediaUUID, M.Name, I.ImageUUID, (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID) AS AverageRating FROM media M LEFT JOIN images I ON I.ImageID = M.CoverImageID WHERE M.MediaUUID = ? LIMIT 1');
                $stmt->bind_param("s", $_GET['id']);  
            }
            else
            {
                $stmt = null;
            }

            if ($stmt !== null && $stmt->execute() && ($row = $stmt->get_result()->fetch_row()))
            {
                ?>
                    <section>
                        <img style="height:512px" src="<?php echo 'images/'.$row[2].'.jpg' ?>">
                        <h1><?php echo $row[1] ?></h1>
                        <?php 
                        if ($row[3] !== null) 
                        { 
                            ?>
                                <h3>Rating: <?php echo number_format($row[3] * 0.5, 1, '.', '') ?> / 5</h3>
                            <?php
                        } 
                        ?>
                        <?php
                            $stmt->close();
                        ?>
                        <a href="review.php?id=<?php echo $_GET['id']?>">
                            <h4>
                                Rate
                            </h4>
                        </a>
                    </section>
                    <div class="gap"></div>
                    <section>
                        <h1>Reviews</h1>
                        <?php
                            $stmt = CONNECTION->prepare('SELECT COUNT(R.RatingID) FROM ratings R LEFT JOIN media M ON M.MediaID = R.AboutMediaID WHERE M.MediaUUID = ?');
                            $stmt->bind_param("s", $_GET['id']);  
                            
                            $stmt->execute();
                            ?>
                                <h6><?php echo $stmt->get_result()->fetch_row()[0] ?> Ratings submitted</h6>
                            <?php

                            $stmt = CONNECTION->prepare('SELECT A.FullName, R.ReviewText, R.Rating FROM ratings R LEFT JOIN accounts A ON A.AccountID = R.AuthorAccountID LEFT JOIN media M ON M.MediaID = R.AboutMediaID WHERE R.ReviewText != \'\' AND M.MediaUUID = ? LIMIT 10');
                            $stmt->bind_param("s", $_GET['id']);  
                            
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while (($row = $result->fetch_row()) !== null)
                            {
                                ?>
                                    <div class="review">
                                        <h3 style="margin-bottom:0px;"><?php echo $row[0] ?> says:</h3>
                                        <h6 style="margin-top:0px;">(<?php echo $row[2] * 0.5 ?> / 5)</h6>
                                        <p style="margin-left:32px">"<?php echo $row[1] ?>"</p>
                                    </div>
                                <?php
                            }
                        ?>
                        <a href="<?php linkToLoginIfNot() ?>review.php?id=<?php echo $_GET['id'] ?>">
                            <h4>
                                Write your own review...
                            </h4>
                        </a>
                    </section>
                    <div class="gap"></div>
                    <section>
                        <?php
                            createCardContainer('Most Liked Movies', 'More', '#', 'INNER JOIN media_standalone MS ON MS.MediaID = M.MediaID WHERE M.MediaUUID != \''.$_GET['id'].'\' ORDER BY (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID)', CARD_TYPE_MEDIA);
                            createCardContainer('Least Liked Movies', 'More', '#', 'INNER JOIN media_standalone MS ON MS.MediaID = M.MediaID WHERE M.MediaUUID != \''.$_GET['id'].'\' ORDER BY (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID) DESC', CARD_TYPE_MEDIA);
                        ?>
                    </section>
                <?php

                $stmt->close();
            }
            else
            {
                if ($stmt !== null)
                {
                    $stmt->close();
                }

                ?>
                    <section>
                        <h3>404: Page not found.</h3>
                    </section>
                <?php
            }
        ?>
        <?php include __DIR__.'/segments/footer.php' ?>
    </div>
</body>
</html>