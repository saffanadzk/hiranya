<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require_once '../config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid artwork ID."
    ]);
    exit();
}

$art_sql = "
    SELECT artworks.*, users.username AS artist_name, categories.name AS category_name
    FROM artworks
    LEFT JOIN users ON artworks.artist_id = users.id
    LEFT JOIN categories ON artworks.category_id = categories.id
    WHERE artworks.id = $id
";
$art_res = mysqli_query($conn, $art_sql);

if (mysqli_num_rows($art_res) === 0) {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "message" => "Artwork not found."
    ]);
    exit();
}

$artwork = mysqli_fetch_assoc($art_res);
$artwork['price'] = (float)$artwork['price'];
$artwork['hiranya_price'] = $artwork['hiranya_price'] ? (float)$artwork['hiranya_price'] : null;
$artwork['image_url'] = 'uploads/' . $artwork['image_url'];

// If in auction, fetch auction details
$auction = null;
$bids = [];
if ($artwork['status'] === 'in_auction') {
    $auc_query = mysqli_query($conn, "SELECT * FROM auctions WHERE artwork_id = $id");
    if (mysqli_num_rows($auc_query) > 0) {
        $auction = mysqli_fetch_assoc($auc_query);
        $auction['start_bid'] = (float)$auction['start_bid'];
        $auction['current_bid'] = (float)$auction['current_bid'];
        
        // Fetch last 5 bids
        $auction_id = $auction['id'];
        $bids_query = mysqli_query($conn, "
            SELECT bids.id, bids.bid_amount, bids.bid_time, users.username 
            FROM bids 
            JOIN users ON bids.user_id = users.id 
            WHERE bids.auction_id = $auction_id 
            ORDER BY bids.bid_amount DESC LIMIT 5
        ");
        while ($bid = mysqli_fetch_assoc($bids_query)) {
            $bid['bid_amount'] = (float)$bid['bid_amount'];
            $bids[] = $bid;
        }
    }
}

echo json_encode([
    "success" => true,
    "data" => [
        "artwork" => $artwork,
        "auction" => $auction,
        "recent_bids" => $bids
    ]
], JSON_PRETTY_PRINT);
?>
