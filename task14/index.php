<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'addFriend') {
            $name = $_POST['name'];
            $photo_url = $_POST['photo_url'];
            $group_name = $_POST['group_name'];

            $stmt = $conn->prepare("INSERT INTO friends (name, photo_url, group_name) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $photo_url, $group_name);
            $stmt->execute();
            $stmt->close();
        } elseif ($_POST['action'] == 'deleteFriend') {
            $id = $_POST['id'];

            $stmt = $conn->prepare("DELETE FROM friends WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($_POST['action'] == 'editFriend') {
            $id = $_POST['id'];
            $group_name = $_POST['group_name'];

            $stmt = $conn->prepare("UPDATE friends SET group_name = ? WHERE id = ?");
            $stmt->bind_param("si", $group_name, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$friends = $conn->query("SELECT * FROM friends");
$groups = $conn->query("SELECT * FROM groups");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Friends not on a list</h1>
<ul class="friend-list">
    <?php foreach ($friends as $friend): ?>
    <li class="friend-item">
        <img src="<?= $friend['photo_url'] ?>" alt="Photo of <?= $friend['name'] ?>">
        <?= $friend['name'] ?>
        <form action="index.php" method="POST">
            <select name="group_name">
                <?php foreach ($groups as $group): ?>
                    <option value="<?= $group['group_name'] ?>" <?= $friend['group_name'] == $group['group_name'] ? 'selected' : '' ?>>
                        <?= $group['group_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="id" value="<?= $friend['id'] ?>">
            <input type="hidden" name="action" value="editFriend">
            <button type="submit">Save</button>
        </form>
        <form action="index.php" method="POST" style="display:inline;">
            <input type="hidden" name="id" value="<?= $friend['id'] ?>">
            <input type="hidden" name="action" value="deleteFriend">
            <button type="submit">Delete</button>
        </form>
    </li>
    <?php endforeach; ?>
</ul>

<h2>Add a New Friend</h2>
<form action="index.php" method="POST">
    <input type="text" name="name" placeholder="Friend's Name" required>
    <input type="text" name="photo_url" placeholder="Photo URL">
    <select name="group_name">
        <option value="">None</option>
        <?php foreach ($groups as $group): ?>
            <option value="<?= $group['group_name'] ?>"><?= $group['group_name'] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="action" value="addFriend">
    <button type="submit">Add Friend</button>
</form>

</body>
</html>
