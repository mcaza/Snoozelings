<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    
    //Get Newest Entry
    $query = 'SELECT id FROM productivityEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $result['id'];
    
    //Update Checkboxes
    if ($_POST['oneCheck']) {
        $oneCheck = 1;
    } else {
        $oneCheck = 0;
    }
    if ($_POST['twoCheck']) {
        $twoCheck = 1;
    } else {
        $twoCheck = 0;
    }
    if ($_POST['threeCheck']) {
        $threeCheck = 1;
    } else {
        $threeCheck = 0;
    }

    if ($_POST['fourCheck']) {
        $fourCheck = 1;
    } else {
        $fourCheck = 0;
    }
    
    if ($_POST['fiveCheck']) {
        $fiveCheck = 1;
    } else {
        $fiveCheck = 0;
    }
    
    if ($_POST['habitCheckOne']) {
         $habitCheckOne = 1;
     } else {
         $habitCheckOne = 0;
     }
     
     if ($_POST['habitCheckTwo']) {
         $habitCheckTwo = 1;
     } else {
         $habitCheckTwo = 0;
     }  
 
    $query = "UPDATE productivityEntries SET habitOneCheck = :one, habitTwoCheck = :two, oneCheck = :tone, twoCheck = :ttwo, threeCheck = :tthree, fourCheck = :tfour, fiveCheck = :tfive WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":one", $habitCheckOne);
    $stmt->bindParam(":two", $habitCheckTwo);
    $stmt->bindParam(":tone", $oneCheck);
    $stmt->bindParam(":ttwo", $twoCheck);
    $stmt->bindParam(":tthree", $threeCheck);
    $stmt->bindParam(":tfour", $fourCheck);
    $stmt->bindParam(":tfive", $fiveCheck);
    $stmt->execute();
    
    
    //Update Scores
    if ($_POST['productivity']) {
        $pro = $_POST["productivity"];
        $query = "UPDATE productivityEntries SET productivity = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['mood']) {
        $pro = $_POST["mood"];
        $query = "UPDATE productivityEntries SET mood = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['health']) {
        $pro = $_POST["health"];
        $query = "UPDATE productivityEntries SET physicalHealth = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['mental']) {
        $pro = $_POST["mental"];
        $query = "UPDATE productivityEntries SET mentalHealth = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['notes']) {
        $pro = $_POST["notes"];
        $query = "UPDATE productivityEntries SET notes = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    
    //Update Tomorrow's Tasks
    if ($_POST['tomorrowTaskOne']) {
        $pro = htmlspecialchars($_POST["tomorrowTaskOne"]);
        $query = "UPDATE productivityEntries SET taskOne = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['tomorrowTaskTwo']) {
        $pro = htmlspecialchars($_POST["tomorrowTaskTwo"]);
        $query = "UPDATE productivityEntries SET taskTwo = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['tomorrowTaskThree']) {
        $pro = htmlspecialchars($_POST["tomorrowTaskThree"]);
        $query = "UPDATE productivityEntries SET taskThree = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['tomorrowTaskFour']) {
        $pro = htmlspecialchars($_POST["tomorrowTaskFour"]);
        $query = "UPDATE productivityEntries SET taskFour = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['tomorrowTaskFive']) {
        $pro = htmlspecialchars($_POST["tomorrowTaskFive"]);
        $query = "UPDATE productivityEntries SET taskFive = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    
    //Update Weekly Journal
    if ($_POST['newHabitOne']) {
        $pro = htmlspecialchars($_POST["newHabitOne"]);
        $query = "UPDATE productivityEntries SET habitOne = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['neaHabitTwo']) {
        $pro = htmlspecialchars($_POST["neaHabitTwo"]);
        $query = "UPDATE productivityEntries SET habitTwo = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['weeklyWins']) {
        $pro = htmlspecialchars($_POST["weeklyWins"]);
        $query = "UPDATE productivityEntries SET weeklyWin = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['weeklyLoses']) {
        $pro = htmlspecialchars($_POST["weeklyLoses"]);
        $query = "UPDATE productivityEntries SET weeklyLoss = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }
    if ($_POST['weeklyLesson']) {
        $pro = htmlspecialchars($_POST["weeklyLesson"]);
        $query = "UPDATE productivityEntries SET learned = :num WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":num", $pro);
        $stmt->execute();
    }

    
    //SPop Up
    $_SESSION['finish'] = 2;
    
    header("Location: ../journal");
    
} else {
    header("Location: ../journal");
}










