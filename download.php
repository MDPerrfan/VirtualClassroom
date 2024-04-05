<?php
$filePath = $_GET['files'];
if (!file_exists($filePath)) {
    die("File not found.");
}
$mimeType = mime_content_type($filePath);
header('Content-Type: ' . $mimeType);
readfile($filePath);
exit;
?>