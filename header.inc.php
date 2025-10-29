<header>
    <a href="index.php">En Vadrouille</a>

    <?php
        if(isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {  
            echo "<h1 class='admin-connected'>Vous êtes connecté.e.s en tant qu'Admin</h1>";
        }
    ?>
    <?php
        if(isset($_SESSION['username'])) {
            echo "
                <nav class='nav-connected'>
                    <a href='dashboard.php' class='dashboard'>Tableaux de bord</a>
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