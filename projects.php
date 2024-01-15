<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekti - ReAKT</title>
    <link type="image/png" sizes="16x16" rel="icon" href="./assets/favicon.png">
    <link rel="stylesheet" href="./styles/style.scss"> <!-- Add your stylesheet link here -->
</head>
<body>
    <?php include "navbar.php"; ?>
    
    <div class="latest-projects">
        <?php
        $projectsJson = file_get_contents('data.json');
        $projects = json_decode($projectsJson, true);

        $itemsPerPage = 6;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;
        $pagedProjects = array_slice($projects['projects'], $offset, $itemsPerPage);

        foreach ($pagedProjects as $project) {
            echo '<a class="project-card" href="project.php?id=' . $project["id"] . '">';
            echo '<img src="./assets/ProjectsImages/' . $project["thumbnail"] . '" alt="' . $project["title"] . '">';
            echo '<h3>' . $project["title"] . '</h3>';
            echo '</a>';
        }
        ?>
    </div>

    <div class="pagination">
    <?php
    $totalPages = ceil(count($projects['projects']) / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

    for ($i = 1; $i <= $totalPages; $i++) {
        $isActive = ($i == $currentPage) ? 'current' : '';
        echo '<a href="?page=' . $i . '" class="' . $isActive . '">' . $i . '</a>';
    }
    ?>
    </div>
    <?php include 'footer.php' ?>

</body>
</html>