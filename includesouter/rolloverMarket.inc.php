<?php
require_once 'dbh-inc.php';

//Set Next Table RO Time
$hours = 2;
$now = new DateTime('now', new DateTimezone('UTC'));
$modified = (clone $now)->add(new DateInterval("PT{$hours}H")); 
$rotime = $modified->format('Y-m-d H:i:s');

$query = 'UPDATE times SET fleaMarkets = :time';
$stmt = $pdo->prepare($query);
$stmt->bindParam(":time", $rotime);
$stmt->execute();

//Table One
$query = "SELECT * FROM marketTables WHERE itemOne IS NOT NULL";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($tables as $table) {
    if ($table['itemOne'] == "Coins") {
        
    } else {
        //EXP Check
        $query = "SELECT * FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $table['pet_id']);
        $stmt->execute();
        $infoCheck = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $exp = $infoCheck['sellingEXP'];
        $multiplier = 0;
        if ($exp < 50) {
            $multiplier = 1;
        } elseif ($exp < 150) {
            $multiplier = 1.05;
        } elseif ($exp < 325) {
            $multiplier = 1.10;
        } elseif ($exp < 600) {
            $multiplier = 1.15;
        } elseif ($exp < 1000) {
            $multiplier = 1.20;
        } else {
            $multiplier = 1.25;
        }
        
        //Item Info
        $query = "SELECT * FROM itemList WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $table['itemOne']);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        //Calculate Coins
        $total = round($table['quantityOne'] * $item['sell'] * $multiplier);

        //Delete From Inventory
        for ($i = 0; $i < $table['quantityOne'];$i++) {
            $query = "DELETE FROM items WHERE name = :name AND user_id = :user LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $table['itemOne']);
            $stmt->bindParam(":user", $table['user_id']);
            $stmt->execute();

        }

        //Change Coins + Quantity on Table
        $coins = "Coins";
        $query = "UPDATE marketTables SET itemOne = :item, coinsOne = :coins, quantityOne = NULL WHERE user_id = :user";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":item", $coins);
        $stmt->bindParam(":coins", $total);
        $stmt->bindParam(":user", $table['user_id']);
        $stmt->execute();
        
        //Snoozeling EXP
        $query = 'UPDATE snoozelings SET sellingEXP = sellingEXP + 2 WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $table['pet_id']);
        $stmt->execute();
    }
    
}

//Table Two
$query = "SELECT * FROM marketTables WHERE itemTwo IS NOT NULL";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($tables as $table) {
    if ($table['itemTwo'] == "Coins") {
        
    } else {
        
        //EXP Check
        $query = "SELECT * FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $table['pet_id']);
        $stmt->execute();
        $infoCheck = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $exp = $infoCheck['sellingEXP'];
        $multiplier = 0;
        if ($exp < 50) {
            $multiplier = 1;
        } elseif ($exp < 150) {
            $multiplier = 1.05;
        } elseif ($exp < 325) {
            $multiplier = 1.10;
        } elseif ($exp < 600) {
            $multiplier = 1.15;
        } elseif ($exp < 1000) {
            $multiplier = 1.20;
        } else {
            $multiplier = 1.25;
        }
        //Item Info
        $query = "SELECT * FROM itemList WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $table['itemTwo']);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        //Calculate Coins
        $total = round($table['quantityTwo'] * $item['sell'] * $multiplier);

        //Delete From Inventory
        for ($i = 0; $i < $table['quantityTwo'];$i++) {
            $query = "DELETE FROM items WHERE name = :name AND user_id = :user LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $table['itemTwo']);
            $stmt->bindParam(":user", $table['user_id']);
            $stmt->execute();

        }

        //Change Coins + Quantity on Table
        $coins = "Coins";
        $query = "UPDATE marketTables SET itemTwo = :item, coinsTwo = :coins, quantityTwo = NULL WHERE user_id = :user";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":item", $coins);
        $stmt->bindParam(":coins", $total);
        $stmt->bindParam(":user", $table['user_id']);
        $stmt->execute();
    }
    
}

//Table Three
$query = "SELECT * FROM marketTables WHERE itemThree IS NOT NULL";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($tables as $table) {
    if ($table['itemThree'] == "Coins") {
        
    } else {
        
        //EXP Check
        $query = "SELECT * FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $table['pet_id']);
        $stmt->execute();
        $infoCheck = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $exp = $infoCheck['sellingEXP'];
        $multiplier = 0;
        if ($exp < 50) {
            $multiplier = 1;
        } elseif ($exp < 150) {
            $multiplier = 1.05;
        } elseif ($exp < 325) {
            $multiplier = 1.10;
        } elseif ($exp < 600) {
            $multiplier = 1.15;
        } elseif ($exp < 1000) {
            $multiplier = 1.20;
        } else {
            $multiplier = 1.25;
        }
        
        //Item Info
        $query = "SELECT * FROM itemList WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $table['itemThree']);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        //Calculate Coins
        $total = round($table['quantityThree'] * $item['sell'] * $multiplier);

        //Delete From Inventory
        for ($i = 0; $i < $table['quantityThree'];$i++) {
            $query = "DELETE FROM items WHERE name = :name AND user_id = :user LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $table['itemThree']);
            $stmt->bindParam(":user", $table['user_id']);
            $stmt->execute();

        }

        //Change Coins + Quantity on Table
        $coins = "Coins";
        $query = "UPDATE marketTables SET itemThree = :item, coinsThree = :coins, quantityThree = NULL WHERE user_id = :user";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":item", $coins);
        $stmt->bindParam(":coins", $total);
        $stmt->bindParam(":user", $table['user_id']);
        $stmt->execute();
    }
    
}

//Table Four
$query = "SELECT * FROM marketTables WHERE itemFour IS NOT NULL";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($tables as $table) {
    if ($table['itemFour'] == "Coins") {
        
    } else {
        
        //EXP Check
        $query = "SELECT * FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $table['pet_id']);
        $stmt->execute();
        $infoCheck = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $exp = $infoCheck['sellingEXP'];
        $multiplier = 0;
        if ($exp < 50) {
            $multiplier = 1;
        } elseif ($exp < 150) {
            $multiplier = 1.05;
        } elseif ($exp < 325) {
            $multiplier = 1.10;
        } elseif ($exp < 600) {
            $multiplier = 1.15;
        } elseif ($exp < 1000) {
            $multiplier = 1.20;
        } else {
            $multiplier = 1.25;
        }
        
        //Item Info
        $query = "SELECT * FROM itemList WHERE name = :name";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":name", $table['itemFour']);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        //Calculate Coins
        $total = round($table['quantityFour'] * $item['sell'] * $multiplier);

        //Delete From Inventory
        for ($i = 0; $i < $table['quantityFour'];$i++) {
            $query = "DELETE FROM items WHERE name = :name AND user_id = :user LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":name", $table['itemFour']);
            $stmt->bindParam(":user", $table['user_id']);
            $stmt->execute();

        }

        //Change Coins + Quantity on Table
        $coins = "Coins";
        $query = "UPDATE marketTables SET itemFour = :item, coinsFour = :coins, quantityFour = NULL WHERE user_id = :user";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":item", $coins);
        $stmt->bindParam(":coins", $total);
        $stmt->bindParam(":user", $table['user_id']);
        $stmt->execute();
    }
    
}

