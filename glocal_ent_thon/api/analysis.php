<?php
require_once '/workspaces/projects/vendor/autoload.php';
use Gemini\Data\UploadedFile;
use Gemini\Enums\MimeType;
use Gemini;
//use Google\Cloud\Storage\StorageClient;

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

            /*$bucketName = 'your-private-bucket';
            $fileName = basename($destination);

            $storage = new StorageClient([
                'projectId' => $projectId,
            ]);
            $bucket = $storage->bucket($bucketName);
            $object = $bucket->upload(
                fopen($destination, 'r'),
                [
                    'name' => $fileName
                ]
            );

            $signedUrl = $object->signedUrl(
                new \DateTime('+10 minutes'),
                [
                    'version' => 'v4',
                ]
            );*/

            $result = $client
                ->generativeModel(model: "gemini-2.0-flash")
                ->generateContent([
                    "What is this file?",
                    new UploadedFile(
                        fileUri: "https://glowing-space-spoon-x5xx44676g9pf6457-5050.app.github.dev/db/" . basename($fileName),
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