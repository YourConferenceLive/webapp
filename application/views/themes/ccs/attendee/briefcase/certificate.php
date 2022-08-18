<?php
error_reporting(E_ERROR);
define('PROJECT_ID', $this->project->id);
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
		$header = 'cms_uploads'.DIRECTORY_SEPARATOR.'projects'.DIRECTORY_SEPARATOR.PROJECT_ID.DIRECTORY_SEPARATOR.'theme_assets/ccs/ccs/ccs'.DIRECTORY_SEPARATOR.'briefcase'.DIRECTORY_SEPARATOR.'pdf-header.jpg';
        $this->Image($header, 0, 0, 210, '', 'JPG', '', 'B', false, 300, '', false, false, 0, false, false, false);
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+35, PDF_MARGIN_RIGHT);
	}

    // Page footer
    public function Footer() {
		/* Put your code here (see a working example below) */
		$footer 		= 'cms_uploads'.DIRECTORY_SEPARATOR.'projects'.DIRECTORY_SEPARATOR.'3'.DIRECTORY_SEPARATOR.'theme_assets/ccs/ccs/ccs'.DIRECTORY_SEPARATOR.'briefcase'.DIRECTORY_SEPARATOR.'pdf-footer.png';

		$footerWidth 	= 210;
		$footerX 		= 0; 
		$footerY 		= 260;

		$this->Image($footer, $footerX, $footerY, $footerWidth);

		// $this->SetX(-18);

		// $this->Cell(0, 0, $footerBG, 0, 0, 'C');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('COS - YCL');
$pdf->SetTitle('Accreditation Certificate - '.$user['name'].' '.$user['surname']);
$pdf->SetSubject('Accreditation Certificate');
$pdf->SetKeywords(implode(array($user['name'].' '.$user['surname'], 'COS', 'YCL', 'Accreditation', 'Certificate')));

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT-10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT-10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// create some HTML content
$styles = '<style>*{color:#000000;}p.doc-heading{font-weight:bold;text-decoration:underline;}p{padding:0px;line-height:1.5; margin:0px;}.text-center{text-align:center;}.french{color:#284050}.candidate_name{font-weight:bold;}</style>';
$html = $styles.'<p class="doc-heading"><i>CERTIFICATE OF ATTENDANCE - ATTESTATION DE PARTICIPATION</i></p>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'C', true);

$html = $styles.'<br><br>This is the official attestation of your attendance at the 2021 COS Annual Meeting June 24 – 27<br><span class="french">Voici l&#39;attestation officielle de votre participation au Congrès annuel 2020 de la SCO le 24 au 27 juin</span>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'C', true);

$html = $styles.'<br><br><strong>Name/<span class="french">Nom</span>:<span="candidate_name"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$user['name'].' '.$user['surname'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span></strong>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'C', true);

$html = $styles.'<br><br>
<table>
	<tr>
		<td style="width:20%"></td>
		<td style="width:60%">
			<table border="1" cellspacing="0" cellpadding="5" width="100%" style="margin:0 auto;">
			    <tr>
			        <th align="center" width="60%">Date</th>
			        <th align="center">Maximum Hours<br><span class="french">Heures Maximum</span></th>
			    </tr>
			    <tr>
			        <td align="center">Thursday June 24 / <span class="french">Jeudi 24 juin</span></td>
			        <td align="center">5</td>
			    </tr>
			    <tr>
			        <td align="center">Friday June 25 / <span class="french">Vendredi 25 juin</span></td>
			        <td align="center">7</td>
			    </tr>
			    <tr>
			        <td align="center">Saturday June 26 / <span class="french">Samedi 26 juin</span></td>
			        <td align="center">5.5</td>
			    </tr>
			    <tr>
			        <td align="center">Sunday June 27 / <span class="french">Dimanche 27 juin</span></td>
			        <td align="center">6</td>
			    </tr>
			</table>
		</td>
		<td style="width:20%"></td>
	</tr>
</table>';
$pdf->writeHTML($html, true, false, true, false, '');

$html = $styles.'
<u>MOC Section 1</u><br>
The 2021 COS Annual Meeting is an Accredited Group Learning activity under Section 1 as defined by the Maintenance of Certification Program of the Royal College of Physician and Surgeons of Canada (RCPSC) and approved by the Canadian Ophthalmological Society. Participants may claim up to 23.5 hours.<br><br>
<span class="french">Le congrès annuel 2021 de la SCO constitue une activité d\'apprentissage collectif agréée conformément à la définition précisée dans le programme de Maintien du certificat du Collège royal des médecins et chirurgiens du Canada (CRMCC); elle a été approuvée par la Société canadienne d\'ophtalmologie. Les participants peuvent cumuler des crédits par heure de participation au congrès, jusqu\'à concurrence de 19 heures.</french><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

$html = $styles.'<br>
<u>AMA PRA category 1</u><br>
Through an agreement between the American Medical Association and the RCPSC, the 2020 COS Annual Meeting, as a live educational activity, qualifies for AMA PRA category 1 credits.<br><br>
<span class="french">Conformément à une entente entre l\'AMA et le CRMCC, les médecins qui assisteront au congrès annuel de la SCO 2020 pourront accumuler des crédits PRA de catégorie 1 de l\'AMA puisqu\'il s\'agit d\'une activité éducative interactive.</span><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

$html = $styles.'<br>
<u>UEMS for ECMEC</u><br>
Live educational activities, occurring in Canada, recognized by the Royal College of Physicians and Surgeons of Canada as Accredited Group Learning Activities (Section 1) are deemed by the European Union of Medical Specialists eligible for ECMEC®.<br><br>
<span class="french">Les activités éducatives tenues au Canada et reconnues par le Collège royal des médecins et chirurgiens du Canada comme des activités d\'apprentissage collectif agréées (section 1) sont réputées admissibles à des crédits européens de formation médicale continue par l\'Union européenne des médecins spécialistes.</span><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

// add a page
$pdf->AddPage();

$html = $styles.'<br>
<u>Co-developed Symposia</u><br>
<i>The Lion\'s Lair:</i> Retina Research Proposals was co-developed with COS and Bayer and was planned to achieve scientific integrity, objectivity and balance.<br><br>
<i>Glaucoma 2021:</i> Back to the Future was co-developed with COS and Allergan/AbbVie and was planned to achieve scientific integrity, objectivity and balance.<br><br>
<span class="french">La séance entitulé Dans <i>l\'antre du lion</i> : propositions novatrices de recherche en rétine a été élaboré conjointement avec la SCO et Bayer de manière à respecter les principes d\'intégrité, d\'objectivité et d\'équilibre scientifiques.<br><br>
La séance entitulé <i>Glaucome 2021</i> : retour vers le futur a été élaboré conjointement avec la SCO et Allergan/AbbVie de manière à respecter les principes d\'intégrité, d\'objectivité et d\'équilibre scientifiques.</span><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

$html = $styles.'<br>
<u>Section 2</u><br>
Learning from poster presentations may be claimed as a Scanning Activity under Section 2, as defined by the RCPSC. You may claim 0.5 credits per poster with a documented learning outcome.<br><br>
<span class="french">Le temps passé à l\'étude d\'affiches peut être inscrit à titre d\'activité d\'analyse de section 2. Les participants peuvent inscrire 0,5 crédit par affiche s\'ils ont consigné le résultat d\'apprentissage.</span><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

$html = $styles.'<br>
<u>Section 3</u><br>
The Skills Transfer Courses (STCs) are Accredited Self-Assessment Programs (Section 3) as defined by the Maintenance of Certification Program of the Royal College of Physicians and Surgeons of Canada, and approved by Canadian Ophthalmological Society. You may claim a maximum of 1.25 – 1.75 hours per STC (credits are automatically calculated).<br><br>
<span class="french">Les Cours de transfert de compétences sont programmes d\'autoévaluation agréé (section 3), au sens que lui donne le programme de Maintien du certificat du Collège royal des médecins et chirurgiens du Canada; elle a été approuvés par la Société canadienne d\'ophtalmologie. Vous pouvez déclarer un maximum de 1,25 à 1,75 crédit chacun heures (les crédits sont calculés automatiquement).</span><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

$html = $styles.'<br>
<u>TCOS – COC – JCAHPO</u><br >
TCOS Workshop | Atelier LSCO COC CE: 3.6 credits, JCAHPO: 3.0 credits<br>
<span class="french">TCSO Scientific Session | Séance scientifique LSCO : COC CE: 4.1 credits, JCaHPO: 3.75 credits</span><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

$signaute 		= 'cms_uploads'.DIRECTORY_SEPARATOR.'projects'.DIRECTORY_SEPARATOR.'3'.DIRECTORY_SEPARATOR.'theme_assets/ccs/ccs/ccs'.DIRECTORY_SEPARATOR.'briefcase'.DIRECTORY_SEPARATOR.'pdf-signature.jpg';

$html = $styles.'<br><br><br>
<img src="'.$signaute.'" width="150">';
$pdf->writeHTMLCell(0, 0, '', '', $html, 'B', 1, 0, true, 'C', true);

$html = $styles.'<br>Hady Saheb, MD<br>
Chair, Maintenance of Certification committee<br>
<span class="french">Président, Comité de maintien du certificat</span><br>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'C', true);

// add a page
$pdf->AddPage();

$totalEntities 	= 0;
$totalRows 		= 0;

$header_array 	= array();

if ($sessions != new stdClass()) {
	$header_array[$totalEntities] = array('heading' 		=> 'Section 1 - Group Learning',
										  'sub_heading_1' 	=> 'Session Title',
										  'sub_heading_2' 	=> 'Number of Hours');
	$totalEntities++;
	$sessionCount = sizeof($sessions);
	$totalRows 	  = $totalRows+$sessionCount;
}

if ($eposters != new stdClass()) {
	$header_array[$totalEntities] = array('heading' 		=> 'Section 2 - Self - Learning',
										  'sub_heading_1' 	=> 'ePoster/Surgical Video Title',
										  'sub_heading_2' 	=> '');
	$totalEntities++;
	$eposterCount = sizeof($eposters);
	$totalRows 	  = $totalRows+$eposterCount;
}

if ($stcs != new stdClass()) {
	$header_array[$totalEntities] = array('heading' 		=> 'Section 3 - Practice Assessment',
										  'sub_heading_1' 	=> 'STC Title',
										  'sub_heading_2' 	=> '');
	$totalEntities++;
	$stcCount 	  = sizeof($stcs);
	$totalRows 	  = $totalRows+$stcCount;
}

if ($totalEntities > 0) {

$html = $styles.'<strong>Summary of Credits</strong>';
$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'C', true);
$rowCount = 1;
$rowsPerPage = 30;
$html = '<br><br>
<table>
	<tr>
		<td style="width:5%"></td>
		<td style="width:90%">
			<table border="1" cellpadding="5" cellspacing="0">';
	for ($main = 0; $main < $totalEntities; $main++) {

		if ($rowCount >= $rowsPerPage) {
			$rowCount = 1;
			$html .= '</table>
</td>
<td style="width:5%"></td>
</tr>
</table>';
			$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

			$pdf->AddPage();
			$html = '<table>
<tr>
<td style="width:5%"></td>
<td style="width:90%">
	<table border="1" cellpadding="5" cellspacing="0">';
		}
		// for table headers
		$html .= '<tr><td'.(($main == 0) ? ' width="80%"' : '' ).' style="background-color:#e7e6e6; font-weight:bold;">'.$header_array[$main]['heading'].'</td><td'.(($main == 0) ? ' width="20%"' : '' ).' style="background-color:#e7e6e6; font-weight:bold;"></td></tr>';
		$html .= '<tr><td style="background-color:#e7e6e6; font-weight:bold;">'.$header_array[$main]['sub_heading_1'].'</td><td align="center" style="background-color:#e7e6e6; font-weight:bold;">'.$header_array[$main]['sub_heading_2'].'</td></tr>';
		$rowCount = $rowCount+2;
		if ($header_array[$main]['heading'] == 'Section 1 - Group Learning' && $sessionCount > 0) {
			foreach ($sessions as $session) {
				$html .= '<tr><td width="80%">'.$session->name.'</td><td width="20%" align="center">'.$session->credit.'</td></tr>';
				$rowCount = $rowCount+(ceil(strlen($session->name)/85));

				if ($rowCount >= $rowsPerPage) {
					$rowCount = 1;
					$html .= '</table>
		</td>
		<td style="width:5%"></td>
	</tr>
</table>';
					$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

					$pdf->AddPage();
					$html = '<table>
	<tr>
		<td style="width:5%"></td>
		<td style="width:90%">
			<table border="1" cellpadding="5" cellspacing="0">';
				}
			}
			$html .= '<tr><td>&nbsp;</td><td align="center"></td></tr><tr><td>&nbsp;</td><td align="center"></td></tr>';
			$rowCount = $rowCount+2;
		}

		if ($header_array[$main]['heading'] == 'Section 2 - Self - Learning' && $eposterCount > 0) {
			foreach ($eposters as $eposters) {
				$html .= '<tr><td width="80%">'.$eposters->title.'</td><td width="20%" align="center">'.$eposters->credit.'</td></tr>';
				$rowCount = $rowCount+(ceil(strlen($eposters->title)/85));

				if ($rowCount >= $rowsPerPage) {
					$rowCount = 1;
					$html .= '</table>
		</td>
		<td style="width:5%"></td>
	</tr>
</table>';
					$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

					$pdf->AddPage();
					$html = '<table>
	<tr>
		<td style="width:5%"></td>
		<td style="width:90%">
			<table border="1" cellpadding="5" cellspacing="0">';
				}
			}
			$html .= '<tr><td>&nbsp;</td><td align="center"></td></tr><tr><td>&nbsp;</td><td align="center"></td></tr>';
			$rowCount = $rowCount+2;
		}

		if ($header_array[$main]['heading'] == 'Section 3 - Practice Assessment' && $stcCount > 0) {
			foreach ($stcs as $stc) {
				$html .= '<tr><td width="80%">'.$stc->name.'</td><td width="20%" align="center">'.$stc->credit.'</td></tr>';
				$rowCount = $rowCount+(ceil(strlen($stc->name)/85));

				if ($rowCount >= $rowsPerPage) {
					$rowCount = 1;
					$html .= '</table>
		</td>
		<td style="width:5%"></td>
	</tr>
</table>';
					$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

					$pdf->AddPage();
					$html = '<table>
	<tr>
		<td style="width:5%"></td>
		<td style="width:90%">
			<table border="1" cellpadding="5" cellspacing="0">';
				}
			}
			$html .= '<tr><td>&nbsp;</td><td align="center"></td></tr><tr><td>&nbsp;</td><td align="center"></td></tr>';
			$rowCount = $rowCount+2;
		}
	}
	$html .= '</table>
		</td>
		<td style="width:5%"></td>
	</tr>
</table>';
} else {
	$html = '<div style="background-color:yellow; padding:10px; text-align:center; font-weight:bold; text-transform:uppercase;"><br><br><br>Unfortunately, you don\'t qualify for this certificate yet.<br><br><br></div>';
}

$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'L', true);

// reset pointer to the last page
$pdf->lastPage();

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output(trim($user['name']).'-'.$user['surname'].'-Accreditation-Certificate-'.date('m/d/YH:i:s', strtotime('now')).'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
