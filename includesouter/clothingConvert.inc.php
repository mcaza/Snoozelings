 <?php
    require_once 'dbh-inc.php';

    $query = "SELECT * FROM snoozelings";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $snoozelings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = 0;

foreach ($snoozelings as $snooze) {
    $clothes = "";
    $final = "";
    
    if ($snooze['clothesBottom']) {
        $clothes = $snooze['clothesBottom'];
    }
    if ($snooze['clothesTop']) {
        $clothes = $clothes . ' ' . $snooze['clothesTop'];
    }
    if ($snooze['clothesHoodie']) {
        $clothes = $clothes . ' ' . $snooze['clothesHoodie'];
    }
    if ($snooze['clothesBoth']) {
        $clothes = $clothes . ' ' . $snooze['clothesBoth'];
    }
    
    
    $final = trim($clothes);
    

    
    if ($final) {
        $query = 'UPDATE snoozelings SET clothes = :clothes WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $snooze['id']);
        $stmt->bindParam(":clothes", $final);
        $stmt->execute();
        $count++;
    }
    

}

echo $count . " Snoozelings Updated";