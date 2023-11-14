<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Account_Model', 'account');
	}

	public function test()
	{
		echo "test";
	}

	public function register()
	{
		echo json_encode($this->account->register());
	}

	/**
	 * @throws PHPExcel_Exception
	 * @throws PHPExcel_Reader_Exception
	 *
	 * Column A = Name
	 * Column B = Surname
	 * Column C = Email
	 * Column D = Credentials
	 * Column E = Disclosures
	 */
	public function importUsers()
	{
		$file = FCPATH.'cms_uploads/temp/cos_presenters.xlsx'; // Hardcoded

		$this->load->library('excel');

		$objPHPExcel = PHPExcel_IOFactory::load($file);

		$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

		/** @var array $cell
		 * Get the data from spreadsheet file
		 */
		foreach ($cell_collection as $cell)
		{
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

			if ($row == 1) {
				$header[$column] = $data_value;
			} else {
				$rows[$row][$column] = $data_value;
			}
		}

		echo json_encode($this->account->importUsers($rows));

	}
}
