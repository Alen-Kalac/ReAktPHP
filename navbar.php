<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    
</head>

<body>
    <nav>
       <a class="logo" href="index.php"> <h1>ReAKT</h1></a>
        <div class="link-container">
            <a href="index.php">Početna</a>
            <a href="projects.php">Projekti</a>
            <a href="blog.php">Objave</a>
            <a href="therapy.php">Savetovalište</a>
            <a href="contact.php">Kontakt</a>
        </div>
        <div class="hamburger-icon" onclick="toggleMenu()">☰</div>
    </nav>

    <script>
        function toggleMenu() {
            var links = document.querySelector('.link-container');
            var icon = document.querySelector('.hamburger-icon');

            if (links.style.display === 'flex') {
                links.style.display = 'none';
                icon.innerHTML = '☰';
            } else {
                links.style.display = 'flex';
                icon.innerHTML = '✕';
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            var currentPage = window.location.pathname.split("/").pop() || "index.php";
            var links = document.querySelectorAll('.link-container a');

            links.forEach(function (link) {
                var linkPage = link.getAttribute('href').split("/").pop();
                if (linkPage === currentPage) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>