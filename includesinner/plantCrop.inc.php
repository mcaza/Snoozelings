<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

//Get Variables
    $userId = $_COOKIE['user_id'];
    $farmer = $_POST['farmer'];
    $seed = $_POST['seed'];
    $plot = $_POST['plot'];
    
    //Get Snoozeling Info 
    $query = "SELECT job, farmEXP FROM snoozelings WHERE id = :farmer";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":farmer", $farmer);
    $stmt->execute(); 
    $snooze = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Check if Pet is Crafting
    if ($snooze['job'] === "jack") {
        $query = 'SELECT * FROM craftingtables WHERE pet_id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $farmer);
        $stmt->execute();
        $table = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($table) {
            $now = new DateTime("now", new DateTimezone('UTC'));
            $future_date = new DateTime($table['finishtime']);
            if ($table['finishtime']) {
                if ($future_date >= $now) {
                        $reply = "That snoozeling is currently crafting.";
                    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":user_id", $userId);
                    $stmt->bindParam(":message", $reply);
                    $stmt->execute();
                    header("Location: ../farm");
                    die(); 
                }
            }
        }
    }
    
    if(!$farmer) {
            $reply = "You need to select a farmer.";
        $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":message", $reply);
        $stmt->execute();
        header("Location: ../farm");
        die();
    }
    
    $exp = $snooze['farmEXP'] + .5;
    
    //Get First Seed ID
    $query = "SELECT id, list_id FROM items WHERE name = :name && user_id = :id ORDER BY id LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $seed);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $seedId = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(!$seedId) {
            $reply = "You do not own any of that seed.";
            $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":message", $reply);
            $stmt->execute();
        header("Location: ../farm");
        die();
    }
    

        if (!$plot || !$seed) {
            $message = "Planting Error: Check Logs for More Info";
            error_log($message, 1, "megan.caza@gmail.com");
            echo 'There has been an error with planting your crop. An email with complete details has been sent to lead developer Slothie.';
            die();
        }
    
    

    
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
    if ($seed == "MysterySeed") {
        $query = "SELECT * FROM seeds";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stg1 = 60;
        $stg2 = 120;
        $stg3 = 180;
        $count = count($results)-1;
        $rand = rand(0,$count);
        $name = $results[$rand]['name'];
        $temp1 = $stg1 * $reduce;
        $temp2 = $stg2 * $reduce;
        $temp3 = $stg3 * $reduce;
        $stg1 = round($temp1, 0);
        $stg2 = round($temp2, 0);
        $stg3 = round($temp3, 0);
        $amount = $results[$rand]['amount'];
        $plantName = $results[$rand]['plantName'];
    } else {
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
    }
    
    
    
    //Error Email
    if (!$plantName) {
        $message = "Plant name crash = Plot: " . $plot . ", Seed: " . $seed . ", User: " . $userId . ", Farmer: " . $farmer;
            error_log($message, 1, "megan.caza@gmail.com");
            echo 'There has been an error with planting your crop. An email with complete details has been sent to lead developer Slothie.';
            die();
    }
    
    
//Calculate Times
    //Update Snoozeling to working and add cooldown
    $now = new DateTime("now", new DateTimezone('UTC'));
    
    $time1 = (clone $now)->add(new DateInterval("PT{$stg1}M")); 
    $format1 = $time1->format('Y-m-d H:i:s');
    
    $time2 = (clone $now)->add(new DateInterval("PT{$stg2}M")); 
    $format2 = $time2->format('Y-m-d H:i:s');
    
    $time3 = (clone $now)->add(new DateInterval("PT{$stg3}M")); 
    $format3 = $time3->format('Y-m-d H:i:s');
    
    //Record to Database to Track for Error
    if ($seed == "MysterySeed") {
        $mystery = 1;
    } else {
        $mystery = 0;
    }
    
    $query = "INSERT INTO plantingLogs SET name = :name, stg1 = :stg1, stg2 = :stg2, stg3 = :stg3, amount = :amount, plantName = :plantName, mystery = :mystery, user_id = :user, plot = :plot, seed = :seed, farmer = :farmer";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":stg1", $format1);
    $stmt->bindParam(":stg2", $format2);
    $stmt->bindParam(":stg3", $format3);
    $stmt->bindParam(":amount", $amount);
    $stmt->bindParam(":plantName", $plantName);
    $stmt->bindParam(":mystery", $mystery);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":plot", $plot);
    $stmt->bindParam(":seed", $seed);
    $stmt->bindParam(":farmer", $farmer);
    $stmt->execute();

//Update Seed into Farm
    if ($seed == "MysterySeed") {
        $query = "UPDATE farms SET name = :name, stg1 = :stg1, stg2 = :stg2, stg3 = :stg3, amount = :amount, plantName = :plantName, mystery = 1 WHERE id = :id";
    } else {
        $query = "UPDATE farms SET name = :name, stg1 = :stg1, stg2 = :stg2, stg3 = :stg3, amount = :amount, plantName = :plantName WHERE id = :id";
    }
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
    
    //Reply
    if ($seedId['list_id'] == 14) {
        $reply = 'You have planted a single Mystery Seed.';
    } else {
        $reply = 'You have planted a single ' . $plantName . ' Seed.';
    }
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();

//Redirect
    header("Location: ../farm.php");

} else {
header("Location: ../farm.php");
    die();
}









