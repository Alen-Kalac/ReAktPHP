<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Admin</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>

<body>
    <div class="admin-blog">
        <div class="blog-form">
            <h2>Nova objava</h2>
            <form method="post" action="" enctype="multipart/form-data" onsubmit="prepareBlogContent()">
                <label  for="newBlogTitle">Naslov:</label>
                <br>
                <input class="title" type="text" name="newBlogTitle" required><br>

                <label for="newBlogDesc">Opis:</label>
                <div data-underline="no" data-indent="no" data-outdent="no" data-insertunorderedlist="no"
                    data-insertorderedlist="no" data-forecolor="no" data-fontname="no" data-formatblock="no"
                    data-tiny-editor name="new_description" required id="myEditor">
                </div><br>

                <input type="hidden" name="new_description_content" id="new_description_content">

                <label for="newThumbnail">Naslovna slika:</label>
                <br>
                <input type="file" name="newThumbnail" required onchange="previewThumbnail(this)"><br>
                <img id="thumbnailPreview" class="thumbnail">

                <button type="submit" class="submit" name="add">Dodaj</button>
            </form>
        </div>
        <div class="blog-grid">
            <?php

            $blogsJson = file_get_contents('../data.json');
            $blogs = json_decode($blogsJson, true);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (isset($_POST['edit'])) {
                    $blogIdToEdit = $_POST['blog_id'];
                    header("Location: editBlog.php?id=$blogIdToEdit");
                    exit();
                }


                if (isset($_POST['add'])) {
                    $newBlogTitle = $_POST['newBlogTitle'];
                    $newBlogDesc = $_POST['new_description_content'];
                    $newThumbnailName = $_FILES['newThumbnail']['name'];
                    $newThumbnailTmp = $_FILES['newThumbnail']['tmp_name'];

                    $lastBlog = end($blogs['blogs']);
                    $newBlogId = ($lastBlog) ? intval($lastBlog['id']) + 1 : 1;

                    $blogFolder = "../assets/BlogImages/blog{$newBlogId}";
                    if (!file_exists($blogFolder)) {
                        mkdir($blogFolder);
                    }

                    move_uploaded_file($newThumbnailTmp, "$blogFolder/$newThumbnailName");

                    $newBlog = array(
                        'id' => $newBlogId,
                        'title' => $newBlogTitle,
                        'description' => $newBlogDesc,
                        'thumbnail' => "blog{$newBlogId}/$newThumbnailName",
                    );

                    // Add the new blog post to the array
                    $blogs['blogs'][] = $newBlog;

                    // Save the updated blogs to the JSON file
                    file_put_contents('../data.json', json_encode($blogs, JSON_PRETTY_PRINT));
                }
            }

            // Display blog posts with edit options
            foreach (array_reverse($blogs['blogs']) as $blog) {
                echo '<div class="blog-post">';
                echo '<h2>' . $blog['title'] . '</h2>';
                echo '<img src="../assets/BlogImages/' . $blog['thumbnail'] . '" alt="' . $blog['title'] . '" style="max-width: 200px;">';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="blog_id" value="' . $blog['id'] . '">';
                echo '<button type="submit" name="edit">Izmeni</button>';
                // Add delete options here if needed
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <script>
        function prepareBlogContent() {
            const editor = document.getElementById('myEditor');
            const blogContent = document.getElementById('new_description_content');
            blogContent.value = editor.innerHTML;
        }

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
                preview.style.display = null;
            }
        }
    </script>

    <script src="https://unpkg.com/tiny-editor/dist/bundle.js"></script>
</body>

</html>