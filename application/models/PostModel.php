<?php

class PostModel extends CI_Model
{

    public function savePosts($reqData)
    {
        $path = './assets/images/post_image';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = '0';

        if (!is_dir($config['upload_path']))
            die("THE UPLOAD DIRECTORY DOES NOT EXIST");

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            return "UPLOAD ERROR ! " . $this->upload->display_errors();
        } else {
            $filepath = $this->upload->data();
            $current_time = (new DateTime())->format('Uv');
            rename($filepath['full_path'], $filepath['file_path'] . "/" . $current_time . "_" . $filepath['orig_name']);
            $doc_path = $path . "/" . $current_time . "_" . $filepath['orig_name'];
            $data = [
                'description' => $reqData['description'],
                'image' => $doc_path,
                'user_id' => $reqData['user_id'],
                'tag' => $reqData['add_tags'],
            ];
            $this->db->insert('post_details', $data);

            return $doc_path;
        }
    }

    public function loadAllPost($userId)
    {

        $query = $this->db->query('SELECT d.*, l.like_count, full_name, pl.liked FROM post_details d left join (select post_id, count(1) as like_count from post_like group by post_id) l on d.post_id = l.post_id join user_account u on d.user_id = u.id left join (select post_id, 1 as liked from post_like  where liked_by = ' . $userId . ' ) pl ON d.post_id = pl.post_id ORDER BY date_posted DESC');
        return $query->result();
    }

    public function loadAllPostBySearchKey($userId, $searchTag)
    {

        $query = $this->db->query('SELECT d.*, l.like_count, full_name, pl.liked FROM post_details d left join (select post_id, count(1) as like_count from post_like group by post_id) l on d.post_id = l.post_id join user_account u on d.user_id = u.id left join (select post_id, 1 as liked from post_like  where liked_by = ' . $userId . ' ) pl ON d.post_id = pl.post_id where d.tag like "%' . $searchTag . '%"');
        return $query->result();
    }

    public function loadAllUserPostBySearchKey($userId, $searchTag){
        $query = $this->db->query('SELECT d.*, l.like_count, full_name, pl.liked FROM post_details d left join (select post_id, count(1) as like_count from post_like group by post_id) l on d.post_id = l.post_id join user_account u on d.user_id = u.id left join (select post_id, 1 as liked from post_like  where liked_by = ' . $userId . ' ) pl ON d.post_id = pl.post_id where d.user_id = ' . $userId .' and d.tag like "%' . $searchTag . '%"'. ' ORDER BY date_posted DESC');
        return $query->result();

    }

    public function loadAllComment($postId)
    {
        $query = $this->db->query('SELECT c.*, u.full_name from comment c left join user_account u ON c.user_id=u.id where c.post_id=' . $postId . '');
        return $query->result();

    }

    public function saveComment($reqData)
    {
        $data = [
            'user_id' => $reqData['user_id'],
            'post_id' => $reqData['post_id'],
            'comment' => $reqData['comment'],
        ];
        $this->db->insert('comment', $data);

    }

    public function loadPostByUserId($userId)
    {

        $query = $this->db->query('SELECT d.*, l.like_count, full_name, pl.liked FROM post_details d left join (select post_id, count(1) as like_count from post_like group by post_id) l on d.post_id = l.post_id join user_account u on d.user_id = u.id left join (select post_id, 1 as liked from post_like  where liked_by = ' . $userId . ' ) pl ON d.post_id = pl.post_id where d.user_id = ' . $userId . ' ORDER BY date_posted DESC');
        return $query->result();
    }

    public function updatePostDetails($reqData)
    {
        $this->db->set('description', $reqData['description']);
        $this->db->set('tag', $reqData['tag']);
        $this->db->where('post_id', $reqData['post_id']);
        $this->db->update('post_details');

    }

    public function deletePost($postId)
    {
        $this->deleteCommentByPostId($postId);
        $this->deleteLikesByPostId($postId);
        $this->db->where('post_id', $postId);
        return $this->db->delete('post_details');
    }

    public function deleteCommentByPostId($postId)
    {
        $this->db->where('post_id', $postId);
        return $this->db->delete('comment');
    }

    public function deleteLikesByPostId($postId)
    {
        $this->db->where('post_id', $postId);
        return $this->db->delete('post_like');
    }


    public function updateLikedPost($postId, $userId, $status)
    {

        if (json_decode($status)) {
            $data = [
                'post_id' => $postId,
                'liked_by' => $userId,
            ];
            $query = $this->db->insert('post_like', $data);
            return $query;
        } else {
            $this->db->where('post_id =', $postId);
            $this->db->where('liked_by =', $userId);
            $this->db->delete('post_like');
        }

    }

}