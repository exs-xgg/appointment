<?php
class Fetch_model extends CI_Model {

        public function __construct()
        {
           $this->load->database();
        }

        public function getSMSNotifyClientsList()
        {
          $sql = "SELECT appointment_id, appointment_date, appointment_start_time, appointment_end_time, services_name, B.first_name, B.last_name, A.phone FROM appointment
                  LEFT JOIN users A ON A.id=appointment.appointment_client_id
                  LEFT JOIN services ON services.services_id=appointment.appointment_service_id
                  LEFT JOIN users B ON B.id=appointment.appointment_dentist_id

                  WHERE
                  appointment_date = DATE_FORMAT(ADDDATE(NOW(), INTERVAL 1 DAY), \"%Y-%m-%d\")
                  AND
                  appointment_sms_notification = 0
                  AND
                  A.id IN (SELECT user_id FROM users_groups WHERE group_id=2)";

          $query = $this->db->query($sql);

          return $query->result_array();
        }

        public function getAppointmentList($start = null, $end = null, $group = null, $id = null)
        {
          if(is_null($start))
          {
            $sql = "SELECT
                    CONCAT_WS(' / ', CONCAT(A.first_name, ' ', A.last_name), services_name) AS 'title',
                    CONCAT_WS(' / ', CONCAT(A.first_name, ' ', A.last_name), services_name, CONCAT(' by ', B.first_name, ' ', B.last_name)) AS 'description',
                    CONCAT_WS('T',appointment_date, appointment_start_time) AS 'start',
                    CONCAT_WS('T',appointment_date, appointment_end_time) AS 'end'
                    FROM appointment
            LEFT JOIN services ON services.services_id=appointment.appointment_service_id
            LEFT JOIN users A ON A.id=appointment.appointment_client_id
            LEFT JOIN users B ON B.id=appointment.appointment_dentist_id

            WHERE (MONTH(appointment_date) = MONTH(CURRENT_DATE()) AND YEAR(appointment_date) = YEAR(CURRENT_DATE()))
            AND appointment_cancelled = 0

            ";

            $query = $this->db->query($sql);
          }
          else
          {
            $where = "";
            if($group == "admin")
            {
              $array = array($start, $end);
            }
            else
            {
              if($group=="dentist")
              {
                $where = "AND appointment_dentist_id=?";
              }
              else
              {
                $where = "AND appointment_client_id=?";
              }
              $array = array($start, $end, $id);
            }
            $sql = "SELECT
                    CONCAT_WS(' / ', CONCAT(A.first_name, ' ', A.last_name), services_name) AS 'title',
                    CONCAT_WS(' / ', CONCAT(A.first_name, ' ', A.last_name), services_name, CONCAT(' by ', B.first_name, ' ', B.last_name)) AS 'description',
                    CONCAT_WS('T',appointment_date, appointment_start_time) AS 'start',
                    CONCAT_WS('T',appointment_date, appointment_end_time) AS 'end',
                    appointment_id AS 'id',
                    appointment_cancelled as 'is_cancelled',
                    appointment_show_up as 'is_show'
                    FROM appointment
            LEFT JOIN services ON services.services_id=appointment.appointment_service_id
            LEFT JOIN users A ON A.id=appointment.appointment_client_id
            LEFT JOIN users B ON B.id=appointment.appointment_dentist_id

            WHERE ((appointment_date BETWEEN ? AND ?) ".$where.")
           ";

            $query = $this->db->query($sql, $array);
          }

          return $query->result_array();
        }

        public function getServicesList()
        {
          $sql = "SELECT * FROM services ORDER BY services_name";

          $query = $this->db->query($sql);

          return $query->result_array();
        }

        public function getProviderList()
        {
          $sql = "SELECT * FROM users WHERE id IN (SELECT user_id FROM users_groups WHERE group_id=3) ORDER BY last_name";

          $query = $this->db->query($sql);

          return $query->result_array();
        }

        public function getClientList()
        {
          $sql = "SELECT * FROM users WHERE id IN (SELECT user_id FROM users_groups WHERE group_id=2) ORDER BY last_name";

          $query = $this->db->query($sql);

          return $query->result_array();
        }

        public function getClientList2()
        {
          $sql = "SELECT * FROM users LEFT JOIN user_extra_info ON user_extra_info.user_extra_info_user_id=users.id WHERE id IN (SELECT user_id FROM users_groups WHERE group_id=2) ORDER BY last_name";

          $query = $this->db->query($sql);

          return $query->result_array();
        }

        public function getClientList3($id)
        {
          $sql = "SELECT * FROM users LEFT JOIN user_extra_info ON user_extra_info.user_extra_info_user_id=users.id WHERE id IN (SELECT user_id FROM users_groups WHERE group_id=2) AND id=? ORDER BY last_name";

          $query = $this->db->query($sql, $id);

          return $query->result_array();
        }

        public function getAppointmentAvailability($date = null, $service = null, $provider = null, $time = null)
        {
          $sql = "SELECT * FROM appointment WHERE appointment_cancelled = 0 AND appointment_date=? AND appointment_start_time=FROM_UNIXTIME(LEFT(?,length(?)-3),\"%H:%i:%s\")";

          $sql = "SELECT * FROM appointment WHERE appointment_cancelled = 0 AND appointment_date=?
                  AND (appointment_start_time=FROM_UNIXTIME(LEFT(?,length(?)-3),\"%H:%i:%s\") AND appointment_end_time COLLATE 'utf8_general_ci'>=ADDTIME(FROM_UNIXTIME(LEFT(?,length(?)-3),\"%H:%i:%s\"), (SEC_TO_TIME((SELECT services_duration FROM services WHERE services_id=appointment_service_id)*60))))";
          $sql = "SELECT * FROM appointment WHERE appointment_cancelled = 0 AND appointment_date=? AND FROM_UNIXTIME(LEFT(?,length(?)-3),\"%H:%i:%s\") BETWEEN appointment_start_time AND SUBTIME(appointment_end_time, '0:1')";

          $query = $this->db->query($sql, array($date, $time, $time));

          if($query->num_rows() > 0)
          {
            return array(0, 'Time and date selected already booked.');
          }
          else
          {
            return array(1, 'Time and date selected is available.');
          }
          //return $query->result_array();
        }

        public function getClientNumber($id)
        {
          $sql = "SELECT phone FROM users WHERE id = (SELECT appointment_client_id FROM appointment WHERE appointment_id=?) LIMIT 1";

          $query = $this->db->query($sql, $id);

          return $query->result_array();
        }

        public function getAppointmentDetails($id)
        {
          $sql = "SELECT
                  appointment_id AS 'id',
                  appointment_client_id AS 'client_id',
                  CONCAT_WS('', services_name) AS 'service',
                  CONCAT_WS('', appointment_date) AS 'date',
                  CONCAT_WS('',appointment_start_time) AS 'time'
                  FROM appointment
          LEFT JOIN services ON services.services_id=appointment.appointment_service_id
          LEFT JOIN users A ON A.id=appointment.appointment_client_id
          LEFT JOIN users B ON B.id=appointment.appointment_dentist_id

          WHERE appointment_id = ?

          ";

          $query = $this->db->query($sql, $id);

          return $query->result_array();
        }

        public function getConfirmCode($email, $code)
        {
          $sql = "SELECT * FROM register_confirm WHERE register_confirm_email=? AND register_confirm_code=? AND register_confirm_timestamp IS NULL";

          $query = $this->db->query($sql, array($email, $code));

          return $query->result_array();
        }

        public function getServicesInfo($id)
        {
          $sql = "SELECT * FROM services WHERE services_id=? ORDER BY services_name";

          $query = $this->db->query($sql, $id);

          return $query->result_array();
        }

        public function getServicesInfo2($id)
        {
          $sql = "SELECT services_id AS 'ID', services_name AS 'Name', services_description AS 'Desc', services_duration AS 'Duration' FROM services WHERE services_id=? ORDER BY services_name";

          $query = $this->db->query($sql, $id);

          return $query->result_array();
        }

        public function getListAppointment()
        {
          $sql = "SELECT * FROM appointment
                  LEFT JOIN users A ON A.id=appointment.appointment_client_id
                  LEFT JOIN users B ON B.id=appointment.appointment_dentist_id
                  LEFT JOIN services C ON C.services_id=appointment_service_id
                  ORDER BY appointment_date DESC, appointment_start_time DESC
                  ";

          $query = $this->db->query($sql);

          return $query->result_array();
        }

        public function getInfo($user)
        {
          $sql = "SELECT id, email FROM users WHERE email=?";

          $query = $this->db->query($sql, $user);

          return $query->result_array();
        }
}
