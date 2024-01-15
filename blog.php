<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - ReAKT</title>
    <link rel="stylesheet" href="./styles/style.scss">
    <link type="image/png" sizes="16x16" rel="icon" href="./assets/favicon.png">
</head>
<style>
        .pagination {

            list-style: none;

        }
    </style>
<body>
     <div class="blog">
        <?php include "navbar.php" ?>

        <?php
        // Read blog posts from the local JSON file
        $blogsJson = file_get_contents('data.json');
        $blogs = json_decode($blogsJson, true);

        // Pagination
        $postsPerPage = 10;
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $totalPages = ceil(count($blogs['blogs']) / $postsPerPage);
        $start = (count($blogs['blogs']) - ($currentPage - 1) * $postsPerPage) - 1;
        $end = $start - $postsPerPage + 1;

        // Display blog posts for the current page
        for ($i = $start; $i >= $end && $i >= 0; $i--) {
            $blog = $blogs['blogs'][$i];
            echo '<div class="blog-post">';
            echo '<h2>' . $blog['title'] . '</h2>';
            echo '<img src="assets/BlogImages/' . $blog['thumbnail'] . '" alt="' . $blog['title'] . '" class="thumbnail"><br>';
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

    </div>
    <?php include 'footer.php' ?>

</body>

</html>