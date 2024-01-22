<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css"> <!-- Add your stylesheet link here -->
    <link type="image/png" sizes="16x16" rel="icon" href="./assets/favicon.png">

    <?php
    // Get project ID from the URL parameter
    $projectId = isset($_GET['id']) ? $_GET['id'] : '';

    // Read projects from the local JSON file
    $projectsJson = file_get_contents('data.json');
    $projects = json_decode($projectsJson, true);

    // Find the project with the matching ID
    $project = null;
    foreach ($projects['projects'] as $proj) {
        if ($proj['id'] == $projectId) {
            $project = $proj;
            break;
        }
    }

    // Set the title based on the project
    $pageTitle = $project ? htmlspecialchars($project["title"]) : 'Project not found';
    echo '<title>' . $pageTitle . '</title>';
    ?>
</head>
<body>
    <?php include "navbar.php"; ?>

    <?php if ($project): ?>
    <div class="project-details">
        <h1><?php echo $project["title"]; ?></h1>
        <p><?php echo $project["description"]; ?></p>

        <div class="photo-gallery">
            <?php
            // Assuming $project["images"] is an array of photo filenames
            foreach ($project["images"] as $photo) {
                echo '<img src="./assets/ProjectsImages/' . $photo . '" alt="' . $project["title"] . '">';
            }
            ?>
        </div>
    </div>
    <?php else: ?>
        <p>Project not found</p>
    <?php endif; ?>
    <?php include 'footer.php' ?>

</body>
</html>
