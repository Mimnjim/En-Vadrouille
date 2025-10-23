<?php
    session_start();
    include_once('cnx.inc.php');

    if(isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['username'] === 'admin') {
        $admin_loggned_in = true;
    } else {
        $admin_loggned_in = false;
    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SharingBlog - Page d'accueil</title>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/global.css">

    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Sans+Bogle&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <a href="#">En Vadrouille</a>

        <?php
            if($admin_loggned_in) {  
                echo "<h1 class='admin-connected'>Vous êtes connecté.e.s en tant qu'Admin</h1>";
            }
        ?>
        <?php
            if(isset($_SESSION['username'])) {
                echo "
                    <nav class='nav-connected-admin'>
                        <a href='profil.php'><i class='bx bx-user-circle'></i></a>
                    </nav>
                ";

            } else {
                echo '
                    <nav>
                        <a href="connexion.php">Se connecter</a>
                    </nav>  
                ';
            }
        ?>        
    </header>
    
    <?php
        if($admin_loggned_in) {
            echo "
                <div class='add-billet'>
                    <a href='traite-php/traite-billet.php'><i class='bx bx-plus-circle'></i></a>
                </div>
            ";
        }
    ?>
    
    <main>
        <section class="hero-section">
            <img src="images/bg-en-vadrouille.png" alt="">
            <div class="elements-hero">
                <h1>En Vadrouille</h1>
                <h2>Découvre mes bons plans au fil des balades</h2>
            </div>
        </section>

        <h1 class="title-section">Les dernieres sorties</h1>

        <section class="list-billets">

            <?php
                $query = "SELECT * FROM billets ";
                $stmt = $cnx->query($query);
                $billets = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($billets as $billet) {
                    echo "
                        <a href='billet.php?id=" . htmlspecialchars($billet['id_billet']) . "'>
                            <article>
                                <img src='" . htmlspecialchars($billet['image']) . "' alt=''>
                                <h2>" . htmlspecialchars($billet['titre']) . "</h2>
                                <p>
                                    " . htmlspecialchars(substr($billet['description'], 0, 120)) . "...
                                </p>
                            </article>
                        </a>
                    ";
                }

            ?>


            <!-- <a href="billet.php">
                <article>
                    <img src="images/sorties-img/exposition-mille-et-une-vies-espace-monte-cristo-in-situ-8-2048x1365.jpg" alt="">
                    <h2>Mille et une vies à l’Espace Monte-Cristo : une expo qui transporte</h2>
                    <p>
                        Plongé au cœur de l’art contemporain, j’ai découvert une exposition unique à l’Espace Monte-Cristo. « Mille et une vies » propose un voyage sensoriel entre sculptures, installations et émotions. Une sortie parfaite pour les amateurs d’art ou les curieux en quête d’inspiration !
                    </p>
                </article>
            </a>

            <a href="billet.php">
                <article>
                    <img src="images/sorties-img/exposition-mille-et-une-vies-espace-monte-cristo-in-situ-8-2048x1365.jpg" alt="">
                    <h2>Mille et une vies à l’Espace Monte-Cristo : une expo qui transporte</h2>
                    <p>
                        Plongé au cœur de l’art contemporain, j’ai découvert une exposition unique à l’Espace Monte-Cristo. « Mille et une vies » propose un voyage sensoriel entre sculptures, installations et émotions. Une sortie parfaite pour les amateurs d’art ou les curieux en quête d’inspiration !
                    </p>
                </article>
            </a>

            <a href="billet.php">
                <article>
                    <img src="images/sorties-img/exposition-mille-et-une-vies-espace-monte-cristo-in-situ-8-2048x1365.jpg" alt="">
                    <h2>Mille et une vies à l’Espace Monte-Cristo : une expo qui transporte</h2>
                    <p>
                        Plongé au cœur de l’art contemporain, j’ai découvert une exposition unique à l’Espace Monte-Cristo. « Mille et une vies » propose un voyage sensoriel entre sculptures, installations et émotions. Une sortie parfaite pour les amateurs d’art ou les curieux en quête d’inspiration !
                    </p>
                </article>
            </a>
            <a href="billet.php">
                <article>
                    <img src="images/sorties-img/exposition-mille-et-une-vies-espace-monte-cristo-in-situ-8-2048x1365.jpg" alt="">
                    <h2>Mille et une vies à l’Espace Monte-Cristo : une expo qui transporte</h2>
                    <p>
                        Plongé au cœur de l’art contemporain, j’ai découvert une exposition unique à l’Espace Monte-Cristo. « Mille et une vies » propose un voyage sensoriel entre sculptures, installations et émotions. Une sortie parfaite pour les amateurs d’art ou les curieux en quête d’inspiration !
                    </p>
                </article>
            </a>
            <a href="billet.php">
                <article>
                    <img src="images/sorties-img/exposition-mille-et-une-vies-espace-monte-cristo-in-situ-8-2048x1365.jpg" alt="">
                    <h2>Mille et une vies à l’Espace Monte-Cristo : une expo qui transporte</h2>
                    <p>
                        Plongé au cœur de l’art contemporain, j’ai découvert une exposition unique à l’Espace Monte-Cristo. « Mille et une vies » propose un voyage sensoriel entre sculptures, installations et émotions. Une sortie parfaite pour les amateurs d’art ou les curieux en quête d’inspiration !
                    </p>
                </article>
            </a>
            <a href="billet.php">
                <article>
                    <img src="images/sorties-img/exposition-mille-et-une-vies-espace-monte-cristo-in-situ-8-2048x1365.jpg" alt="">
                    <h2>Mille et une vies à l’Espace Monte-Cristo : une expo qui transporte</h2>
                    <p>
                        Plongé au cœur de l’art contemporain, j’ai découvert une exposition unique à l’Espace Monte-Cristo. « Mille et une vies » propose un voyage sensoriel entre sculptures, installations et émotions. Une sortie parfaite pour les amateurs d’art ou les curieux en quête d’inspiration !
                    </p>
                </article>
            </a> -->
        </section>

    </main>
    <footer>

    </footer>
<script>
    let header = document.querySelector('header');
    header.style.background = 'transparent';

    window.addEventListener('scroll', function() {
        if (window.scrollY > 752) {
            header.style.background = '#5A9690';
        } else {
            header.style.background = 'transparent';
        }
    });
</script>
</body>
</html>