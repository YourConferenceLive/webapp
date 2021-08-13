<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eposters_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();

		$this->user = $_SESSION['project_sessions']["project_{$this->project->id}"];
		$this->load->model('Logger_Model', 'logger');
	}

	public function getAll()
	{
		$this->db->select('eposters.*, eposter_tracks.track');
		$this->db->from('eposters');
		$this->db->join('eposter_tracks', 'eposter_tracks.id=eposters.track_id');
		$this->db->where('eposters.project_id', $this->project->id);
		// $this->db->limit(1);
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
		{
			foreach ($eposters->result() as $eposter)
				$eposter->authors = $this->getAuthorsPerEposter($eposter->id);

			return $eposters->result();
		}

		return new stdClass();
	}

	public function getAllPrizes()
	{
	    $row 	= $this->db->query(" SHOW COLUMNS FROM `eposters` LIKE 'prize'")->row()->Type;
	    $regex 	= "/'(.*?)'/";
	    preg_match_all($regex, $row, $enum_array);
	    $enum_fields = $enum_array[1];
	    if (sizeof($enum_fields))
	    	return( $enum_fields );

		return new stdClass();
	}

	public function getAllTypes()
	{
	    $row 	= $this->db->query(" SHOW COLUMNS FROM `eposters` LIKE 'type'")->row()->Type;
	    $regex 	= "/'(.*?)'/";
	    preg_match_all($regex, $row, $enum_array);
	    $enum_fields = $enum_array[1];
	    if (sizeof($enum_fields))
	    	return( $enum_fields );

		return new stdClass();
	}

	public function getAllEpostersByPresenter($author_id)
	{
		$this->db->select('eposters.*');
		$this->db->from('eposters');
		$this->db->join('eposter_authors', 'eposter_authors.eposter_id = eposters.id');
		$this->db->where('eposter_authors.author_id', $author_id);
		$this->db->where('eposters.project_id', $this->project->id);
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
			return $eposters->result();

		return new stdClass();
	}

	public function getById($id)
	{
		$this->db->select('*');
		$this->db->from('eposters');
		$this->db->where('id', $id);
		$this->db->where('project_id', $this->project->id);
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
		{
			$eposters->result()[0]->authors = $this->getAuthorsPerEposter($id);
			return $eposters->result()[0];
		}

		return new stdClass();
	}

	public function getAllTracks()
	{
		$this->db->select('*');
		$this->db->from('eposter_tracks');
		$this->db->where('project_id', $this->project->id);
		$this->db->where('status', 1);
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
			return $eposters->result();

		return new stdClass();
	}

	public function resizeImage($filename, $eposter_type)
	{
    	$source_path 	= FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/' . $filename;
      	$target_path 	= FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/thumbnails/';
      	$config_manip 	= array('image_library' => 'gd2',
      							'source_image' => $source_path,
      							'new_image' => $target_path,
      							'maintain_ratio' => TRUE,
      							'width' => 275,
      							'height' => 275);
		$this->load->library('image_lib', $config_manip);
		if (!$this->image_lib->resize()) {
			@unlink(FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/' . $filename);
			return array('status' 			=> 'failed',
						 'msg' 				=> 'Unable to upload the eposter photo', 
						 'technical_data' 	=> $this->image_lib->display_errors());
      	}

      	if ($eposter_type == 'surgical_video') {
			@unlink(FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/' . $filename);
      	}

		$this->image_lib->clear();
   }

	public function add()
	{

		$eposter_data = $this->input->post();
		// Upload eposter photo if set
		$eposter_photo = '';
		if (isset($_FILES['eposterPhoto']) && $_FILES['eposterPhoto']['name'] != '')
		{
			$photo_config['allowed_types']	= 'gif|jpg|png|jpeg';
			$photo_config['file_name'] 		= $eposter_photo = rand().'_'.str_replace(' ', '_', $_FILES['eposterPhoto']['name']);
			$photo_config['upload_path'] 	= FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/';

			$this->load->library('upload', $photo_config);
			if ( ! $this->upload->do_upload('eposterPhoto')):
				return array('status' 			=> 'failed',
							 'msg' 				=> 'Unable to upload the eposter photo', 
							 'technical_data' 	=> $this->upload->display_errors());
			else:
		        $uploadedImage = $this->upload->data();
		        $this->resizeImage($uploadedImage['file_name'], $eposter_data['eposterType']);
			endif;

		}

		$obj_created_datetime 	= new DateTime('NOW');
		$created_datetime 		= $obj_created_datetime->format('Y-m-d H:i:s');

		$obj_updated_datetime 	= new DateTime('NOW');
		$updated_datetime 		= $obj_updated_datetime->format('Y-m-d H:i:s');

		$data 	= array('project_id' 			=> $this->project->id,
						'title' 				=> $eposter_data['eposterName'],
						'credits' 				=> $eposter_data['eposterCredits'],
						'control_number' 		=> $eposter_data['eposterControlNumber'],
						'eposter' 				=> $eposter_photo,
						'track_id' 				=> $eposter_data['eposterTrack'],
						'type' 					=> $eposter_data['eposterType'],
						'prize' 				=> $eposter_data['eposterPrize'],
						'status' 				=> $eposter_data['eposterStatus'],
						'video_url' 			=> (($eposter_data['eposterType'] == 'surgical_video') ? $eposter_data['videoLink'] : '' ),
						'created_datetime' 		=> $created_datetime,
						'updated_datetime' 		=> $updated_datetime
		);

		$this->db->insert('eposters', $data);

		if ($this->db->affected_rows() > 0)
		{
			$eposter_id = $this->db->insert_id();

			$contact 	= 1;
			foreach ($eposter_data['eposterAuthors'] as $author_id)
			{
				$data 	= array('user_id' 			=> $author_id,
								'eposter_id' 		=> $eposter_id,
								'contact' 			=> $contact,
								'created_datetime' 	=> $created_datetime,
								'updated_datetime' 	=> $updated_datetime);

				$this->db->insert('eposter_authors', $data);
				$contact = 0;
			}

			return array('status' => 'success', 'eposter_id' => $this->db->insert_id());
		} else {
			if ($eposter_photo != '') {
				@unlink(FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/' . $eposter_photo);
				@unlink(FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/thumbnails/' . $eposter_photo);
			}
		}

		return array('status' => 'failed', 'msg' => 'Error occurred', 'technical_data'=> $this->db->error());

	}

	public function update()
	{
		$eposter_data = $this->input->post();

		if (!isset($eposter_data['eposterId']) || $eposter_data['eposterId'] == 0)
			return array('status' => 'failed', 'msg'=>'No eposter(ID) selected', 'technical_data'=>'');

		// Upload eposter photo if set
		$eposter_photo = '';
		if (isset($_FILES['eposterPhoto']) && $_FILES['eposterPhoto']['name'] != '')
		{
			$photo_config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$photo_config['file_name'] 		= $eposter_photo = rand().'_'.str_replace(' ', '_', $_FILES['eposterPhoto']['name']);
			$photo_config['upload_path'] 	= FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/';

			$this->load->library('upload', $photo_config);
			if (!$this->upload->do_upload('eposterPhoto')):
				print_r(array('status' 			=> 'failed',
							 'msg'				=> 'Unable to upload the eposter photo',
							 'technical_data'	=> $this->upload->display_errors()));

			else:
		        $uploadedImage = $this->upload->data();
		        $this->resizeImage($uploadedImage['file_name'], $eposter_data['eposterType']);
			endif;

			$data['eposter'] 					= $eposter_photo;
		}

		$data 	= array('project_id' 			=> $this->project->id,
						'title' 				=> $eposter_data['eposterName'],
						'credits' 				=> $eposter_data['eposterCredits'],
						'control_number' 		=> $eposter_data['eposterControlNumber'],
						'track_id' 				=> $eposter_data['eposterTrack'],
						'type' 					=> $eposter_data['eposterType'],
						'status' 				=> $eposter_data['eposterStatus'],
						'video_url' 			=> (($eposter_data['eposterType'] == 'surgical_video') ? $eposter_data['videoLink'] : '' ),
		);

		$this->db->set($data);
		$this->db->where('id', $eposter_data['eposterId']);

		if ($this->db->update('eposters'))
		{
			$eposter_id = $eposter_data['eposterId'];

			if (isset($eposter_data['eposterAuthors']))
			{
				$this->db->where('eposter_id', $eposter_id);
				$this->db->delete('eposter_authors');

				$contact 				= 1;
				$obj_created_datetime 	= new DateTime('NOW');
				$created_datetime 		= $obj_created_datetime->format('Y-m-d H:i:s');

				$obj_updated_datetime 	= new DateTime('NOW');
				$updated_datetime 		= $obj_updated_datetime->format('Y-m-d H:i:s');

				foreach ($eposter_data['eposterAuthors'] as $author_id)
				{
					$data 	= array('user_id' 			=> $author_id,
									'eposter_id' 		=> $eposter_id,
									'contact' 			=> $contact,
									'created_datetime' 	=> $created_datetime,
									'updated_datetime' 	=> $updated_datetime);

					$this->db->insert('eposter_authors', $data);
					$contact = 0;
				}
			}

			$eposter = $this->db->get_where('eposters', array('id'=>$eposter_data['eposterId']))->result()[0];

			return array('status' => 'success', 'eposter_id' => $eposter_data['eposterId'], 'eposter' => $eposter);
		}

		return array('status' => 'warning', 'msg' => 'No changes made', 'technical_data'=> $this->db->error());

	}

	public function getAllAuthors()
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->where('active', 1);
		$this->db->group_by('user.id');
		$this->db->order_by('user.surname', 'asc');
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
			return $eposters->result();

		return new stdClass();
	}

	public function removeEposter($eposter_id)
	{
		$this->db->select('eposter');
		$this->db->from('eposters');
		$this->db->where('id', $eposter_id);
		$this->db->where('project_id', $this->project->id);

		$eposters = $this->db->get();
		$eposter_image = '';

		if ($eposters->num_rows() > 0)
		{
			$row 			= $eposters->row_array();
			$eposter_image 	= $row['eposter'];
		}

		$this->db->where('id', $eposter_id);

		if ($this->db->delete('eposters') > 0) {
			@unlink(FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/thumbnails/' . $eposter_image);
			@unlink(FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/' . $eposter_image);
			return array('status' => 'success');
		}

		return array('status' => 'failed');
	}

	public function getAuthorsPerEposter($eposter_id)
	{
		$this->db->select('user.*');
		$this->db->from('user');
		$this->db->join('eposter_authors', 'eposter_authors.user_id = user.id');
		$this->db->where('eposter_authors.eposter_id', $eposter_id);
		$this->db->group_by('user.id');
		$this->db->order_by('user.name', 'asc');
		$eposters = $this->db->get();
		if ($eposters->num_rows() > 0)
			return $eposters->result();

		return new stdClass();
	}

	function downloadAllImages(){
		ini_set('set_time_limit', '3600');
		ini_set('max_execution_time',3600);
		ini_set('max_input_time','500');
		ini_set('memory_limit','512M');
		ini_set('upload_max_filesize', '3072M');
		ini_set('post_max_size', '3072M');

		$this->db->select('ep.*, ea.*, user.surname as author, et.track as track_name')
			->from('eposters ep')
			->join('eposter_authors ea', ' ep.id=ea.eposter_id')
			->join('user', 'ea.user_id=user.id')
			->join('eposter_tracks et', 'ep.track_id = et.id')
		;
		$eposter_result = $this->db->get();

		# create new zip opbject
		$zip = new ZipArchive();
		$tmp_file = tempnam('.','');
		$zip->open($tmp_file, ZipArchive::CREATE);

		$image_array = array();
		if($eposter_result->num_rows() > 0){
			foreach ($eposter_result->result() as $eposter_images){
				if($eposter_images->eposter != ''){
					if (file_exists(FCPATH.'cms_uploads/projects/'.$this->project->id.'/eposters/'.$eposter_images->eposter)) {
						$file = base_url().'cms_uploads/projects/'.$this->project->id.'/eposters/'.$eposter_images->eposter;
						# download file
						$download_file = file_get_contents( $file);
						#add it to the zip
						$zip->addFromString(basename($file),$download_file);
						$zip->renameName(basename($file), $eposter_images->title.'_'.$eposter_images->author.'_'.$eposter_images->track_name.'.jpg');
					}
				}
			}
			$zip->close();
			# send the file to the browser as a download
			header('Content-disposition: attachment; filename=COS_images.zip');
			header('Content-type: application/zip');
			readfile($tmp_file);

		}
	}



}


