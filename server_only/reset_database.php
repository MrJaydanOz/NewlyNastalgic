<?php
    $sqlIDType = 'INT';
    $sqlUUIDType = 'CHAR(6)';

    ob_start();
?>
DROP TABLE IF EXISTS UUItems, Accounts, Reviews;
CREATE TABLE UUItems 
(
    UUID <?php echo $sqlUUIDType ?> NOT NULL PRIMARY KEY
);

CREATE TABLE Accounts 
(
    AccountID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY,
    AccountUUID <?php echo $sqlUUIDType ?> NOT NULL UNIQUE,
    FullName VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE Reviews 
(
    ReviewID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY,
    AccountID <?php echo $sqlIDType ?> NOT NULL,
    FullName VARCHAR(32) NOT NULL UNIQUE
);

ALTER TABLE Reviews ADD FOREIGN KEY (AccountID) REFERENCES Accounts(AccountID);
<?php
    if (!isset($connection))
        include __DIR__.'/../functions/connect.php';

    $connection->multi_query(ob_get_clean());
    do
    {
        if ($result = $connection->store_result()) 
        {
            while ($row = $result->fetch_row()) 
            {
                printf("%s\n", $row[0]);
            }
        }
        
        if ($connection->more_results()) {
            printf("-----------------\n");
        }
    }
    while ($connection->next_result());
?>