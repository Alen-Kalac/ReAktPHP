<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Admin</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
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
            header("Location: editProject.php?id=$projectIdToEdit");
            exit();
        } elseif (isset($_POST['add'])) {
            // Handle logic to add a new project here
            $lastProject = end($projects['projects']); // Get the last project
            $newProject = array(
                'id' => $lastProject['id'] + 1, // Generate new ID
                'title' => $_POST['new_title'],
                'description' => $_POST['new_description_content'],
                'thumbnail' => '', // Add logic for handling thumbnail
                'images' => array(), // Add logic for handling images
            );

            $projectFolder = "../assets/ProjectsImages/project{$newProject['id']}";
            mkdir($projectFolder);

            // Handle file upload for thumbnail
            if (!empty($_FILES['new_thumbnail']['name'])) {
                $thumbnailName = $_FILES['new_thumbnail']['name'];
                $thumbnailTmp = $_FILES['new_thumbnail']['tmp_name'];
                move_uploaded_file($thumbnailTmp, "$projectFolder/$thumbnailName");
                $newProject['thumbnail'] = "project{$newProject['id']}/$thumbnailName";

            }

            // Handle file upload for images
            if (!empty($_FILES['new_images']['name'][0])) {
                foreach ($_FILES['new_images']['name'] as $index => $imageName) {
                    $imageTmp = $_FILES['new_images']['tmp_name'][$index];
                    $imagePath = "$projectFolder/$imageName";
                    move_uploaded_file($imageTmp, $imagePath);
                    $newProject['images'][] = "project{$newProject['id']}/$imageName";

                }
            }

            // Add the new project to the projects array
            $projects['projects'][] = $newProject;

            // Save the updated projects to the JSON file
            file_put_contents('../data.json', json_encode($projects, JSON_PRETTY_PRINT));

            // Redirect to the same page without POST data
            header("Location: {$_SERVER['PHP_SELF']}");
            exit();
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
    echo '<div data-underline="no"  data-indent="no" data-outdent="no"
    data-insertunorderedlist="no" data-insertorderedlist="no" data-forecolor="no" data-fontname="no"
    data-formatblock="no" data-tiny-editor name="new_description" required id="myEditor">
</div>';
    echo '<input type="hidden" name="new_description_content" id="new_description_content">';
    echo '<label for="new_thumbnail">Thumbnail:</label>';
    echo '<input type="file" name="new_thumbnail" onchange="previewThumbnail(this)"><br>';
    echo '<img id="thumbnailPreview" style="max-width: 200px; display: none;"><br>';
    echo '<label for="new_images">Images:</label>';
    echo '<input type="file" name="new_images[]" multiple onchange="previewImages(this)"><br>';
    echo '<div id="imagesPreview"></div>';
    echo '<button type="submit" name="add" onclick="prepareDescriptionContent()">Dodaj</button>';
    echo '</form>';
    echo '</div>';

    foreach ($projects['projects'] as $project) {
        echo '<div>';
        echo '<h2>' . $project['title'] . '</h2>';
        echo '<p>' . $project['description'] . '</p>';
        echo '<img src="../assets/ProjectsImages/' . $project['thumbnail'] . '" alt="' . $project['title'] . '" style="max-width: 200px;">';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="project_id" value="' . $project['id'] . '">';
        echo '<button type="submit" name="edit">Edit</button>';
        // Add delete options here if needed
        echo '</form>';
        echo '</div>';
    }
    ?>

    <script>
        function previewThumbnail(input) {
            const preview = document.getElementById('thumbnailPreview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        function previewImages(input) {
            const previewContainer = document.getElementById('imagesPreview');
            previewContainer.innerHTML = ''; // Clear previous previews

            for (const file of input.files) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    img.style.maxWidth = '200px';
                    previewContainer.appendChild(img);
                }

                reader.readAsDataURL(file);
            }
        }

        function prepareDescriptionContent() {
            const editor = document.getElementById('myEditor');
            const descriptionContent = document.getElementById('new_description_content');
            descriptionContent.value = editor.innerHTML;
        }
    </script>
    <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script>
</body>

</html>