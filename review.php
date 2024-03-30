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
            if (
                isset($_POST) &&
                isset($_POST['rating']))
            {
                $stmt = CONNECTION->prepare('REPLACE INTO ratings (AboutMediaID, AuthorAccountID, Rating, ReviewText) VALUES ((SELECT M.MediaID FROM media M WHERE M.MediaUUID = ? LIMIT 1), ?, ?, ?)');
                $review = null;
                if (isset($_POST['review']))
                {
                    $review = $_POST['review'];
                }
                $stmt->bind_param("siis", $_GET['id'], $_SESSION[SESSION_CURRENT_ACCOUNT], $_POST['rating'], $review);
                if ($stmt->execute())
                {
                    ?>
                        <h1>Review Successfully Posted!</h1>
                        <a href="media.php?id=<?php echo $_GET['id']?>">
                            <h1>Back</h1>
                        </a>
                    <?php
                }
            }
            else
            {
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
                            <img style="height:256px" src="<?php echo 'images/'.$row[2].'.jpg' ?>">
                            <h1><?php echo $row[1] ?></h1>
                        </section>
                        <div class="gap"></div>
                        <section>
                            <h1>Review</h1>
                            <form method="POST" action="<?php echo 'review.php?id='.$_GET['id'];?>">
                                <h4>Rating:</h4>
                                <br>
                                <input id="rating0" name="rating" type="radio" value="0">
                                <label for="rating0">0</label>
                                <br>
                                <input id="rating1" name="rating" type="radio" value="1">
                                <label for="rating1">0.5</label>
                                <br>
                                <input id="rating2" name="rating" type="radio" value="2">
                                <label for="rating2">1</label>
                                <br>
                                <input id="rating3" name="rating" type="radio" value="3">
                                <label for="rating3">1.5</label>
                                <br>
                                <input id="rating4" name="rating" type="radio" value="4">
                                <label for="rating4">2</label>
                                <br>
                                <input id="rating5" name="rating" type="radio" value="5">
                                <label for="rating5">2.5</label>
                                <br>
                                <input id="rating6" name="rating" type="radio" value="6">
                                <label for="rating6">3</label>
                                <br>
                                <input id="rating7" name="rating" type="radio" value="7">
                                <label for="rating7">3.5</label>
                                <br>
                                <input id="rating8" name="rating" type="radio" value="8">
                                <label for="rating8">4</label>
                                <br>
                                <input id="rating9" name="rating" type="radio" value="9">
                                <label for="rating9">4.5</label>
                                <br>
                                <input id="rating10" name="rating" type="radio" value="10">
                                <label for="rating10">5</label>
                                <br>
                                <h4>Review:</h4>
                                <br>
                                <label for="review">Review (Optional):</label>
                                <br>
                                <textarea  id="review" name="review"></textarea>
                                <br>
                            <input type="submit" value="Submit">
                        </form>
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
            }
        ?>
        <?php include __DIR__.'/segments/footer.php' ?>
    </div>
</body>
</html>