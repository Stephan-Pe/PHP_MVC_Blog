<?php

class Pages extends Controller
{
  public function __construct()
  {
  }
  public function index()
  {
    if (isLoggedIn()) {
      redirect('posts');
    }
    $data = [
      'title' => 'Mein Blog',
      'description' => 'Betreibe Deinen eigenen Infokanal!'
    ];

    $this->view('pages/index', $data);
  }
  public function about()
  {
    $data = [
      'title' => 'Über uns',
      'description' => 'Teile Deine Erlebnisse mit anderen!'
    ];
    $this->view('pages/about', $data);
  }
}
