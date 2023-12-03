<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_SESSION['user_id'];
    $farmer = $_POST['farmer'];
    $seed = $_POST['seed'];
    $plot = $_POST['plot'];
    
    //Get Snoozeling Info 
    $query = "SELECT job, farmEXP FROM snoozelings WHERE id = :farmer";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":farmer", $farmer);
    $stmt->execute();
    $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $exp = $snooze['farmEXP'] + .5;


    
    //Get Time Reducer
    if ($snooze['job'] === "jack" || $exp < 50) {
        $reduce = 1;
    } elseif ($exp < 150) {
        $reduce = .90;
    } elseif ($exp < 325) {
        $reduce = .80;
    } elseif ($exp < 600) {
        $reduce = .70;
    } elseif ($exp < 1000) {
        $reduce = .60;
    } else {
        $reduce = .50;
    }

//Get Seed Info
    $query = "SELECT * FROM seeds WHERE name = :name";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $seed);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $name = $result['name'];
    $temp1 = intval($result['stg1']) * $reduce;
    $temp2 = intval($result['stg2']) * $reduce;
    $temp3 = intval($result['stg3']) * $reduce;
    $stg1 = round($temp1, 0);
    $stg2 = round($temp2, 0);
    $stg3 = round($temp3, 0);
    $amount = $result['amount'];
    $plantName = $result['plantName'];
    
    //Get First Seed ID
    $query = "SELECT id FROM items WHERE name = :name && user_id = :id ORDER BY id LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $seedId = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$seedId) {
        $_SESSION["reply"] = "You do not own any of that seed.";
        header("Location: ../farm");
        die();
    }
    
//Calculate Times
    //Update Snoozeling to working and add cooldown
    $now = new DateTime();
    
    $time1 = (clone $now)->add(new DateInterval("PT{$stg1}M")); 
    $format1 = $time1->format('Y-m-d H:i:s');
    
    $time2 = (clone $now)->add(new DateInterval("PT{$stg2}M")); 
    $format2 = $time2->format('Y-m-d H:i:s');
    
    $time3 = (clone $now)->add(new DateInterval("PT{$stg3}M")); 
    $format3 = $time3->format('Y-m-d H:i:s');

//Update Seed into Farm
    $query = "UPDATE farms SET name = :name, stg1 = :stg1, stg2 = :stg2, stg3 = :stg3, amount = :amount, plantName = :plantName WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":stg1", $format1);
    $stmt->bindParam(":stg2", $format2);
    $stmt->bindParam(":stg3", $format3);
    $stmt->bindParam(":amount", $amount);
    $stmt->bindParam(":plantName", $plantName);
    $stmt->bindParam(":id", $plot);
    $stmt->execute();
    
//Add EXP to Snoozeling
if ($snooze['job'] === "Farmer") {
    $query = "UPDATE snoozelings SET farmEXP = :exp WHERE id = :id";
     $stmt = $pdo->prepare($query);
    $stmt->bindParam(":exp", $exp);
    $stmt->bindParam(":id", $farmer);
    $stmt->execute();
}
    
    //Delete Seed from Inventory
    $query = 'DELETE FROM items WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $seedId['id']);
    $stmt->execute();

//Redirect
    header("Location: ../farm.php");

} else {
header("Location: ../farm.php");
    die();
}









