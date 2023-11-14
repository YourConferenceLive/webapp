<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translator_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);
	}

    // Create save function for savingSelected language by userId
    public function addUserLanguage() {
        $id = $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'];

        $data = array('userid' 		=> $this->user['user_id'],
					  'user_id' 		=> $id,
					  'created_datetime' 	=> date('Y-m-d H:i:s'));

		if ($this->db->insert('user_language_settings', $data)) {
			return true;
		} else {
			return false;
		}
    }

    public function getUserLanguage() {
        $id = $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'];
        $this->db->select('uls.language');
        $this->db->from('user_language_settings uls');
        $this->db->where('uls.userid', $id);
        $this->db->order_by('CHAR_LENGTH(uls.language)', 'DESC');
        
        $sessions = $this->db->get();
        
        if ($sessions->num_rows() > 0)
		{
			return $sessions->result();
		}
        return false;
    }

    // create get function for retrieving Selected language by id

    public function getTranslatedData($language, $original_text) {
        if($language == "spanish") {
            $this->db->select('esl.spanish_text');
            $this->db->from('english_spanish_lang esl');
            $this->db->where('esl.english_text', $original_text);
        } else if($language == "english") {
            $this->db->select('esl.english_text');
            $this->db->from('english_spanish_lang esl');
            $this->db->where('esl.spanish_text', $original_text);
        }

		$sessions = $this->db->get();

        if ($sessions->num_rows() > 0)
		{
			return $sessions->result();
		}
        return false;

    }

    public function getTextData() {
        $this->db->select('esl.english_text, esl.spanish_text');
        $this->db->from('english_spanish_lang esl');

		$sessions = $this->db->get();

        if ($sessions->num_rows() > 0)
		{
			return $sessions->result();
		}
        return false;

    }

    public function updateUserLanguage($language) {
        $xretobj = array();
        $id = $_SESSION['project_sessions']["project_{$this->project->id}"]['user_id'];

        if($this->getUserLanguage() == true){
            $data = array('language' => $language); 

            $this->db->where('userid', $id); 
            $this->db->update('user_language_settings', $data);
            $result = $this->db->affected_rows();
            
            if($result > 0)
            {
                $xretobj['bool'] = true;
                $xretobj['msg'] = "update success.";
            }
            else
            {
                $xretobj['bool'] = false;
                $xretobj['msg'] = "update fail.";
            }
        }
        else {
            // insert the new language here
            $xretobj['bool'] = false;
            $xretobj['msg'] = "create insert language first.";

            $data = array(
                'userid'=>$id,
                'language'=>$language,
                'added_datetime'=>date('Y-m-d H:i:s')
            );
            $this->db->insert('user_language_settings', $data);
            if($this->db->insert_id()){
                $xretobj['bool'] = true;
                $xretobj['msg'] = "Language setting created.";
            }
            else
            {
                $xretobj['bool'] = false;
                $xretobj['msg'] = "Fail to create language setting.";
            }
        }

        return $xretobj;
    }
}
