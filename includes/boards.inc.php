<?php
$userId = $_SESSION['user_id'];
$var = "id";

$order = "datetime";
//Filter GET Stuff
if ($_GET['order']) {
    $order = $_GET['order'];
}
if ($_GET['type']) {
    $type = $_GET['type'];
}

//Get GET Data
if ($type === "all" && $order === "all") {
        $query = 'SELECT * FROM posts ORDER BY datetimr DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($type === "official") {
    if ($order === "likes") {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY likes DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY datetime DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} elseif ($type === "general") {
        if ($order === "likes") {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY likes DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY datetime DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} elseif ($type === "freebies") {
       if ($order === "likes") {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY likes DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY datetime DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}
    } elseif ($type === "media") {
       if ($order === "likes") {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY likes DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY datetime DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}
    } elseif ($type === "artwork") {
       if ($order === "likes") {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY likes DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY datetime DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}
    } elseif ($type === "guides") {
       if ($order === "likes") {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY likes DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $query = 'SELECT * FROM posts WHERE category = :type ORDER BY datetime DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}
    } else {
    $query = 'SELECT * FROM posts ORDER BY datetime DESC LIMIT 20';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Post Button (Right)
echo '<div style="text-align: right;"><button  class="fancyButton" onClick="window.location.href=\'newPost\'">New Post</button></div>';

//Filter Section
echo '<h3>Filter By</h3>';
echo '<form method="GET">';
echo '<div class="filterBoxes">';
echo '<div class="filterBox">';
echo '<label style="margin-top: 2rem;" for="order" class="form">Order:</label><br>';
echo '<select class="input"  name="order" style="width: 8rem;">';
echo '<option value="date"></option>';
echo '<option value="date">Date</option>';
echo '<option value="likes">Likes</option>';
echo '</select>';
echo '</div>';
echo '<div class="filterBox">';
echo '<label style="margin-top: 2rem;" for="type" class="form">Type:</label><br>';
echo '<select class="input"  name="type" style="width: 8rem;">';
echo '<option value="all"></option>';
echo '<option value="official">News</option>';
echo '<option value="general">General</option>';
echo '<option value="media">Media</option>';
echo '<option value="freebies">Giveaways</option>';
echo '<option value="artwork">Artwork</option>';
echo '<option value="guides">Guides</option>';
echo '</select>';
echo '</div>';
echo '</div>';

//Button & End Form
echo '<button class="fancyButton">Filter</button>';
echo '</form>';


//Display Posts
foreach ($posts as $post) {
    //Grab Bonded ID and Username
    $query = 'SELECT username, bonded FROM users WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $post['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //Get Pet Information
    $query = 'SELECT * FROM snoozelings WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $user['bonded']);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo '<div class="post">';
    echo '<div class="postRowOne">';
    echo '<div class="postUser">';
    echo '<a href="profile?id=' . $post['user_id'] . '"><h4 style="margin-top: 0;">'  . htmlspecialchars($user['username']) . '</h4></a>';
    displayPet($pet, "articon");
    
    echo '</div>';

    echo '<div class="postContent" style="margin-right: auto; margin-left: auto;">';
    echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
    echo '<p>' . nl2br(htmlspecialchars($post['text'])) . '</p></div>';
    echo '</div>';
    echo '<div class="readMore"><a href="post?id=' . $post['id'] . '"><h4>Read More >></h4></a></div>';
    echo '</div>';
    
}























