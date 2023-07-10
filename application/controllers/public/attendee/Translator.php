<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translator extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if
		(
			!isset($_SESSION['project_sessions']["project_{$this->project->id}"]) ||
			(
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_presenter'] != 1 &&
				$_SESSION['project_sessions']["project_{$this->project->id}"]['is_moderator'] != 1
			)
		)redirect(base_url().$this->project->main_route."/presenter/login"); // Not logged-in

		$this->user = (object) ($_SESSION['project_sessions']["project_{$this->project->id}"]);

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
		// echo "<pre>";
		// var_dump($selectedLanguage);
		// die();
		
		$xdata = $this->translate->updateUserLanguage($selectedLanguage);
		echo json_encode($xdata);
	}

	public function test() {
			echo json_encode(123);
	}

	
}
