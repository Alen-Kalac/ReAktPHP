<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css"> <!-- Add your stylesheet link here -->
    <link type="image/png" sizes="16x16" rel="icon" href="./assets/favicon.png">

    <?php
    // Get blog ID from the URL parameter
    $blogId = isset($_GET['id']) ? $_GET['id'] : '';

    // Read blogs from the local JSON file
    $blogsJson = file_get_contents('data.json');
    $blogs = json_decode($blogsJson, true);

    // Find the blog with the matching ID
    $blog = null;
    foreach ($blogs['blogs'] as $blg) {
        if ($blg['id'] == $blogId) {
            $blog = $blg;
            break;
        }
    }

    // Set the title based on the blog
    $pageTitle = $blog ? htmlspecialchars($blog["title"]) : 'Blog not found';
    echo '<title>' . $pageTitle . '</title>';
    ?>
</head>
<body>
    <?php include "navbar.php"; ?>

    <?php if ($blog): ?>
    <div class="project-details">
        <h1><?php echo $blog["title"]; ?></h1>
        <p><?php echo $blog["description"]; ?></p>
    </div>
    <?php else: ?>
        <p>Blog not found</p>
    <?php endif; ?>
    <?php include 'footer.php' ?>

</body>
</html>
