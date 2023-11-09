<?php

require_once 'shared.php';

// If this page was posted to.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Now, check for CV file upload.
	$success = true; // Assume success.
	if ($_FILES['cv_file']['name'] != "") {

		// Gather information about uploaded file (file extension etc.)
		$file = $_FILES['cv_file']['name'];
		$path = pathinfo($file);
		$filename = $path['filename'];
		$ext = $path['extension'];
		
		// TODO: Reject files with multipart extensions or that are not PDF files.
		// if (substr_count($file, ".") > 1 || strtolower($ext) !== "pdf") {
		// 	header("Location: /index.php?action=error");
		// 	die();
		// }

		$temp_name = $_FILES['cv_file']['tmp_name'];
		$path_filename_ext = $UPLOAD_DIR . $filename . "." . $ext;

		// TODO: MD5 filenames so the attacker cannot add special characters (e.g. directory traversal).
		// $path_filename_ext = $UPLOAD_DIR . md5($filename) . "." . $ext;

		// Check if file already exists
		if (file_exists($path_filename_ext)) {
			$success = false;
		} 
		else {
			move_uploaded_file($temp_name, $path_filename_ext); // Move file to uploads folder.
			$success = true;
		}
	}

	header('Location: /index.php?action=' . ($success ? "thank" : "error")); // Send user back to page.
}
