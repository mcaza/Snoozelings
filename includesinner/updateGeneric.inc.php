<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_COOKIE['user_id'];
    
    //Get Newest Entry
    $query = 'SELECT id FROM genericEntries WHERE user_id = :id ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $result['id'];
    

    
    if ($_POST["physical"]) {
        $phy = $_POST["physical"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET physicalHealth = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
     if ($_POST["mental"]) {
        $phy = $_POST["mental"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET mentalHealth = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
     if ($_POST["emotional"]) {
        $phy = $_POST["emotional"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET emotionalHealth = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
     if ($_POST["spiritual"]) {
        $phy = $_POST["spiritual"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET spiritualHealth = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
     if ($_POST["social"]) {
        $phy = $_POST["social"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET socialHealth = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
     if ($_POST["food"]) {
        $phy = $_POST["food"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET eating = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
    if ($_POST["water"]) {
        $phy = $_POST["water"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET water = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
    if ($_POST["exercise"]) {
        $phy = $_POST["exercise"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET excercise = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
    if ($_POST["sleep"]) {
        $phy = $_POST["sleep"];
        if ($phy > 10 || $phy < 1) {
        header("Location: ../index");
            die();
        }
        $query = "UPDATE genericEntries SET sleeping = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $phy);
        $stmt->execute();
    }
    
    if ($_POST["pain"]) {
        $notes = $_POST["pain"];
        $query = "UPDATE genericEntries SET pain = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $notes);
        $stmt->execute();
    }
    
    if ($_POST["illness"]) {
        $notes = $_POST["illness"];
        $query = "UPDATE genericEntries SET illness = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $notes);
        $stmt->execute();
    }
    
    if ($_POST["goodThing"]) {
        $notes = $_POST["goodThing"];
        $query = "UPDATE genericEntries SET goodThing = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $notes);
        $stmt->execute();
    }
    
    if ($_POST["badThing"]) {
        $notes = $_POST["badThing"];
        $query = "UPDATE genericEntries SET badThing = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $notes);
        $stmt->execute();
    }
    
    if ($_POST["notes"]) {
        $notes = $_POST["notes"];
        $query = "UPDATE genericEntries SET notes = :pain WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pain", $notes);
        $stmt->execute();
    }
    
    
    //Set Session for Coins
    $reply = "Your journal has been edited.";
    $query = 'INSERT INTO replies (user_id, message) VALUES (:user_id, :message)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $userId);
    $stmt->bindParam(":message", $reply);
    $stmt->execute();
    
    header("Location: ../journal");
    
} else {
    header("Location: ../journal");
}