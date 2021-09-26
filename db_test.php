<?php
# Database access

try{
    $db = new PDO("mysql:host=localhost;dbname=tutorials", "root", "password");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth= $db->query("SELECT * FROM tutorials WHERE author like '%Izhar%'");
    while($row = $sth -> fetch(PDO::FETCH_ASSOC)) {
        printf("%-40s %-20s\n", $row["title"], $row["author"]);
    }
}
catch (PDOException $e){
    printf("We had a problem: %s\n", $e->getMessage());
}

exit();
?>