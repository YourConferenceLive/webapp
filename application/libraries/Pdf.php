<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
	function __construct()
	{
		parent::__construct();
	}
/*
	//Page header
    public function Header() {
        // Page background
        $image_file = 'cms_uploads'.DIRECTORY_SEPARATOR.'projects'.DIRECTORY_SEPARATOR.'3'.DIRECTORY_SEPARATOR.'theme_assets'.DIRECTORY_SEPARATOR.'briefcase'.DIRECTORY_SEPARATOR.'pdf-header.jpg';

		$this->Image($img_file, 5, 3, 50, 15, '', '', '', false, 300, '', false, false, 0);

    	$this->Rect(0, 0, $this->getPageWidth(), 20,'F',array(),array(30, 127, 184));

        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        // Set font
        // $this->SetFont('helvetica', 'B', 20);

        // Title
        // $this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY();

        // Set font
        $this->SetFont('helvetica', 'I', 8);

        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }*/
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
