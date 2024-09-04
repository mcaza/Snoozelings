<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    
    //Get Journal Id
    $query = 'SELECT id FROM journals WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $closed = 0;
    
    //Get Date
    $now = new DateTime('now');
    $formatted = $now->format('Y-m-d');
    
    //Grab Form Variables
    if ($_POST['productivity']) {
        $productivity = $_POST['productivity'];
    } else {
        $productivity = NULL;
    }
    if ($_POST['mood']) {
        $mood = $_POST['mood'];
    } else {
        $mood = NULL;
    }
    if ($_POST['health']) {
        $health = $_POST['health'];
    } else {
        $health = NULL;
    }
    if ($_POST['mental']) {
        $mental = $_POST['mental'];
    } else {
        $mental = NULL;
    }
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
    if (date('N') == 6 || date('N') == 7) {
        
    } else {
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
    }
    //Check for Habits
    $query = 'SELECT * FROM productivityEntries WHERE user_id = :id ORDER BY id DESC LIMIT 7'; 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $habits = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($habits as $habit) {
        if ($habit['habitOne']) {
            $habitCheck = true;
            break;
        }
    }
    if ($habitCheck) {
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
    }
    
    $taskOne = $_POST['tomorrowTaskOne'];
    $taskTwo = $_POST['tomorrowTaskTwo'];
    $taskThree = $_POST['tomorrowTaskThree'];
    
    if ($_POST['tomorrowTaskFour']) {
        $taskFour = $_POST['tomorrowTaskFour'];
        $taskFive = $_POST['tomorrowTaskFive'];
    }
    
    if ($_POST['newHabitOne']) {
        $habitOne = $_POST['newHabitOne'];
        $habitTwo = $_POST['neaHabitTwo'];
        $weeklyWins = $_POST['weeklyWins'];
        $weeklyLosses = $_POST['weeklyLoses'];
        $weeklyLesson = $_POST['weeklyLesson'];
    }
    
    //Get Journal Id
    $query = 'SELECT id FROM productivityEntries WHERE user_id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $prevCheck = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($prevCheck != false) {
    //Custom Variable Checks
    if ($productivity > 10 || $productivity < 1 || is_numeric($productivity) != true) {
        header("Location: ../index");
        die();
    }
    
    if ($mood > 10 || $mood < 1 || is_numeric($mood) != true) {
        header("Location: ../index");
        die();
    }
    
    if ($health > 10 || $health < 1 || is_numeric($health) != true) {
        header("Location: ../index");
        die();
    }
    
    if ($mental > 10 || $mental < 1 || is_numeric($mental) != true) {
        header("Location: ../index");
        die();
    }
    }
    
    //Submit Journal
    if (date('N') == 7) {
        $query = 'INSERT INTO productivityEntries (user_id, journal_id, date, productivity, mood, physicalHealth, mentalHealth, taskOne, taskTwo, taskThree, taskFour, taskFive,oneCheck,twoCheck,threeCheck,weeklyWin,weeklyLoss,learned,closed) VALUES (:user_id, :journal_id, :date, :productivity, :mood, :physicalHealth, :mentalHealth, :taskOne, :taskTwo, :taskThree, :taskFour, :taskFive, :oneCheck, :twoCheck, :threeCheck, :weeklyWin, :weeklyLoss, :learned)';
    } else if (date('N') == 5) {
        $query = 'INSERT INTO productivityEntries (user_id, journal_id, date, productivity, mood, physicalHealth, mentalHealth, taskOne, taskTwo, taskThree, oneCheck,twoCheck,threeCheck,fourCheck,fiveCheck) VALUES (:user_id, :journal_id, :date, :productivity, :mood, :physicalHealth, :mentalHealth, :taskOne, :taskTwo, :taskThree, :oneCheck, :twoCheck, :threeCheck, :fourCheck, :fiveCheck)';
    } else if (date('N') == 6 ) {
        $query = 'INSERT INTO productivityEntries (user_id, journal_id, date, productivity, mood, physicalHealth, mentalHealth, taskOne, taskTwo, taskThree, oneCheck,twoCheck,threeCheck) VALUES (:user_id, :journal_id, :date, :productivity, :mood, :physicalHealth, :mentalHealth, :taskOne, :taskTwo, :taskThree, :oneCheck, :twoCheck, :threeCheck)';
    } else {

        $query = 'INSERT INTO productivityEntries (user_id, journal_id, date, productivity, mood, physicalHealth, mentalHealth, taskOne, taskTwo, taskThree, taskFour, taskFive, oneCheck,twoCheck,threeCheck,fourCheck,fiveCheck) VALUES (:user_id, :journal_id, :date, :productivity, :mood, :physicalHealth, :mentalHealth, :taskOne, :taskTwo, :taskThree, :taskFour, :taskFive, :oneCheck, :twoCheck, :threeCheck, :fourCheck, :fiveCheck)';
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":journal_id", $result['id']);
    $stmt->bindParam(":date", $formatted);
    $stmt->bindParam(":productivity", $productivity);
    $stmt->bindParam(":mood", $mood);
    $stmt->bindParam(":physicalHealth", $health);
    $stmt->bindParam(":mentalHealth", $mental);
    $stmt->bindParam(":taskOne", $taskOne);
    $stmt->bindParam(":taskTwo", $taskTwo);
    $stmt->bindParam(":taskThree", $taskThree);
    $stmt->bindParam(":oneCheck", $oneCheck);
    $stmt->bindParam(":twoCheck", $twoCheck);
    $stmt->bindParam(":threeCheck", $threeCheck);
    if (date('N') == 7) {
        $stmt->bindParam(":habitOne", $habitOne);
        $stmt->bindParam(":habitTwo", $habitTwo);
        $stmt->bindParam(":weeklyWin", $weeklyWins);
        $stmt->bindParam(":weeklyLoss", $weeklyLosses);
        $stmt->bindParam(":learned", $taskFour);
        $stmt->bindParam(":taskFour", $taskFour);
        $stmt->bindParam(":taskFive", $taskFive);
    } else if (date('N') == 5) {
        $stmt->bindParam(":fourCheck", $fourCheck);
        $stmt->bindParam(":fiveCheck", $fiveCheck);
    } else if (date('N') == 6 ) {
        
    } else {
        $stmt->bindParam(":taskFour", $taskFour);
        $stmt->bindParam(":taskFive", $taskFive);
        $stmt->bindParam(":fourCheck", $fourCheck);
        $stmt->bindParam(":fiveCheck", $fiveCheck);
    }
    $stmt->execute();
    
    //Get Newest Entry ID
    $query = 'SELECT * FROM productivityEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1'; 
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $newest = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Update Habit Check
    if ($habitCheck) {
        $query = 'UPDATE productivityEntries SET habitOneCheck = :checkOne, habitTwoCheck = :checkTwo WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $newest['id']);
        $stmt->bindParam(":checkOne", $habitCheckOne);
        $stmt->bindParam(":checkTwo", $habitCheckTwo);
        $stmt->execute();
    }
    
    //Update Notes
    if ($_POST['notes']) {
        $query = 'UPDATE productivityEntries SET notes = :notes WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $newest['id']);
        $stmt->bindParam(":notes", $_POST['notes']);
        $stmt->execute();
    }
    
    //Add +1 Journal to Daily Record
    $query = 'UPDATE dailyRecords SET journalEntries = journalEntries + 1 ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Add +1 Journal to User Data
    $query = 'UPDATE users SET journalEntries = journalEntries + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Add +1 Entries to Journal
    $query = 'UPDATE journals SET entries = entries + 1 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $result['id']);
    $stmt->execute();
    
    //Add 5 Coins
    $query = 'UPDATE users SET coinCount = coinCount + 5 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    //Set Session for Coins
    if ($_POST['newHabitOne']) {
            $_SESSION['finish'] = 3;

    } else {
            $_SESSION['finish'] = 1;

    }
    
    header("Location: ../journal");
    
} else {
    header("Location: ../journal");
}

