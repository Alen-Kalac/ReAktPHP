<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
</head>

<body>

    <?php
    // Navigation bar links
    $navLinks = [
        'Home' => 'index.php',
        'Projects' => 'projects.php',
        'Blog' => 'blog.php',
        'Therapy' => 'therapy.php',
        'Contact' => 'contact.php',
    ];

    // Output the navigation bar
    echo '<nav>';
    echo '<ul>';
    foreach ($navLinks as $label => $url) {
        echo "<li><a href=\"$url\">$label</a></li>";
    }
    echo '</ul>';
    echo '</nav>';
    ?>

</body>

</html>