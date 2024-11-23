 <?php
    require_once 'dbh-inc.php';

    //Important Dates
    $query = 'SELECT * FROM times';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $times = $stmt->fetch(PDO::FETCH_ASSOC);
    $now = new DateTime($times['mailone']);

    $query = 'SELECT * FROM birthdayGifts';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $gifts = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($gifts as $gift) {
        $tester = new DateTime($gift['birthdate']);
        if ($tester->format('Y-m-d') == $now->format('Y-m-d')) {
            $query = 'SELECT * FROM itemList WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $gift['list_id']);
            $stmt->execute();
            $iteminfo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($gift['dye']) {
                $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate, dye) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate, :dye);";
            } else {
                $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            }
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":list", $gift['list_id']);
            $stmt->bindParam(":user", $gift['giftee']);
            $stmt->bindParam(":name", $iteminfo['name']);
            $stmt->bindParam(":display", $gift['display']);
            $stmt->bindParam(":description", $iteminfo['description']);
            $stmt->bindParam(":type", $iteminfo['type']);
            $stmt->bindParam(":rarity", $iteminfo['rarity']);
            $stmt->bindParam(":canDonate", $iteminfo['canDonate']);
            if ($gift['dye']) {
                $stmt->bindParam(":dye", $gift['dye']);
            }
            $stmt->execute();
            
            $query = 'DELETE FROM birthdayGifts WHERE id = :id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $gift['id']);
            $stmt->execute();
        }
    }
