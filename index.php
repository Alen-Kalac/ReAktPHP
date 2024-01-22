<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="image/png" sizes="16x16" rel="icon" href="./assets/favicon.png">
    <title>Početna - ReAKT</title>
    <link rel="stylesheet" href="./styles/style.css?v=1.2">

</head>
<style>

</style>

<body>
    <?php
    include 'navbar.php'
        ?>
    <div class="promo-carousel">
        <?php
        include 'carousel.php'
            ?>
    </div>
    <div class="mission">
        <div class="mission-container">
            <img src="./assets/Misija.svg" alt="" />
            <div class="text">
                <h2>Misija udruženja ReAkt</h2>
                <p>
                    Unapređenje kvaliteta života mladih i osoba iz marginalizovanih
                    grupa različitih starosnih kategorija kroz sveobuhvatne programe i
                    aktivnosti, i izgradnja inkluzivnog društva koje pruža jednake
                    šanse za razvoj i uspeh svim članovima zajednice.
                </p>
            </div>
        </div>
    </div>
    <div class="goals">
        <div class="goal">
            <img src="./assets/Aktivizam.svg" alt="" />
            <p>Omladinski aktivizam</p>
        </div>
        <div class="goal">
            <img src="./assets/Blagostanje.svg" alt="" />
            <p>Mentalno zdravlje</p>
        </div>
        <div class="goal">
            <img src="./assets/Edukacija.svg" alt="" />
            <p>Edukacija i osnaživanje</p>
        </div>
        <div class="goal">
            <img src="./assets/Marginalizacija.svg" alt="" />
            <p>Podrška marginalizovanim grupama</p>
        </div>
        <div class="goal">
            <img src="./assets/Potrebe.svg" alt="" />
            <p>Istraživanje potreba zajednice</p>
        </div>
        <div class="goal">
            <img src="./assets/Pravda.svg" alt="" />
            <p>Socijalna pravda</p>
        </div>
    </div>
    <div class="projects-bg">
        <div class="projects">
            <div class="text">
                <h2>Naši projekti</h2>
                <p>
                    Udruženje "ReAkt" je ostvarilo značajne projekte na različitim
                    poljima, obuhvatajući teme kao što su aktivizam, psihološko
                    savetovanje, multikulturalnost i unapređenje položaja žena. Naša
                    posvećenost raznolikim inicijativama svedoči o širokom uticaju
                    koje udruženje ima u podršci zajednici i promociji društvenih
                    promena.
                </p>
            </div>
        </div>
        <div class="projects-grid">
            <?php
            // Read data from data.json
            $jsonData = file_get_contents('data.json');
            $data = json_decode($jsonData, true);

            // Get the last 3 projects
            $projects = array_slice($data['projects'], -3);

            // Generate HTML for each project
            foreach ($projects as $project) {
                $projectId = $project['id'];
                $projectTitle = $project['title'];
                $projectThumbnail = $project['thumbnail'];

                // Output HTML for each project
                echo '<a href="project.php?id=' . $projectId . '" class="project-card">';
                echo '<img src="./assets/ProjectsImages/' . $projectThumbnail . '" alt="' . $projectTitle . '">';
                echo '<h4>' . $projectTitle . '</h4>';
                echo '</a>';
            }
            ?>

        </div>
        <div class="cta">
            <a href="projects.php">Pogledaj sve naše projekte</a>
        </div>
    </div>
    <div class="therapy">
        <h2>Psihološko savetovanje</h2>
        <div class="content">
            <div class="options">
                <p>
                    U okviru rada udruženja Reakt dostupne su usluge usmerene na očuvanje mentalnog zdravlja dece,
                    mladih i odraslih kroz pružanje sledećih usluga :

                    <span>Psihodijagnostika</span>
                    <span>Individualne i grupne savetodavno-terapijske usluge za decu, mlade i odrasle</span>
                    <span>Psihoedukacija</span>
                    <span>Karijerno savetovanje</span>

                </p>

                <a href="contact.php">Zakazi savetovanje</a>
            </div>
            <img src="./assets/Therapy.svg" alt="">
        </div>

    </div>
    <h2 class="last-posts">
        Poslednje objave
    </h2>
    <div class="projects-grid">
        <?php
        // Read data from data.json
        $jsonData = file_get_contents('data.json');
        $data = json_decode($jsonData, true);

        // Get the last 3 blogs
        $blogs = array_slice($data['blogs'], -3);

        // Generate HTML for each blog
        foreach ($blogs as $blog) {
            $blogId = $blog['id'];
            $blogTitle = $blog['title'];
            $blogDescription = $blog['description'];
            $blogThumbnail = $blog['thumbnail'];

            // Output HTML for each blog
            echo '<a href="blog.php?id=' . $blogId . '" class="project-card">';
            echo '<img src="./assets/BlogImages/' . $blogThumbnail . '" alt="' . $blogTitle . '">';
            echo '<h4>' . $blogTitle . '</h4>';
            echo '<p>' . strip_tags($blogDescription) . '</p>';


            echo '</a>';
        }
        ?>
    </div>
    <div class="cta">
        <a href="blog.php">Pogledaj sve objave</a>
    </div>
    <div class="partners" id="partnersContainer">
        <h3>Naši partneri</h3>
        <div class="partner-grid" id="partnerGrid">
            <?php
            $folderPath = './assets/PartnersLogo/';
            $files = scandir($folderPath);

            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    echo '<img src="' . $folderPath . $file . '" class="partner-img">';
                }
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <script>
        function scrollPartners() {
            var grid = document.getElementById('partnerGrid');
            var scrollAmount = 2; // Adjust the scrolling speed
            var isPaused = false;

            function scroll() {
                if (!isPaused) {
                    grid.scrollLeft += scrollAmount;

                    if (grid.scrollLeft + grid.clientWidth >= grid.scrollWidth) {
                        grid.scrollLeft = 0; // Reset to the beginning
                        isPaused = true;

                        setTimeout(function () {
                            isPaused = false;
                        }, 3000); // Pause for 3 seconds
                    }
                }
            }

            var scrollInterval = setInterval(scroll, 50); // Adjust the interval as needed
        }

        // Call the scrollPartners function when the document is ready
        document.addEventListener('DOMContentLoaded', scrollPartners);


    </script>
</body>

</html>