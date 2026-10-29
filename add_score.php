<?php
// Load database configuration
$config = include('db_config.php');

// Create a connection
$conn = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);

// Function to generate a random unique ID
function generateUniqueId($conn) {
    $unique = false;
    $id = 0;

    while (!$unique) {
        // Generate a random number between 1 and 99,999,999,999 (11 digits)
        $id = rand(1, 99999999999);

        // Check if this ID already exists in the database
        $result = $conn->query("SELECT COUNT(*) AS count FROM scores WHERE id = $id");
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            $unique = true;
        }
    }

    return $id;
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Get data from POST request (cast to float)
$scoreOne = (float)($_POST['score_one'] ?? 0);
$scoreTwo = (float)($_POST['score_two'] ?? 0);
$scoreThree = (float)($_POST['score_three'] ?? 0);
$scoreFour = (float)($_POST['score_four'] ?? 0);
$scoreFive = (float)($_POST['score_five'] ?? 0);
$scoreSix = (float)($_POST['score_six'] ?? 0);
$scoreSeven = (float)($_POST['score_seven'] ?? 0);
$scoreEight = (float)($_POST['score_eight'] ?? 0);
$scoreNine = (float)($_POST['score_nine'] ?? 0);
$scoreTen = (float)($_POST['score_ten'] ?? 0);
$score = (float)($_POST['score'] ?? 0);

// Ignore obviously invalid submissions
if ($score <= 0 || $score > 1000) {
    http_response_code(422);
    exit;
}

// Generate a unique random ID
$uniqueId = generateUniqueId($conn);

// Prepare and execute the SQL query to insert individual scores with the random ID
$stmt = $conn->prepare("INSERT INTO scores (id, score_one, score_two, score_three, score_four, score_five, score_six, score_seven, score_eight, score_nine, score_ten, total_score) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("dddddddddddd", $uniqueId, $scoreOne, $scoreTwo, $scoreThree, $scoreFour, $scoreFive, $scoreSix, $scoreSeven, $scoreEight, $scoreNine, $scoreTen, $score);

$stmt->execute();
$stmt->close();

// Work out where this score sits on the leaderboard: rank 1 = highest total_score.
$total = (int) $conn->query("SELECT COUNT(*) AS total FROM scores")->fetch_assoc()['total'];

$betterStmt = $conn->prepare("SELECT COUNT(*) AS better FROM scores WHERE total_score > ?");
$betterStmt->bind_param("d", $score);
$betterStmt->execute();
$better = (int) $betterStmt->get_result()->fetch_assoc()['better'];
$betterStmt->close();

$rank = $better + 1;
$percentile = $total > 0 ? (int) round((1 - ($rank - 1) / $total) * 100) : 100;
$percentile = max(1, min(100, $percentile));

// Close the connection
$conn->close();

// Tell the front end where this score ranks, so it can show it and offer to share it.
header('Content-Type: application/json');
echo json_encode([
    'ok'         => true,
    'rank'       => $rank,
    'total'      => $total,
    'percentile' => $percentile,
]);
?>