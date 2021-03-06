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

            $token = bin2hex(random_bytes(8));
            $_SESSION['token'] = $token;

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
                $data['confirm_password_err'] = 'Bitte Passwort best??tigen';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passw??rter stimmen nicht ??berein';
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

                    $subject = 'Best??tige Deinen Account';

                    $message = '<p>Solltest Du Dich nicht bei uns registriert haben kannst Du dieses E-mail ignorieren.</p> ';

                    $message .= '<p> Hier ist der Link zum best??tigen Deiner Email Adresse: </br><br>';
                    $message .= '<a href="' . $url . '">' . $url . '</a></p>';
                    $message .= "<p>Lieber User, </p> <h3>Willkommen in der " . SITENAME . " Familie<br></h3>
                    <br><br>";

                    $headers = "From: siteart <siteart@feritel.swiss>\r\n";
                    $headers .= "Reply-To: siteart <siteart@feritel.swiss>\r\n";
                    $headers .= "Content-type: text/html\r\n";


                    mail($to, $subject, $message, $headers);

                    flash('register_success', 'Checke Deine Mail zur Best??tigung Deiner Mailadresse ??? !');

                    redirect('users/login');
                } else {
                    die('Unerwarteter Fehler ????');
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
                'remote' => $_POST['remote'],
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
                $user_id = $this->userModel->getUserId($data['email']);
            } else {
                // User not found
                $data['email_err'] = 'Konto nicht gefunden';
            }
            if ($this->userModel->loginAttemps($user_id, $data['remote'])) {
                $results = $this->userModel->checkBrute($user_id);
                $count = array_sum(...$results);
                if ($count >= MAX_LOGIN_ATTEMPS_PER_HOUR) {
                    $data['email_err'] = 'Sorry zu viele Serveranfragen bitte versuchen Sie es sp??ter!';
                }
            } else 
            if ($this->userModel->getUserStatus($data['email'])) {
                $status = $this->userModel->getUserStatus($data['email']);
                if ($status == 'pending') {
                    flash('register_success', 'Dein Account wurde nicht aktiviert, checke deinen Spamfolder und best??tige deine Email!');
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
                $data['token_err'] = 'Token Error ????!';
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
                    flash('register_success', 'Ihr Account ist nun aktiv ????!');
                    $this->userModel->deleteUserToken($data['email']);
                    redirect('users/login');
                } else {
                    die('Unerwarteter Fehler ????');
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
    public function pwdrequest()
    {

        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $token = bin2hex(random_bytes(8));
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data
            $data = [
                'token' => $token,
                'email' => trim($_POST['email']),
                'token_err' => '',
                'email_err' => '',

            ];



            // Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Bitte Email eingeben.';
            }

            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found

            } else {
                // User not found
                $data['email_err'] = 'Konto nicht gefunden';
            }

            // Make sure errors are empty
            if (empty($data['email_err'])) {
                if ($this->userModel->pwdrequest($data)) {

                    $email = $_POST['email'];
                    // $url = URLROOT . "/users/verify?validator=" . $token;
                    $url = URLROOT . "/users/pwdreset?email=" . $email . "&token=" . $token;
                    $to = $email;

                    $subject = 'Setze ein neues Passwort f??r Deinen Account';

                    $message = '<p>Wir haben eine E-mailanfrage f??r das zur??cksetzen Deines Passwortes erhalten,
                    sollte diese Anfrage nicht von Dir sein kannst Du dieses E-mail ignorieren.</p> ';

                    $message .= '<p> Hier ist der Link zum zur??cksetzen Deines Passwortes: </br><br>';
                    $message .= '<a href="' . $url . '">' . $url . '</a></p>';
                    $message .= "<p>Lieber User, </p> <h3>Willkommen in der " . SITENAME . " Familie<br></h3>
                    <br><br>";

                    $headers = "From: siteart <siteart@feritel.swiss>\r\n";
                    $headers .= "Reply-To: siteart <siteart@feritel.swiss>\r\n";
                    $headers .= "Content-type: text/html\r\n";


                    mail($to, $subject, $message, $headers);

                    flash('register_success', 'Checke Deine Mail zum zur??cksetzen Deines Passwortes ??? !');

                    $this->view('users/pwdrequest', $data);
                } else {
                    die('Unerwarteter Fehler ????');
                }
            } else {
                // Load view with errors
                $this->view('users/pwdrequest', $data);
            }
        } else {
            // Init data
            $data = [
                'token' => '',
                'email' => '',
                'token_err' => '',
                'email_err' => '',
            ];

            // Load view
            $this->view('users/pwdrequest', $data);
        }
    }
    public function pwdreset()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'token' => trim($_POST['token']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'token_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            // Validate data
            if (empty($data['token'])) {
                $data['token_err'] = 'Token Error ????!';
            }

            if ($this->userModel->findUserByEmail($data['email'])) {
            } else {
                // User not found
                $data['email_err'] = 'Konto nicht gefunden';
            }
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Bitte neues Passwort eingeben.';
            } elseif (!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,30}$/', $data['password'])) {
                $data['password_err'] = 'Das Passwort muss mindestens 8 Zeichen haben, davon ein Grossbuchstabe eine Zahl und ein Sonderzeichen';
            }
            // Validate password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Bitte Passwort best??tigen';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passw??rter stimmen nicht ??berein';
                }
            }
            // Make shure errors are empty
            if (empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Validated

                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register Users
                if ($this->userModel->updatepwd($data)) {
                    flash('register_success', 'Dein Passwort wurde erfolgreich zur??ckgesetzt ????!');
                    $this->userModel->deleteUserToken($data['email']);

                    redirect('users/login');
                } else {

                    die('Unerwarteter Fehler ????');
                }
            } else {
                $this->view('users/pwdreset', $data);
            }
        } else {
            // Load view with errors
            $data = [
                'token' => '',
                'email' => '',
                'password' => '',
                'token_err' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            $this->view('users/pwdreset', $data);
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
