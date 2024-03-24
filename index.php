<?php include __DIR__.'/functions/connect.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__.'/segments/header.php' ?>
    <title>Newly Nastaligic</title>
</head>
<body>
    <div id="application">
        <?php
            $para =
            [
                'name' => 'Test container',
                'type' => ''
            ];
            include __DIR__.'/segments/card_container.php';
        ?>
        <?php include __DIR__.'/segments/footer.php' ?>
    </div>
</body>
</html>