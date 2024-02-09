<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div id="myCarousel" class="carousel slide">
        <div class="carousel-inner" role="listbox">
            <?php
            // Read the content of the data.json file
            $jsonData = file_get_contents('data.json');

            // Decode the JSON data
            $data = json_decode($jsonData, true);

            // Get the last 5 promos from the promo_carousel array
            $lastPromos = array_slice($data['promo_carousel'], -5);

            // Loop through the promos and generate HTML
            foreach ($lastPromos as $index => $promo) {
                $activeClass = ($index === 0) ? 'active' : ''; // Add 'active' class for the first iteration
            
                ?>
                <div class="item <?= $activeClass ?>">
                    <div class="slide">
                        
                        <div class="text">
                            <h2>
                                <?= $promo['title'] ?>
                            </h2>
                            <?php if (!empty($promo['description'])): ?>
                                <div class="description"><?= $promo['description'] ?></div>
                            <?php endif; ?>
                            <?php if (!empty($promo['a_tag_text']) && !empty($promo['a_tag_href'])): ?>
                                <a href="<?= $promo['a_tag_href'] ?>"><?= $promo['a_tag_text'] ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="img-container">
                            <img src="./assets/PromoImages/<?= $promo['image'] ?>" alt="Slide" />
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Activate Carousel
            $("#myCarousel").carousel({ interval: 5000, pause: false });
        });
    </script>

</body>

</html>
