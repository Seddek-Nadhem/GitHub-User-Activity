#!/usr/bin/env php
<?php

// Check if username argument is provided
if ($argc < 2) {
    echo "Please provide a GitHub username.\n";
    echo "Usage: github-activity <username>\n";
    exit(1);
}

$username = $argv[1];
echo "Hello, " . $username . "!\n";