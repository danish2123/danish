<?php
$host = '127.0.0.1';  // Ensure this is the correct host for your MySQL server
$db   = 'friend_list'; 
$user = 'root';       // Change this if your MySQL user is different
$pass = '';           // Change this if your MySQL password is different

try {
    // Establish the PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Output an error message if the connection fails
    die("Connection to the database failed: " . $e->getMessage());
}

$query = "SELECT * FROM user_friend_lists";

try {
    // Prepare and execute the SQL query
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle any errors during query execution
    echo "Error in query execution: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #3b5998;
        }
        .friend-list {
            list-style-type: none;
            padding: 0;
        }
        .friend-list li {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .friend-list li img {
            border-radius: 50%;
            margin-right: 15px;
            width: 50px;
            height: 50px;
        }
        .friend-list li:last-child {
            border-bottom: none;
        }
        .friend-info {
            flex-grow: 1;
        }
        .friend-info strong {
            display: block;
            font-size: 16px;
        }
        .friend-info span {
            color: #555;
        }
        .friend-list .list-name {
            color: #777;
            font-size: 14px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Friend List</h1>
        <ul class="friend-list">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $row): ?>
                    <li>
                        <!-- Replace with a proper image source or use placeholder -->
                        <img src="https://via.placeholder.com/50" alt="Profile Picture">
                        <div class="friend-info">
                            <strong><?php echo isset($row['friend_name']) && !empty($row['friend_name']) ? htmlspecialchars($row['friend_name'], ENT_QUOTES, 'UTF-8') : 'John Doe'; ?></strong>
                            <span><?php echo isset($row['user_name']) && !empty($row['user_name']) ? htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8') : 'Jane Smith'; ?>'s friend</span>
                            <?php if (isset($row['list_name']) && !empty($row['list_name'])): ?>
                                <div class="list-name">List: <?php echo htmlspecialchars($row['list_name'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No friends found.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
