<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Live_support_chat extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url().$this->project->main_route."/admin/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('Sessions_Model', 'sessions');
	}


	function index() {

		$sidebar_data['user'] = $this->user;
        $data['status'] = $this->status();

		$this->load
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/header")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/menubar")
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/sidebar", $sidebar_data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/live-support-chat", $data)
			->view("{$this->themes_dir}/{$this->project->theme}/admin/common/footer")
		;

    }

    public function status()
    {
        $this->db->select('status');
        $this->db->from('live_support_chat_status');
        $this->db->where('name', 'isOn');
        $status = $this->db->get();
        if ($status->num_rows() > 0) {
            return $status->row()->status;
        } else {
            return 0;
        }
    }

    public function toggleStatus($status)
    {
        $set = array(
            'status' => $status
        );
        $this->db->where('project_id', $this->project->id);
        $this->db->update("live_support_chat_status", $set, array('name' => 'isOn'));
        if($this->db->affected_rows() > 0){
            echo json_encode(array('status'=>'success'));
        }else{
            echo json_encode(array('status'=>'failed'));
        }
    }

    public function allChats($user_id)
    {
        $sql =
            "
            SELECT lsc.*
            FROM live_support_chat as lsc
            WHERE 
                  (
                      (lsc.chat_from_type = 'attendee' AND lsc.from_id = '{$user_id}'  AND lsc.project_id = '{$this->project->id}') 
                          OR 
                      (lsc.chat_from_type = 'admin' AND lsc.to_id = '{$user_id}' AND lsc.project_id = '{$this->project->id}')
                  ) 
            ";

        $chats = $this->db->query($sql);
        if ($chats->num_rows() > 0)
            return $chats->result_array();

        return array();
    }

    public function allChatsJSON($user_id)
    {
        echo json_encode($this->allChats($user_id));
    }

    public function newText()
    {
        $text = $this->input->post('chat_text');
        $to_id = $this->input->post('to_id');

        $admin_id = $this->user->user_id;

        $chat = array
        (
            'chat_from_type' => 'admin',
            'from_id' => $admin_id,
            'to_id' => $to_id,
            'text' => $text,
            'date_time' => date('Y-m-d H:i:s'),
			'project_id' => $this->project->id
        );

        $this->db->insert('live_support_chat', $chat);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(array('status'=>'success'));
        } else {
            echo json_encode(array('status'=>'failed'));
        }
    }
}
?>
