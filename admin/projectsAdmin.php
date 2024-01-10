<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Admin</title>
</head>

<body>

    <?php
    // Read projects from the local JSON file
    $projectsJson = file_get_contents('../data.json');
    $projects = json_decode($projectsJson, true);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if edit button is clicked
        if (isset($_POST['edit'])) {
            $projectIdToEdit = $_POST['project_id'];
            header("Location: editAdmin.php?id=$projectIdToEdit");
            exit();
        } elseif (isset($_POST['add'])) {
            // Handle logic to add a new project here
            $newProject = array(
                'id' => count($projects['projects']) + 1, // Generate new ID
                'title' => $_POST['new_title'],
                'description' => $_POST['new_description'],
                'thumbnail' => '', // Add logic for handling thumbnail
                'images' => array(), // Add logic for handling images
            );

            // Handle file upload for thumbnail
            if (!empty($_FILES['new_thumbnail']['name'])) {
                $thumbnailName = $_FILES['new_thumbnail']['name'];
                $thumbnailTmp = $_FILES['new_thumbnail']['tmp_name'];
                move_uploaded_file($thumbnailTmp, "../assets/projectImg/$thumbnailName");
                $newProject['thumbnail'] = $thumbnailName;
            }

            // Handle file upload for images
            if (!empty($_FILES['new_images']['name'][0])) {
                foreach ($_FILES['new_images']['name'] as $index => $imageName) {
                    $imageTmp = $_FILES['new_images']['tmp_name'][$index];
                    $imagePath = "../assets/projectImg/$imageName";
                    move_uploaded_file($imageTmp, $imagePath);
                    $newProject['images'][] = $imageName;
                }
            }

            // Add the new project to the projects array
            $projects['projects'][] = $newProject;

            // Save the updated projects to the JSON file
            file_put_contents('../data.json', json_encode($projects, JSON_PRETTY_PRINT));
        }
    }

    // Display projects with edit and delete options
    echo '<div>';
    echo '<h2>Dodaj novi projekat</h2>';
    // Form to add a new project
    echo '<form method="post" action="" enctype="multipart/form-data">';
    echo '<label for="new_title">Title:</label>';
    echo '<input type="text" name="new_title" required><br>';
    echo '<label for="new_description">Description:</label>';
    echo '<textarea name="new_description" required></textarea><br>';
    echo '<label for="new_thumbnail">Thumbnail:</label>';
    echo '<input type="file" name="new_thumbnail"><br>';
    echo '<label for="new_images">Images:</label>';
    echo '<input type="file" name="new_images[]" multiple><br>';
    echo '<button type="submit" name="add">Dodaj</button>';
    echo '</form>';
    echo '</div>';

    foreach ($projects['projects'] as $project) {
        echo '<div>';
        echo '<h2>' . $project['title'] . '</h2>';
        echo '<p>' . $project['description'] . '</p>';
        echo '<img src="../assets/projectImg/' . $project['thumbnail'] . '" alt="' . $project['title'] . '" style="max-width: 200px;">';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="project_id" value="' . $project['id'] . '">';
        echo '<button type="submit" name="edit">Edit</button>';
        // Add delete options here if needed
        echo '</form>';
        echo '</div>';
    }

    ?>

</body>

</html>
