<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Admin</title>
    <link rel="stylesheet" href="../styles/style.css">
   
</head>

<body>
    <div class="admin-promo">
        <div class="promo-form">
            <h2>New Promo Post</h2>
            <form method="post" action="" enctype="multipart/form-data" onsubmit="preparePromoContent()">
                <label for="newPromoTitle">Naslov:</label>
                <br>
                <input class="title" type="text" name="newPromoTitle" required><br>

                <label for="newPromoDescription">Opis:</label>
                <br>
                <textarea class="description"  name="newPromoDescription"></textarea><br>

                <label for="newPromoImage">Slika:</label>
                <br>
                <input class="title" type="file" name="newPromoImage" required onchange="previewPromoImage(this)"><br>
                <img id="promoImagePreview" class="thumbnail">

                <label for="newATagText">Text za dugme:</label>
                <br>
                <input class="title" type="text" name="newATagText"><br>

                <label for="newATagHref">Link za dugme:</label>
                <br>
                <input class="title" type="url" name="newATagHref"><br>

                <button type="submit" class="submit" name="add">Dodaj:</button>
            </form>
        </div>
        <div class="promo-grid">
            <?php

            $promosJson = file_get_contents('../data.json');
            $promos = json_decode($promosJson, true);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (isset($_POST['edit'])) {
                    $promoIdToEdit = $_POST['promo_id'];
                    header("Location: editPromo.php?id=$promoIdToEdit");
                    exit();
                }


                if (isset($_POST['add'])) {
                    $newPromoTitle = $_POST['newPromoTitle'];
                    $newPromoDescription = $_POST['newPromoDescription'];
                    $newPromoImageName = $_FILES['newPromoImage']['name'];
                    $newPromoImageTmp = $_FILES['newPromoImage']['tmp_name'];
                    $newATagText = $_POST['newATagText'];
                    $newATagHref = $_POST['newATagHref'];

                    $lastPromo = end($promos['promo_carousel']);
                    $newPromoId = ($lastPromo) ? intval($lastPromo['id']) + 1 : 1;

                    $promoFolder = "../assets/PromoImages/promo{$newPromoId}";
                    if (!file_exists($promoFolder)) {
                        mkdir($promoFolder);
                    }

                    move_uploaded_file($newPromoImageTmp, "$promoFolder/$newPromoImageName");

                    $newPromo = array(
                        'id' => $newPromoId,
                        'title' => $newPromoTitle,
                        'description' => $newPromoDescription,
                        'image' => "promo{$newPromoId}/$newPromoImageName",
                        'a_tag_text' => $newATagText,
                        'a_tag_href' => $newATagHref,
                    );

                    // Add the new promo post to the array
                    $promos['promo_carousel'][] = $newPromo;

                    // Save the updated promos to the JSON file
                    file_put_contents('../data.json', json_encode($promos, JSON_PRETTY_PRINT));
                }

                // Redirect to a different page to prevent form resubmission
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            }

            // Display promo posts with edit options
            foreach (array_reverse($promos['promo_carousel']) as $promo) {
                echo '<div class="promo-post">';
                echo '<h2>' . $promo['title'] . '</h2>';
                echo '<img src="../assets/PromoImages/' . $promo['image'] . '" alt="' . $promo['title'] . '" style="max-width: 200px;">';
               echo '<form method="post" action="">';
                echo '<input type="hidden" name="promo_id" value="' . $promo['id'] . '">';
                echo '<button type="submit" name="edit">Izmeni</button>';
                // Add delete options here if needed
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <script>
        function preparePromoContent() {
            // You can add any preparation logic needed here
        }

        function previewPromoImage(input) {
            const preview = document.getElementById('promoImagePreview');
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
</body>

</html>
