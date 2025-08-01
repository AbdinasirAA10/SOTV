<?php
$client_id = '88679cc88a3b40a892d406253e1a6108';
$client_secret = '64c70c0046f944b9a2b6154f9831345d';
$redirect_uri = 'https://localhost/anaana-music-site/index.php';

if (!isset($_SESSION['access_token'])) {
    if (isset($_GET['code'])) {
        // Exchange code for access token
        $code = $_GET['code'];
        $token_url = 'https://accounts.spotify.com/api/token';

        $data = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect_uri,
            'client_id' => $client_id,
            'client_secret' => $client_secret
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($token_url, false, $context);
        $response = json_decode($result);

        if ($response && isset($response->access_token)) {
            $_SESSION['access_token'] = $response->access_token;
        } else {
            echo "<div class='error'>Error: Failed to retrieve access token.</div>";
        }
    } else {
        // Redirect to Spotify login
        $auth_url = "https://accounts.spotify.com/authorize?client_id=$client_id&response_type=code&redirect_uri=$redirect_uri&scope=user-read-private";
        header("Location: $auth_url");
        exit;
    }
}

// Fetch user profile
$access_token = $_SESSION['access_token'] ?? null;
$user = null;
$playlist = null;

if ($access_token) {
    $opts = [
        "http" => [
            "method" => "GET",
            "header" => "Authorization: Bearer $access_token"
        ]
    ];
    $context = stream_context_create($opts);

    $user_json = file_get_contents("https://api.spotify.com/v1/me", false, $context);
    $user = json_decode($user_json);

    // Example: Fetch a featured playlist
    $playlist_json = file_get_contents("https://api.spotify.com/v1/playlists/37i9dQZF1DX4JAvHpjipBk", false, $context);
    $playlist = json_decode($playlist_json);
}
