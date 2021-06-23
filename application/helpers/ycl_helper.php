<?php
function liveSupportChatStatus()
{
	$CI =& get_instance();

	$CI->db->select('status');
	$CI->db->from('live_support_chat_status');
	$CI->db->where('name', 'isOn');
	$status = $CI->db->get();
	if ($status->num_rows() > 0) {
		return $status->row()->status;
	} else {
		return 0;
	}
}
