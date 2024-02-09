<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promo Post</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>
    <?php
    // Read promo posts from the local JSON file
    $promosJson = file_get_contents('../data.json');
    $promos = json_decode($promosJson, true);

    // Function to delete the entire promo post and its image
    function deletePromo($promoId, $imageName)
    {
        // Remove the promo post from the array
        foreach ($GLOBALS['promos']['promo_carousel'] as $index => $promo) {
            if ($promo['id'] == $promoId) {
                // Delete the image from the directory
                $imagePath = "../assets/PromoImages/{$promo['image']}";
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Remove the promo post from the array
                array_splice($GLOBALS['promos']['promo_carousel'], $index, 1);
                // Save the updated promos to the JSON file
                file_put_contents('../data.json', json_encode($GLOBALS['promos'], JSON_PRETTY_PRINT));

                // Redirect back to the promoAdmin.php page after deletion
                header("Location: promoAdmin.php");
                exit();
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if save button is clicked
        if (isset($_POST['save'])) {
            $promoIdToEdit = $_POST['promo_id'];

            // Update promo details
            foreach ($promos['promo_carousel'] as &$promo) {
                if ($promo['id'] == $promoIdToEdit) {
                    $promo['title'] = $_POST['title'];
                    $promo['a_tag_text'] = $_POST['a_tag_text'];
                    $promo['a_tag_href'] = $_POST['a_tag_href'];

                    // Update image
                    if (!empty($_FILES['newImage']['name'])) {
                        // Delete the old image
                        $imagePath = "../assets/PromoImages/{$promo['image']}";
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }

                        // Upload the new image
                        $newImageName = $_FILES['newImage']['name'];
                        $newImageTmp = $_FILES['newImage']['tmp_name'];

                        move_uploaded_file($newImageTmp, "../assets/PromoImages/promo{$promoIdToEdit}/$newImageName");
                        $promo['image'] = "promo{$promoIdToEdit}/$newImageName";
                    }

                    // Update description
                    $promo['description'] = $_POST['description'];

                    // Save the updated promos to the JSON file
                    file_put_contents('../data.json', json_encode($promos, JSON_PRETTY_PRINT));
                    header("Location: promoAdmin.php");
                }
            }
        }

        // Check if delete promo button is clicked
        if (isset($_POST['deletePromo'])) {
            $promoIdToDelete = $_POST['promo_id'];
            $imageToDelete = '';

            // Find the promo post to get its image name
            foreach ($promos['promo_carousel'] as $promo) {
                if ($promo['id'] == $promoIdToDelete) {
                    $imageToDelete = $promo['image'];
                    break;
                }
            }

            // Delete the entire promo post
            deletePromo($promoIdToDelete, $imageToDelete);
        }
    }

    // Display the form for editing the promo post
    $promoId = isset($_GET['id']) ? $_GET['id'] : '';
    $promoToEdit = null;

    // Find the promo post with the specified ID for editing
    foreach ($promos['promo_carousel'] as $promo) {
        if ($promo['id'] == $promoId) {
            $promoToEdit = $promo;
            break;
        }
    }

    // If the promo post is not found, initialize an empty promo post
    if (!$promoToEdit) {
        $promoToEdit = array(
            'id' => '', // Leave empty for a new promo post, generate a new ID when saving
            'title' => '',
            'image' => '',
            'a_tag_text' => '',
            'a_tag_href' => '',
            'description' => '', // Add description field if needed
        );
    }

    // Display the promo post editing form
    ?>
    <div class="promo-edit">
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="promo_id" value="<?php echo $promoToEdit['id']; ?>">

            <label for="title">Naslov:</label>
            <br>
            <input type="text" class="title" name="title" value="<?php echo $promoToEdit['title']; ?>" required><br>

            <label for="image">Slika:</label>
            <br>
            <img class="thumbnail-preview" src="../assets/PromoImages/<?php echo $promoToEdit['image']; ?>" alt="Preview"><br>
            <label for="newImage">Izmeni sliku:</label>
            <br>
            <input type="file" name="newImage" onchange="updateImagePreview(this)"><br>

            <!-- Add textarea for changing the description -->
            <label for="description">Opis:</label>
            <br>
            <textarea
            style="height"
            oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'
             class="description" name="description" required><?php echo $promoToEdit['description']; ?></textarea><br>

            <label for="a_tag_text">Text za dugme:</label>
            <br>
            <input type="text" class="title" name="a_tag_text" value="<?php echo $promoToEdit['a_tag_text']; ?>"><br>

            <label for="a_tag_href">Link za dugme:</label>
            <br>
            <input type="url" class="title" name="a_tag_href" value="<?php echo $promoToEdit['a_tag_href']; ?>"><br>

            <button type="submit" class="submit" name="save">Sačuvaj</button>

            <button type="submit" class="submit" name="deletePromo">Izbriši</button>
        </form>
    </div>

    <script>
        // Function to update the image preview with the newly uploaded image
        function updateImagePreview(input) {
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
