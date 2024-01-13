<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="./styles/style.scss">
    <style>
       

        .pagination {
            
            list-style: none;
            
        }
    </style>
</head>

<body>

    <?php
    include "navbar.php"
        ?>
    <?php
    // Read blog posts from the local JSON file
    $blogsJson = file_get_contents('data.json');
    $blogs = json_decode($blogsJson, true);

    // Pagination
    $postsPerPage = 10;
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($currentPage - 1) * $postsPerPage;
    $end = $start + $postsPerPage;
    $totalPages = ceil(count($blogs['blogs']) / $postsPerPage);

    // Display blog posts for the current page
    for ($i = $start; $i < $end && $i < count($blogs['blogs']); $i++) {
        $blog = $blogs['blogs'][$i];
        echo '<div class="blog-post">';
        echo '<img src="assets/BlogImages/' . $blog['thumbnail'] . '" alt="' . $blog['title'] . '" class="thumbnail"><br>';
        echo '<h2>' . $blog['title'] . '</h2>';
        echo '<p>' . $blog['description'] . '</p>';
        echo '</div>';
    }

    // Pagination links
    echo '<ul class="pagination">';
    for ($page = 1; $page <= $totalPages; $page++) {
        echo '<li><a href="?page=' . $page . '">' . $page . '</a></li>';
    }
    echo '</ul>';
    ?>

</body>

</html>