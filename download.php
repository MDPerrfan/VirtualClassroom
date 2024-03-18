<?php
// Get the file path from the URL parameter
$filePath = $_GET['file'];

// Validate the file path (optional, for security)
// You can add checks here to ensure the file path is within a specific directory or has a valid extension

// Check if the file exists
if (!file_exists($filePath)) {
  die("File not found.");
}

// Get the file mime type
$mimeType = mime_content_type($filePath);

// Set headers for download
header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Content-Length: ' . filesize($filePath));

// Read the file content and deliver to the user
readfile($filePath);
exit;
?>