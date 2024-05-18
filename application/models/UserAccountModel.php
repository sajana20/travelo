<?php

class UserAccountModel extends CI_Model
{
    public function addUser($data)
    {

        $this->db->insert('user_account', $data);
    }

    public function findUserByEmail($email)
    {
        $this->db->select('id, full_name, email, password');
        $this->db->where('email =', $email);
        $query = $this->db->get('user_account');
        return $query->row();
    }

    public function addInterest($data)
    {
        foreach (explode(',', $data['selectedInterests']) as $interest) {
            $this->db->insert('user_tags', [
                'user_id' => $data['user_id'],
                'tag' => $interest,
            ]);
        }

    }

    public function hasInterests($userId)
    {

        $query = $this->db->query('select exists (select 1 FROM user_tags where user_id = ' . $userId . ' limit 1) as has_interest');
        return $query->row();
    }

    public function findUserById($userId)
    {
        $this->db->select('full_name');
        $this->db->where('id =', $userId);
        $query = $this->db->get('user_account');
        return $query->row();
    }
    
    public function updateUserProfile($reqData, $userId)
    {
 
        $this->db->set('full_name',   $reqData['full_name']);
        $this->db->where('id', $userId);
        $this->db->update('user_account');

    }

}