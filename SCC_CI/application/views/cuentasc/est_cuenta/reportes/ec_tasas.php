<?php
// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alcaldia SJV');
$pdf->SetTitle('Estado de cuenta');
$pdf->SetSubject('Tasas municipales');

// set default header data
$pdf->SetHeaderData('', 0, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 127);

//============================================================+
// BODY PDF DOCUMENT
//============================================================+
$fecha = date('d-m-Y');
$cuerpo_pdf = <<<OED
<h1 align="center">Estado de cuenta | Tasas municipales</h1><br/>
<label align="right"><strong>N°: </strong>$Encabezado->idestadocuenta</label><br/>
<label align="right"><strong>Emitido: </strong>$fecha</label><br/>
<label align="left"><strong>NC: </strong>$Encabezado->nc</label><br/>
<label align="left"><strong>Titular: </strong>$Encabezado->contribuyente</label><br/>
<label align="left"><strong>Dirección: </strong>$Encabezado->direccion</label><br/>
<label align="left"><strong>Propietario: </strong>$Encabezado->propietario</label><br/><br/>
<label align="left"><strong>Detalle del estado de cuenta: </strong></label>
OED;
$pdf->writeHTMLCell(0, 0, '', '', $cuerpo_pdf, 0, 1, 0, true, '', true);


$table = '<table style="border:none; padding:6px; font-size: 8px;">';
$table .= '<tr style="background-color:#D3D3D3">
				<th style="border:1px solid #000;" align="center" >Año</th>
				<th style="border:1px solid #000;" align="center"># Meses</th>
				<th style="border:1px solid #000;" align="center">Periodo</th>
				<th style="border:1px solid #000;" align="center">Alum</th>
				<th style="border:1px solid #000;" align="center">Aseo</th>
				<th style="border:1px solid #000;" align="center">Pavi</th>
				<th style="border:1px solid #000;" align="center">Tasa Mensual</th>
				<th style="border:1px solid #000;" align="center">Sub-Total</th>
				<th style="border:1px solid #000;" align="center">Multa</th>
				<th style="border:1px solid #000;" align="center">Interes</th>
		   </tr>';
foreach ($Detalle as $rw) {
    $table .= '<tr>
					<th style="border:1px solid #000;">' . $rw->anio . '</th>
					<th style="border:1px solid #000;">' . $rw->cnt_meses . '</th>
					<th style="border:1px solid #000;">' . $rw->periodo . '</th>
					<th style="border:1px solid #000;">' . $rw->alumbrado_ec . '</th>
					<th style="border:1px solid #000;">' . $rw->aseo_ec . '</th>
					<th style="border:1px solid #000;">' . $rw->pavimento_ec . '</th>
					<th style="border:1px solid #000;">' . $rw->mensualidad_ec . '</th>
					<th style="border:1px solid #000;">' . $rw->cobro_periodo . '</th>
					<th style="border:1px solid #000;">' . $rw->multa_parcial . '</th>
					<th style="border:1px solid #000;">' . $rw->interes_parcial . '</th>
				</tr>';
}
$table .= '<tr>
				<td colspan="5"></td>
				<td style="border:1px solid #000;" colspan="3"><strong>Meses detallados</strong></td>
				<td style="border:1px solid #000;" colspan="2"><strong>' . $pie->meses_retraso . '</strong></td>
			</tr>
			<tr>
				<td colspan="5"></td>
				<td style="border:1px solid #000;" colspan="3"><strong>Sub-total</strong></td>
				<td style="border:1px solid #000;" colspan="2"><strong>$ ' . $pie->total_calculo . '</strong></td>
			</tr>
			<tr>
				<td colspan="5"></td>
				<td style="border:1px solid #000;" colspan="3"><strong>5% Fiesta</strong></td>
				<td style="border:1px solid #000;" colspan="2"><strong>$ ' . $pie->fiesta_ec . '</strong></td>
			</tr>';
$table .= '</table>';
$pdf->writeHTMLCell(0, 0, '', '', $table, 0, 1, 0, true, '', true);

setlocale(LC_TIME, "spanish");
$mes = strftime("%B de %Y");
$pie_pdf = <<<OED
	<h4 align="left"><strong>MORA</strong></h4>
	<label align="left"><strong>Multa: &nbsp;&nbsp;&nbsp;</strong>$ $pie->multa_ec</label><br/>
	<label align="left"><strong>Interes: &nbsp;&nbsp;</strong>$ $pie->interes_ec</label>
	<label align="right"><h2>Total a pagar: $ $pie->total_pago</h2></label><br/><br/><br/>
	<label align="center">_________________________________</label><br/>
	<label align="center"><strong>Alicia Gabriela Viscarra Gonzalez</strong></label><br/>
	<label align="center">Enc. Cuentas Corrientes</label><br/><br/>
	<div style="border:1px solid #000;">
		<label align="justify">$pie->observaciones</label>
	</div><br/>
	<label align="center"><strong>NOTA: </strong>El presente Estado de Cuenta tiene validez hasta <strong>el último día de $mes</strong></label>
OED;
$pdf->writeHTMLCell(0, 0, '', '', $pie_pdf, 0, 1, 0, true, '', true);

//============================================================+
// END PDF DOCUMENT
//============================================================+
// move pointer to last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
ob_clean();
$pdf->Output('EC_Tasas' . $Encabezado->nc . '_' . $fecha . '.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+