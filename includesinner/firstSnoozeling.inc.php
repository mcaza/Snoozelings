<?php

require_once '../../includes/dbh-inc.php';
require_once '../../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $name = $_POST["name"];
    $id = $_POST["snoozeling"];
    $pronouns = $_POST["pronouns"];
    $userId = $_COOKIE['user_id'];
    $todaysDate = date("Y-m-d");
    $job = "jack";
    $mood = "Happy";
    $breedStatus = "Closed";
    $title = "The New One";
    $bed = "BlueFree";
    
    $query = "SELECT * FROM blueprints WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
   $query = "INSERT INTO snoozelings (owner_id, mainColor, hairColor, tailColor, eyeColor, noseColor, hairType, tailType, specials, name, pronouns, birthDate, job, mood, breedStatus, title, bedcolor) VALUES (:owner_id, :mainColor, :hairColor, :tailColor, :eyeColor, :noseColor, :hairType, :tailType, :specials, :name, :pronouns, :birthDate, :job, :mood, :breedStatus, :title, :bed);";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(":owner_id", $userId);
    $stmt->bindParam(":mainColor", $result["mainColor"]);
    $stmt->bindParam(":hairColor", $result["hairColor"]);
    $stmt->bindParam(":tailColor", $result["tailColor"]);
    $stmt->bindParam(":eyeColor", $result["eyeColor"]);
    $stmt->bindParam(":noseColor", $result["noseColor"]);
    $stmt->bindParam(":hairType", $result["hairType"]);
    $stmt->bindParam(":tailType", $result["tailType"]);
    $stmt->bindParam(":specials", $result["specials"]);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":pronouns", $pronouns);
    $stmt->bindParam(":birthDate", $todaysDate);
    $stmt->bindParam(":job", $job);
    $stmt->bindParam(":mood", $mood);
    $stmt->bindParam(":breedStatus", $breedStatus);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":bed", $bed);
    $stmt->execute(); 
    
    $query = "DELETE FROM blueprints WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();    
    
    $query = "SELECT id FROM snoozelings WHERE owner_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $newId = $result["id"];
    
    $query = "UPDATE users SET bonded = :id WHERE id = :userId";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $newId);
    $stmt->bindParam(":userId", $userId);
    $stmt->execute();
    
    //Increase Daily Records +1
    $query = 'UPDATE dailyRecords SET newMembers = newMembers + 1 ORDER BY id DESC LIMIT 1';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    //Add Bed to Account (Account bound)
    $bed = 155;
    $zero = 0;
    
    $query = 'SELECT * FROM itemList WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $bed);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
        $stmt = $pdo->prepare($query);
    $stmt->bindParam(":list", $bed);
    $stmt->bindParam(":user", $userId);
    $stmt->bindParam(":name", $item['name']);
    $stmt->bindParam(":display", $item['display']);
    $stmt->bindParam(":description", $item['description']);
    $stmt->bindParam(":type", $item['type']);
    $stmt->bindParam(":rarity", $item['rarity']);
    $stmt->bindParam(":canDonate", $zero);
    $stmt->execute();
    
    //Add 2 Farms to Account
    $round = 2;
    for ($i = 0; $i < $round; $i++) {
        $query = 'INSERT INTO farms (user_id) VALUES (:id)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }
    
    //Add Crafting Table
    $query = 'INSERT INTO craftingtables (pet_id, user_id) VALUES (:pet, :id)';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->bindParam(":pet", $result['id']);
    $stmt->execute();
    
    //Welcome Mail Message
    $message = "Welcome newest Snooze Village citizen!!
    
    Read through this letter for important Snoozelings information.
    
    <b style='font-size: 2rem;'>Mail System</b>
    
    Here in Snooze Village, we don't want to overwhelm our postman. We also feel that it's important to not be checking our inboxes all the time. Because of these two reasons, the postman only delivers your mail twice a day at 6 AM EST and 7PM EST.
    
    Please keep this in mind when sending messages to your friends. They aren't ignoring you. The postman just takes plenty of breaks on his route.
    
    <b style='font-size: 2rem;'>Health Journaling</b>
    
    When filling out your journal, we ask that you do not include any identifying information. Even though no one will be reading your journal but you, we do believe it is safest to not store identifying information on our servers.
    
    <strong>Things You Can Include:</strong>
    Symptoms, Times, Dates, Body Locations, How Your Appointments Went, New Treatments Attempted, Generic Medication Names (Heart Medication, Antidepressents, Cortisone Shots), Medication Doses (Anxiety Med 1 - 30mg), Physio Exercises
    
    <strong>Things You Shouldn't Include:</strong>
    Doctors Names, Your Name, Facility Names, Facility Addresses, Specific Medication Names (Bupropion, etc), City/State/Province Names
    
    <b>Please Note</b>
    If you are having any difficult thoughts about harming yourself or others, please contact emergency services immediately. We cannot help you because your journal is meant to be private and is not monitored by staff. There are professionals out there trained to help you through these tough times.
    
    That's everything for today. Hope you enjoy the game. <3
    
    ~From Slothie (Lead Developer)";
    $title = "Welcome to Snooze Village!";
    $from = 1;
    $one = 1;
    $zero = 0;
    $now = new DateTime('now');
    $date = $now->format('Y-m-d H:i:s');
    $query = "INSERT INTO mail (sender, reciever, title, message, sent, opened, sendtime) VALUES (:from, :to, :title, :message, :sent, :opened, :datetime)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":from", $from);
    $stmt->bindParam(":to", $userId);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":message", $message);
    $stmt->bindParam(":sent", $one);
    $stmt->bindParam(":opened", $zero);
    $stmt->bindParam(":datetime", $date);
    $stmt->execute();
    
    //Add Wish Token if Alpha Tester
    $query = 'SELECT alphaTester FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    $tokenCheck = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($tokenCheck['alphaTester'] == 1) {
        $token = 225;
        $query = 'SELECT * FROM itemList WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $token);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        $query = "INSERT INTO items (list_id, user_id, name, display, description, type, rarity, canDonate) VALUES (:list, :user, :name, :display, :description, :type, :rarity, :canDonate);";
            $stmt = $pdo->prepare($query);
        $stmt->bindParam(":list", $token);
        $stmt->bindParam(":user", $userId);
        $stmt->bindParam(":name", $item['name']);
        $stmt->bindParam(":display", $item['display']);
        $stmt->bindParam(":description", $item['description']);
        $stmt->bindParam(":type", $item['type']);
        $stmt->bindParam(":rarity", $item['rarity']);
        $stmt->bindParam(":canDonate", $zero);
        $stmt->execute();
    }
    
    //Update Tutorial to 3
    $query = 'UPDATE users SET tutorial = 3 WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
    
    header("Location: ../pet?id=" . $result["id"]);
    
    
} else {
    header("Location: ../index.php");
}