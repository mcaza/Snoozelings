<?php

//Get Values
$id = $_GET['id'];
$userId = $_COOKIE['user_id'];

if ($id == 0) {
    $id = $userId;
}

//Replies
$query = "SELECT * FROM replies WHERE user_id = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$reply = $stmt->fetch(PDO::FETCH_ASSOC);

//Check for Friend Requests
$query = "SELECT * FROM friendRequests WHERE newFriend = :id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":id", $userId);
$stmt->execute();
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Go Back Arrow
echo '<div class="leftRightButtons">';
echo '<a href="profile?id=' . $id . '"><<</a>';
echo '</div>';

//Notification
if ($reply) {
    echo '<div class="returnBar" style="margin-top: 1rem;margin-bottom:2rem;">';
    echo '<p>' . $reply['message'] . '</p>';
    echo '</div>';
    $query = "DELETE FROM replies WHERE user_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $userId);
    $stmt->execute();
}

//Title
if ($id === $userId) {
    
    //Display Requests if Any
    if ($requests) {
        echo '<h3 style="margin-bottom: 2rem;">Friend Requests</h3>';
        //Friend Div
        echo '<div style="display: flex;flex-direction: row;flex-wrap: wrap; justify-content: center;row-gap: 2rem; column-gap: 2rem">';
        foreach ($requests as $request) {
            //User Info
            $query = "SELECT * FROM users WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $request['sender']);
            $stmt->execute();
            $userinfo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            //Bonded Pet Info
            $query = "SELECT * FROM snoozelings WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $userinfo['bonded']);
            $stmt->execute();
            $pet = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo '<a href="profile?id=' . $request['sender'] . '" style="border: 2px dashed #827188; border-radius: 20px;width: 30%;">';
            displayPet($pet, "artfriends"); 
            echo '<p><strong>' . $userinfo['username'] . '</strong></p>';
            echo '</a>';

        }
        echo '</div>';
        echo '<hr>';
    }
    
    
    echo '<h3 style="margin-bottom: 2rem;">Your Friend List</h3>';
} else {
    $query = 'SELECT username FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<h3 style="margin-bottom: 2rem;">' . $result['username'] . '\'s Friend List</h3>';
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
    $list = array_filter($list);
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

//Delete Friends
echo '<hr>';
echo '<h3>Manage Friend List</h3><br>';
echo '<form action="includes/deleteFriend.inc.php" onsubmit="return confirm(\'Are you sure you want to remove this friend from your friend list?\');" method="POST">';
echo '<select class="input" name="friend">';
foreach ($list as $friend) {
    //User Info
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $friend);
    $stmt->execute();
    $userinfo = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo '<option value="' . $userinfo['id'] . '">' . $userinfo['username'] . '</option>';
}
echo '</select>';
echo '<br><button class="redButton">Delete Friend</button></form>';







