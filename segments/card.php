<?php
function createCard(string $cardLink, string $coverLink, string $title, float|null $rating) : void
{
    ?>
        <div class="card">
            <a href="<?php echo $cardLink ?>" class="backing" style="transform:translateY(<?php echo '0' ?>px);">
                <img src="<?php echo $coverLink ?>">
                <h4><?php echo $title ?></h4>
                <?php if ($rating !== null) 
                { 
                    ?>
                        <p><?php echo number_format($rating * 0.5, 1, '.', '') ?></p>
                        <div class="bar">
                            <div style="height:100%;width:<?php echo number_format(($rating / 10.0) * 100.0, 0, '.', '') ?>%;"></div>
                        </div>
                    <?php 
                } ?>
            </a>
        </div>
    <?php
}
?>