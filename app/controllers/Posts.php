<?php
class Posts extends Controller
{
  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
    }

    $this->postModel = $this->model('Post');
    $this->userModel = $this->model('User');
  }

  public function index()
  {
    // Get posts
    $posts = $this->postModel->getPosts();

    $data = [
      'posts' => $posts
    ];

    $this->view('posts/index', $data);
  }


  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      if ($_FILES) {
        $img_size = $_FILES['image']['size'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $filename = $_FILES['image']['name'];
        $img_ex = pathinfo($filename, PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        $new_filename = uniqid() . '.' . $img_ex_lc;
        $img_upload_path = '../public/img/' . $new_filename;
        $img_load_path = 'img/' . $new_filename;
        $max_size    = 2097152;
        $allowed_exs = array("jpg", "jpeg", "png");
      }

      $data = [
        'title' => trim($_POST['title']),
        'image' => $img_load_path,
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'image_err' => '',
        'title_err' => '',
        'body_err' => ''
      ];
      // doublecheck image size also in js 
      if ($img_size >= $max_size) {
        $data['image_err'] = 'Zu grosses Datenvolumen.';
      } elseif (!$allowed_exs) {
        $data['image_err'] = 'Nicht unterstütztes Bildformat';
      } else {
        // die(print_r(exif_read_data($tmp_name)));
        move_uploaded_file(
          $tmp_name,
          $img_upload_path
        );
      }

      // Validate data
      if (empty($data['title'])) {
        $data['title_err'] = 'Bitte Titel eingeben ✍.';
      }
      if (empty($data['body'])) {
        $data['body_err'] = 'Bitte einen Beitrag erstellen ✍!';
      }
      // die('Files' . print_r($data));
      // Make sure no errors
      if (empty($data['title_err']) && empty($data['body_err'])) {
        // Validated
        if ($this->postModel->addPost($data)) {
          flash('post_message', 'Post veröffentlicht.');
          redirect('posts');
        } else {
          die('Unerwarteter Fehler 🔥');
        }
      } else {
        // Load view with errors
        $this->view('posts/add', $data);
      }
    } else {
      $data = [
        'title' => '',
        'body' => ''
      ];

      $this->view('posts/add', $data);
    }
  }
  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST array
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'id' => $id,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'title_err' => '',
        'body_err' => ''
      ];
      // die('Files' . print_r($img_size . ' & ' . $max_size));
      // doublecheck if fileextension is allowed also in js


      // Validate data
      if (empty($data['title'])) {
        $data['title_err'] = 'Titel muss vorhanden sein ✍.';
      }
      if (empty($data['body'])) {
        $data['body_err'] = 'Beitrag darf nicht lehr sein ✍.';
      }
      // die('Files' . print_r($data));
      // Make sure no errors
      if (empty($data['title_err']) && empty($data['body_err'])) {
        // Validated
        if ($this->postModel->updatePost($data)) {
          flash('post_message', 'Post veröffentlicht.');
          redirect('posts');
        } else {
          die('Unerwarteter Fehler 🔥');
        }
      } else {
        // Load view with errors
        $this->view('posts/edit', $data);
      }
    } else {
      // Get existing post from model
      $post = $this->postModel->getPostById($id);
      // check for owner
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }
      $data = [
        'id' => $id,
        'title' => $post->title,
        'body' => $post->body
      ];

      $this->view('posts/edit', $data);
    }
  }

  public function show($id)
  {
    $post = $this->postModel->getPostById($id);

    $user = $this->userModel->getUserById($post->user_id);

    $data = [
      'post' => $post,
      'user' => $user,
    ];

    $this->view('posts/show', $data);
  }
  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Get existing post from model
      $post = $this->postModel->getPostById($id);
      // check for owner
      if ($post->user_id != $_SESSION['user_id']) {
        redirect('posts');
      }
      if ($this->postModel->deletePost($id)) {
        flash('post_message', 'Post gelöscht.');
        redirect('posts');
      } else {
        die('Unerwarteter Fehler 🔥');
      }
    } else {
      redirect('posts');
    }
  }
}
