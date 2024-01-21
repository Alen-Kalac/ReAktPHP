<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - ReAKT</title>
    <link type="image/png" sizes="16x16" rel="icon" href="./assets/favicon.png">
    <link rel="stylesheet" href="./styles/style.scss"> <!-- Add your stylesheet link here -->
</head>
<body>
    <?php include "navbar.php"; ?>
    <div class="grid-container">

        <div class="grid">
            <?php
            $blogsJson = file_get_contents('data.json');
            $blogs = json_decode($blogsJson, true);

            $itemsPerPage = 6;
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;
            $pagedBlogs = array_slice(array_reverse($blogs['blogs']), $offset, $itemsPerPage);

            foreach ($pagedBlogs as $blog) {
                echo '<a class="grid-card" href="blogPost.php?id=' . $blog["id"] . '">';
                echo '<img src="./assets/BlogImages/' . $blog["thumbnail"] . '" alt="' . $blog["title"] . '">';
                echo '<h3>' . $blog["title"] . '</h3>';
                echo '</a>';
            }
            ?>
        </div>
    </div>

    <div class="pagination">
    <?php
    $totalPages = ceil(count($blogs['blogs']) / $itemsPerPage);
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
