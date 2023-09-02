<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);
		$this->load->model('Logger_Model', 'logger');
	}

	public function getAll()
	{
		$this->db->select('s.*, st.name as session_track');
		$this->db->from('sessions s');
		$this->db->join('session_tracks st', 's.track = st.id', 'left');
		$this->db->where('s.is_deleted', 0);
		$this->db->where('s.project_id', $this->project->id);
		$this->db->group_start();
			$this->db->where('s.end_date_time >=', date('Y-m-d'));
			$this->db->or_where('s.id', 78);
			$this->db->or_where('s.id', 79);
			$this->db->or_where('s.id', 80);
		$this->db->group_end();
		$this->db->order_by('s.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			foreach ($sessions->result() as $session)
			{
				$session->briefcase = $this->getUserBriefcasePerSession($session->id);
				$session->presenters = $this->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->getModeratorsPerSession($session->id);
				$session->invisible_moderators = $this->getInvisibleModeratorsPerSession($session->id);
			}

			return $sessions->result();
		}

		return new stdClass();
	}

	public function getAllSessions(){
		$sessions = $this->db->select('*')->from('sessions')->where('project_id', $this->project->id)->get();
		if ($sessions->num_rows() > 0)
		{
			return $sessions;
		}
		return new stdClass();
	}

	public function getAllArchived()
	{
		$this->db->select('s.*, st.name as session_track');
		$this->db->from('sessions s');
		$this->db->join('session_tracks st', 's.track = st.id', 'left');
		$this->db->where('s.is_deleted', 0);
		$this->db->where('s.project_id', $this->project->id);
		$this->db->group_start();
			$this->db->where('s.end_date_time <', date('Y-m-d'));
			
		$this->db->group_end();
		$this->db->order_by('s.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			foreach ($sessions->result() as $session)
			{
				$session->briefcase = $this->getUserBriefcasePerSession($session->id);
				$session->presenters = $this->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->getModeratorsPerSession($session->id);
				$session->invisible_moderators = $this->getInvisibleModeratorsPerSession($session->id);
			}
			return $sessions->result();
		}

		return new stdClass();
	}

	public function getFromDay($date)
	{
		$this->db->select('s.*, st.name as session_track');
		$this->db->from('sessions s');
		$this->db->join('session_tracks st', 's.track = st.id', 'left');
		$this->db->where('s.is_deleted', 0);
		$this->db->where('s.project_id', $this->project->id);
		$this->db->where('DATE(s.start_date_time)', $date);
		$this->db->order_by('s.start_date_time', 'ASC');
		$sessions = $this->db->get();
		
		if ($sessions->num_rows() > 0)
		{
			foreach ($sessions->result() as $session)
			{
				$session->briefcase = $this->getUserBriefcasePerSession($session->id);
				$session->presenters = $this->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->getModeratorsPerSession($session->id);
				$session->invisible_moderators = $this->getInvisibleModeratorsPerSession($session->id);
			}
			return $sessions->result();
		}
		return new stdClass();
	}

	public function getAllSessionWeek()
	{
		$this->db->select('s.*, st.name as session_track');
		$this->db->from('sessions s');
		$this->db->join('session_tracks st', 's.track = st.id', 'left');
		$this->db->where('s.is_deleted', 0);
		$this->db->where('s.project_id', $this->project->id);
		$this->db->where('DATE_FORMAT(s.start_date_time, "%Y-%m-%d") >=', date('Y-m-d'));
		$this->db->where('DATE_FORMAT(s.start_date_time, "%Y-%m-%d") <', date('Y-m-d', strtotime("+7 days")));
		$this->db->order_by('s.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			foreach ($sessions->result() as $session)
			{
				$session->briefcase = $this->getUserBriefcasePerSession($session->id);
				$session->presenters = $this->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->getModeratorsPerSession($session->id);
				$session->invisible_moderators = $this->getInvisibleModeratorsPerSession($session->id);
			}

			return $sessions->result();
		}

		return new stdClass();
	}

	public function getAllSessionsByPresenter($presenter_id)
	{
		$this->db->select('sessions.*');
		$this->db->from('sessions');
		$this->db->join('session_presenters', 'session_presenters.session_id = sessions.id');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('session_presenters.presenter_id', $presenter_id);
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->group_by('sessions.id');
		$this->db->order_by('sessions.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getAllSessionsByPresenterModerator($user_id)
	{
		$this->db->select('sessions.*');
		$this->db->from('sessions');
		$this->db->join('session_presenters', 'session_presenters.session_id = sessions.id', 'left');
		$this->db->join('session_moderators', 'session_moderators.session_id = sessions.id', 'left');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where('session_presenters.presenter_id', $user_id);
		$this->db->or_where('session_moderators.moderator_id', $user_id);
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->group_by('sessions.id');
		$this->db->order_by('sessions.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getAllSessionsByPresenterModeratorKeynote($user_id)
	{
		$this->db->select('sessions.*');
		$this->db->from('sessions');
		$this->db->join('session_presenters', 'session_presenters.session_id = sessions.id', 'left');
		$this->db->join('session_moderators', 'session_moderators.session_id = sessions.id', 'left');
		$this->db->join('session_keynote_speakers', 'session_keynote_speakers.session_id = sessions.id', 'left');
		$this->db->where('sessions.is_deleted', 0);
		$this->db->where("end_date_time >=", date('Y-m-d H:i:s'));
		$this->db->group_start();
		$this->db->where('session_presenters.presenter_id', $user_id);
		$this->db->or_where('session_moderators.moderator_id', $user_id);
		$this->db->or_where('session_keynote_speakers.speaker_id', $user_id);
		$this->db->group_end();
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->group_by('sessions.id');
		$this->db->order_by('sessions.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getById($id)
	{
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where('id', $id);
		$this->db->where('is_deleted', 0);
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			$sessions->result()[0]->briefcase = $this->getUserBriefcasePerSession($id);
			$sessions->result()[0]->presenters = $this->getPresentersPerSession($id);
			$sessions->result()[0]->keynote_speakers = $this->getKeynoteSpeakersPerSession($id);
			$sessions->result()[0]->moderators = $this->getModeratorsPerSession($id);
			$sessions->result()[0]->invisible_moderators = $this->getInvisibleModeratorsPerSession($id);
			$sessions->result()[0]->resources = $this->getResources($id);

			return $sessions->result()[0];
		}

		return new stdClass();
	}

	public function getByDay($day, $track_id, $keynote_id, $speaker_id, $keyword)
	{
		if ($keynote_id) {
			$session_ids = $this->db->select('session_id')
								 ->where('speaker_id', $keynote_id)
								 ->group_by('session_id')
								 ->get_compiled_select('session_keynote_speakers', true);

			$this->db->where('sessions.id IN ('.$session_ids.')');
		}

		$this->db->select('sessions.*, session_tracks.name AS session_track');
		$this->db->from('sessions');

		$where = array('sessions.project_id' => $this->project->id,
					   'sessions.is_deleted' => 0,
					   'DATE(sessions.start_date_time)' => $day
					);

		if ($track_id) {
			$where['track'] = $track_id;
		}

		if ($speaker_id) {
			$this->db->where('sessions.id IN (SELECT `session_id`
										FROM `session_presenters`
										WHERE `presenter_id`='.$speaker_id.'
										GROUP BY `session_id`)');
		}

		if ($keyword) {
			$this->db->like('sessions.name',$keyword);
			$this->db->or_like('sessions.description',$keyword);
		}

		$this->db->join('session_tracks', 'session_tracks.id=sessions.track', 'left');
		$this->db->where($where);
		$this->db->order_by('sessions.start_date_time', 'ASC');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
		{
			foreach ($sessions->result() as $session)
			{
				$session->briefcase = $this->getUserBriefcasePerSession($session->id);
				$session->presenters = $this->getPresentersPerSession($session->id);
				$session->keynote_speakers = $this->getKeynoteSpeakersPerSession($session->id);
				$session->moderators = $this->getModeratorsPerSession($session->id);
			}

			return $sessions->result();
		}

		return new stdClass();
	}

	public function getAllTracks()
	{
		$this->db->select('*');
		$this->db->from('session_tracks');
		$this->db->where('project_id', $this->project->id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getAllTypes()
	{
		$this->db->select('*');
		$this->db->from('session_types');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function add()
	{
		$session_data = $this->input->post();
//		print_r(trim($session_data));
//		exit;
//		print_r($_FILES['sessionEndImage']);
//		exit;
		// Upload session photo if set
		$session_photo = '';
		$session_end_image = '';
		if (isset($_FILES['sessionPhoto']) && $_FILES['sessionPhoto']['name'] != '')
		{
			$photo_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$photo_config['file_name'] = $session_photo = rand().'_'.str_replace(' ', '_', $_FILES['sessionPhoto']['name']);
			$photo_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/thumbnails/';

			$this->load->library('upload', $photo_config);
			$this->upload->initialize($photo_config);
			if ( ! $this->upload->do_upload('sessionPhoto'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the session photo', 'technical_data'=>$this->upload->display_errors());
		}
		$sessionSponsorLogo = '';
		if($session_data['isSponsorLogoRemoved'] == 0) {
			if (isset($_FILES['sessionSponsorLogo']) && $_FILES['sessionSponsorLogo']['name'] != '') {
				$photo_config['allowed_types'] = 'gif|jpg|png|jpeg';
				$photo_config['file_name'] = $sessionSponsorLogo = rand() . '_' . str_replace(' ', '_', $_FILES['sessionSponsorLogo']['name']);
				$photo_config['upload_path'] = FCPATH . 'cms_uploads/projects/' . $this->project->id . '/sessions/thumbnails/';

				$this->load->library('upload', $photo_config);
				$this->upload->initialize($photo_config);
				if (!$this->upload->do_upload('sessionSponsorLogo'))
					return array('status' => 'failed', 'msg' => 'Unable to upload the session sponsor logo', 'technical_data' => $this->upload->display_errors());
			}
		}else{

		}
		$sessionLogo = '';
		if($session_data['isSessionLogoRemoved'] == 0) {
			if (isset($_FILES['sessionLogo']) && $_FILES['sessionLogo']['name'] != '') {
				$photo_config['allowed_types'] = 'jpg|png|jpeg';
				$photo_config['file_name'] = $sessionLogo = rand() . '_' . str_replace(' ', '_', $_FILES['sessionLogo']['name']);

				$photo_config['upload_path'] = FCPATH . 'cms_uploads/projects/' . $this->project->id . '/sessions/logo/';

				$this->load->library('upload', $photo_config);
				$this->upload->initialize($photo_config);
				if (!$this->upload->do_upload('sessionLogo'))
					return array('status' => 'failed', 'msg' => 'Unable to upload the session logo', 'technical_data' => $this->upload->display_errors());
			}
		} else{

		}

		if (isset($_FILES['sessionEndImage']) && $_FILES['sessionEndImage']['name'] != '')
		{
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name'] = $session_end_image = rand().'_'.str_replace(' ', '_', $_FILES['sessionEndImage']['name']);
			$config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/images/';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('sessionEndImage'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the session end image', 'technical_data'=>$this->upload->display_errors());
		}

		$mobileSessionBackground = '';
		if (isset($_FILES['mobileSessionBackground']) && $_FILES['mobileSessionBackground']['name'] != '')
		{
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name'] = $mobileSessionBackground = rand().'_'.str_replace(' ', '_', $_FILES['mobileSessionBackground']['name']);
			$config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/images/background/';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('mobileSessionBackground'))
				return array('status' => 'failed', 'msg'=>'Unable to upload mobile session background', 'technical_data'=>$this->upload->display_errors());
		}

		$start_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['startDateTime']);
		$start_time_mysql = $start_time_object->format('Y-m-d H:i:s');

		$end_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['endDateTime']);
		$end_time_mysql = $end_time_object->format('Y-m-d H:i:s');

		$data = array(
			'project_id' => $this->project->id,
			'name' => $session_data['sessionName'],
			'other_language_name' => $session_data['sessionNameOther'],
			'room_id' => $session_data['roomID'],
			'description' => $session_data['sessionDescription'],
			'thumbnail' => $session_photo,
			'session_logo_width' => $session_data['sessionLogoWidth'],
			'session_logo_height' => $session_data['sessionLogoHeight'],
			'sponsor_logo_width' => $session_data['sponsorLogoWidth'],
			'sponsor_logo_height' => $session_data['sponsorLogoHeight'],
			'agenda' => $session_data['sessionAgenda'],
			'session_type' => $session_data['sessionType'],
			'external_meeting_link' => (isset($session_data['sessionExternalUrl']))?$session_data['sessionExternalUrl']:'',
			'track' => (isset($session_data['sessionTrack'])? $session_data['sessionTrack']: ''),
			'credits' => $session_data['sessionCredits'],
			'millicast_stream' => $session_data['millicastStream'],
			'presenter_embed_code' => $session_data['slidesHtml'],
			'zoom_link' => $session_data['zoomLink'],
			'video_url' => $session_data['sessionVideo'],
			'start_date_time' => $start_time_mysql,
			'end_date_time' => $end_time_mysql,
			'created_by' => $this->user->user_id,
			'created_on' => date('Y-m-d H:i:s'),
			'header_toolbox_status' => (isset($session_data['header_toolbox']) && ($session_data['header_toolbox']=='on') ? 1:0),
			'header_notes' => (isset($session_data['header_notes']) && ($session_data['header_notes']=='on') ? 1:0),
			'header_question' => (isset($session_data['header_question']) && ($session_data['header_question']=='on') ? 1:0),
			'header_resources' => (isset($session_data['header_resources']) && ($session_data['header_resources']=='on') ? 1:0),
			'header_askrep' => (isset($session_data['header_askrep']) && ($session_data['header_askrep']=='on') ? 1:0),
			'right_sticky_notes' => (isset($session_data['right_sticky_notes']) && ($session_data['right_sticky_notes']=='on') ? 1:0),
			'right_sticky_resources' => (isset($session_data['right_sticky_resources']) && ($session_data['right_sticky_resources']=='on') ? 1:0),
			'right_sticky_question' => (isset($session_data['right_sticky_question']) && ($session_data['right_sticky_question']=='on') ? 1:0),
			'right_sticky_askrep' => (isset($session_data['right_sticky_askrep']) && ($session_data['right_sticky_askrep']=='on') ? 1:0),
			'session_end_text' => (isset($session_data['sessionEndText'])?trim($session_data['sessionEndText']):''),
			'session_end_image' => $session_end_image,
			'claim_credit_link' => (isset($session_data['claim_credit_link'])?trim($session_data['claim_credit_link']):''),
			'claim_credit_url' => (isset($session_data['claim_credit_url'])?trim($session_data['claim_credit_url']):''),
			'session_end_redirect' => (isset($session_data['sessionEndRedirect'])?trim($session_data['sessionEndRedirect']):null),
			'toolbox_note_text' => (isset($session_data['notes_text'])?trim($session_data['notes_text']):''),
			'toolbox_question_text' => (isset($session_data['question_text'])?trim($session_data['question_text']):''),
			'toolbox_resource_text' => (isset($session_data['resource_text'])?trim($session_data['resource_text']):''),
			'toolbox_askrep_text' => (isset($session_data['ask_a_rep_text'])?trim($session_data['ask_a_rep_text']):''),
			'time_zone' => (isset($session_data['time_zone'])?trim($session_data['time_zone']):''),
			'event_id' => (isset($session_data['eventID'])?trim($session_data['eventID']):''),
			'notes' => (isset($session_data['sessionNotes'])?trim($session_data['sessionNotes']):''),
			'attendee_settings_id' => (isset($session_data['session_color_preset'])?trim($session_data['session_color_preset']):'0'),
			'button1_text' => (isset($session_data['button1_text'])?trim($session_data['button1_text']):''),
			'button1_link' => (isset($session_data['button1_link'])?trim($session_data['button1_link']):''),
			'button2_text' => (isset($session_data['button2_text'])?trim($session_data['button2_text']):''),
			'button2_link' => (isset($session_data['button2_link'])?trim($session_data['button2_link']):''),
			'button3_text' => (isset($session_data['button3_text'])?trim($session_data['button3_text']):''),
			'button3_link' => (isset($session_data['button3_link'])?trim($session_data['button3_link']):''),
			'auto_redirect_status' => (isset($session_data['autoRedirectSwitch']) && ($session_data['autoRedirectSwitch']=='on') ? 1:0),
		);

		if($session_data['isSponsorLogoRemoved'] == 0){
			$data['sponsor_logo'] = $sessionSponsorLogo;
		}
		if($session_data['isSessionLogoRemoved'] == 0){
			$data['sponsor_logo'] = $sessionLogo;
		}

		if($session_end_image != '' && $session_end_image != null){
			$data['session_end_image'] = $session_end_image;
		}

		if(isset($mobileSessionBackground) && $mobileSessionBackground != '' && $mobileSessionBackground != null){
			$data['mobile_session_background'] = $mobileSessionBackground;
		}

		$this->db->insert('sessions', $data);

		if ($this->db->affected_rows() > 0)
		{
			$session_id = $this->db->insert_id();
			if(isset($session_data['sessionPresenters']) && !empty($session_data['sessionPresenters'])) {
				foreach ($session_data['sessionPresenters'] as $presenter_id) {
					$data = array(
						'presenter_id' => $presenter_id,
						'session_id' => $session_id,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_presenters', $data);
				}
			}
			if(isset($session_data['sessionKeynoteSpeakers']) && !empty($session_data['sessionKeynoteSpeakers'])) {
				foreach ($session_data['sessionKeynoteSpeakers'] as $speaker_id) {
					$data = array(
						'speaker_id' => $speaker_id,
						'session_id' => $session_id,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_keynote_speakers', $data);
				}
			}
			if(isset($session_data['sessionModerators']) && !empty($session_data['sessionModerators'])) {
				foreach ($session_data['sessionModerators'] as $moderator_id) {
					$data = array(
						'moderator_id' => $moderator_id,
						'session_id' => $session_id,
						'is_invisible' => 0,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_moderators', $data);
				}
			}
			if(isset($session_data['sessionInvisibleModerators']) && !empty($session_data['sessionInvisibleModerators'])) {
				foreach ($session_data['sessionInvisibleModerators'] as $moderator_id) {
					$data = array(
						'moderator_id' => $moderator_id,
						'session_id' => $session_id,
						'is_invisible' => 1,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_moderators', $data);
				}
			}

			return array('status' => 'success', 'session_id' => $session_id);
		}

		return array('status' => 'failed', 'msg' => 'Error occurred', 'technical_data'=> $this->db->error());

	}

	public function update()
	{
		$session_data = $this->input->post();
//		print_r($_FILES);exit;
		if (!isset($session_data['sessionId']) || $session_data['sessionId'] == 0)
			return array('status' => 'failed', 'msg'=>'No session(ID) selected', 'technical_data'=>'');

		// Upload session photo if set
		$session_photo = '';
		$session_end_image = '';
		if (isset($_FILES['sessionPhoto']) && $_FILES['sessionPhoto']['name'] != '')
		{
			$photo_config['allowed_types'] = 'gif|jpg|png|jpeg';
			$photo_config['file_name'] = $session_photo = rand().'_'.str_replace(' ', '_', $_FILES['sessionPhoto']['name']);
			$photo_config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/thumbnails/';

			$this->load->library('upload', $photo_config);
			$this->upload->initialize($photo_config);
			if ( ! $this->upload->do_upload('sessionPhoto'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the session photo', 'technical_data'=>$this->upload->display_errors());
		}

		$sessionSponsorLogo = '';
		if($session_data['isSponsorLogoRemoved'] == 0) {
			if (isset($_FILES['sessionSponsorLogo']) && $_FILES['sessionSponsorLogo']['name'] != '') {
				$photo_config['allowed_types'] = 'gif|jpg|png|jpeg';
				$photo_config['file_name'] = $sessionSponsorLogo = rand() . '_' . str_replace(' ', '_', $_FILES['sessionSponsorLogo']['name']);
				$photo_config['upload_path'] = FCPATH . 'cms_uploads/projects/' . $this->project->id . '/sessions/thumbnails/';

				$this->load->library('upload', $photo_config);
				$this->upload->initialize($photo_config);
				if (!$this->upload->do_upload('sessionSponsorLogo'))
					return array('status' => 'failed', 'msg' => 'Unable to upload the session sponsor logo', 'technical_data' => $this->upload->display_errors());
			}
		}else{
			$path = FCPATH . 'cms_uploads/projects/' . $this->project->id . '/sessions/thumbnails/';
			$this->unbind_sponsor_logo( $session_data['sessionId'], $path);
		}

		$sessionLogo = '';
		if($session_data['isSessionLogoRemoved'] == 0) {
			if (isset($_FILES['sessionLogo']) && $_FILES['sessionLogo']['name'] != '') {
				$photo_config['allowed_types'] = 'gif|jpg|png|jpeg';
				$photo_config['file_name'] = $sessionLogo = rand() . '_' . str_replace(' ', '_', $_FILES['sessionLogo']['name']);
				$photo_config['upload_path'] = FCPATH . 'cms_uploads/projects/' . $this->project->id . '/sessions/logo/';

				$this->load->library('upload', $photo_config);
				$this->upload->initialize($photo_config);
				if (!$this->upload->do_upload('sessionLogo'))
					return array('status' => 'failed', 'msg' => 'Unable to upload the session logo', 'technical_data' => $this->upload->display_errors());
			}
		}else{
			$path = FCPATH . 'cms_uploads/projects/' . $this->project->id . '/sessions/logo/';
			$this->unbind_session_logo( $session_data['sessionId'], $path);
		}

		if (isset($_FILES['sessionEndImage']) && $_FILES['sessionEndImage']['name'] != '')
		{
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name'] = $session_end_image = rand().'_'.str_replace(' ', '_', $_FILES['sessionEndImage']['name']);
			$config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/images/';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('sessionEndImage'))
				return array('status' => 'failed', 'msg'=>'Unable to upload the session end image', 'technical_data'=>$this->upload->display_errors());
		}

		$mobileSessionBackground = '';
		if (isset($_FILES['mobileSessionBackground']) && $_FILES['mobileSessionBackground']['name'] != '')
		{
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['file_name'] = $mobileSessionBackground = rand().'_'.str_replace(' ', '_', $_FILES['mobileSessionBackground']['name']);
			$config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/images/background/';

			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ( ! $this->upload->do_upload('mobileSessionBackground'))
				return array('status' => 'failed', 'msg'=>'Unable to upload mobile session background', 'technical_data'=>$this->upload->display_errors());
		}

		$start_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['startDateTime']);
		$start_time_mysql = $start_time_object->format('Y-m-d H:i:s');

		$end_time_object = DateTime::createFromFormat('m/d/Y h:i A', $session_data['endDateTime']);
		$end_time_mysql = $end_time_object->format('Y-m-d H:i:s');

		$data = array(
			'project_id' => $this->project->id,
			'name' => $session_data['sessionName'],
			'other_language_name' => $session_data['sessionNameOther'],
			'room_id' => $session_data['roomID'],
			'description' => $session_data['sessionDescription'],
			'agenda' => $session_data['sessionAgenda'],
			'session_type' => $session_data['sessionType'],
			'external_meeting_link' => (isset($session_data['sessionExternalUrl']))?$session_data['sessionExternalUrl']:'',
			'track' => isset($session_data['sessionTrack'])? $session_data['sessionTrack']: '',
			'credits' => $session_data['sessionCredits'],
			'millicast_stream' => $session_data['millicastStream'],
			'presenter_embed_code' => $session_data['slidesHtml'],
			'zoom_link' => $session_data['zoomLink'],
			'video_url' => $session_data['sessionVideo'],
			'start_date_time' => $start_time_mysql,
			'end_date_time' => $end_time_mysql,
			'updated_by' => $this->user->user_id,
			'updated_on' => date('Y-m-d H:i:s'),
			'header_toolbox_status' => (isset($session_data['header_toolbox']) && ($session_data['header_toolbox']=='on') ? 1:0),
			'header_notes' => (isset($session_data['header_notes']) && ($session_data['header_notes']=='on') ? 1:0),
			'header_question' => (isset($session_data['header_question']) && ($session_data['header_question']=='on') ? 1:0),
			'header_resources' => (isset($session_data['header_resources']) && ($session_data['header_resources']=='on') ? 1:0),
			'header_askrep' => (isset($session_data['header_askrep']) && ($session_data['header_askrep']=='on') ? 1:0),
			'right_sticky_notes' => (isset($session_data['right_sticky_notes']) && ($session_data['right_sticky_notes']=='on') ? 1:0),
			'right_sticky_resources' => (isset($session_data['right_sticky_resources']) && ($session_data['right_sticky_resources']=='on') ? 1:0),
			'right_sticky_question' => (isset($session_data['right_sticky_question']) && ($session_data['right_sticky_question']=='on') ? 1:0),
			'right_sticky_askrep' => (isset($session_data['right_sticky_askrep']) && ($session_data['right_sticky_askrep']=='on') ? 1:0),
			'session_end_text' => (isset($session_data['sessionEndText'])?trim($session_data['sessionEndText']):''),
			'claim_credit_link' => (isset($session_data['claim_credit_link'])?trim($session_data['claim_credit_link']):''),
			'claim_credit_url' => (isset($session_data['claim_credit_url'])?trim($session_data['claim_credit_url']):''),
			'session_end_redirect' => (isset($session_data['sessionEndRedirect'])?trim($session_data['sessionEndRedirect']):null),
			'toolbox_note_text' => (isset($session_data['notes_text'])?trim($session_data['notes_text']):''),
			'toolbox_question_text' => (isset($session_data['question_text'])?trim($session_data['question_text']):''),
			'toolbox_resource_text' => (isset($session_data['resource_text'])?trim($session_data['resource_text']):''),
			'toolbox_askrep_text' => (isset($session_data['ask_a_rep_text'])?trim($session_data['ask_a_rep_text']):''),
			'time_zone' => (isset($session_data['time_zone'])?trim($session_data['time_zone']):''),
			'event_id' => (isset($session_data['eventID'])?trim($session_data['eventID']):''),
			'notes' => (isset($session_data['sessionNotes'])?trim($session_data['sessionNotes']):''),
			'session_logo_width' => $session_data['sessionLogoWidth'],
			'session_logo_height' => $session_data['sessionLogoHeight'],
			'sponsor_logo_width' => $session_data['sponsorLogoWidth'],
			'sponsor_logo_height' =>  $session_data['sponsorLogoHeight'],
			'attendee_settings_id' =>  $session_data['session_color_preset'],
			'button1_text' => (isset($session_data['button1_text'])?trim($session_data['button1_text']):''),
			'button1_link' => (isset($session_data['button1_link'])?trim($session_data['button1_link']):''),
			'button2_text' => (isset($session_data['button2_text'])?trim($session_data['button2_text']):''),
			'button2_link' => (isset($session_data['button2_link'])?trim($session_data['button2_link']):''),
			'button3_text' => (isset($session_data['button3_text'])?trim($session_data['button3_text']):''),
			'button3_link' => (isset($session_data['button3_link'])?trim($session_data['button3_link']):''),
			'auto_redirect_status' => (isset($session_data['autoRedirectSwitch']) && ($session_data['autoRedirectSwitch']=='on') ? 1:0),
		);

		if($session_end_image != '' && $session_end_image != null){
			$data['session_end_image'] = $session_end_image;
		}
		if ($session_photo != '')
			$data['thumbnail'] = $session_photo;

		if($sessionSponsorLogo != ''){
			$data['sponsor_logo'] = $sessionSponsorLogo;
		}
		if($session_data['isSponsorLogoRemoved'] == 1 )
			$data['sponsor_logo'] = '';
//
		if( $sessionLogo != ''){
			$data['session_logo'] = $sessionLogo;
		}

		if($mobileSessionBackground != '' && $mobileSessionBackground != null){
			$data['mobile_session_background'] = $mobileSessionBackground;
		}

		if($session_data['isSessionLogoRemoved'] == 1 )
		$data['session_logo'] = '';

		$this->db->set($data);
		$this->db->where('id', $session_data['sessionId']);
		$this->db->update('sessions');

		if ($this->db->affected_rows() > 0)
		{
			$session_id = $session_data['sessionId'];

			if (isset($session_data['sessionPresenters']))
			{
				$this->db->where('session_id', $session_id);
				$this->db->delete('session_presenters');

				foreach ($session_data['sessionPresenters'] as $presenter_id)
				{
					$data = array(
						'presenter_id' => $presenter_id,
						'session_id' => $session_id,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_presenters', $data);
				}
			}

			if (isset($session_data['sessionKeynoteSpeakers']))
			{
				$this->db->where('session_id', $session_id);
				$this->db->delete('session_keynote_speakers');

				foreach ($session_data['sessionKeynoteSpeakers'] as $speaker_id)
				{
					$data = array(
						'speaker_id' => $speaker_id,
						'session_id' => $session_id,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_keynote_speakers', $data);
				}
			}

			if (isset($session_data['sessionModerators']))
			{
				$this->db->where('session_id', $session_id);
				$this->db->where('is_invisible', 0);
				$this->db->delete('session_moderators');

				foreach ($session_data['sessionModerators'] as $moderator_id)
				{
					$data = array(
						'moderator_id' => $moderator_id,
						'session_id' => $session_id,
						'is_invisible' => 0,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_moderators', $data);
				}
			}

			if (isset($session_data['sessionInvisibleModerators']))
			{
				$this->db->where('session_id', $session_id);
				$this->db->where('is_invisible', 1);
				$this->db->delete('session_moderators');

				foreach ($session_data['sessionInvisibleModerators'] as $moderator_id)
				{
					$data = array(
						'moderator_id' => $moderator_id,
						'session_id' => $session_id,
						'is_invisible' => 1,
						'added_on' => date('Y-m-d H:i:s'),
						'added_by' => $this->user->user_id,
					);

					$this->db->insert('session_moderators', $data);
				}
			}

			$session = $this->db->get_where('sessions', array('id'=>$session_data['sessionId']))->result()[0];

			return array('status' => 'success', 'session_id' => $session_data['sessionId'], 'session' => $session);
		}

		return array('status' => 'warning', 'msg' => 'No changes made', 'technical_data'=> $this->db->error());

	}

	function unbind_sponsor_logo($session_id, $path){
		$result = $this->db->select('*')
			->from('sessions')
			->where('id',  $session_id)
			->get();

		if($result->num_rows() >0){
			$sponsor_logo = $result->result()[0]->sponsor_logo;
			if($sponsor_logo){
				unlink( $path.$sponsor_logo);
			}
		}
		return true;
	}

	function unbind_session_logo($session_id, $path){
		$result = $this->db->select('*')
			->from('sessions')
			->where('id',  $session_id)
			->get();

		if($result->num_rows() >0){
			$session_logo = $result->result()[0]->session_logo;
			if($session_logo){
				unlink( $path.$session_logo);
			}
		}
		return true;
	}

	public function removeSession($session_id)
	{
		$this->db->set('is_deleted', 1);
		$this->db->where('id', $session_id);
		$this->db->update('sessions');

		if ($this->db->affected_rows() > 0)
			return array('status' => 'success');
		return array('status' => 'failed');
	}

	public function getAllPresenters()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('user_project_access', 'user_project_access.user_id = user.id');
		$this->db->where('user_project_access.level', 'presenter');
		$this->db->where('user_project_access.project_id', $this->project->id);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getAllModerators()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('user_project_access', 'user_project_access.user_id = user.id');
		$this->db->where('user_project_access.level', 'moderator');
		$this->db->where('user_project_access.project_id', $this->project->id);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getAllKeynoteSpeakers()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_keynote_speakers', 'session_keynote_speakers.speaker_id = user.id');
		$this->db->join('sessions', 'session_keynote_speakers.session_id = sessions.id');
		$this->db->where('sessions.project_id', $this->project->id);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getUserBriefcasePerSession($session_id)
	{
		$this->db->select('*');
		$this->db->from('user_agenda');
		$this->db->where('project_id', $this->project->id);
		$this->db->where('session_id', $session_id);
		$this->db->where('user_id', $this->user->user_id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getPresentersPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_presenters', 'session_presenters.presenter_id = user.id');
		$this->db->where('session_presenters.session_id', $session_id);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getKeynoteSpeakersPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_keynote_speakers', 'session_keynote_speakers.speaker_id = user.id');
		$this->db->where('session_keynote_speakers.session_id', $session_id);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getModeratorsPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_moderators', 'session_moderators.moderator_id = user.id');
		$this->db->where('session_moderators.session_id', $session_id);
		$this->db->where('session_moderators.is_invisible', 0);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getInvisibleModeratorsPerSession($session_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('session_moderators', 'session_moderators.moderator_id = user.id');
		$this->db->where('session_moderators.session_id', $session_id);
		$this->db->where('session_moderators.is_invisible', 1);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	/******** Host Chat ********/
	public function getHostChat($session_id)
	{
		$this->db->select("session_host_chat.*, CONCAT(user.name, ' ', user.surname) as host_name, user.id as host_id, user.photo as host_photo");
		$this->db->from('session_host_chat');
		$this->db->join('user', 'user.id = session_host_chat.from_id');
		$this->db->where('session_host_chat.session_id', $session_id);
		$this->db->order_by('session_host_chat.date_time', 'asc');
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	/**
	 * @param $chat Object
	 * @return array
	 */
	public function sendHostChat($chat)
	{
		$chat_data = array(
			'session_id' => $chat['session_id'],
			'from_id' => $chat['from_id'],
			'message' => $chat['message'],
			'date_time' => date('Y-m-d H:i:s')
		);
		$this->db->insert('session_host_chat', $chat_data);
		return ($this->db->affected_rows() > 0) ? array('status'=>'success'):array('status'=>'failed');
	}
	/******./ Host Chat ********/

	public function askQuestion($session_id, $question)
	{
		$question = array(
			'session_id' => $session_id,
			'user_id' => $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
			'question' => $question,
			'asked_on' => date('Y-m-d H:i:s')
		);
		$this->db->insert('session_questions', $question);
		$insert_id = $this->db->insert_id();
		return ($this->db->affected_rows() > 0) ? array('status'=>'success', 'data'=>$insert_id):array('status'=>'failed');
	}

	public function getCredits($session_id)
	{
		$this->db->select("credits");
		$this->db->from('sessions');
		$this->db->where('id', $session_id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result()[0]->credits;

		return 0;
	}

	public function getResources($session_id)
	{
		$this->db->select("*");
		$this->db->from('session_resources');
		$this->db->where('session_id', $session_id);
		$this->db->where('is_active', 1);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0)
			return $sessions->result();

		return new stdClass();
	}

	public function getAllPolls($session_id)
	{
		$this->db->select("*");
		$this->db->from('session_polls');
		$this->db->where('session_id', $session_id);
		$this->db->where('is_active', 1);
		$polls = $this->db->get();
		if ($polls->num_rows() > 0)
			return $polls->result();

		return new stdClass();
	}

	public function getPollById($id)
	{
		$this->db->select("sessions.id as session_id, session_polls.*");
		$this->db->from('session_polls');
		$this->db->join('sessions', 'sessions.id = session_polls.session_id');
		$this->db->where('session_polls.id', $id);
		$polls = $this->db->get();
		if ($polls->num_rows() > 0)
		{
			$polls->result()[0]->options = $this->getPollOptions($polls->result()[0]->id);
			if($polls->result()[0]->poll_comparison_id != 0){
				$polls->result()[0]->poll_compare = $this->getPollOptions($polls->result()[0]->poll_comparison_id);
			}

			return $polls->result()[0];
		}


		return new stdClass();
	}

	public function getPollOptions($poll_id)
	{
		$this->db->select("*");
		$this->db->from('session_poll_options');
		$this->db->where('poll_id', $poll_id);
		$polls = $this->db->get();
		if ($polls->num_rows() > 0)
		{
			return $polls->result();
		}


		return new stdClass();
	}

	public function vote()
	{
		$post = $this->input->post();

		$poll = array(
			'poll_id' => $post['pollId'],
			'user_id' => $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
			'answer_id' => $post['poll_option'],
			'answered_on' => date('Y-m-d H:i:s')
		);
		$this->db->insert('session_poll_answers', $poll);
		return ($this->db->affected_rows() > 0) ? array('status'=>'success'):array('status'=>'failed');
	}


	public function getResultByOptionId($option_id)
	{
		$this->db->select("*");
		$this->db->from('session_poll_answers');
		$this->db->where('answer_id', $option_id);
		$polls = $this->db->get();
		if ($polls->num_rows() > 0)
			return $polls->result();

		return new stdClass();
	}

	public function getPollResult($poll_id)
	{
		$poll = $this->getPollById($poll_id);
		$total_votes = 0;
		$total_comp_votes = 0;
		$results_array = array();
		$result_compere = array();
		$result_obj = new stdClass();
		foreach ($poll->options as $index=>$option)
		{
			$results = $this->getResultByOptionId($option->id);
			$total_votes += count((array)$results);

			$results_array[$option->id] = array(
				'option_name' => $option->option_text,
				'poll_id' => $option->poll_id,
				'number_of_answers' => count((array)$results),
				'option_order'=> $option->option_order
			);
		}
		if(isset($poll->poll_compare)) {
			foreach ($poll->poll_compare as $index=> $compare) {
				$results = $this->getResultByOptionId($compare->id);
				$total_comp_votes += count((array)$results);

				$result_compere[$compare->id] = array(
					'option_name' => $compare->option_text,
					'poll_id' => $compare->poll_id,
					'number_of_answers' => count((array)$results),
					'option_order'=> $compare->option_order
				);
			}
		}

		foreach ($results_array as $option_id => $result) {
			if($result['number_of_answers']  == '0'){
				$results_array[$option_id]['vote_percentage_compare'] = 0;
			}else
			$results_array[$option_id]['vote_percentage'] = round(($result['number_of_answers'] / $total_votes) * 100);
		}
		if($result_compere) {
			foreach ($result_compere as $option_id => $result) {
				if($result['number_of_answers']  == '0'){
					$result_compere[$option_id]['vote_percentage_compare'] = 0;
				}else
					$result_compere[$option_id]['vote_percentage_compare'] = round(($result['number_of_answers'] / $total_comp_votes) * 100);
			}
		}

		$result_obj->poll = $results_array;
		$result_obj->compere = $result_compere;
		$result_obj->poll_type = $poll->poll_type;
		$result_obj->poll_correct_answer1 = $poll->correct_answer1;
		$result_obj->poll_correct_answer2 = $poll->correct_answer2;
		$result_obj->poll_instruction = $poll->poll_instruction;
		$result_obj->slide_number = $poll->slide_number;
		return $result_obj;


	}

	public function addPoll($session_id)
	{
		$pattern = "/^(<br>\s*)*(<p>\s*)*|\s*(<\/p>\s*)*(<\/br>\s*)*$/";
		$post = $this->input->post();
//		print_r($post);exit;

		$data = array(
			'session_id' => $session_id,
			'poll_question' => $post['pollQuestionInput'],
			'poll_name' => $post['pollNameInput'],
			'poll_type' => $post['poll_type'],
			'show_result' => (isset($post['autoPollResult']))?1:0,
			'is_active' => 1,
			'added_on' => date('Y-m-d H:i:s'),
			'added_by' => $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
			'correct_answer1' => $post['poll_answer1'],
			'correct_answer2' => $post['poll_answer2'],
			'poll_instruction' => $post['pollInstructionInput'],
			'slide_number' => (isset($post['slideNumberInput']) ? $post['slideNumberInput'] : 0),
			'external_reference' => (isset($post['pollQuestionReferenceInput']) ? $post['pollQuestionReferenceInput'] : '')
		);
		$this->db->insert('session_polls', $data);

		if ($this->db->affected_rows() > 0)
		{
			$poll_id = $this->db->insert_id();
			$order = 0;
			foreach ($post['pollOptionsInput'] as $i => $option)
			{
				$order ++;
				$options_array = array(
					'poll_id' => $poll_id,
					'option_text' => trim(preg_replace($pattern, "", $option)),
					'option_order' => $order,
					'external_reference' => $post['optionExternalReference'][$i]
				);
				$this->db->insert('session_poll_options', $options_array);
			}

			if($post['poll_comparison'] !== ''){
				$this->addPollComparison($session_id, $post, $poll_id);
			}

			return array('status'=>'success', 'msg'=>'Poll created');

		}else{
			return array('status'=>'error', 'msg'=>'Unable to create poll');
		}

	}

	function addPollComparison($session_id, $post, $pollParentId){
		$pattern = "/^(<br>\s*)*(<p>\s*)*|\s*(<\/p>\s*)*(<\/br>\s*)*$/";
		$data = array(
			'session_id' => $session_id,
			'poll_question' => $post['pollQuestionInput'],
			'poll_name' => $post['pollNameInput'],
			'poll_type' => $post['poll_comparison'],
			'poll_comparison_id' => $pollParentId,
			'show_result' => (isset($post['autoPollResult']))?1:0,
			'is_active' => 1,
			'added_on' => date('Y-m-d H:i:s'),
			'added_by' => $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
			'correct_answer1' => $post['poll_answer1'],
			'correct_answer2' => $post['poll_answer2'],
			'poll_instruction' => $post['pollInstructionInput'],
			'slide_number' => (isset($post['slideNumberInput']) ? $post['slideNumberInput'] : 0),
			'external_reference' => (isset($post['pollQuestionReferenceInput']) ? $post['pollQuestionReferenceInput'] : '')
		);
		$this->db->insert('session_polls', $data);
		$insert_id = $this->db->insert_id();
		if ($this->db->affected_rows() > 0)
		{
			$this->db->update("session_polls", array("poll_comparison_id" => $insert_id), array("id" => $pollParentId));
			$poll_id = $this->db->insert_id();
			$order = 0;
			foreach ($post['pollOptionsInput'] as $i=> $option)
			{
				$order ++;
				$options_array = array(
					'poll_id' => $insert_id,
					'option_text' => trim(preg_replace($pattern, "", $option)),
					'option_order' => $order,
					'external_reference' => $post['optionExternalReference'][$i]
				);
				$this->db->insert('session_poll_options', $options_array);
			}
		}
	}

	public function updatePoll($session_id)
	{
		$pattern = "/^(<br>\s*)*(<p>\s*)*|\s*(<\/p>\s*)*(<\/br>\s*)*$/";
		$post = $this->input->post();
//		print_r($post);exit;
		$data = array(
			'poll_question' => $post['pollQuestionInput'],
			'poll_name' => $post['pollNameInput'],
			'poll_type' => $post['poll_type'],
			'show_result' => (isset($post['autoPollResult']))?1:0,
			'is_active' => 1,
			'added_by' => $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'],
			'correct_answer1' => $post['poll_answer1'],
			'correct_answer2' => $post['poll_answer2'],
			'poll_instruction' => $post['pollInstructionInput'],
			'slide_number' => (isset($post['slideNumberInput']) ? $post['slideNumberInput'] : 0),
			'external_reference' => (isset($post['pollQuestionReferenceInput']) ? $post['pollQuestionReferenceInput'] : '')
		);
		if($post['pollId'] != 0) {

			$this->db->where('id', $post['pollId']);
			$this->db->update('session_polls', $data);
			$order = 0;
			foreach ($post['pollOptionsInput'] as $i => $option) {

				$order ++;
				$options_array = array(
					'option_text' => preg_replace($pattern, "", $option),
					'option_order' => $order,
					'external_reference' => $post['optionExternalReference'][$i]
				);
				if (isset($post['option_' . $i]) && $post['option_' . $i] !== 'undefined' ) {
					$this->db->where('id', $post['option_' . $i]);
					$this->db->update('session_poll_options', $options_array);

				} else {
					$options_array = array(
						'poll_id' => $post['pollId'],
						'option_text' => preg_replace($pattern, "", $option),
						'option_order' => $order,
						'external_reference' => $post['optionExternalReference'][$i]
					);
					$this->db->insert('session_poll_options', $options_array);
				}
			}
			if(isset($post['option_deleted']) && !empty($post['option_deleted'])) {
				foreach ($post['option_deleted'] as $deleted) {
					$this->deletePollOption($deleted);
				}
			}

			return array('status' => 'success', 'msg' => 'Poll updated');

		} else {
			return array('status' => 'error2', 'msg' => 'Unable to update poll');
		}


	}

	public function deletePollOption($option_id){
		$this->db->delete('session_poll_options', array('id'=>$option_id));
		return true;
	}

	public function getQuestions($session_id)
	{
		$sql = "SELECT sq.*, u.name as user_name, u.surname as user_surname, u.id as user_id FROM `session_questions` sq left join user u on sq.user_id = u.id where sq.session_id  = $session_id AND sq.id not In (SELECT question_id FROM session_question_stash ) or sq.id IN (SELECT question_id FROM session_question_stash where hidden != 1)";
		$polls = $this->db->query($sql);
		if ($polls->num_rows() > 0){
			$poll_array = array();
			foreach($polls->result() as $poll){
				$poll->isOnSaveQuestion = ($this->db->select('*')->from('session_question_saved')->where('question_id', $poll->id)->where('saved_status', 1)->get()->row()? 1:0);
				$poll_array[]= $poll;
			}

			return $poll_array;
		}


		return new stdClass();
	}

	public function getSessionWeek(){
		$this->db->select("s.start_date_time,DAYNAME(s.start_date_time) as dayname");
		$this->db->from("sessions s");
		$this->db->where('DATE_FORMAT(s.start_date_time, "%Y-%m-%d") >=', date('Y-m-d'));
		$this->db->where('DATE_FORMAT(s.start_date_time, "%Y-%m-%d") <', date('Y-m-d', strtotime("+7 days")));
		$this->db->group_by('dayname');
		$this->db->order_by("s.start_date_time", "asc");
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0) {
			return $sessions->result();
		}
		return new stdClass();

	}

	function getAttendee_question_direct_chat(){

	}

	function save_presenter_attendee_chat(){
		$post = $this->input->post();
		$this->db->insert('attendee_direct_chat', array(
			'session_id'=>$post['session_id'],
			'from_id'=>$this->user->user_id,
			'to_id'=>$post['sender_id'],
			'chats'=>$post['chat'],
			'date_time'=>date('Y-m-d H:i:s'),
			'sent_from'=>'presenter',
		));
		if($this->db->insert_id()){
			return array('status'=>'success');
		}else
			return '';
	}

	function saveChatAdmin(){
		$post = $this->input->post();
		$this->db->insert('attendee_direct_chat', array(
			'session_id'=>$post['session_id'],
			'from_id'=>$this->user->user_id,
			'to_id'=>'admin',
			'chats'=>$post['chat'],
			'date_time'=>date('Y-m-d H:i:s'),
			'sent_from'=>'attendee',
		));
		if($this->db->insert_id()){
			return array('status'=>'success');
		}else
			return array('status'=>'Error, Something went wrong');
	}

	function getAttendeeChatsAjax(){
		$post = $this->input->post();
		$chats = $this->db->select('adc.*, u.name as first_name, u.surname as last_name, DATE_FORMAT(date_time, "%Y-%M-%d %H:%i") as date_time')
			->from('attendee_direct_chat adc')
			->join('user u', 'adc.from_id = u.id')
			->where('session_id', $post['session_id'])
			->group_start()
			->where('from_id', $post['sender_id'])
			->or_where('to_id', $post['sender_id'])
			->group_end()
			->order_by('adc.date_time', 'asc')
			->get();

		if($chats->num_rows()>0){
			return array('status'=>'success', 'chats'=>$chats->result());
		}else{
			return array('status'=>'Error, Something went wrong');
		}
	}

	function getAdminChatsAjax(){
		$post = $this->input->post();
		$uid = $this->user->user_id;
		$sql =	"SELECT `adc`.*, `u`.`name` as `username`, `u`.`surname` as `surname` FROM `attendee_direct_chat` `adc` LEFT JOIN `user` `u` ON  IF(`adc`.`from_id` != 'admin', adc.from_id = u.id, adc.to_id = u.id ) WHERE `session_id` = ".$post['session_id']." AND ( `to_id` = ".$uid." OR `from_id` = ".$uid." ) ORDER BY `date_time` ASC";
	$result = $this->db->query($sql);
		if($result->num_rows()>0){
			return array('status'=>'success', 'data'=>$result->result());
		}else{
			return array('status'=>'error', 'data'=>$result->result());
		}

	}

	function saveQuestionAjax(){
		$field_set = array(
			'question_id'=>$this->input->post('question_id'),
			'user_id'=>$this->user->user_id,
			'saved_status'=>'1',
			'date_time'=>date('Y-m-d H:i:s')
		);

		$result = $this->db->select('*')
			->from('session_question_saved')
//			->where('user_id', $this->user->user_id)
			->where('question_id', $this->input->post('question_id'))
			->get();

		if ($result->num_rows()>0){
			$this->db->where('question_id', $this->input->post('question_id'));
			$this->db->update('session_question_saved', $field_set);
		}else
		$this->db->insert('session_question_saved', $field_set);

		if($this->db->affected_rows() > 0){
			return array('status'=>'success', 'msg'=>'Save Successfully');
		}else{
			return array('status'=>'error', 'msg'=>'Sorry something went wrong');
		}
	}

	function getSavedQuestions($session_id){
		$saved_question = $this->db->select('sqv.*, us.id as user_id, sq.question as question, sq.asked_on, sq.session_id, u.name as user_name, u.surname as user_surname, us.name as q_from_name , us.surname as q_from_surname')
			->from('session_question_saved sqv')
			->join('session_questions sq', 'sqv.question_id = sq.id', 'left')
			->join('user u', 'sqv.user_id = u.id')
			->join('user us', 'sq.user_id = us.id')
			->where('sq.session_id', $session_id)
//			->where('sqv.user_id', $this->user->user_id)
			->where('saved_status', '1')
			->order_by('sq.asked_on', 'asc')
			->get();

		if($saved_question->num_rows() > 0){
			return array('status'=>'success', 'data'=>$saved_question->result());
		}else{
			return array('status'=>'empty', 'data'=>$saved_question->result());
		}
	}

	function hideQuestionAjax(){
		$field_set = array(
			'question_id'=>$this->input->post('question_id'),
			'user_id'=>$this->user->user_id,
			'hidden'=>'1',
			'date_time'=>date('Y-m-d H:i:s')
		);

		$result = $this->db->select('*')
			->from('session_question_stash')
			->where('user_id', $this->user->user_id)
			->where('question_id', $this->input->post('question_id'))
			->get();

		if ($result->num_rows()>0){
			$this->db->where('id',$result->result()[0]->id);
			$this->db->update('session_question_stash', $field_set);
		}else
			$this->db->insert('session_question_stash', $field_set);

		if($this->db->affected_rows() > 0){
			return array('status'=>'success', 'msg'=>'Question hidden');
		}else{
			return array('status'=>'error', 'msg'=>'Sorry something went wrong');
		}
	}

	function hideSavedQuestionAjax(){
			$this->db->where('question_id', $this->input->post('question_id'));
			$this->db->update('session_question_saved', array('saved_status'=>0));

		if($this->db->affected_rows() > 0){
			return array('status'=>'success', 'msg'=>'Question removed from starred');
		}else{
			return array('status'=>'error', 'msg'=>'Sorry something went wrong');
		}
	}

	function save_ask_a_rep()
	{

		$post = $this->input->post();

		$data = array(
			'session_id' => $post['session_id'],
			'user_id' => $post['user_id'],
			'rep_type' => $post['rep_type'],
			'date_time' => date('Y-m-d H:i:s'),
			'project_id' => $this->project->id
		);

		$this->db->select('*');
		$this->db->from('ask_a_rep');
		$this->db->where(array('session_id' => $post['session_id'], 'user_id' => $post['user_id'], 'rep_type' => $post['rep_type']));
		$this->db->where('project_id', $this->project->id);
		$response = $this->db->get();
		if ($response->num_rows() > 0)
			echo json_encode(array('status' => 'failed', 'msg' => "You have already requested to be contacted by a representative ({$post['rep_type']}).<br> A representative will contact you shortly."));
		else {
			$this->db->insert('ask_a_rep', $data);
			if ($this->db->affected_rows() > 0)
				echo json_encode(array('status' => 'success', 'msg' => "Thank you for your request. <br> A representative will contact you shortly."));
			else
				echo json_encode(array('status' => 'failed', 'msg' => "Unable to request, please try again."));
		}

		return;
	}

	function saveTimeSpentOnSession($session_id, $user_id){
		$this->db->where(array('session_id'=>$session_id, 'user_id'=>$user_id, 'project_id'=>$this->project->id));
		$response = $this->db->get('total_time_on_session');

		if ( $response->num_rows() > 0 )
		{
			$this->db->where(array('session_id'=>$session_id, 'user_id'=>$user_id, 'project_id'=>$this->project->id));
			$this->db->update('total_time_on_session', array('total_time'=>$this->input->post()['time']));
		} else {
			$this->db->set(array('session_id'=>$session_id, 'user_id'=>$user_id, 'project_id'=>$this->project->id));
			$this->db->insert('total_time_on_session', array('total_time'=>$this->input->post()['time']));
		}

		echo 1;
		return;
	}

	function getTimeSpentOnSession($session_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from('total_time_on_session');
		$this->db->where(array('session_id'=>$session_id, 'user_id'=>$user_id, 'project_id'=>$this->project->id));

		$response = $this->db->get();
		if ($response->num_rows() > 0)
		{
			echo $response->result_array()[0]['total_time'];
		}else{
			echo 0;
		}

		return;
	}

	function addSessionResources(){
		$post = $this->input->post();
		if($post['resource_url'] == '' && empty($_FILES)){
			return array('status'=>'error', 'msg'=>'File or URL cannot be empty');
		}
			$insert_field = array(
				'session_id'=>$post['session-id'],
				'resource_type'=>'url',
				'resource_path'=>$post['resource_url'],
				'resource_name'=>$post['resource_name']
			);
			$this->db->insert('session_resources', $insert_field);
			$id = $this->db->insert_id();
			if($id > 0) {
				if (!empty($_FILES)) {
					$_FILES['resource_file']['name'] = $_FILES['resource_file']['name'];
					$_FILES['resource_file']['type'] = $_FILES['resource_file']['type'];
					$_FILES['resource_file']['tmp_name'] = $_FILES['resource_file']['tmp_name'];
					$_FILES['resource_file']['error'] = $_FILES['resource_file']['error'];
					$_FILES['resource_file']['size'] = $_FILES['resource_file']['size'];
					$this->load->library('upload');
					$this->upload->initialize($this->set_upload_options_resource($post['resource_name']));
					$this->upload->do_upload('resource_file');
					$file_upload_name = $this->upload->data();
					$this->db->update('session_resources', array('resource_path' => $file_upload_name['file_name'], 'resource_type' => 'file'), array('id' => $id));
				}
				return array('status'=>'success', 'msg'=>'Resource Added Successfully');
			}
		}

	function set_upload_options_resource($name) {
		$this->load->helper('string');
		$randname = random_string('numeric', '8');
		$config = array();
		$config['upload_path'] = FCPATH.'cms_uploads/projects/'.$this->project->id.'/sessions/resources/';
		$config['allowed_types'] = '*';
		$config['overwrite'] = FALSE;
		$config['file_name'] = $name.'_'.$randname;
		return $config;
	}

	function getSessionResources($session_id){
		$post = $this->input->post();
		$result = $this->db->select('*')
			->from('session_resources')
			->where('session_id', $session_id)
			->where('is_active', 1)
			->get();
		if($result->num_rows() > 0){
			return array('status'=>'success', 'data'=>$result->result());
		}else
			return array('status'=>'error');
	}

	function updateSessionResource(){
		$post = $this->input->post();

		$this->db->where('id', $post['resource_id']);
		$this->db->update('session_resources', array('is_active'=>$post['is_active']));
		if($this->db->affected_rows() > 0){
			return array('status'=>'success', 'msg'=>'Resource has been removed');
		}else
			return array('status'=>'error', 'msg'=>'Something went wrong');
	}

	function update_viewsessions_history_open($session_id){
		$post = $this->input->post();
		$session_his_arr = array(
			'end_date_time' => date("Y-m-d H:i:s")
		);
		$this->db->update('logs', $session_his_arr, array("id" => $post['logs_id']));

		$logs_history = $this->db->get_where('logs', array("id" => $post['logs_id']))->row();
		if (!empty($logs_history)) {
			$where_session_his_arr = array(
				'project_id' => $this->project->id,
				'ref_1' => $logs_history->ref_1,
				'user_id' => $this->user->user_id,
				'name' => 'Attend',
				'info' => 'Session View'
			);
			$logs_attend_history = $this->db->get_where('logs', $where_session_his_arr)->row();
			if (!empty($logs_attend_history)) {
				$sessions_details = $this->db->get_where('sessions', array("id" => $logs_history->ref_1))->row();


				if (date("Y-m-d H:i:s", strtotime($sessions_details->start_date_time)) < date("Y-m-d H:i:s") && date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time))) {
					if (date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time))) {
						$end_date_time = date("Y-m-d H:i:s");
					} else {
						$end_date_time = date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time));
					}
				} else {
					if (date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time))) {
						$end_date_time = date("Y-m-d H:i:s", strtotime($sessions_details->start_date_time));
					} else {
						$end_date_time = date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time));
					}
				}

				$session_his_array = array(
					'end_date_time' => $end_date_time
				);
				$this->db->update('logs', $session_his_array, array("id" => $logs_attend_history->id));

			}
		}
		echo json_encode(array("status" => "success"));
	}

	function add_viewsessions_history_open(){
		$post = $this->input->post();
		$this->load->library('user_agent');

		$session_his_arr = array(
			'name'=> 'View',
			'project_id' =>$this->project->id,
			'ref_1' => $post['sessions_id'],
			'user_id' => $this->user->user_id,
			'os' => $this->agent->platform(),
			'browser' => $this->agent->browser(),
			'info' => 'Session View',
			'ip' => $this->input->ip_address(),
			'start_date_time' => date("Y-m-d H:i:s"),
			'date_time' => date("Y-m-d H:i:s"),
		);

		$this->db->insert('logs', $session_his_arr);
		$insert_id = $this->db->insert_id();

		$where_session_his_arr = array(
			'project_id' =>$this->project->id,
			'ref_1' => $post['sessions_id'],
			'user_id' => $this->user->user_id,
			'name' => 'Attend',
			'info' => 'Session View'
		);

		$login_sessions_history = $this->db->get_where('logs', $where_session_his_arr)->row();

		$sessions_details = $this->db->get_where('sessions', array("id" => $post['sessions_id']))->row();
		if (!empty($login_sessions_history)) {

		} else {
			if (date("Y-m-d H:i:s", strtotime($sessions_details->start_date_time)) < date("Y-m-d H:i:s") && date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time))) {
				if (date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time))) {
					$start_date_time = date("Y-m-d H:i:s");
				} else {
					$start_date_time = date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time));
				}
			} else {
				if (date("Y-m-d H:i:s") < date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time))) {
					$start_date_time = date("Y-m-d H:i:s", strtotime($sessions_details->start_date_time));
				} else {
					$start_date_time = date("Y-m-d H:i:s", strtotime($sessions_details->end_date_time));
				}
			}

			$session_his_array = array(
				'name'=> 'Attend',
				'info'=> 'Session View',
				'ref_1' => $post['sessions_id'],
				'user_id' => $this->user->user_id,
				'os' => $this->agent->platform(),
				'browser' => $this->agent->browser(),
				'ip' => $this->input->ip_address(),
				'start_date_time' => $start_date_time,
				'project_id' =>$this->project->id,
				'date_time' =>date('Y-m-d H:i:s'),
			);
			$this->db->insert('logs', $session_his_array);
		}

		echo json_encode(array("status" => "success", "logs_id" => $insert_id));
	}

	function get_flash_report($sessions_id) {
		$this->db->select('*, u.id as user_id, s.id as session_id, l.start_date_time as view_start_time, l.end_date_time as view_end_time');
		$this->db->from('logs l');
		$this->db->join('sessions s', 'l.ref_1 = s.id');
		$this->db->join('user u', 'u.id = l.user_id');
		$this->db->where("l.ref_1", $sessions_id);
		$this->db->where("l.project_id", $this->project->id);
		$this->db->where('l.name','Attend');
		$this->db->where('l.info','Session View');
		$logs = $this->db->get();

//		echo"<pre>";

		if ($logs->num_rows() > 0) {
			$return_array = array();
			foreach ($logs->result() as $value) {
//				print_r($value);
//				print_r($value);
//
//				$this->db->select('*');
//				$this->db->from('sessions_group_chat');
//				$this->db->where(array("sessions_id" => $sessions_id, 'user_id' => $value->user_id));
//				$sessions_group_chat_msg = $this->db->get();
//				$messages = 0;
//				if ($sessions_group_chat_msg->num_rows() > 0) {
//					$messages = $sessions_group_chat_msg->num_rows();
//				}

//				$polls = 0;
//				$this->db->select('*');
//				$this->db->from('session_poll_answers');
//				$this->db->where(array("sessions_id" => $sessions_id, "cust_id" => $value->cust_id));
//				$tbl_poll_voting = $this->db->get();
//				if ($tbl_poll_voting->num_rows() > 0) {
//					$polls = $tbl_poll_voting->num_rows();
//				}

				$this->db->select('*');
				$this->db->from('session_questions');
				$this->db->where(array("session_id" => $sessions_id, "user_id" => $value->user_id));
				$session_questions = $this->db->get();
				$questions = 0;
				if ($session_questions->num_rows() > 0) {
					$questions = $session_questions->num_rows();
				}

				$value->total_time_new = $this->getTimeSpentOnSession($sessions_id, $value->user_id);

//				$value->total_chat = $messages;
				$value->total_questions = $questions;
//				$value->total_polls = $polls;
				$return_array[] = $value;
			}
		}else{
			return array();
		}
		return $return_array;
	}

	function getAllAttendee(){
		$this->db->select('*')
			->from('user')
			->get();
	}
	function get_user_question($sessions_id, $user_id){
		$question = $this->db->select('*')
			->from('session_questions')
			->where('session_id', $sessions_id)
			->where('user_id', $user_id)
			->get()->result();

		if(!empty($question))
			return $question;
		else
			return '';
	}

	function markLaunchedPoll($poll_id){
		$this->db->update('session_polls', array('is_launched'=>'1'), "id = $poll_id");
	}

	function getPollingData($session_id, $poll_list){
		$this->db->select('*');
		$this->db->from('logs l');
		$this->db->join('user u', 'u.id = l.user_id');
		$this->db->where("l.ref_1", $session_id);
		$this->db->where("l.name", 'Attend');
		$this->db->where("info", 'Session View');
		$this->db->where("project_id", $this->project->id);
		$sessions_history = $this->db->get();
		if ($sessions_history->num_rows() > 0) {
			$return_array = array();
			foreach ($sessions_history->result() as $value) {
				if (!empty($poll_list)) {
					foreach ($poll_list as $val) {
						$value->polling_answer[] = $this->get_polling_answer($val['poll_id'], $value->user_id);
					}
				}
				$return_array[] = $value;
			}
			return $return_array;
		} else {
			return "";
		}
	}

	function get_polling_answer($poll_id, $user_id) {
		$this->db->select('*');
		$this->db->from('session_poll_answers');
		$this->db->where(array("poll_id" => $poll_id, "user_id" => $user_id));
		$tbl_poll_voting = $this->db->get();
		if ($tbl_poll_voting->num_rows() > 0) {
			$tbl_poll_voting = $tbl_poll_voting->row();
			$option = $this->db->get_where("session_poll_options", array("id" => $tbl_poll_voting->answer_id))->row()->option_text;
			return $option;
		} else {
			return "";
		}
	}

	function getPollList($session_id){
		$this->db->select('*');
		$this->db->from('session_polls s');
		$this->db->where("s.session_id", $session_id);
		$sessions_poll_question = $this->db->get();

		$polls = array();

		if ($sessions_poll_question->num_rows() > 0) {
			$presurvey = 0;
			$poll = 0;
			$assessment = 0;
			foreach ($sessions_poll_question->result() as $sessions_poll_question) {
				if ($sessions_poll_question->poll_type == 'presurvey') {
					$presurvey = $presurvey + 1;
					$polls[] = array(
						'poll_id' => (int) $sessions_poll_question->id,
						'text' => $sessions_poll_question->poll_type . " " . $presurvey . " : " . $sessions_poll_question->poll_question,
					);
				} else if ($sessions_poll_question->poll_type == 'poll') {
					$poll = $poll + 1;
					$polls[] = array(
						'poll_id' => (int) $sessions_poll_question->id,
						'text' => $sessions_poll_question->poll_type . " " . $poll . " : " . $sessions_poll_question->poll_question,
					);
				} else if ($sessions_poll_question->poll_type == 'assessment') {
					$assessment = $assessment + 1;
					$polls[] = array(
						'poll_id' => (int) $sessions_poll_question->id,
						'text' => $sessions_poll_question->poll_type . " " . $assessment . " : " . $sessions_poll_question->poll_question,
					);
				}
			}
		}
		return $polls;
	}

	function createPollChart($session_id){
		ob_start();
		$sesstion_title = $this->getSessionName($session_id);
		$poll_data = $this->getPollData($session_id);

		$this->load->library('Pdf');
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);

		$pdf->SetTitle($sesstion_title);
		$pdf->SetHeaderMargin(30);
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Your Conference Live');
		$pdf->AddFont('dejavusans', '', 'DejaVuSans.ttf', true);
		$pdf->AddFont('dejavusans', 'B', 'DejaVuSans-Bold.ttf', true);
		$pdf->AddFont('dejavusans', 'I', 'DejaVuSans-Oblique.ttf', true);
		$pdf->AddFont('dejavusans', 'BI', 'DejaVuSans-BoldOblique.ttf', true);
		$pdf->AddPage('L', 'A4');

		$chart_title = $sesstion_title;
//        $pdf->SetFont('helvetica', '', 45);
		$pdf->SetFont('helvetica', '', 45);
		$pdf->SetXY(10, 40);
		$pdf->Write(0, $chart_title, '', 0, 'C', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', '', 30);
		$pdf->SetXY(10, 120);
		$pdf->Write(0, 'Polling Overview', '', 0, 'C', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', 'B', 12);
		$pdf->SetXY(10, 135);
		$pdf->Write(0, 'Produced by Your Conference Live Platform', '', 0, 'C', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', '', 15);
		$pdf->SetXY(10, 142);
		$pdf->Write(0, date("F j, Y, g:i A").' ET', '', 0, 'C', true, 0, false, false, 0);

		foreach ($poll_data as $poll)
		{
			$pdf->AddPage('L', 'A4');

			$pdf->SetTextColor(79, 79, 79);
			$pdf->SetFont('helvetica', '', 6);
			$pdf->SetXY(4, 4);
			$pdf->Write(0, 'Report generated on', '', 0, '', true, 0, false, false, 0);

			$pdf->SetFont('helvetica', '', 7);
			$pdf->SetXY(4, 7);
			$pdf->Write(0, date("F j, Y, g:i A").' ET', '', 0, '', true, 0, false, false, 0);

			$pdf->SetFont('helvetica', '', 8);
			$pdf->SetXY(5, 5);
			$pdf->WriteHTML($sesstion_title, '', 0, 'C', true, 0, false, false, 0);

			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('helvetica', 'B', 20);
			$pdf->SetXY(10, 30);

			$pdf->WriteHTML(trim($poll->poll_question), '', 0, '', true, 'C', false, false, 0);



			$xc = 80;
			$yc = 90;
			$r = 30;

			$color_sets = array();
			$color_sets[] = array(85, 149, 255);
			$color_sets[] = array(220, 57, 18);
			$color_sets[] = array(153, 0, 153);
			$color_sets[] = array(16, 150, 24);
			$color_sets[] = array(0, 202, 202);
			$color_sets[] = array(255, 153, 0);

			$pie_current_degree = 0;
			$color_set = 0;
			$desc_y = 75;
			foreach ($poll->options as $option)
			{

				if ($poll->total_votes != 0)
				{
					$percent = number_format(($option->total_votes*100)/$poll->total_votes, 2);
					$pie_degree = number_format((($percent/100)*360)+$pie_current_degree, 2);

					$color_r = $color_sets[$color_set][0];
					$color_g = $color_sets[$color_set][1];
					$color_b = $color_sets[$color_set][2];

					$pdf->SetFillColor($color_r, $color_g, $color_b);
					$pdf->PieSector($xc, $yc, $r, $pie_current_degree, $pie_degree, 'FD', false, 0, 2);

					if ($percent != 0)
					{
						$pdf->Circle(140, $desc_y, 2, 0, 360, 'DF', null, array($color_r, $color_g, $color_b));
						$desc_y = $desc_y+10;

//                        $pdf->SetFont('helvetica', 'I', 10);
						$pdf->SetFont('dejavusans', '', 8,'', true);
						$pdf->SetTextColor(0,0,0);

						$pdf->SetXY(142, $desc_y - 12);
						$pdf->WriteHTML( trim($option->option_text), '', 0, true, true, 'left', false, false, 0);


					}

					$pie_current_degree = $pie_degree;
					$color_set++;
				}
			}


			$pdf->SetXY(30, 130);
			$pdf->SetFont('helvetica', 'B', 12);
			$result_table =
				'<table cellspacing="0" cellpadding="5">
                    <tr>
                        <td style="width: 500px;">Option</td>
                        <td style="width: 100px;">Votes</td>
                        <td style="width: 100px;">Percentage</td>
                    </tr>
                 </table>';
			$pdf->writeHTML($result_table, true, false, false, false, 'center');

			$pdf->SetXY(30, 136);
			$pdf->SetFont('helvetica', '', 12);
			$result_table =
				'<table cellpadding="5">';

			foreach ($poll->options as $option)
			{

				if ($poll->total_votes != 0)
				{
					$result_table .= '<tr>

                                    <td style="width: 500px; height: 10px;">'.trim($option->option_text).'</td>

                                    <td style="width: 100px;">'.$option->total_votes.'</td>
                                    <td style="width: 100px;">'.number_format(($option->total_votes*100)/$poll->total_votes, 1).'%</td>
                                  </tr>';
				}

			}

			$result_table .= '</table>';
			$pdf->SetFont('dejavusans', '', 10,'', true);
			$pdf->writeHTML($result_table, true, false, false, false, 'center');

			$pdf->SetXY(30, 180);
			$pdf->SetFont('helvetica', 'B', 12);
			$result_table =
				'<table cellspacing="0" cellpadding="5">
                    <tr>
                        <td style="width: 465px;"></td>
                        <td style="width: 200px;">Total '.$poll->total_votes.'</td>
                        <td style="width: 100px;"></td>
                    </tr>
                 </table>';
			$pdf->writeHTML($result_table, true, false, false, false, 'center');
		}
		ob_end_clean();
		$pdf->Output(__DIR__.'/Poll Overview - '.$sesstion_title.'.pdf', 'FD');

		return;
	}

	function getSessionName($session_id){
		return $this->db->select('*')
			->from('sessions')
			->where('id', $session_id)
			->get()->result()[0]->name;

	}

	private function getPollData($session_id)
	{
		$poll_questions = $this->db->query("SELECT * FROM `session_polls` WHERE `session_id` = '{$session_id}'")->result();

		foreach ($poll_questions as $question)
		{
			$question->options = $this->db->query("SELECT * FROM `session_poll_options` WHERE `poll_id` = '{$question->id}'")->result();

			foreach ($question->options as $options)
			{
				$question->total_votes = count($this->db->select('*')->from('session_poll_answers')->where('poll_id', $options->poll_id)->get()->result());
				$options->total_votes = count($this->db->select('*')->from('session_poll_answers')->where('answer_id', $options->id)->get()->result());
			}

		}
		return $poll_questions;
	}

	function attendee_question_report($session_id){
		$result = $this->db->select('CONCAT(u.name, " ",u.surname) as name, sq.question')
			->from('session_questions sq')
			->join('user u', 'u.id = sq.user_id')
			->where('session_id', $session_id)
			->get();

		if($result->num_rows()>0) {
			$questionData = $result;
			$file_name = 'Attendee Questions/' . date('Y-m-d') . '.csv';
			header("Content-Description: File Transfer");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Content-Type: application/csv;");
			// get data
			// file creation
			$file = fopen('php://output', 'w');
			$header = array("Attendee Name", "Question");
			fputcsv($file, $header);
			if ($questionData) {
				foreach ($questionData->result_array() as $value) {
					fputcsv($file, $value);
				}
			} else {
				$content = array('', '');
				fputcsv($file, $content);
			}

			fclose($file);
			exit;
		}

	}

	function getSponsorLogo($session_id){
		return $this->db->select('sponsor_logo')
			->from('sessions')
			->where('id', $session_id)
			->get()->result();
	}

	function view_json($sessions_id){
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where("id", $sessions_id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0) {
			$result_sessions = $sessions->row();
			$this->db->select('*');
			$this->db->from('logs v');
			$this->db->join('user u', 'u.id=v.user_id');
//			$this->db->where("v.session_id", $sessions_id);
			$this->db->where("v.ref_1", $sessions_id);
			$this->db->where("v.project_id", $this->project->id);
			$this->db->where("v.name", "Attend");
			$this->db->where("v.info", "Session View");
//			$this->db->where("v.sessions_id", $sessions_id);
			$sessions_history = $this->db->get();

//			print_r ($sessions_history->result());exit;
			$sessions_history_login = array();
			if ($sessions_history->num_rows() > 0) {
				foreach ($sessions_history->result() as $val) {
					$start_date_time = strtotime($val->start_date_time);
					$end_date_time = strtotime($val->end_date_time);
					if ($end_date_time != "") {
						if ($end_date_time >= $start_date_time) {
							$total_time = $end_date_time - $start_date_time;
						} else {
							$total_time = $start_date_time - $end_date_time;
						}
					} else {
						$end_date_time = 0;
						$total_time = 0;
					}

//					$private_notes = array();
//					$this->db->select('*');
//					$this->db->from('sessions_cust_briefcase');
//					$this->db->where(array("user_id" => $val->cust_id, "sessions_id"=>$sessions_id));
//					$sessions_cust_briefcase = $this->db->get();
//					if ($sessions_cust_briefcase->num_rows() > 0) {
//						foreach ($sessions_cust_briefcase->result() as $note_row)
//							$private_notes[] = $note_row->note;
//						//$private_notes = $sessions_cust_briefcase->row()->note;
//					}

					$sessions_history_login[] = array(
						'uuid' => $val->user_id,
						'access' => 50,
						'created_time' => $start_date_time,
						'last_connected' => $end_date_time,
						'total_time' => $total_time,
						//'total_time' => $this->getTimeSpentOnSession($sessions_id, $val->cust_id),
						'meta' => array("notes" => null, "personal_slide_notes" => array()),
						'alertness' => array("checks_returned" => "", "understood" => ""),
						'browser_sessions' => array("0" => array("uuid" => $val->user_id, "launched_time" => $start_date_time, "last_connected" => $end_date_time, "user_agent" => $val->os . ' - ' . $val->browser)),
						'identity' => array("uuid" => $val->user_id, 'identifier' => $val->user_id, 'name' => $val->name . ' ' . $val->surname, 'email' => $val->email, 'profile_org_name' => null, 'profile_org_title' => null, 'profile_org_website' => "", 'profile_bio' => $val->bio, 'profile_twitter' => "", 'profile_linkedin' => "", 'profile_country' => $val->country, 'profile_picture_url' => "", 'profile_last_updated' => ""),
						'state_changes' => array("0" => array("timestamp" => 1592865240, "state" => 0))
					);
				}
			}

			$this->db->select('*');
			$this->db->from('session_polls s');
//			$this->db->join('poll_type p', 's.poll_type_id=p.poll_type_id');
			$this->db->where("s.session_id", $sessions_id);
			$sessions_poll_question = $this->db->get();
			$polls = array();

			if ($sessions_poll_question->num_rows() > 0) {
				$presurvey = 0;
				$poll = 0;
				$assessment = 0;
				foreach ($sessions_poll_question->result() as $sessions_poll_question) {
					$options = array();
					$this->db->select('*');
					$this->db->from('session_poll_options');
					$this->db->where("poll_id", $sessions_poll_question->id);
					$poll_question_option = $this->db->get();
					if ($poll_question_option->num_rows() > 0) {
						foreach ($poll_question_option->result() as $val) {
//							print_r($val);exit;
							$votes = array();
							$this->db->select('*');
							$this->db->from('session_poll_answers');
							$this->db->where("answer_id", $val->id);
							$tbl_poll_voting = $this->db->get();
							if ($tbl_poll_voting->num_rows() > 0) {
								foreach ($tbl_poll_voting->result() as $tbl_poll_voting) {
									if($this->is_random_guest($tbl_poll_voting->user_id)){
										$votes[] = (int) $tbl_poll_voting->user_id;
									}
								}
							}
							$options[] = array(
								'option_id' => (int) $val->id,
								'external_reference' => $val->external_reference,
								'text' => $val->option_text,
								'total_votes' => ($this->db->select('*')->from('session_poll_answers')->where('answer_id', $val->id)->get()->num_rows()),
								'votes' => $votes
							);

							$total_votes = 0;
							$this->db->select('*');
							$this->db->from('session_poll_answers');
							$this->db->where("poll_id", $val->poll_id);
							$tbl_poll_voting_2 = $this->db->get();
							if ($tbl_poll_voting_2->num_rows() > 0) {
								$total_votes = $tbl_poll_voting_2->num_rows();
							}
						}
					}
					if ($sessions_poll_question->poll_type == 'presurvey') {
						$presurvey = $presurvey + 1;
						$polls[] = array(
							'uuid' => '',
							'status' => 4000,
							'external_reference' => $sessions_poll_question->external_reference,
							'poll_id' => (int) $sessions_poll_question->id,
							'text' => $sessions_poll_question->poll_question,
							'options' => $options,
							'total_votes' => $total_votes,
							'response_type' => 0,
							'text_responses' => array()
						);
					} else if ($sessions_poll_question->poll_type == 'poll') {
						$poll = $poll + 1;
						$polls[] = array(
							'uuid' => '',
							'text' => $sessions_poll_question->poll_question,
							'status' => 4000,
							'external_reference' => $sessions_poll_question->external_reference,
							'poll_id' => (int) $sessions_poll_question->id,
							'options' => $options,
							'total_votes' => $total_votes,
							'response_type' => 0,
							'text_responses' => array()
						);
					} else if ($sessions_poll_question->poll_type == 'assessment') {
						$assessment = $assessment + 1;
						$polls[] = array(
							'uuid' => '',
							'status' => 4000,
							'external_reference' => $sessions_poll_question->external_reference,
							'poll_id' => (int) $sessions_poll_question->id,
							'text' => $sessions_poll_question->poll_question,
							'options' => $options,
							'total_votes' => $total_votes,
							'response_type' => 0,
							'text_responses' => array()
						);
					}
				}
			}

			print_R($polls);exit;

			$this->db->select('*');
			$this->db->from('session_questions');
			$this->db->where("session_id", $sessions_id);
			$sessions_cust_question = $this->db->get();
			$questions = array();
			if ($sessions_cust_question->num_rows() > 0) {
				foreach ($sessions_cust_question->result() as $key => $val) {
					$questions[] = array(
						'uuid'=>$val->user_id,
						'index' => (int) $key,
						'login' => (int) $val->user_id,
						'body' => $val->question,
						'timestamp' => strtotime($val->asked_on),
						'upvotes'=>array()
//                        'question' => $val->question,
//                        'reply_login_id' => ($val->answer_by_id != "") ? $val->answer_by_id : "",
//                        'reply' => ($val->answer != "") ? $val->answer : ""
					);
				}
			}
			$charting[] = array(
				'online' => 0,
				'timestamp' => 0,
				'total_logins' => 0
			);

			$this->db->select('*');
			$this->db->from('session_host_chat');
			$this->db->where("session_id", $sessions_id);
			$sessions_group_chat_msg = $this->db->get();
			$messages = array();
			if ($sessions_group_chat_msg->num_rows() > 0) {
				foreach ($sessions_group_chat_msg->result() as $key => $val) {
					$messages[] = array(
						'uuid' => $val->from_id,
						'login' => $val->from_id,
						'timestamp' => strtotime($val->date_time),
						'message' => $val->message,
						'status' => 0,
						'is_positive' => FALSE,
						'deleted_reason' => 0
					);
				}
			}

			$this->db->select('*');
			$this->db->from('session_resources');
			$this->db->where("session_id", $sessions_id);
			$session_resource = $this->db->get();
			$files = array();
			$hyperlinks = array();
			if ($session_resource->num_rows() > 0) {
				foreach ($session_resource->result() as $key => $val) {
					$files[] = array(
						'uuid' => "",
						'name' => $val->resource_name,
						'about' => "",
						'size' => 1000,
						'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
					);
					$hyperlinks[] = array(
						'uuid' => "",
						'name' => "",
						'url' => $val->resource_path,
						'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
					);
				}
			}



			$create_array = array(
				'actual_end_time' => strtotime($result_sessions->end_date_time),
				'cssid' => $result_sessions->event_id,
				'end_time' => strtotime($result_sessions->end_date_time),
				'name' => $result_sessions->name,
				'reference' => $result_sessions->id,
				'session_id' => (int) $result_sessions->id,
				'start_time' => strtotime($result_sessions->start_date_time),
				'logins' => $sessions_history_login,
				'alertness' => array('count' => 0, 'checks' => array(), 'template' => array('alertness_template_id' => 1, 'name' => "", 'feature_name' => "", 'briefing_preface' => "", 'briefing_text' => "", 'briefing_accept_button' => "", 'briefing_optout_enabled' => "", 'prompt_title' => "", 'prompt_text' => "", 'prompt_audio_file' => "", 'prompt_duration' => "", 'show_failure_notifications' => "", 'aai_variance' => "", 'aai_starting_boundary' => "", 'aai_ending_boundary' => "", 'aai_setup_delay' => "")),
				'chat' => array('enabled' => true,'messages' => $messages),
				'hostschat' => array('messages' => $messages),
				'jpc' => array('conversations' => array()),
				'presentation' => array('decks' => array(array("uuid"=>"","name"=>"","thumbnail_url"=>'',"slides"=>array("image_url"=>"","index"=>"","notes"=>"",'title'=>"","thumbnail_url"=>"","uuid"=>""))), 'slide_events' => array(array("slide_uuid"=>"","timestamp"=>""))),
				'polling' => array("enabled" => true, "polls" => $polls),
				'questions' => array("enabled"=>true,'submitted'=>$questions),
				'resources'=>array("files"=>$files,'hyperlinks'=>$hyperlinks),
				'charting' => $charting
			);


			$json_array = array("data" => json_encode($create_array), "session_reference" => (int) $result_sessions->id, "session_id" => (int) $result_sessions->id, "source" => "gravity");

			$data_to_post = "data=" . json_encode($create_array) . "&session_reference=" . (int) $result_sessions->id . "&session_id=" . (int) $result_sessions->id . "&source=gravity"; //if http_build_query causes any problem with JSON data, send this parameter directly in post.

			echo json_encode($create_array, JSON_PRETTY_PRINT);
//			return true;
		} else {
			return FALSE;
		}
	}

	function send_json($sessions_id){
				
		$this->db->select('*');
		$this->db->from('sessions');
		$this->db->where("id", $sessions_id);
		$sessions = $this->db->get();
		if ($sessions->num_rows() > 0) {
			$result_sessions = $sessions->row();
			$this->db->select('*');
			$this->db->from('logs v');
			$this->db->join('user u', 'u.id=v.user_id');
//			$this->db->where("v.session_id", $sessions_id);
			$this->db->where("v.ref_1", $sessions_id);
			$this->db->where("v.project_id", $this->project->id);
			$this->db->where("v.name", "Attend");
			$this->db->where("v.info", "Session View");
//			$this->db->where("v.sessions_id", $sessions_id);
			$sessions_history = $this->db->get();

//			print_r ($sessions_history->result());exit;
			$sessions_history_login = array();
			if ($sessions_history->num_rows() > 0) {
				foreach ($sessions_history->result() as $val) {
					$start_date_time = strtotime($val->start_date_time);
					$end_date_time = strtotime($val->end_date_time);
					if ($end_date_time != "") {
						if ($end_date_time >= $start_date_time) {
							$total_time = $end_date_time - $start_date_time;
						} else {
							$total_time = $start_date_time - $end_date_time;
						}
					} else {
						$end_date_time = 0;
						$total_time = 0;
					}

//					$private_notes = array();
//					$this->db->select('*');
//					$this->db->from('sessions_cust_briefcase');
//					$this->db->where(array("user_id" => $val->cust_id, "sessions_id"=>$sessions_id));
//					$sessions_cust_briefcase = $this->db->get();
//					if ($sessions_cust_briefcase->num_rows() > 0) {
//						foreach ($sessions_cust_briefcase->result() as $note_row)
//							$private_notes[] = $note_row->note;
//						//$private_notes = $sessions_cust_briefcase->row()->note;
//					}

					$sessions_history_login[] = array(
						'uuid' => $val->user_id,
						'access' => 50,
						'created_time' => $start_date_time,
						'last_connected' => $end_date_time,
						'total_time' => $total_time,
						//'total_time' => $this->getTimeSpentOnSession($sessions_id, $val->cust_id),
						'meta' => array("notes" => null, "personal_slide_notes" => array()),
						'alertness' => array("checks_returned" => "", "understood" => ""),
						'browser_sessions' => array("0" => array("uuid" => $val->user_id, "launched_time" => $start_date_time, "last_connected" => $end_date_time, "user_agent" => $val->os . ' - ' . $val->browser)),
						'identity' => array("uuid" => $val->user_id, 'identifier' => $val->user_id, 'name' => $val->name . ' ' . $val->surname, 'email' => $val->email, 'profile_org_name' => null, 'profile_org_title' => null, 'profile_org_website' => "", 'profile_bio' => $val->bio, 'profile_twitter' => "", 'profile_linkedin' => "", 'profile_country' => $val->country, 'profile_picture_url' => "", 'profile_last_updated' => ""),
						'state_changes' => array("0" => array("timestamp" => 1592865240, "state" => 0))
					);
				}
			}

			$this->db->select('*');
			$this->db->from('session_polls s');
//			$this->db->join('poll_type p', 's.poll_type_id=p.poll_type_id');
			$this->db->where("s.session_id", $sessions_id);
			$sessions_poll_question = $this->db->get();
			$polls = array();

			if ($sessions_poll_question->num_rows() > 0) {
				$presurvey = 0;
				$poll = 0;
				$assessment = 0;
				foreach ($sessions_poll_question->result() as $sessions_poll_question) {
					$options = array();
					$this->db->select('*');
					$this->db->from('session_poll_options');
					$this->db->where("poll_id", $sessions_poll_question->id);
					$poll_question_option = $this->db->get();
					if ($poll_question_option->num_rows() > 0) {
						foreach ($poll_question_option->result() as $val) {
//							print_r($val);exit;
							$votes = array();
							$this->db->select('*');
							$this->db->from('session_poll_answers');
							$this->db->where("answer_id", $val->id);
							$tbl_poll_voting = $this->db->get();
							if ($tbl_poll_voting->num_rows() > 0) {
								foreach ($tbl_poll_voting->result() as $tbl_poll_voting) {
									if($this->is_random_guest($tbl_poll_voting->user_id)){
										$votes[] = (int) $tbl_poll_voting->user_id;
									}
								}
							}
							$options[] = array(
								'option_id' => (int) $val->id,
								'external_reference' => $val->external_reference,
								'text' => $val->option_text,
								'total_votes' => ($this->db->select('*')->from('session_poll_answers')->where('answer_id', $val->id)->get()->num_rows()),
								'votes' => $votes
							);

							$total_votes = 0;
							$this->db->select('*');
							$this->db->from('session_poll_answers');
							$this->db->where("poll_id", $val->poll_id);
							$tbl_poll_voting_2 = $this->db->get();
							if ($tbl_poll_voting_2->num_rows() > 0) {
								$total_votes = $tbl_poll_voting_2->num_rows();
							}
						}
					}
					if ($sessions_poll_question->poll_type == 'presurvey') {
						$presurvey = $presurvey + 1;
						$polls[] = array(
							'uuid' => '',
							'status' => 4000,
							'external_reference' => $sessions_poll_question->external_reference,
							'poll_id' => (int) $sessions_poll_question->id,
							'text' => $sessions_poll_question->poll_question,
							'options' => $options,
							'total_votes' => $total_votes,
							'response_type' => 0,
							'text_responses' => array()
						);
					} else if ($sessions_poll_question->poll_type == 'poll') {
						$poll = $poll + 1;
						$polls[] = array(
							'uuid' => '',
							'text' => $sessions_poll_question->poll_question,
							'status' => 4000,
							'external_reference' => $sessions_poll_question->external_reference,
							'poll_id' => (int) $sessions_poll_question->id,
							'options' => $options,
							'total_votes' => $total_votes,
							'response_type' => 0,
							'text_responses' => array()
						);
					} else if ($sessions_poll_question->poll_type == 'assessment') {
						$assessment = $assessment + 1;
						$polls[] = array(
							'uuid' => '',
							'status' => 4000,
							'external_reference' => $sessions_poll_question->external_reference,
							'poll_id' => (int) $sessions_poll_question->id,
							'text' => $sessions_poll_question->poll_question,
							'options' => $options,
							'total_votes' => $total_votes,
							'response_type' => 0,
							'text_responses' => array()
						);
					}
				}
			}


			$this->db->select('*');
			$this->db->from('session_questions');
			$this->db->where("session_id", $sessions_id);
			$sessions_cust_question = $this->db->get();
			$questions = array();
			if ($sessions_cust_question->num_rows() > 0) {
				foreach ($sessions_cust_question->result() as $key => $val) {
					$questions[] = array(
						'uuid'=>$val->user_id,
						'index' => (int) $key,
						'login' => (int) $val->user_id,
						'body' => $val->question,
						'timestamp' => strtotime($val->asked_on),
						'upvotes'=>array()
//                        'question' => $val->question,
//                        'reply_login_id' => ($val->answer_by_id != "") ? $val->answer_by_id : "",
//                        'reply' => ($val->answer != "") ? $val->answer : ""
					);
				}
			}
			$charting[] = array(
				'online' => 0,
				'timestamp' => 0,
				'total_logins' => 0
			);

			$this->db->select('*');
			$this->db->from('session_host_chat');
			$this->db->where("session_id", $sessions_id);
			$sessions_group_chat_msg = $this->db->get();
			$messages = array();
			if ($sessions_group_chat_msg->num_rows() > 0) {
				foreach ($sessions_group_chat_msg->result() as $key => $val) {
					$messages[] = array(
						'uuid' => $val->from_id,
						'login' => $val->from_id,
						'timestamp' => strtotime($val->date_time),
						'message' => $val->message,
						'status' => 0,
						'is_positive' => FALSE,
						'deleted_reason' => 0
					);
				}
			}

			$this->db->select('*');
			$this->db->from('session_resources');
			$this->db->where("session_id", $sessions_id);
			$session_resource = $this->db->get();
			$files = array();
			$hyperlinks = array();
			if ($session_resource->num_rows() > 0) {
				foreach ($session_resource->result() as $key => $val) {
					$files[] = array(
						'uuid' => "",
						'name' => $val->resource_name,
						'about' => "",
						'size' => 1000,
						'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
					);
					$hyperlinks[] = array(
						'uuid' => "",
						'name' => "",
						'url' => $val->resource_path,
						'clicks' =>array(array('login'=>"",'player_timestamp'=>"",'eos_timestamp'=>""))
					);
				}
			}



			$create_array = array(
				'actual_end_time' => strtotime($result_sessions->end_date_time),
				'cssid' => $result_sessions->event_id,
				'end_time' => strtotime($result_sessions->end_date_time),
				'name' => $result_sessions->name,
				'reference' => $result_sessions->id,
				'session_id' => (int) $result_sessions->id,
				'start_time' => strtotime($result_sessions->start_date_time),
				'logins' => $sessions_history_login,
				'alertness' => array('count' => 0, 'checks' => array(), 'template' => array('alertness_template_id' => 1, 'name' => "", 'feature_name' => "", 'briefing_preface' => "", 'briefing_text' => "", 'briefing_accept_button' => "", 'briefing_optout_enabled' => "", 'prompt_title' => "", 'prompt_text' => "", 'prompt_audio_file' => "", 'prompt_duration' => "", 'show_failure_notifications' => "", 'aai_variance' => "", 'aai_starting_boundary' => "", 'aai_ending_boundary' => "", 'aai_setup_delay' => "")),
				'chat' => array('enabled' => true,'messages' => $messages),
				'hostschat' => array('messages' => $messages),
				'jpc' => array('conversations' => array()),
				'presentation' => array('decks' => array(array("uuid"=>"","name"=>"","thumbnail_url"=>'',"slides"=>array("image_url"=>"","index"=>"","notes"=>"",'title'=>"","thumbnail_url"=>"","uuid"=>""))), 'slide_events' => array(array("slide_uuid"=>"","timestamp"=>""))),
				'polling' => array("enabled" => true, "polls" => $polls),
				'questions' => array("enabled"=>true,'submitted'=>$questions),
				'resources'=>array("files"=>$files,'hyperlinks'=>$hyperlinks),
				'charting' => $charting
			);


			$json_array = array("data" => json_encode($create_array), "session_reference" => (int) $result_sessions->id, "session_id" => (int) $result_sessions->id, "source" => "gravity");

			$data_to_post = "data:" . json_encode($create_array) . "&session_reference=" . (int) $result_sessions->id . "&session_id=" . (int) $result_sessions->id . "&source=gravity"; //if http_build_query causes any problem with JSON data, send this parameter directly in post.
		
			$url = "https://omni-channel-api-prod.herokuapp.com/gravity/gravitypostback";
			// $url ='';
			// print_R($url);exit;
			// print_r($url);exit;
			$headers = array(
				'Content-Type:application/json',
				'Accept: application/json'
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($json_array));
			$result = curl_exec($ch);
			curl_close($ch);
			$result = json_encode($result);
			
			if ($result == 1) {
				return $result;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	function is_random_guest($user_id){
		$result = $this->db->select('*')->from('user')->where(['id'=>$user_id, 'is_random_guest'=>0])->get();
		if($result->num_rows() > 0) {
			return true;
		}
		return '';
	}

	function updateShowedResult($poll_id){
		$this->db->select('*')
		->where('id', $poll_id)
		->update('session_polls', array('is_result_showed'=>'1'));
		return $this->db->affected_rows();
	}

	function update_closed_poll($poll_id){
		$this->db->select('*')
			->where('id', $poll_id)
			->update('session_polls', array('is_poll_closed'=>'1'));
		return $this->db->affected_rows();
	}

	function update_closed_poll_result($poll_id){
		$this->db->select('*')
			->where('id', $poll_id)
			->update('session_polls', array('is_result_closed'=>'1'));
		return $this->db->affected_rows();
	}

	function redoPoll($poll_id){
		try{
			$this->db->update("session_polls", array("is_result_showed" => 0, "is_launched" => 0, 'is_result_closed' => 0, 'is_poll_closed'=>0), array("id" => $poll_id));
			$this->db->delete("session_poll_answers", array("poll_id" => $poll_id));
		}catch (\Exception $e){
			return json_encode(array('status'=>'error', 'result'=>$e));
		}
		return json_encode(array('status'=>'success','result'=> 1));
	}

	function removePoll($poll_id){
		$this->db->delete("session_polls", array("id" => $poll_id));
		$this->db->delete("session_poll_options", array("poll_id" => $poll_id));
		$this->db->delete("session_poll_answers", array("poll_id" => $poll_id));

		return json_encode(array('status'=>'success', 'result'=>$this->db->affected_rows()));
	}

	function getPollsBySession($session_id){
		$result = $this->db->select('*')
			->from('session_polls')
			->where('session_id', $session_id)
			->get();

		if($result){
			$poll_options_array = array();
			foreach($result->result() as $polls){
				$polls->options = $this->getPollOptions($polls->id);
				$poll_options_array[] = $polls;
			}
			return $poll_options_array;
		}


		return '';
	}

	public function askarepReport($session_id){
		$rep = $this->db->select('a.*,CONCAT(u.name, " ", u.surname) AS user_name')
			->from('ask_a_rep a')
			->join('user u', 'a.user_id = u.id', 'left')
			->where('session_id', $session_id)
			->where('project_id', $this->project->id)
			->get();

		if($rep->num_rows() >0)
			return json_encode(array('status'=>'success','result'=>$rep->result()));
		else
			return '';

	}

	public function clearJson($session_id){
		try {
			$this->db->trans_begin();
			$this->deleteSessionLogHistory($session_id);
			$this->deleteSessionQuestion($session_id);
			$this->deleteSessionHostChat($session_id);
			$this->deleteTotalTimeOnSession($session_id);
			$this->deletePoll($session_id);

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				echo json_encode(array('status' => 'failed', 'reason' => $this->db->error()));
			} else {
				$this->db->trans_commit();
				echo json_encode(array('status' => 'success'));

			}
		}catch (\Exception $e){
			echo json_encode(array('status' => 'failed', 'reason' => $e));
		}

	}
	 public function deleteSessionLogHistory($session_id){
//		$this->db->select('*');
		$this->db->from('logs');
		$this->db->where("ref_1", $session_id);
		$this->db->where("project_id", $this->project->id);
		$this->db->where("name", "Attend");
		$this->db->where("info", "Session View");
		$this->db->delete();
	}

	function deleteSessionQuestion($session_id){
		$question = $this->db->select('*')
			->from('session_questions')
			->where('session_id', $session_id)
//			->where('project_id', $this->project->id)
			->get();

		if($question->num_rows() > 0){
			foreach ($question->result() as $item){
				$this->deleteSessionFavQuestion($item->id);
				$this->deleteSessionStashedQuestion($item->id);
			}
			$this->db->where('session_id', $session_id);
			$this->db->delete("session_questions", array("session_id" => $session_id));
		}
	}

	function deleteSessionHostChat($session_id){
		$this->db->delete("session_host_chat", array("session_id" => $session_id));
	}


	function deleteSessionFavQuestion($question_id){
		$this->db->delete("session_question_saved", array("question_id" => $question_id));
	}
	function deleteSessionStashedQuestion($question_id){
		$this->db->delete("session_question_stash", array("question_id" => $question_id));
	}

	function markQuestionReplied($question_id)
    {
        $data = array(
            'id' => $question_id
        );

        $this->db->where($data);
        $this->db->update('session_questions', array('marked_replied'=>1));

        if ($this->db->affected_rows() > 0)
           return true;
        else
             return false;
    }
	
	function deleteTotalTimeOnSession($session_id){
		$this->db->delete("total_time_on_session", array("session_id" => $session_id));
	}
	function deletePoll($session_id){
		$result = $this->db->select('*')
			->from('session_polls')
			->where('session_id', $session_id)
			->get();

		if($result->num_rows()>0){
			foreach ($result->result() as $item){
				$this->deletePollAnswerByPoll($item->id);
			}
			$this->db->where('session_id', $session_id);
			$this->db->update('session_polls', array('is_launched'=>'0', 'is_poll_closed'=>'0', 'is_result_showed'=>'0'));
		}
	}

	function deletePollOptionByPoll($poll_id){
		$this->db->delete("session_poll_options", array("poll_id" => $poll_id));
	}
	function deletePollAnswerByPoll($poll_id){
		$this->db->delete("session_poll_answers", array("poll_id" => $poll_id));
	}

}
