<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//if (ycl_env == "testing")
			//redirect('https://yourconference.live/COS/');

		if (isset($_SESSION['project_sessions']["project_{$this->project->id}"]) && $_SESSION['project_sessions']["project_{$this->project->id}"]['is_attendee'] == 1)
			redirect(base_url().$this->project->main_route."/lobby"); // Already logged-in
	}

	public function index()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/login")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;
	}

	public function staff()
	{
		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/staff_login")
			->view("{$this->themes_dir}/{$this->project->theme}/attendee/common/footer")
		;
	}

	public function logout(){
		print_r('test');

		$this->session->sess_destroy();
		session_destroy();
	}

	

	// Key for authentication :
		// 

	public  function cco_authentication() {
		  $token = $this->input->get('token');
       	 $response_array = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))));

		 print_r($response_array);exit;
	
        if (isset($response_array) && !empty($response_array)) {
            $identifier = $response_array->identity->identifier;
            $member_id = substr($identifier, 4);
            $curl = curl_init();

			
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.clinicaloptions.com/api/external?memberid=" . $member_id . "&SecurityToken=eW91cmNvbmZlcmVuY2UubGl2ZS9NeUNFQQ==",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

			
            $response = curl_exec($curl);
			print_r($response);exit;
            $err = curl_error($curl);
            curl_close($curl);
            $member_array = json_decode($response);


			// print_r($member_array);exit;
            if (isset($member_array) && !empty($member_array)) {
				print_r('User details successfully received from CCO');
				print_r($member_array);
				
//                 $or_where = '(email = "' . $member_array->emailAddress . '")';
//                 $this->db->where($or_where);
//                 $customer = $this->db->get('customer_master');

//                 if ($customer->num_rows() > 0) {
//                     $user_details = $customer->row();
//                     $set_update_array = array(
//                         'first_name' => $member_array->firstName,
//                         'last_name' => $member_array->lastName,
//                         'email' => $member_array->emailAddress,
//                         'specialty' => $member_array->specialty,
//                         'degree' => $member_array->degree,
//                         'city' => $response_array->identity->city,
//                         'zipcode' => $response_array->identity->zip,
//                         'state' => $response_array->identity->state,
//                         'country' => $response_array->identity->country,
//                         'topic' => $member_array->topics,
//                         'identifier_id' => $response_array->identity->identifier,
//                         'customer_session' => $response_array->session,
//                         'iat' => $response_array->iat,
//                         'exp' => $response_array->exp,
//                         'aud' => json_encode($response_array->aud),
//                         'jti' => $response_array->jti
//                     );
//                     $this->db->update("customer_master", $set_update_array, array("cust_id" => $user_details->cust_id));
//                     $token = $this->objlogin->update_user_token($user_details->cust_id);
//                     $session = array(
//                         'cid' => $user_details->cust_id,
//                         'cname' => $user_details->first_name,
//                         'fullname' => $user_details->first_name . " " . $user_details->last_name,
//                         'email' => $user_details->email,
//                         'token' => $token,
//                         'userType' => 'user'
//                     );
//                     $this->session->set_userdata($session);
//                     $sessions = $this->db->get_where('sessions', array('sessions_id' => $response_array->session));
//                     if ($sessions->num_rows() > 0) {
//                         redirect('sessions/attend/' . $response_array->session);
//                     } else {
// //*                        redirect('home');
//                         echo '<div style="align-content:center; text-align:center; margin-top: 10%">
//     <img src="https://yourconference.live/CCO/front_assets/images/YCL_logo.png">
//     <h1 style="text-align:center">There is an error in the session number</h1>
// </div>';
//                     }
//                 } else {
//                     $this->db->order_by("cust_id", "desc");
//                     $row_data = $this->db->get("customer_master")->row();
//                     if (!empty($row_data)) {
//                         $reg_id = $row_data->cust_id;
//                         $register_id = date("Y") . '-20' . $reg_id;
//                     } else {
//                         $register_id = date("Y") . '-200';
//                     }
//                     $set = array(
//                         "register_id" => $register_id,
//                         'first_name' => ($member_array->firstName == '')?'_Empty_':$member_array->firstName,
//                         'last_name' => ($member_array->lastName == '')?'_Empty_':$member_array->lastName,
//                         'email' => $member_array->emailAddress,
//                         'password' => base64_encode(123),
//                         'specialty' => $member_array->specialty,
//                         'degree' => $member_array->degree,
//                         'city' => $response_array->identity->city,
//                         'zipcode' => $response_array->identity->zip,
//                         'state' => $response_array->identity->state,
//                         'country' => $response_array->identity->country,
//                         'topic' => $member_array->topics,
//                         'identifier_id' => $response_array->identity->identifier,
//                         'customer_session' => $response_array->session,
//                         'iat' => $response_array->iat,
//                         'exp' => $response_array->exp,
//                         'aud' => json_encode($response_array->aud),
//                         'jti' => $response_array->jti,
//                         'address' => "",
//                         'register_date' => date("Y-m-d h:i")
//                     );
//                     $this->db->insert("customer_master", $set);
//                     $cust_id = $this->db->insert_id();
//                     $user_details = $this->db->get_where("customer_master", array("cust_id" => $cust_id))->row();
//                     if (!empty($user_details)) {
//                         $token = $this->objlogin->update_user_token($user_details->cust_id);
//                         $session = array(
//                             'cid' => $user_details->cust_id,
//                             'cname' => $user_details->first_name,
//                             'fullname' => $user_details->first_name . " " . $user_details->last_name,
//                             'email' => $user_details->email,
//                             'token' => $token,
//                             'userType' => 'user'
//                         );
//                         $this->session->set_userdata($session);
//                         $sessions = $this->db->get_where('sessions', array('sessions_id' => $response_array->session));
//                         if ($sessions->num_rows() > 0) {
//                             redirect('sessions/attend/' . $response_array->session);
//                         } else {
// //*                          redirect('home');
//                             echo '<div style="align-content:center; text-align:center; margin-top: 10%">
//     <img src="https://yourconference.live/CCO/front_assets/images/YCL_logo.png">
//     <h1 style="text-align:center">There is an error in the session number</h1>
// </div>';
//                         }
//                     }
//                 }
            }else{
                echo "User details not received from CCO";
            }
        }
	}
}
