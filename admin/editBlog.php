<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog Post</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

</head>

<body>
    <?php
    // Read blog posts from the local JSON file
    $blogsJson = file_get_contents('../data.json');
    $blogs = json_decode($blogsJson, true);

    // Function to delete the entire blog post and its thumbnail
    function deleteBlog($blogId, $thumbnailName)
    {
        // Remove the blog post from the array
        foreach ($GLOBALS['blogs']['blogs'] as $index => $blog) {
            if ($blog['id'] == $blogId) {
                // Delete the thumbnail from the directory
                $thumbnailPath = "../assets/BlogImages/$thumbnailName";
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }

                // Remove the blog post from the array
                array_splice($GLOBALS['blogs']['blogs'], $index, 1);
                // Save the updated blogs to the JSON file
                file_put_contents('../data.json', json_encode($GLOBALS['blogs'], JSON_PRETTY_PRINT));

                // Redirect back to the blogAdmin.php page after deletion
                header("Location: blogAdmin.php");
                exit();
            }
        }
    }

    // Function to delete the thumbnail of a blog post
    function deleteThumbnail($blogId, $thumbnailName)
    {
        $thumbnailPath = "../assets/BlogImages/blog{$blogId}/$thumbnailName";
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath); // Delete the thumbnail file
        }

        // Remove the thumbnail reference from the blog post's data
        foreach ($GLOBALS['blogs']['blogs'] as &$blog) {
            if ($blog['id'] == $blogId) {
                $blog['thumbnail'] = ''; // Set thumbnail to empty
                break;
            }
        }

        // Save the updated blogs to the JSON file
        file_put_contents('../data.json', json_encode($GLOBALS['blogs'], JSON_PRETTY_PRINT));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if save button is clicked
        if (isset($_POST['save'])) {
            $blogIdToEdit = $_POST['blog_id'];

            // Update blog details
            foreach ($blogs['blogs'] as &$blog) {
                if ($blog['id'] == $blogIdToEdit) {
                    $blog['title'] = $_POST['title'];

                    // Update description with the value from the hidden input
                    $blog['description'] = $_POST['new_description_content'];

                    // Update thumbnail photo
                    if (!empty($_FILES['newThumbnail']['name'])) {
                        // Delete the old thumbnail
                        deleteThumbnail($blogIdToEdit, $blog['thumbnail']);

                        // Upload the new thumbnail
                        $newThumbnailName = $_FILES['newThumbnail']['name'];
                        $newThumbnailTmp = $_FILES['newThumbnail']['tmp_name'];

                        // Create the new folder for the blog using its ID
                        $blogFolder = "../assets/BlogImages/blog{$blogIdToEdit}";
                        if (!file_exists($blogFolder)) {
                            mkdir($blogFolder);
                        }

                        move_uploaded_file($newThumbnailTmp, "$blogFolder/$newThumbnailName");
                        $blog['thumbnail'] = "blog{$blogIdToEdit}/$newThumbnailName";
                    }

                    // Save the updated blogs to the JSON file
                    file_put_contents('../data.json', json_encode($blogs, JSON_PRETTY_PRINT));
                    header("Location: blogAdmin.php");
                }
            }
        }

        // Check if delete blog button is clicked
        if (isset($_POST['deleteBlog'])) {
            $blogIdToDelete = $_POST['blog_id'];
            $thumbnailToDelete = '';

            // Find the blog post to get its thumbnail name
            foreach ($blogs['blogs'] as $blog) {
                if ($blog['id'] == $blogIdToDelete) {
                    $thumbnailToDelete = $blog['thumbnail'];
                    break;
                }
            }

            // Delete the entire blog post
            deleteBlog($blogIdToDelete, $thumbnailToDelete);
        }
    }

    // Display the form for editing the blog post
    $blogId = isset($_GET['id']) ? $_GET['id'] : '';
    $blogToEdit = null;

    // Find the blog post with the specified ID for editing
    foreach ($blogs['blogs'] as $blog) {
        if ($blog['id'] == $blogId) {
            $blogToEdit = $blog;
            break;
        }
    }

    // If the blog post is not found, initialize an empty blog post
    if (!$blogToEdit) {
        $blogToEdit = array(
            'id' => '', // Leave empty for a new blog post, generate a new ID when saving
            'title' => '',
            'description' => '',
            'thumbnail' => '', // Add thumbnail field if needed
        );
    }

    // Display the blog post editing form
    ?>
    <div class="blog-edit">
        <form method="post" action="" enctype="multipart/form-data" onsubmit="updateDescription()">
            <input type="hidden" name="blog_id" value="<?php echo $blogToEdit['id']; ?>">

            <label for="title">Naslov:</label>
            <br>
            <input type="text" class="title" name="title" value="<?php echo $blogToEdit['title']; ?>" required><br>

            <label for="description">Opis:</label>
            <div class="description" data-underline="no" data-indent="no" data-outdent="no"
                data-insertunorderedlist="no" data-insertorderedlist="no" data-forecolor="no" data-fontname="no"
                data-formatblock="no" data-tiny-editor name="new_description" required id="myEditor">
                <?php echo $blogToEdit['description']; ?>
            </div><br>
            <input type="hidden" name="new_description_content" id="new_description_content">
            <label for="thumbnail">Naslovna slika:</label>
            <br>
            <img class="thumbnail-preview" src="../assets/BlogImages/<?php echo $blogToEdit['thumbnail']; ?>"
                alt="Thumbnail"><br>
            <label for="newThumbnail">Izmeni naslovnu sliku:</label>
            <br>
            <input type="file" name="newThumbnail" onchange="updateThumbnailPreview(this)"><br>

            <button type="submit" class="submit" name="save">Sačuvaj</button>

            <button type="submit" class="submit" name="deleteBlog">Izbriši</button>
        </form>
    </div>
    <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script>
    <script>
        // Function to update the hidden input with the innerHTML of the div
        function updateDescription() {
            var editorContent = document.getElementById('myEditor').innerHTML;
            document.getElementById('new_description_content').value = editorContent;
        }

        // Function to update the thumbnail preview with the newly uploaded image
        function updateThumbnailPreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.querySelector('.thumbnail-preview').setAttribute('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>