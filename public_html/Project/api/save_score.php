<?php
//remember, API endpoints should only echo/output precisely what you want returned
//any other unexpected characters can break the handling of the response
$response = ["message" => "There was a problem saving your score"];
http_response_code(400);
$contentType = $_SERVER["CONTENT_TYPE"];
error_log("Content Type $contentType");
if ($contentType === "application/json") {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true)["data"];
} else if ($contentType === "application/x-www-form-urlencoded") {
    $data = $_POST;
}

error_log(var_export($data, true));
if (isset($data["score"]) && isset($data["data"]) && isset($data["nonce"])) {
    session_start();
    $reject = false;
    if (!isset($_SESSION["nonce"]) || empty($_SESSION["nonce"]) || $data["nonce"] != $_SESSION["nonce"]) {
        error_log("Invalid nonce, possible duplicated post");
        $reject = true;
    }
    unset($_SESSION["nonce"]);
    require_once(__DIR__ . "/../../../lib/functions.php");
    $user_id = get_user_id();
    if ($user_id <= 0) {
        $reject = true;
        error_log("User not logged in");
        http_response_code(403);
        $response["message"] = "You must be logged in to save your score";
        flash($response["message"], "warning");
    }
    if (!$reject) {
        $score = (int)se($data, "score", 0, false);
        $calced = 0;
        $data = $data["data"]; //anti-cheating
        $lastDate = null;
        $data_count = count($data);
        $duplicate_dates = 0;
        foreach ($data as $r) {
            $date = DateTime::createFromFormat("U", $r["ts"]);
            if (!$lastDate || $date >= $lastDate) {
                if ($date === $lastDate) {
                    $duplicate_dates++;
                }
                $lastDate = $date;
            } else {
                $reject = true;
                error_log("Invalid ts validation for game activity");
                break;
            }
        }
        if ($duplicate_dates >= $data_count) {
            error_log("Too many duplicate dates");
            $reject = true;
        }
        if (!$reject) {
            http_response_code(200);
            
            save_score($score, $user_id, true);
            $response["message"] = "Score Saved!";
            error_log("Score of $score saved successfully for $user_id");
        } else {
            $response["message"] = "AntiCheat Detection Triggered. Score rejected.";
        }
    }
}
echo json_encode($response);