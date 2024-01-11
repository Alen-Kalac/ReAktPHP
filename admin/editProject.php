<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>

    <?php
    // Read projects from the local JSON file
    $projectsJson = file_get_contents('../data.json');
    $projects = json_decode($projectsJson, true);

    // Function to delete an image from the project and from the directory
    function deleteImage($projectId, $imageName)
    {
        $imagePath = "../assets/projectImg/$imageName";
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }

        // Remove the image from the project's images array
        foreach ($GLOBALS['projects']['projects'] as &$project) {
            if ($project['id'] == $projectId) {
                $indexToDelete = array_search($imageName, $project['images']);
                if ($indexToDelete !== false) {
                    array_splice($project['images'], $indexToDelete, 1);
                }
                break;
            }
        }

        // Save the updated projects to the JSON file
        file_put_contents('../data.json', json_encode($GLOBALS['projects'], JSON_PRETTY_PRINT));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if save button is clicked
        if (isset($_POST['save'])) {
            $projectIdToEdit = $_POST['project_id'];

            // Update project details
            foreach ($projects['projects'] as &$project) {
                if ($project['id'] == $projectIdToEdit) {
                    $project['title'] = $_POST['title'];
                    $project['description'] = $_POST['new_description_content']; // Use the hidden field for description
    
                    if (!empty($_FILES['newThumbnail']['name'])) {
                        $newThumbnailName = $_FILES['newThumbnail']['name'];
                        $newThumbnailTmp = $_FILES['newThumbnail']['tmp_name'];
                        move_uploaded_file($newThumbnailTmp, "../assets/projectImg/$newThumbnailName");
                        $project['thumbnail'] = $newThumbnailName;
                    }

                    // Update images array
                    if (!empty($_FILES['images']['name'][0])) {
                        $newImages = array();
                        foreach ($_FILES['images']['name'] as $index => $imageName) {
                            $newImageTmp = $_FILES['images']['tmp_name'][$index];
                            $newImagePath = "../assets/projectImg/$imageName";
                            move_uploaded_file($newImageTmp, $newImagePath);
                            $newImages[] = $imageName;
                        }
                        $project['images'] = array_merge($project['images'], $newImages);
                        $project['images'] = array_values(array_unique($project['images'])); // Remove duplicates and reindex
                    }

                    // Save the updated projects to the JSON file
                    file_put_contents('../data.json', json_encode($projects, JSON_PRETTY_PRINT));
                    header("Location: projectsAdmin.php");
                }
            }
        }

        // Check if delete image button is clicked
        if (isset($_POST['deleteImage'])) {
            $projectIdToDeleteImage = $_POST['project_id'];
            $imageNameToDelete = $_POST['deleteImage'];

            // Call the deleteImage function to delete the specific image
            deleteImage($projectIdToDeleteImage, $imageNameToDelete);
        }
        // Check if delete project button is clicked
        if (isset($_POST['deleteProject'])) {
            $projectIdToDelete = $_POST['project_id'];

            // Remove the project from the array
            foreach ($projects['projects'] as $index => $project) {
                if ($project['id'] == $projectIdToDelete) {
                    // Delete images from the directory
                    foreach ($project['images'] as $imageToDelete) {
                        deleteImage($projectIdToDelete, $imageToDelete);
                    }

                    // Remove the project from the array
                    array_splice($projects['projects'], $index, 1);
                    // Save the updated projects to the JSON file
                    file_put_contents('../data.json', json_encode($projects, JSON_PRETTY_PRINT));

                    // Redirect back to the projectsAdmin.php page after deletion
                    header("Location: projectsAdmin.php");
                    exit();
                }
            }
        }
    }

    // Display the form for editing or adding projects
    $projectId = isset($_GET['id']) ? $_GET['id'] : '';
    $projectToEdit = null;

    // Find the project with the specified ID for editing
    foreach ($projects['projects'] as $project) {
        if ($project['id'] == $projectId) {
            $projectToEdit = $project;
            break;
        }
    }

    // If the project is not found, initialize an empty project
    if (!$projectToEdit) {
        $projectToEdit = array(
            'id' => '', // Leave empty for a new project, generate a new ID when saving
            'title' => '',
            'description' => '',
            'thumbnail' => '', // Add thumbnail field if needed
            'images' => array(),
        );
    }

    // Display the project editing form
    ?>
    <form method="post" action="" enctype="multipart/form-data" onsubmit="updateDescription()">
        <input type="hidden" name="project_id" value="<?php echo $projectToEdit['id']; ?>">

        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $projectToEdit['title']; ?>" required><br>

        <label for="description">Description:</label>
        <div data-underline="no" data-remove-format="no" data-indent="no" data-outdent="no"
            data-insertunorderedlist="no" data-insertorderedlist="no" data-forecolor="no" data-fontname="no"
            data-formatblock="no" data-tiny-editor name="new_description" required id="myEditor">
            <?php echo $projectToEdit['description']; ?>
        </div><br>
        <input type="hidden" name="new_description_content" id="new_description_content">


        <label for="thumbnail">Current Thumbnail:</label>
        <img src="../assets/projectImg/<?php echo $projectToEdit['thumbnail']; ?>" alt="Thumbnail"
            style="max-width: 200px;"><br>
        <label for="newThumbnail">Change Thumbnail:</label>
        <input type="file" name="newThumbnail"><br>

        <label for="images">Images:</label>
        <div style="display: flex; flex-wrap: wrap;">
            <?php
            foreach ($projectToEdit['images'] as $image) {
                echo '<div style="margin-right: 10px; margin-bottom: 10px;">';
                echo '<img src="../assets/projectImg/' . $image . '" alt="' . $projectToEdit['title'] . '" style="max-width: 100px; max-height: 100px;">';
                echo '<br>';
                echo '<button type="submit" name="deleteImage" value="' . $image . '">Delete</button>';
                echo '</div>';
            }
            ?>
        </div>
        <input type="file" name="images[]" multiple><br>

        <button type="submit" name="save">Save</button>
        <button type="submit" name="deleteProject">Delete Project</button>
    </form>
    <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script>

    <script>
        // Function to update the hidden input with the innerHTML of the div
        function updateDescription() {
            var editorContent = document.getElementById('myEditor').innerHTML;
            document.getElementById('new_description_content').value = editorContent;
        }
    </script>

</body>

</html>