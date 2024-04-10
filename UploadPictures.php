<?php
session_start();
include_once 'Project/db.php';
include_once 'Project/Functions.php';

setNewPageTitle('Upload Pictures');
validateUserLogin();

// Fetching albums
$userId = $_SESSION['user'];
$albumsQuery = "SELECT Album_Id, Title FROM Album WHERE Owner_Id = '$userId'";
$result = $conn->query($albumsQuery);
$albums = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $albums[] = $row;
    }
}

$defaultAlbumId = isset($_GET['album_id']) ? $_GET['album_id'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $albumId = $_POST['album_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (empty($title)) {
        $title = "";
    }
    if (empty($description)) {
        $description = 'No description';
    }
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    if (!empty($_FILES['pictures']['name'][0])) {
        $fileCount = count($_FILES['pictures']['name']);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $_FILES['pictures']['name'][$i];
            $tmpName = $_FILES['pictures']['tmp_name'][$i];
            $fileSize = $_FILES['pictures']['size'][$i];
            $fileType = $_FILES['pictures']['type'][$i];
            $fileError = $_FILES['pictures']['error'][$i];

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = array("jpg", "jpeg", "png", "gif");

            if (in_array($fileExt, $allowedExtensions)) {
                $newFileName = uniqid('image_') . '.' . $fileExt;
                $uploadPath = 'uploads/' . $newFileName;

                if (move_uploaded_file($tmpName, $uploadPath)) {

                    $insertPictureQuery = "INSERT INTO picture (Album_Id, File_Name, Title, Description) VALUES ('$albumId', '$newFileName', '$title', '$description')";
                    if ($conn->query($insertPictureQuery) !== TRUE) {
                        notifyError('Error occurred while inserting pictures into the database');
                        header('location: ' . $_SERVER['PHP_SELF']);
                        exit();
                    }
                } else {
                    notifyError('Failed to upload one or more pictures');
                    header('location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }
            } else {
                notifyError('Invalid file type. Allowed types: JPG, JPEG, PNG, GIF');
                header('location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        }
        notifySuccess('Pictures uploaded successfully');
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        notifyError('Please select at least one picture to upload');
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

?>

<?php include 'Project/header.php'; ?>
<div class="container">
    <div class="upload-form">
        <h1 class="upload-title">Upload Pictures</h1>
        <ul class="upload-tips">
            <li>Accepted image types: JPG(JPEG), GIF and PNG.</li>
            <li>You can upload multiple pictures by pressing the shift key while selecting pictures</li>
            <li>While uploading multiple pictures, the title and description fields will be applied to all pictures.</li>
        </ul>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" id="uploadPicturesForm">
            <div class="form-group">
                <label for="albumSelect" class="form-label">Uploaded to Album:</label>
                <select id="albumSelect" class="form-control" name="album_id">
                    <option value="">Select Album</option>
                    <?php foreach ($albums as $album) : ?>
                        <option value="<?php echo $album['Album_Id']; ?>" <?php echo ($defaultAlbumId === $album['Album_Id']) ? 'selected' : ''; ?>>
                            <?php echo $album['Title']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="input-error" id="albumTitleError"></span>
            </div>

            <div class="form-group">
                <label for="pictures" class="form-label">File to Upload:</label>
                <input id="pictures" class="form-control" type="file" accept="image/*" multiple name="pictures[]">
                <span class="input-error" id="picturesError"></span>
            </div>

            <div class="form-group">
                <label for="title" class="form-label">Title:</label>
                <input id="title" class="form-control" type="text" name="title">
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" class="form-control" name="description"></textarea>
            </div>

            <?php displayUserNotification(); ?>

            <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Clear" class="btn btn-secondary">
            </div>
        </form>
    </div>
</div>
