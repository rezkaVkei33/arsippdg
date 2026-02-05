<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    private $table_users = 'users';
    private $table_login_activity = 'login_activity';

    public function __construct()
    {
        parent::__construct();
    }

    // Get user by username
    public function get_user_by_username($username)
    {
        return $this->db->where('username', $username)->get($this->table_users)->row();
    }

    // Get user by ID
    public function get_user_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table_users)->row();
    }

    // Insert user
    public function insert($data)
    {
        return $this->db->insert($this->table_users, $data);
    }

    // Update user
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table_users, $data);
    }

    // Delete user
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table_users);
    }

    // Get all users
    public function get_all()
    {
        return $this->db->get($this->table_users)->result();
    }

    // Count users
    public function count_all()
    {
        return $this->db->count_all($this->table_users);
    }

    // ========== LOGIN ACTIVITY METHODS ==========

    // Record login activity
    public function record_login($user_id, $ip_address)
    {
        $data = [
            'user_id' => $user_id,
            'login_time' => date('Y-m-d H:i:s'),
            'ip_address' => $ip_address
        ];
        return $this->db->insert($this->table_login_activity, $data);
    }

    // Get last N login activities for a user
    public function get_user_login_history($user_id, $limit = 10)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->order_by('login_time', 'DESC')
            ->limit($limit)
            ->get($this->table_login_activity)
            ->result();
    }

    // Get latest login activity for a user
    public function get_latest_login($user_id)
    {
        return $this->db
            ->where('user_id', $user_id)
            ->order_by('login_time', 'DESC')
            ->limit(1)
            ->get($this->table_login_activity)
            ->row();
    }

    // Count login activities for a user
    public function count_user_logins($user_id)
    {
        return $this->db->where('user_id', $user_id)->count_all_results($this->table_login_activity);
    }
}
