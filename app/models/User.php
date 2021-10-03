<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    // Register user
    public function register($data)
    {
        $this->db->query('INSERT INTO users (name, email, password, token,  status ) VALUES (:name, :email, :password, :token, :status)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':token', $data['token']);
        $this->db->bind(':status', 'pending');

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Login User
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_password = $row->password;
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }
    // Login User
    public function updateUserStatus($data)
    {
        $this->db->query("UPDATE users SET status= :status WHERE email= :email AND token= :token");
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':token', $data['token']);


        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // Get user status
    public function getUserStatus($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();
        $status = $row->status;

        return $status;
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    // Get user by id
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        // Bind value
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }
    // Get user by token
    public function deleteUserToken($email)
    {
        $this->db->query("UPDATE users SET token= null WHERE email= :email");
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        return $row;
    }
}
