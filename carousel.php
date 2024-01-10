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
            <div class="item active">
                <div class="slide">
                    <div class="img-container">
                        <img src="./assets/Projects.jpg" alt="Slide" />
                    </div>
                    <div class="text">
                        <h2>Projekat1</h2>
                        <a href="">Vise informacija</a>
                    </div>
                </div>
            </div>

            <div class="item ">
                <div class="slide">
                    <div class="img-container">
                        <img src="./assets/Projects.jpg" alt="Slide" />
                    </div>
                    <div class="text">
                        <h2>Projekat1</h2>
                        <a href="">Vise informacija</a>
                    </div>
                </div>
            </div>

            <div class="item ">
                <div class="slide">
                    <div class="img-container">
                        <img src="./assets/Projects.jpg" alt="Slide" />
                    </div>
                    <div class="text">
                        <h2>Projekat1</h2>
                        <a href="">Vise informacija</a>
                    </div>
                </div>
            </div>

            <div class="item ">
                <div class="slide">
                    <div class="img-container">
                        <img src="./assets/Projects.jpg" alt="Slide" />
                    </div>
                    <div class="text">
                        <h2>Projekat1</h2>
                        <a href="">Vise informacija</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            // Activate Carousel
            $("#myCarousel").carousel({ interval: 3000, pause: false });

        });
    </script>

</body>

</html>