<?php
/*
 * Base Controller
 * loads Models and Views
 */
 
class Controller {
  // Load model
  public function model($model) {
    // Require model file
    require_once '../app/models/' . $model . '.php';

    // Instantiate model
    return new $model();
  }

  // Load views
  public function view($view, $data = []) {
    // Check for view file
    if(file_exists('../app/views/' . $view . '.php')) {
      require_once '../app/views/' . $view . '.php';
    } else {
      die('View file not found');
    }
  }
}