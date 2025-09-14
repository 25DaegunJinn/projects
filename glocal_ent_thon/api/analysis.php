<?php
require_once '/workspaces/projects/vendor/autoload.php';
use Gemini\Data\UploadedFile;
use Gemini\Enums\MimeType;
use Gemini;

$client = Gemini::client("AIzaSyAIJnTKR03KvS952y50wTgXYtG6PThvh7Q");

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($_FILES["file"])) {
        $fileTmp = $_FILES["file"]["tmp_name"];
        $fileName = $_FILES["file"]["name"];
        $fileType = $_FILES["file"]["type"];
        $fileSize = $_FILES["file"]["size"];

        $destination = "/workspaces/projects/glocal_ent_thon/db/" . basename($fileName);

        if(move_uploaded_file($fileTmp, $destination)) {
            echo "업로드 성공: " . htmlspecialchars($fileName);

            $result = $client
                ->generativeModel(model: "gemini-2.0-flash")
                ->generateContent([
                    "What is this file?",
                    new UploadedFile(
                        fileUri: "https://25daegunjinn.github.io/projects/glocal_ent_thon/db" . basename($fileName),
                        mimeType: MimeType::APPLICATION_PDF
                    )
                ]);
            
            echo $result -> text(); 
            return $destination;
        } else {
            echo "업로드 실패";
            return "false";
        }
    } else {
        echo "파일이 전송되지 않음";
        return "false";
    }
}
?>