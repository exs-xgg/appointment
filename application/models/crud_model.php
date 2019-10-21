<?php
date_default_timezone_set('Asia/Manila');

class Crud_model extends CI_Model {

        public function __construct()
        {
           $this->load->database();
        }

        public function servicesAdd($data)
        {
            
            $this->db->insert('services', $data);
            return true;
        }

        public function servicesUpdate($where, $data)
        {
            $this->db->update('services', $data, $where);
            return true;
        }

        public function appointmentAdd($data)
        {
          $this->db->insert('appointment', $data);
          return $this->db->insert_id();
        }

        public function appointmentUpdate($where, $data)
        {
          $this->db->update('appointment', $data, $where);
          return true;
        }

        public function registerConfirmAdd($data)
        {
          $this->db->insert('register_confirm', $data);
          return true;
        }

        public function registerConfirmUpdate($where, $data)
        {
          $this->db->update('register_confirm', $data, $where);
          return true;
        }

        public function registerUserExtraInfoAdd($data)
        {
          $this->db->insert('user_extra_info', $data);
          return true;
        }

        public function registerUserExtraInfoEdit($where, $data)
        {
          $this->db->update('user_extra_info', $data, $where);
          return true;
        }


        public function userUpdate($where, $data)
        {
          $this->db->update('users', $data, $where);
          return true;
        }
}
