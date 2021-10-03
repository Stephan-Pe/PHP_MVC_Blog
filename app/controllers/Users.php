<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    public function register()
    {
        // Check for posts
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // $otp = rand(100000, 999999);
            $token = bin2hex(random_bytes(8));
            $_SESSION['token'] = $token;
            // $token = bin2hex(random_bytes(8));
            // $expires = date("U") + 1800;
            // sanatize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Init Data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'token' => $token,
                'status' => 'pending',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Bitte Emailadresse eingeben.';
            } else {
                // Check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email ist schon vergeben.';
                }
            }

            // Validate Name
            if (empty($data['name'])) {
                $data['name_err'] = 'Bitte Namen eingeben';
            }
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Bitte Passwort eingeben.';
            } elseif (!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/', $data['password'])) {
                $data['password_err'] = 'Das Passwort muss mindestens 8 Zeichen haben, davon ein Grossbuchstabe eine Zahl und ein Sonderzeichen';
            }
            // Validate password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Bitte Passwort bestätigen';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwörter stimmen nicht überein';
                }
            }

            // Make shure errors are empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Validated

                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register Users
                if ($this->userModel->register($data)) {
                    $email = $_POST['email'];
                    // $url = URLROOT . "/users/verify?validator=" . $token;
                    $url = URLROOT . "/users/verify?email=" . $email . "&token=" . $token;
                    $to = $email;

                    $subject = 'Setze ein neues Passwort für Deinen Account';

                    $message = '<p>Wir haben eine E-mailanfrage für das zurücksetzen Deines Passwortes erhalten,
                    sollte diese Anfrage nicht von Dir sein kannst Du dieses E-mail ignorieren.</p> ';

                    $message .= '<p> Hier ist der Link zum zurücksetzen Deines Passwortes: </br><br>';
                    $message .= '<a href="' . $url . '">' . $url . '</a></p>';
                    $message .= "<p>Lieber User, </p> <h3>Willkommen in der " . SITENAME . " Familie<br></h3>
                    <br><br>";

                    $headers = "From: siteart <siteart@feritel.swiss>\r\n";
                    $headers .= "Reply-To: siteart <siteart@feritel.swiss>\r\n";
                    $headers .= "Content-type: text/html\r\n";


                    mail($to, $subject, $message, $headers);

                    flash('register_success', 'Checke Deine Mail zur Bestätigung Deiner Mailadresse ✉ !');

                    redirect('users/login');
                } else {
                    die('Unerwarteter Fehler 🔥');
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }
        } else {
            // Init Data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'token' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'token_err' => ''
            ];

            // Load view

            $this->view('users/register', $data);
        }
    }
    public function login()
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Bitte Email eingeben.';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Bitte Passwort eingeben.';
            }

            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'Konto nicht gefunden';
            }
            // Check for user/status
            if ($this->userModel->getUserStatus($data['email'])) {
                $status = $this->userModel->getUserStatus($data['email']);
                if ($status == 'pending') {
                    flash('register_success', 'Dein Account wurde nicht aktiviert, checke deinen Spamfolder und bestätige deine Email!');
                    $this->view('users/login', $data);
                } else {
                }
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Validated

                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create Session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Falsches Passwort';

                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }
    public function verify()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'token' => trim($_POST['token']),
                'status' => trim($_POST['status']),
                'email' => trim($_POST['email']),

                'email_err' => '',
                'token_err' => '',
            ];
            // Validate data
            if (empty($data['token'])) {
                $data['token_err'] = 'Token Error 🔥!';
            }
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                // User not found
                $data['email_err'] = 'Konto nicht gefunden';
            }
            // die('Files' . print_r($data));
            // Make sure no errors
            if (empty($data['token_err']) && empty($data['email_err'])) {
                // Validated
                if ($this->userModel->updateUserStatus($data)) {
                    flash('register_success', 'Ihr Account ist nun aktiv 😊!');
                    $this->userModel->deleteUserToken($data['email']);
                    redirect('users/login');
                } else {
                    die('Unerwarteter Fehler 🔥');
                }
            } else {
                // Load view with errors
                $this->view('users/verify', $data);
            }
        } else {
            $data = [
                'token' => '',
                'email' => '',
                'status' => 'active'
            ];

            $this->view('users/verify', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('pages/index');
    }
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }
}
