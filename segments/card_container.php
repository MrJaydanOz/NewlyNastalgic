<?php 
include_once __DIR__.'/../functions/session.php';
include_once __DIR__.'/../functions/connect.php';
include_once __DIR__.'/card.php';
define('CARD_TYPE_MEDIA', 1);

function createCardContainer(string $name, string $moreLabel, string $moreLink, string $query, int $cardType) : void
{
    ?>
        <div class="card-container">
            <div class="title">
                <h1><?php echo $name ?></h1>
                <a href="<?php echo $moreLink ?>">
                    <h2><?php echo $moreLabel ?></h2>
                    <?php echo file_get_contents(__DIR__.'/svg/more_icon_small.svg'); ?>
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

                            $result = CONNECTION->query($query);
                            
                            if ($result === false)
                            {
                                ?>
                                    <h3 class="error">There has been an error loading this line of cards.</h3>
                                <?php
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
                                            createCard('media.php?id='.$row[0], 'images/'.$row[2].'.jpg', $row[1], $row[3]);
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