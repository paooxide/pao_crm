<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clientmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth'));
        $this->load->helper(array('url', 'language'));
        $this->lang->load('auth');
    }

    public function createmision($nwreq)
    {
        $query = $this->db->insert('requests', $nwreq);
        return $query;
    }
    public function deletemision($user_id, $req_id)
    {
        $query = $this->db->query(" DELETE from requests where user_id = '$user_id' and id = '$req_id'");
        return $query;
    }
    public function updatemision($nwreq,$data1)
    {
      $query = $this->db->replace('requests', $nwreq);
        return $query;
    }
    public function treat($req_id)
    {
      $this->db->set('treated', '1', FALSE);
      $this->db->where('id',$req_id);
      $query = $this->db->update('requests'); // gives UPDATE mytable SET field = field+1 WHERE id = 2

        return $query;
    }
    public function nottreat($req_id)
    {
      $this->db->set('treated', '0', FALSE);
      $this->db->where('id',$req_id);
      $query = $this->db->update('requests'); // gives UPDATE mytable SET field = field+1 WHERE id = 2

        return $query;
    }

    public function viewmision($user_id)
    {
        $query = $this->db->query("SELECT * from requests where user_id = '$user_id' order by id desc ");
        return $query->result();
    }
    public function onemision($user_id, $req_id)
    {
        $query = $this->db->query("SELECT * from requests where user_id = '$user_id' and id = '$req_id' ");
        return $query->row();
    }
    public function viewallmision()
    {
      $query = $this->db->query("SELECT users.email, users.first_name, users.company,
         users.phone, requests.subject, requests.body, requests.mission, requests.id, requests.treated,
          requests.create_time FROM `users` INNER JOIN `requests` WHERE users.id = requests.user_id ");
      return $query->result();
    }

    public function creatprof($data)
    {
        $query = $this->db->insert('clients', $data);
        return $query;
    }

    public function updateclient($user_id, $data)
    {
      $this->db->set('first_name', $data['first_name']);
      $this->db->set('last_name', $data['last_name']);
      $this->db->set('company', $data['company']);
      $this->db->set('phone', $data['phone']);
      $this->db->set('company', $data['company']);
      $this->db->set('address', $data['address']);
      $this->db->where('id', $user_id);
      $query = $this->db->update('clients');
      return $query;
    }

    public function issetprofile($user_id)
  	{

  		$this->db->where('user_id', $user_id);
  		$this->db->from('clients');
  		$query = $this->db->count_all_results();
  		if ($query > 0) {
  			return TRUE;
  		}else {
  			return FALSE;
  		}

  	}
    public function viewprofile($user_id)
    {
      $query = $this->db->query("SELECT * from clients where user_id = '$user_id' order by id desc limit 1 ");
      return $query->row();
    }
}
