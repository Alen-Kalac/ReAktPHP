<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="image/png" sizes="16x16" rel="icon" href="./assets/favicon.png">
    <title>Početna - ReAKT</title>
    <link rel="stylesheet" href="./styles/style.scss">

</head>
<style>
    
    </style>

<body>
    <?php
    include 'navbar.php'
        ?>
    <?php
    include 'carousel.php'
        ?>
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
                <h2>Realizovani projekti</h2>
                <p>
                    Udruženje "ReAkt" je ostvarilo značajne projekte na različitim
                    poljima, obuhvatajući teme kao što su aktivizam, psihološko
                    savetovanje, multikulturalnost i unapređenje položaja žena. Naša
                    posvećenost raznolikim inicijativama svedoči o širokom uticaju
                    koje udruženje ima u podršci zajednici i promociji društvenih
                    promena.
                </p>
            </div>

            <div class="cta">
                <a href="projects">Pogledaj sve projekte</a>
            </div>
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
    <div class="partners" id="partnersContainer">
        <h3>
            Naši partner
        </h3>
        <div class="partner-grid">
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
   
</body>

</html>