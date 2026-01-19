#!/usr/bin/env php
<?php

// 1. Check for Help Flag
// We check if the first argument exists and matches "--help" or "-h"
if (isset($argv[1]) && ($argv[1] === '--help' || $argv[1] === '-h')) {
    echo "\n";
    echo "GitHub User Activity CLI\n";
    echo "------------------------\n";
    echo "A simple CLI tool to fetch recent GitHub activity.\n";
    echo "\n";
    echo "Usage:\n";
    echo "  github-activity <username>\n";
    echo "\n";
    echo "Arguments:\n";
    echo "  username    The GitHub username to fetch activity for.\n";
    echo "\n";
    echo "Options:\n";
    echo "  --help, -h  Display this help message.\n";
    echo "\n";
    echo "Example:\n";
    echo "  github-activity seddek-nadhem\n";
    echo "\n";
    exit(0); // Stop the script successfully
}

// Check if username argument is provided after github-activity
if ($argc < 2) {
    echo "Please provide a GitHub username.\n";
    echo "For example: github-activity seddek-nadhem\n";
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

// Check if the user exists but has no activity
if (empty($events)) {
    echo "User '$username' has no recent public activity.\n";
    exit(0);
}

foreach($events as $event) {
    $type = $event['type'];
    $repoName = $event['repo']['name'];
    $timestamp = strtotime($event['created_at']);
    $formattedDate = date('j-n-Y', $timestamp) . " on " . date('l', $timestamp);

    switch ($type) {
        case 'PushEvent':
            $commits = $event['payload']['commits'] ?? [];
            $count = count($commits);
            if ($count > 0) {
                echo "- Pushed $count commits to $repoName ($formattedDate)\n";
            }
            break;
        
        case 'CreateEvent':
            echo "- Created a new repository $repoName ($formattedDate)\n";
            break;

        case 'WatchEvent':
            echo "- Starred $repoName ($formattedDate)\n";
            break;

        case 'IssuesEvent':
            echo "- Opened a new issue in $repoName ($formattedDate)\n";
            break;

        default:
            echo "- $type in $repoName ($formattedDate)\n";
            break;
    }
}