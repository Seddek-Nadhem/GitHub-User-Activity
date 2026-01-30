# GitHub User Activity CLI

A simple command-line interface (CLI) tool built with **native PHP** to fetch and display recent activity for any GitHub user.

This project was built to practice core programming concepts including:
- API integration (GitHub REST API).
- JSON parsing.
- Error handling (HTTP 404, 403, etc.).
- Cross-platform CLI execution.

## 🚀 Features

- **Fetch Events:** Displays recent commits, created repositories, starred repos, and opened issues.
- **Smart Formatting:** Converts raw API JSON into human-readable sentences.
- **Error Handling:** Gracefully handles invalid usernames and API rate limits.
- **Cross-Platform:** Runs natively on Windows (via Batch wrapper) and Linux/macOS (via Shebang).
- **Zero Dependencies:** No Composer or external libraries used.

## 📋 Prerequisites

- **PHP 7.4 or higher** installed and available in your system PATH.

## 🛠️ Installation & Usage

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/Seddek-Nadhem/github-user-activity.git](https://github.com/Seddek-Nadhem/github-user-activity.git)
   cd github-user-activity

2. **Make it executable (Linux/macOS only): Skip this step if you are on Windows.**
    ```bash 
    chmod +x github-activity.php

3. **Run the application:**
    (On Windows)
    ```bash
    github-activity <username>
    # Example: github-activity seddek-nadhem
    ```

    On Linux / macOS:
    ```bash
    ./github-activity.php <username>
    # Example: ./github-activity.php seddek-nadhem
    ```

## 📂 Project Structure
- `github-activity.php`: The main logic script (PHP).
- `github-activity.bat`: Wrapper script for easy execution on Windows CMD.
- Built for the roadmap.sh backend developer roadmap.
