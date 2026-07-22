<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require_once '../config.php';

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$limit = max(1, min($limit, 50)); // clamp between 1 and 50

$sql = "
    SELECT artworks.id, artworks.title, artworks.description, artworks.price, 
           artworks.image_url, artworks.status, artworks.is_purchased_by_hiranya, 
           users.username AS artist_name, categories.name AS category_name
    FROM artworks
    LEFT JOIN users ON artworks.artist_id = users.id
    LEFT JOIN categories ON artworks.category_id = categories.id
    WHERE artworks.status = 'available'
";

if ($category_id > 0) {
    $sql .= " AND artworks.category_id = $category_id";
}

$sql .= " ORDER BY artworks.id DESC LIMIT $limit";

$result = mysqli_query($conn, $sql);
$artworks = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // format price and absolute image url
        $row['price'] = (float)$row['price'];
        $row['image_url'] = 'uploads/' . $row['image_url'];
        $artworks[] = $row;
    }
    echo json_encode([
        "success" => true,
        "count" => count($artworks),
        "data" => $artworks
    ], JSON_PRETTY_PRINT);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database query failed: " . mysqli_error($conn)
    ]);
}
?>
