<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . " Error code: " . $conn->connect_errno);
}

$postsData = file_get_contents("https://jsonplaceholder.typicode.com/posts");
$posts = json_decode($postsData, true);

foreach ($posts as $post) {
    $sql = "INSERT INTO posts (id, userId, title, body)
            VALUES ('" . $post['id'] . "', '" . $post['userId'] . "', '" . $conn->real_escape_string($post['title']) . "', '" . $conn->real_escape_string($post['body']) . "')";
    $conn->query($sql);
}

$commentsData = file_get_contents("https://jsonplaceholder.typicode.com/comments");
$comments = json_decode($commentsData, true);

foreach ($comments as $comment) {
    $sql = "INSERT INTO comments (id, postId, name, email, body)
            VALUES ('" . $comment['id'] . "', '" . $comment['postId'] . "', '" . $conn->real_escape_string($comment['name']) . "', '" . $conn->real_escape_string($comment['email']) . "', '" . $conn->real_escape_string($comment['body']) . "')";
    $conn->query($sql);
}

$conn->close();

echo "Загружено " . count($posts) . " записей и " . count($comments) . " комментариев\n";

?>
