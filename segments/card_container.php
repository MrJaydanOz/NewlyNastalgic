<?php 
define('CARD_TYPE_MEDIA', 1);

function createCardContainer(mysqli $connection, string $name, string $moreLabel, string $moreLink, string $query, int $cardType) : void
{
    include_once __DIR__.'/card.php';

    ?>
        <div class="card-container">
            <div class="title">
                <h3><?php echo $name ?></h3>
                <a href="<?php echo $moreLink ?>">
                    <h4><?php echo $moreLabel ?></h4>
                </a>
            </div>
            <div class="card-slider">
                <div class="slit left"></div>
                <div class="view">
                    <div class="contents">
                        <?php
                            switch ($cardType)
                            {
                                case CARD_TYPE_MEDIA:
                                    $query = 'SELECT M.MediaUUID, M.Name, I.ImageUUID, (SELECT AVG(R.Rating) FROM ratings R WHERE R.AboutMediaID = M.MediaID) AS AverageRating FROM media M LEFT JOIN images I ON I.ImageID = M.CoverImageID '.$query.' LIMIT 10;';
                                    break;
                            }

                            $result = $connection->query($query);
                            
                            if ($result === false)
                            {
                                echo '<h3 class="error">There has been an error loading this line of cards.</h3>';
                            }
                            else
                            {
                                $resultList = [];
                                
                                while (($row = $result->fetch_row()) !== null)
                                {
                                    array_push($resultList, $row);
                                }

                                switch ($cardType)
                                {
                                    case CARD_TYPE_MEDIA:
                                        for ($i = count($resultList) - 1; $i >= 0; $i--)
                                        {
                                            $row = $resultList[$i];
                                            createCard('#', 'images/'.$row[2].'.jpg', $row[1], $row[3]);
                                        }
                                        break;
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="slit right"></div>
            </div>
        </div>
    <?php 
}
?>