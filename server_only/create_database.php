<?php
    define('SQL_ID_TYPE', 'INT');
    define('SQL_UUID_TYPE', 'CHAR(6)');
    define('SQL_ENUM_INDEX_TYPE', 'TINYINT UNSIGNED');
    define('SQL_DATE_TYPE', 'DATETIME');
    
    $sqlEnumCertificationValues = ['CTC', 'G', 'PG', 'M', 'MA15+', 'R18+', 'X18+'];

    function sqlIDColumn(string $columnName)
    {
        echo $columnName ?> <?php echo SQL_ID_TYPE ?> NOT NULL PRIMARY KEY AUTO_INCREMENT<?php 
    }

    function sqlUUIDColumn(string $columnName)
    {
        echo $columnName ?> <?php echo SQL_UUID_TYPE ?> NOT NULL UNIQUE, FOREIGN KEY (<?php echo $columnName ?>) REFERENCES UUItems(UUID)<?php 
    }

    ob_start();
?>
CREATE TABLE UUItems
(
    UUID <?php echo SQL_UUID_TYPE ?> NOT NULL PRIMARY KEY
);

CREATE TABLE Accounts
(
    <?php sqlIDColumn("AccountID") ?>,
    <?php sqlUUIDColumn("AccountUUID") ?>,
    FullName VARCHAR(64) NOT NULL UNIQUE,
    Email VARCHAR(320) NOT NULL UNIQUE,
    PasswordHash VARCHAR(256) NOT NULL
);
CREATE TABLE Collection
(
    <?php sqlIDColumn("CollectionID") ?>,
    <?php sqlUUIDColumn("CollectionUUID") ?>,
    Name VARCHAR(256) NOT NULL
);
CREATE TABLE Video
(
    <?php sqlIDColumn("VideoID") ?>,
    <?php sqlUUIDColumn("VideoUUID") ?>,
    URL VARCHAR(256) NOT NULL,
    EmbeddedURL VARCHAR(256) NOT NULL
);
CREATE TABLE Images
(
    <?php sqlIDColumn("ImageID") ?>,
    <?php sqlUUIDColumn("ImageUUID") ?>
);
CREATE TABLE Certification
(
    CertificationIndex <?php echo SQL_ENUM_INDEX_TYPE ?> NOT NULL PRIMARY KEY,
    CertificationName VARCHAR(8) NOT NULL UNIQUE
); INSERT INTO Certification (CertificationIndex, CertificationName) VALUES <?php $c = count($sqlEnumCertificationValues); for ($i = 0; $i < $c; $i++) { if ($i > 0) { echo ', '; } echo '('.$i.', "'.$sqlEnumCertificationValues[$i].'")'; } ?>;

CREATE TABLE CollectionItem
(
    ItemUUID <?php echo SQL_UUID_TYPE ?> NOT NULL, FOREIGN KEY (ItemUUID) REFERENCES UUItems(UUID),
    CollectionID <?php echo SQL_ID_TYPE ?> NOT NULL UNIQUE, FOREIGN KEY (CollectionID) REFERENCES Collection(CollectionID),
    UNIQUE(ItemUUID, CollectionID)
);
CREATE TABLE Media
(
    <?php sqlIDColumn("MediaID") ?>,
    <?php sqlUUIDColumn("MediaUUID") ?>,
    Name VARCHAR(256) NOT NULL,
    ReleaseDate <?php echo SQL_DATE_TYPE ?> NOT NULL,
    CoverImageID <?php echo SQL_ID_TYPE ?> NULL, FOREIGN KEY (CoverImageID) REFERENCES Images(ImageID),
    TrailerVideoID <?php echo SQL_ID_TYPE ?> NULL, FOREIGN KEY (TrailerVideoID) REFERENCES Video(VideoID),
    CertificationIndex <?php echo SQL_ENUM_INDEX_TYPE ?> NULL, FOREIGN KEY (CertificationIndex) REFERENCES Certification(CertificationIndex)
);

CREATE TABLE Ratings
(
    RatingID <?php echo SQL_ID_TYPE ?> NOT NULL PRIMARY KEY AUTO_INCREMENT,
    AuthorAccountID <?php echo SQL_ID_TYPE ?> NOT NULL, FOREIGN KEY (AuthorAccountID) REFERENCES Accounts(AccountID),
    AboutMediaID <?php echo SQL_ID_TYPE ?> NOT NULL, FOREIGN KEY (AboutMediaID) REFERENCES Media(MediaID),
    Rating TINYINT UNSIGNED NOT NULL,
    ReviewText VARCHAR(2048) NULL,
    UNIQUE(AuthorAccountID, AboutMediaID)
);
CREATE TABLE Media_Standalone
(
    MediaID <?php echo SQL_ID_TYPE ?> NOT NULL PRIMARY KEY, FOREIGN KEY (MediaID) REFERENCES Media(MediaID),
    MinutesLong SMALLINT UNSIGNED NOT NULL
);
CREATE TABLE Media_EpisodeContainer
(
    MediaID <?php echo SQL_ID_TYPE ?> NOT NULL PRIMARY KEY, FOREIGN KEY (MediaID) REFERENCES Media(MediaID)
);

DROP TABLE IF EXISTS Media_Episodes;
CREATE TABLE Media_Episodes
(
    MediaID <?php echo SQL_ID_TYPE ?> NOT NULL PRIMARY KEY, FOREIGN KEY (MediaID) REFERENCES Media(MediaID),
    EpisodeContainerID <?php echo SQL_ID_TYPE ?> NOT NULL, FOREIGN KEY (EpisodeContainerID) REFERENCES Media_EpisodeContainer(MediaID),
    EpisodeNumber SMALLINT UNSIGNED NOT NULL,
    SeasonNumber SMALLINT UNSIGNED NOT NULL,
    MinutesLong SMALLINT UNSIGNED NOT NULL,
    UNIQUE(EpisodeContainerID, EpisodeNumber, SeasonNumber)
);
<?php
    include_once __DIR__.'/../functions/connect.php';

    $connection->multi_query(ob_get_clean());

    $hasError = false;

    do
    {
        if ($connection->store_result() === false)
        {
            $hasError = true;
            echo $connection->error."<br>";
        }
    }
    while ($connection->next_result());

    echo "Did Done!"
?>