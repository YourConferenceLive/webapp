<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translator extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if (!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) || $_SESSION['project_sessions']["project_{$this->project->id}"]['is_admin'] != 1)
			redirect(base_url() . $this->project->main_route . "/admin/login"); // Not logged-in

		$this->user = (object)($_SESSION['project_sessions']["project_{$this->project->id}"]);

		$this->load->model('admin/Sponsors_Model', 'sponsors');
		$this->load->model('Users_Model', 'users');
		$this->load->model('Settings_Model', 'settings');
		$this->load->model('Translator_Model', 'translate');
	}
	
    public function initializeUserLanguageSetting() {
        $xdata = $this->translate->getUserLanguage();
        echo json_encode($xdata);
    }

	public function getEnglishToSpanishData() {
		$originalText = $_GET['originalText'];
		$language = $_GET['language'];
		
		$xdata = $this->translate->getTranslatedData($language, $originalText);
		echo json_encode($xdata);
	}

	public function getTextData() {
		$xdata = $this->translate->getTextData();
		echo json_encode($xdata);
	}

    public function updateUserLanguage() {
		$selectedLanguage = $_POST['selectedLanguage'];
		
		$xdata = $this->translate->updateUserLanguage($selectedLanguage);
		echo json_encode($xdata);
	}

   

	
}
