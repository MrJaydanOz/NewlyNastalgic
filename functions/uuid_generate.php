<?php
    include_once __DIR__.'/connect.php';
    define('BASE_64_ALPHABET', 'abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789-_');

    function generateUUID() : string
    {
        do
        {
            $uuid = '';

            for ($i = 0; $i < 6; $i++)
            {
                $uuid .= substr(BASE_64_ALPHABET, random_int(0, 63), 1);
            }

            $result = CONNECTION->query('SELECT UUID FROM uuitems WHERE UUID = \''.$uuid.'\' LIMIT 1');
        }
        while($result->fetch_row() !== null);

        return $uuid;
    }
?>