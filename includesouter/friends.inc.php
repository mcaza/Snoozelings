<?php

//Get Values
$id = $_GET['id'];
$userId = $_SESSION['user_id'];
if ($_SESSION['reply']) {
    $reply = $_SESSION['reply'];
    unset($_SESSION['reply']);
}

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $id . '"><<</a>';
echo '</div>';

//Title
if ($id === $userId) {
    echo '<h3 style="margin-bottom: 2rem;">Your Friend List</h3>';
} else {
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<h3 style="margin-bottom: 2rem;">' . $result['username'] . '\'s Friend List</h3>';
}

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom: 2rem;">';
    echo '<p>' . $reply . '</p>';
    echo '</div>';
}

//Friend Div
echo '<div style="display: flex;flex-direction: row;flex-wrap: wrap; justify-content: center;row-gap: 2rem; column-gap: 2rem">';

//Fetch Friends
$query = 'SELECT friendList FROM users WHERE id = :id';
$stmt = $pdo->prepare($query);
if ($id === $userId) {
    $stmt->bindParam(":id", $userId);
} else {
    $stmt->bindParam(":id", $id);
}
$stmt->execute();
$friends = $stmt->fetch(PDO::FETCH_ASSOC);

if ($friends) {
    $list = explode(" ", $friends['friendList']);
    array_shift($list);
    foreach ($list as $friend) {
        //User Info
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $friend);
        $stmt->execute();
        $userinfo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Bonded Pet Info
        $query = "SELECT * FROM snoozelings WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userinfo['bonded']);
        $stmt->execute();
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //Display
        echo '<a href="profile?id=' . $friend . '" style="border: 2px dashed #827188; border-radius: 20px;width: 30%;">';
        displayPet($pet, "artfriends"); 
        echo '<p><strong>' . $userinfo['username'] . '</strong></p>';
        echo '</a>';
    }
    
//If user Has 0 Friends    
} else {
    if ($id === $userId) {
        echo '<p>You do not have any friends currently.<br><br>Try sending a friend invite!!</p>';
    } else {
        echo '<p>This user does not have any friends.</p>';
    }
}



echo '</div>';