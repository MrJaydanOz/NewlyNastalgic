<?php
    $sqlIDType = 'INT';
    $sqlUUIDType = 'CHAR(6)';
    $sqlEnumIndexType = 'TINYINT UNSIGNED';
    $sqlDateType = 'DATETIME';

    $sqlEnumCertificationValues = ['CTC', 'G', 'PG', 'M', 'MA15+', 'R18+', 'X18+'];

    ob_start();
?>
CREATE TABLE UUItems
(
    UUID <?php echo $sqlUUIDType ?> NOT NULL PRIMARY KEY
);

CREATE TABLE Accounts
(
    AccountID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY AUTO_INCREMENT,
    AccountUUID <?php echo $sqlUUIDType ?> NOT NULL UNIQUE, FOREIGN KEY (AccountUUID) REFERENCES UUItems(UUID),
    FullName VARCHAR(64) NOT NULL UNIQUE,
    Email VARCHAR(320) NOT NULL UNIQUE,
    PasswordHash VARCHAR(256) NOT NULL
);
CREATE TABLE Collection
(
    CollectionID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY AUTO_INCREMENT,
    CollectionUUID <?php echo $sqlUUIDType ?> NOT NULL UNIQUE, FOREIGN KEY (CollectionUUID) REFERENCES UUItems(UUID),
    Name VARCHAR(256) NOT NULL
);
CREATE TABLE Video
(
    VideoID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY AUTO_INCREMENT,
    VideoUUID <?php echo $sqlUUIDType ?> NOT NULL UNIQUE, FOREIGN KEY (VideoUUID) REFERENCES UUItems(UUID),
    URL VARCHAR(256) NOT NULL,
    EmbeddedURL VARCHAR(256) NOT NULL
);
CREATE TABLE Images
(
    ImageID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ImageUUID <?php echo $sqlUUIDType ?> NOT NULL UNIQUE, FOREIGN KEY (ImageUUID) REFERENCES UUItems(UUID)
);
CREATE TABLE Certification
(
    CertificationIndex <?php echo $sqlEnumIndexType ?> NOT NULL PRIMARY KEY,
    CertificationName VARCHAR(8) NOT NULL UNIQUE
); INSERT INTO Certification (CertificationIndex, CertificationName) VALUES <?php $c = count($sqlEnumCertificationValues); for ($i = 0; $i < $c; $i++) { if ($i > 0) { echo ', '; } echo '('.$i.', "'.$sqlEnumCertificationValues[$i].'")'; } ?>;

CREATE TABLE CollectionItem
(
    ItemUUID <?php echo $sqlUUIDType ?> NOT NULL, FOREIGN KEY (ItemUUID) REFERENCES UUItems(UUID),
    CollectionID <?php echo $sqlIDType ?> NOT NULL UNIQUE, FOREIGN KEY (CollectionID) REFERENCES Collection(CollectionID),
    UNIQUE(ItemUUID, CollectionID)
);
CREATE TABLE Media
(
    MediaID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY AUTO_INCREMENT,
    MediaUUID <?php echo $sqlUUIDType ?> NOT NULL UNIQUE, FOREIGN KEY (MediaUUID) REFERENCES UUItems(UUID),
    Name VARCHAR(256) NOT NULL,
    ReleaseDate <?php echo $sqlDateType ?> NOT NULL,
    CoverImageID <?php echo $sqlIDType ?> NULL, FOREIGN KEY (CoverImageID) REFERENCES Images(ImageID),
    TrailerVideoID <?php echo $sqlIDType ?> NULL, FOREIGN KEY (TrailerVideoID) REFERENCES Video(VideoID),
    CertificationIndex <?php echo $sqlEnumIndexType ?> NULL, FOREIGN KEY (CertificationIndex) REFERENCES Certification(CertificationIndex)
);

CREATE TABLE Ratings
(
    RatingID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY AUTO_INCREMENT,
    AuthorAccountID <?php echo $sqlIDType ?> NOT NULL, FOREIGN KEY (AuthorAccountID) REFERENCES Accounts(AccountID),
    AboutMediaID <?php echo $sqlIDType ?> NOT NULL, FOREIGN KEY (AboutMediaID) REFERENCES Media(MediaID),
    Rating TINYINT UNSIGNED NOT NULL,
    ReviewText VARCHAR(2048) NULL,
    UNIQUE(AuthorAccountID, AboutMediaID)
);
CREATE TABLE Media_Standalone
(
    MediaID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY, FOREIGN KEY (MediaID) REFERENCES Media(MediaID),
    MinutesLong SMALLINT UNSIGNED NOT NULL
);
CREATE TABLE Media_EpisodeContainer
(
    MediaID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY, FOREIGN KEY (MediaID) REFERENCES Media(MediaID)
);

DROP TABLE IF EXISTS Media_Episodes;
CREATE TABLE Media_Episodes
(
    MediaID <?php echo $sqlIDType ?> NOT NULL PRIMARY KEY, FOREIGN KEY (MediaID) REFERENCES Media(MediaID),
    EpisodeContainerID <?php echo $sqlIDType ?> NOT NULL, FOREIGN KEY (EpisodeContainerID) REFERENCES Media_EpisodeContainer(MediaID),
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