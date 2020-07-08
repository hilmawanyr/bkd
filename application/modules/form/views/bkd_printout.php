<?php

class PDF Extends FPDF
{
	function Footer()
	{
		$this->SetY(-40);
		$this->SetFont('Arial','I',8);
		$this->Cell(10,10,'*Mengikuti pedoman atau ketentuan dari LPPMP',0,0,'L');
		$this->Ln(5);
		$this->Cell(10,10,'**Ketentuan dari pedoman BKD LLDIKTI Wilayah III',0,0,'L');
	}
}

$pdf = new FPDF("L","mm", "A4");

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(3, 5 ,0);

$pdf->SetFont('Arial','B',10);
$pdf->setXY(22,4);
$pdf->Cell(250,5,'Formulir Beban Kinerja Dosen Internal (BKD Internal)',0,1,'C');
$pdf->Cell(290,5,'Universitas Bhayangkara Jakarta Raya',0,1,'C');

$pdf->Ln(2);
$pdf->setXY(176,6);
$pdf->image(FCPATH.'assets/img/logo-ubj.gif',270,2,14);
// param for image => <file>,<margin-left>,<margin-top>,<size>

$pdf->Ln(17);
$pdf->SetFont('Arial','',10);
$pdf->Cell(33,5,'Nama',0,0,'L');
$pdf->Cell(5,5,' : ',0,0,'L');
$pdf->Cell(170,5,$data->nama,0,0,'L');
$pdf->Cell(23,5,'Fakultas',0,0,'L');
$pdf->Cell(5,5,' : ',0,0,'C');
$pdf->Cell(170,5,$data->fakultas,0,0,'L');

$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(33,5,'NIDN',0,0,'L');
$pdf->Cell(5,5,' : ',0,0,'L');
$pdf->Cell(170,5,$data->nidn,0,0,'L');
$pdf->Cell(23,5,'Program Studi',0,0,'L');
$pdf->Cell(5,5,' : ',0,0,'C');
$pdf->Cell(170,5,$data->prodi,0,0,'L');

$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(33,5,'Jabatan Fungsional',0,0,'L');
$pdf->Cell(5,5,' : ',0,0,'L');
$pdf->Cell(170,5,position_name($data->jabfung),0,0,'L');
$pdf->Cell(23,5,'Semester',0,0,'L');
$pdf->Cell(5,5,' : ',0,0,'C');
$pdf->Cell(170,5,year_name($this->session->userdata('tahunakademik')),0,0,'L');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(1,10,'',0,0,'C');
$pdf->Cell(7,10,'NO','L,T,R,B',0,'C');
$pdf->Cell(150,10,'BIDANG / TUGAS','L,T,R,B',0,'C');
$pdf->Cell(80,5,'WAKTU','L,T,R,B',0,'C');
$pdf->Cell(50,10,'Jumlah SKS','L,T,R,B',0,'C');

$pdf->Ln(5);
$pdf->Cell(158,10,'',0,0,'C');
$pdf->Cell(40,5,'HARI','L,T,R,B',0,'C');
$pdf->Cell(40,5,'JAM','L,T,R,B',0,'C');

$pdf->Ln(5);
$pdf->Cell(1,10,'',0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(7,5,'1','L,T,R,B',0,'C');
$pdf->Cell(280,5,'Pendidikan dan Pengajaran','L,T,R,B',0,'L');

// constanta for credit total
$creditTotal = 0;

foreach ($courses as $course) {
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1,10,'',0,0,'L');
	$pdf->Cell(7,5,'','L,T,R,B',0,'L');
	$pdf->Cell(150,5,$course->nama_mk. ' ('.$course->kode_mk.')','L,T,R,B',0,'L');
	$pdf->Cell(40,5,$course->hari,'L,T,R,B',0,'L');
	$pdf->Cell(40,5,$course->jam_mulai.' - '.$course->jam_selesai,'L,T,R,B',0,'L');
	$pdf->Cell(50,5,$course->sks,'L,T,R,B',0,'C');

	$creditTotal = $creditTotal + $course->sks;
}

foreach ($additional as $aditionals) {
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1,5,'',0,0,'C');
	if (strlen($aditionals->komponen) > 100) {
		$pdf->Cell(7,10,'','LTRB',0,'C');
		$pdf->MultiCell(150,5,'Pengajaran: '.$aditionals->komponen,'LTRB','L',FALSE);
		$pdf->SetXY($pdf->GetX() + 158, $pdf->GetY() - 10);
		$pdf->Cell(40,10,'','L,T,R,B',0,'L');
		$pdf->Cell(40,10,'','L,T,R,B',0,'L');
		$pdf->Cell(50,10,$aditionals->sks,'L,T,R,B',0,'C');
		$pdf->Ln(5);
	} else {
		$pdf->Cell(7,5,'','LTRB',0,'C');
		$pdf->Cell(150,5,'Pengajaran: '.$aditionals->komponen,'LTRB',0,'L');
		$pdf->Cell(40,5,'','L,T,R,B',0,'L');
		$pdf->Cell(40,5,'','L,T,R,B',0,'L');
		$pdf->Cell(50,5,$aditionals->sks,'L,T,R,B',0,'C');
	}

	$creditTotal = $creditTotal + $aditionals->sks;

}

$pdf->Ln(5);
$pdf->Cell(1,10,'',0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(7,5,'2','L,T,R,B',0,'C');
$pdf->Cell(280,5,'Penelitian dan Pengabdian Kepada Masyarakat','L,T,R,B',0,'L');

foreach ($research as $rsc) {
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1,10,'',0,0,'C');

	if (strlen($rsc->judul) > 100 && strlen($rsc->judul) < 213) {
		$height = 10;
	} elseif (strlen($rsc->judul) > 212) {
		$height = 15;
	} elseif (strlen($rsc->judul) < 100) {
		$height = 5;
	}

	if (strlen($rsc->judul) > 100) {
		$pdf->Cell(7,$height,'','L,T,R,B',0,'C');
		$pdf->MultiCell(150,5,'Penelitian: '.$rsc->judul,'LTRB','L',FALSE);
		$pdf->SetXY($pdf->GetX() + 158, $pdf->GetY() - $height);
		$pdf->Cell(40,$height,'','L,T,R,B',0,'L');
		$pdf->Cell(40,$height,'','L,T,R,B',0,'L');
		$pdf->Cell(50,$height,$rsc->sks,'L,T,R,B',0,'C');
		$pdf->Ln($height-5);
	} else {
		$pdf->Cell(7,$height,'','L,T,R,B',0,'C');
		$pdf->Cell(150,$height,'Penelitian: '.$rsc->judul,'LTRB','L',FALSE);
		$pdf->Cell(40,$height,'','L,T,R,B',0,'L');
		$pdf->Cell(40,$height,'','L,T,R,B',0,'L');
		$pdf->Cell(50,$height,$rsc->sks,'L,T,R,B',0,'C');
	}

}

foreach ($devotion as $dev) {
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1,10,'',0,0,'C');

	if (strlen($dev->program) > 100) {
		$pdf->Cell(7,10,'','L,T,R,B',0,'C');
		$pdf->MultiCell(150,5,'Pengabdian: '.$dev->program,'LTRB','L',FALSE);
		$pdf->SetXY($pdf->GetX() + 158, $pdf->GetY() - 10);
		$pdf->Cell(40,10,'','L,T,R,B',0,'L');
		$pdf->Cell(40,10,'','L,T,R,B',0,'L');
		$pdf->Cell(50,10,$dev->sks,'L,T,R,B',0,'C');
		$pdf->Ln(5);
	} else {
		$pdf->Cell(7,5,'','L,T,R,B',0,'C');
		$pdf->Cell(150,5,'Pengabdian: '.$dev->program,'LTRB',0,'L');
		$pdf->Cell(40,5,'','L,T,R,B',0,'L');
		$pdf->Cell(40,5,'','L,T,R,B',0,'L');
		$pdf->Cell(50,5,$dev->sks,'L,T,R,B',0,'C');
	}

}

$pdf->Ln(5);
$pdf->Cell(1,10,'',0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(7,5,'3','L,T,R,B',0,'C');
$pdf->Cell(280,5,'Lain-lain','L,T,R,B',0,'L');

foreach ($others as $other) {
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1,10,'',0,0,'C');
	$pdf->Cell(7,5,'','L,T,R,B',0,'C');
	$pdf->Cell(150,5,$other->jabatan,'L,T,R,B',0,'L');
	$pdf->Cell(40,5,'','L,T,R,B',0,'L');
	$pdf->Cell(40,5,'','L,T,R,B',0,'L');
	$pdf->Cell(50,5,$other->sks,'L,T,R,B',0,'C');

	$creditTotal = $creditTotal + $other->sks;
}

$pdf->Ln(5);
$pdf->Cell(1,10,'',0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(237,5,'Total','L,T,R,B',0,'C');
$pdf->Cell(50,5,$creditTotal,'L,T,R,B',0,'C');

date_default_timezone_set('Asia/Jakarta');

$pdf->Ln(5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(264,1,'',0,0,'C');
$pdf->Cell(7,15,'Bekasi, '.TanggalIndo(date('Y-m-d')),0,0,'R');

$pdf->Ln(15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,1,'',0,0,'C');
$pdf->Cell(110,1,'Wakil Rektor I',0,0,'L');
$pdf->Cell(100,1,'Dekan',0,0,'L');
$pdf->Cell(50,1,'Dosen',0,0,'L');

$pdf->Ln(20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,1,'',0,0,'C');
$pdf->Cell(105,1,'(                                                          )',0,0,'L');
$pdf->Cell(100,1,'(                                                          )',0,0,'L');
$pdf->Cell(50,1,'(                                                          )',0,0,'L');

$pdf->Output('Kartu_BKD_'.date('ymd_his').'.PDF','I');
