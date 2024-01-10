<!-- project.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>
    <link rel="stylesheet" href="./styles/style.scss"> <!-- Add your stylesheet link here -->
</head>
<body>
    <?php include "navbar.php"; ?>

    <?php
    // Get project title from the URL parameter
    $projectTitle = isset($_GET['title']) ? urldecode($_GET['title']) : '';

    // Read projects from the local JSON file
    $projectsJson = file_get_contents('data.json');
    $projects = json_decode($projectsJson, true);

    // Find the project with the matching title
    $project = null;
    foreach ($projects['projects'] as $proj) {
        if ($proj['title'] == $projectTitle) {
            $project = $proj;
            break;
        }
    }

    // Check if the project was found
    if ($project) {
    ?>
    <div class="project-details">
        <h1><?php echo $project["title"]; ?></h1>
        <p><?php echo $project["description"]; ?></p>

        <div class="photo-gallery">
            <?php
            // Assuming $project["photos"] is an array of photo filenames
            foreach ($project["images"] as $photo) {
                echo '<img src="./assets/projectImg/' . $photo . '" alt="' . $project["title"] . '">';
            }
            ?>
        </div>
    </div>
    <?php
    } else {
        echo '<p>Project not found</p>';
    }
    ?>
</body>
</html>
