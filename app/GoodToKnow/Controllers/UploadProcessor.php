<?php


namespace GoodToKnow\Controllers;


class UploadProcessor
{
    public function page()
    {
        /**
         * REPEATING:
         * The goal of this series of routes
         * is to make it possible to upload
         * an image file (jpg, jpeg, png, gif)
         * to the IMAGE folder on the server
         * and to save its URL to the session
         * variable called url_of_most_recent_upload.
         * It shall do all this while making sure
         * the upload contains no malicious code.
         */

        global $is_logged_in;
        global $sessionMessage;

        if (!$is_logged_in || !empty($sessionMessage)) {
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        if (isset($_POST['abort']) AND $_POST['abort'] === "Abort") {
            $sessionMessage .= " You've aborted the task! Session variables reset. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        if (!isset($_POST['submit'])) {
            $sessionMessage .= " An invalid form submission occured. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] == UPLOAD_ERR_NO_FILE) {
            $sessionMessage .= " I aborted what you were trying to do because you didn't select a file. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Start
         */
        $target_dir = IMAGE . "/";

        /**
         * This value is going to show up a lot.
         * It is the file name in the most classical sense (filename.extension)
         */
        define('CLASSICFILENAME', basename($_FILES["fileToUpload"]["name"]));

        /**
         * Store in a var the file name (w/ its path)
         * where the uploaded content will permanently
         * live.
         *
         * NOTE: The entire old file name (w/ extension) is used for the new file name.
         */
        $target_file = $target_dir . CLASSICFILENAME;

        /**
         * Get a string value for the file type based
         * on the file name's extension.
         */
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        /**
         * Run the getimagesize function on the temporarily uploaded file.
         * Doing so it will either return false if that file is not an image file
         * or it will return an array which contains some useful information about
         * the file including its mime type.
         *
         * NOTE: $_FILES["fileToUpload"]["tmp_name"]
         *       is the temporarily uploaded file/path.
         */
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        /**
         * Store the results of getimagesize() (i.e. $image_file_mime_type).
         * Or kick ot if upload is NOT an image.
         */
        if ($check !== false) {
            $image_file_mime_type = $check["mime"];
        } else {
            // File is not an image.
            $sessionMessage .= " Error 546224. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Check if file already exists.
         */
        if (file_exists($target_file)) {
            $sessionMessage .= " Sorry, file already exists. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Check file size.
         */
        if ($_FILES["fileToUpload"]["size"] > 5767168) {
            $sessionMessage .= " Sorry, your file is too large. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Allow (only) certain file formats.
         *
         * NOTE: Although at this point we know it's an image we do NOT know it's a web image
         */
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $sessionMessage .= " Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
            $_SESSION['message'] = $sessionMessage;
            redirect_to("/ax1/Home/page");
        }

        /**
         * Sanity helpers.
         */
        $a_link_href_content = SERVER_URL . '/image/' . rawurlencode(CLASSICFILENAME);
        $a_link_href_content = htmlspecialchars($a_link_href_content);

        $a_link_display_text = SERVER_URL . '/image/' . rawurlencode(CLASSICFILENAME);
        $a_link_display_text = htmlspecialchars($a_link_display_text);

        $a_link_entire_embed = '<a href="' . $a_link_href_content . '" target="_blank">' . $a_link_display_text . '</a>';

        /**
         * Save the file if we are able to move it to its permanent location.
         */
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $sessionMessage .= " The file " . CLASSICFILENAME . " has been uploaded and it is an {$image_file_mime_type}
            file. Here is the link: " . $a_link_entire_embed . ". ";
        } else {
            $sessionMessage .= " Sorry, there was an error uploading your file. ";
        }

        /**
         * Report outcome of this process.
         */
        $_SESSION['url_of_most_recent_upload'] = $a_link_href_content;
        $_SESSION['message'] = $sessionMessage;
        redirect_to("/ax1/Home/page");
    }
}