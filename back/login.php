<?php
// Vérifie si la session est déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../csrf.php');
require_once('../env.php');
require_once('../db.php');
require_once('../authentification.php');

// Authentification BDD
$db = new Database(Env::$DB_HOST, Env::$DB_NAME, Env::$DB_USER, Env::$DB_PASSWORD);
$authentication = new Authentification($db);

// class Login
class Login
{
    private $db;
    private $authentication;

    public function __construct(Database $db, Authentification $authentication)
    {
        $this->db = $db;
        $this->authentication = $authentication;
    }

    // vérifie la connexion à la base de données
    public function checkDatabaseConnection()
    {
        if ($this->db->getConnection()) {
            echo '<script>console.log("Connexion à la base de données réussie.");</script>';
        } else {
            echo '<script>console.log("Échec de la connexion à la base de données.");</script>';
        }
    }

    // processus de connexion
    public function processLogin()
    {
        $errorMessage = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
            // valide le token CSRF
            if (!$this->isValidCsrfToken()) {
                die('La validation du jeton CSRF a échoué.');
            }

            $email = $_POST['email'];
            $password = $_POST['password'];

            // utilise la méthode authenticateAdmin de la class Authentification
            if ($this->authentication->authenticateAdmin($email, $password)) {
                // authentification réussie, redirection vers la page admin
                $_SESSION['user_email'] = $email;
                header('Location: indexFR.php');
                exit();
            } else {
                // incorrect log
                $errorMessage = 'Identifiants incorrects. Veuillez réessayer.';
                echo 'Authentification échouée. Vérifiez la classe Authentification.';
            }
        }

        // genere un nouveau jeton CSRF
        $_SESSION['csrf_token'] = $this->generateCsrfToken();
    }

    private function isValidCsrfToken()
    {
        return isValidCsrfToken();
    }

    private function generateCsrfToken()
    {
        return generateCsrfToken();
    }
}

$login = new Login($db, $authentication);

// Check database connexion
$login->checkDatabaseConnection();

// Process login
$login->processLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>connexion</title>
</head>

<body>
    <!-- Affichez le message d'erreur si nécessaire -->
    <?php if (isset($errorMessage)): ?>
        <div class='alert alert-danger' role='alert'>
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <div class="login-box">
        <h2>Connexion</h2>

        <form action="loginFR.php" method="post">
            <div class="user-box">
                <label for="email" id="emailLabel">Email : </label>
                <input type="email" id="email" name="email" required>
            </div>
            <br>
            <div class="user-box">
                <label for="password" id="passwordLabel">Mot de passe : </label>
                <input type="password" id="password" name="password" required>
            </div>
            <br>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <button type="submit" class="button login-button">Connexion Administrateur</button>


            <a <button type="button" href="indexFR.php">Accéder en tant que Visiteur</button>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </a>
        </form>

        <!-- affiche le label si l'input est vide et le supprime si remplit-->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                function handleInput(inputId) {
                    var input = document.getElementById(inputId);
                    var label = document.getElementById(inputId + 'Label');

                    function updateLabelDisplay() {
                        if (input.value.trim() === '') {
                            label.style.display = 'inline-block';
                        } else {
                            label.style.display = 'none';
                        }
                    }

                    input.addEventListener('input', function () {
                        updateLabelDisplay();
                    });

                    input.addEventListener('change', function () {
                        updateLabelDisplay();
                    });

                    updateLabelDisplay();
                }

                handleInput('email');
                handleInput('password');
            });
        </script>

    </div>
</body>

</html>