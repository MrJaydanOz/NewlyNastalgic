<?php
function createCard(string $cardLink, string $coverLink, string $title, float|null $rating) : void
{
    ?>
        <a href="<?php echo $cardLink ?>" class="card">
            <div class="offset" style="transform:translateY(<?php echo number_format(((($rating / 5.0) - 0.5) * -16) + rand(-8, 8), 0, '.', '') ?>px);">
                <div class="background">
                    <div></div>
                    <svg viewBox="0 0 1 0.17632">
                        <path style="fill:currentColor" d="M0 0.17632,L0 0,L1 0,Z"/>
                    </svg>
                </div>
                <div class="content">
                    <img src="<?php echo $coverLink ?>">
                    <h1><?php echo $title ?></h1>
                    <?php if ($rating !== null) 
                    { 
                        ?>
                            <h2><?php echo number_format($rating * 0.5, 1, '.', '') ?></h2>
                            <div class="bar">
                                <div style="height:100%;width:<?php echo number_format(($rating / 10.0) * 100.0, 0, '.', '') ?>%;"></div>
                            </div>
                        <?php 
                    } ?>
                </div>
            </div>
        </a>
    <?php
}
?>