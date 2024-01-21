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

            // Get the last 5 projects
            $lastProjects = array_slice($data['projects'], -5);

            // Loop through the projects and generate HTML
            foreach ($lastProjects as $index => $project) {
                $activeClass = ($index === 0) ? 'active' : ''; // Add 'active' class for the first iteration
            
                ?>
                <div class="item <?= $activeClass ?>">
                    <div class="slide">
                        
                        <div class="text">
                            <h2>
                                <?= $project['title'] ?>
                            </h2>
                            <a href="project.php?id=<?= $project['id'] ?>">Pogledaj detalje projekta</a>
                        </div>
                        <div class="img-container">
                            <img src="./assets/ProjectsImages/<?= $project['thumbnail'] ?>" alt="Slide" />
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
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