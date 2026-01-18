#!/usr/bin/env php
<?php

// Check if username argument is provided after github-activity
if ($argc < 2) {
    echo "Please provide a GitHub username.\n";
    echo "For example: github-activity kamranahmedse\n";
    exit(1);
}

$username = $argv[1]; // stores userName
$url = "https://api.github.com/users/$username/events";

$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: PHP-CLI-Activity-App\r\n"
    ]
];

$context = stream_context_create($options);

// $response will equal false if there's an error, and that's thx to the @ symbol which's suppressing errors for us to handle
$response = @file_get_contents($url, false, $context);

if ($response === false) {
    $statusLine = $http_response_header[0] ?? '';

    if (strpos($statusLine, "404") !== false) {
        echo "Error: User '$username' not found.\n";
    } elseif (strpos($statusLine, "403") !== false) {
        echo "Error: API rate limit exceeded. Please try again later.\n";
    } else {
        echo "Error: Could not connect to GitHub. Please check your internet connection.\n";
    }

    exit(1);
}

$events = json_decode($response, true);

foreach($events as $event) {
    $type = $event['type'];
    $repoName = $event['repo']['name'];

    switch ($type) {
        case 'PushEvent':
            $commits = $event['payload']['commits'] ?? [];
            $count = count($commits);
            if ($count > 0) {
                echo "- Pushed $count commits to $repoName\n";
            }
            break;
        
        case 'CreateEvent':
            echo "- Created a new repository $repoName\n";
            break;

        case 'WatchEvent':
            echo "- Starred $repoName\n";
            break;

        case 'IssuesEvent':
            echo "- Opened a new issue in $repoName\n";
            break;

        default:
            echo "- $type in $repoName\n";
            break;
    }
}