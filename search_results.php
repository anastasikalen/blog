<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchText = $_GET['searchText'];
$searchTextEscaped = $conn->real_escape_string($searchText);

$sql = "SELECT p.title, c.body FROM posts p
        INNER JOIN comments c ON p.id = c.postId
        WHERE c.body LIKE '%$searchTextEscaped%'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Результаты поиска:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>Заголовок записи:</strong> " . $row['title'] . "<br>";
        echo "<strong>Комментарий:</strong> " . $row['body'] . "</p>";
    }
} else {
    echo "По вашему запросу ничего не найдено.";
}

$conn->close();

?>
