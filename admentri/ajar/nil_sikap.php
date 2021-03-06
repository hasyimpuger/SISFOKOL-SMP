<?php

///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////// SISFOKOL_SMA_v5.0_(PernahJaya)                          ///////
/////// (Sistem Informasi Sekolah untuk SMA)                    ///////
///////////////////////////////////////////////////////////////////////
/////// Dibuat oleh :                                           ///////
/////// Agus Muhajir, S.Kom                                     ///////
/////// URL 	:                                               ///////
///////     * http://omahbiasawae.com/                          ///////
///////     * http://sisfokol.wordpress.com/                    ///////
///////     * http://hajirodeon.wordpress.com/                  ///////
///////     * http://yahoogroup.com/groups/sisfokol/            ///////
///////     * http://yahoogroup.com/groups/linuxbiasawae/       ///////
/////// E-Mail	:                                               ///////
///////     * hajirodeon@yahoo.com                              ///////
///////     * hajirodeon@gmail.com                              ///////
/////// HP/SMS/WA : 081-829-88-54                               ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////





session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
require("../../inc/cek/admentri.php");
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$filenya = "nil_sikap.php";
$judul = "Penilaian Sikap";
$judulku = "[$entri_session : $nip37_session.$nm37_session] ==> $judul";
$juduly = $judul;
$tapelkd = nosql($_REQUEST['tapelkd']);
$smtkd = nosql($_REQUEST['smtkd']);
$kelkd = nosql($_REQUEST['kelkd']);
$progkd = nosql($_REQUEST['progkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);

//page...
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"skkd=$skkd&jnskd=$jnskd&progkd=$progkd&page=$page";

$limit = "50";


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$page = nosql($_POST['page']);

	//page...
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}




	for ($k=1;$k<=$limit;$k++)
		{
		$xyzb = md5("$x$k");


		//skkd
		$xskkd = "skkd";
		$xskkd1 = "$xskkd$k";
		$xskkdxx = nosql($_POST["$xskkd1"]);


		//nilai
		$xnilruh = "nil_rata_amat";
		$xnilruh1 = "$xnilruh$k";
		$nilku = nosql($_POST["$xnilruh1"]);
		$xnil1 = $nilku;
		
					
		$xnilruh = "nil_nil_dirisendiri";
		$xnilruh1 = "$xnilruh$k";
		$nilku = nosql($_POST["$xnilruh1"]);
		$xnil2 = $nilku;
		
		
		$xnilruh = "nil_nil_antarteman";
		$xnilruh1 = "$xnilruh$k";
		$nilku = nosql($_POST["$xnilruh1"]);						
		$xnil3 = $nilku;
			
		
		$xnilruh = "nil_nil_catatanguru";
		$xnilruh1 = "$xnilruh$k";
		$xnil4 = nosql($_POST["$xnilruh1"]);



		$xnilct = "nil_catatan";
		$xnilct1 = "$xnilct$k";
		$xnilctxx = nosql($_POST["$xnilct1"]);

		



		$xnil5 = round(((2 * $xnil1) + $xnil2 + $xnil3 + $xnil4) / 5);
		$xpel_sikap = $xnil5;
		$xnil6 = $xnil5;



		$nilku = $xnil6;
		

		if ($nilku <= '54')
			{
			$nilkux = '1.00';
			}
		else if (($nilku <= '59') AND ($nilku >= '55'))
			{
			$nilkux = '1.33';
			}
			
		else if (($nilku <= '64') AND ($nilku >= '60'))
			{
			$nilkux = '1.67';
			}
		
		else if (($nilku <= '69') AND ($nilku >= '65'))
			{
			$nilkux = '2.00';
			}
		
		else if (($nilku <= '74') AND ($nilku >= '70'))
			{
			$nilkux = '2.33';
			}
			
		else if (($nilku <= '80') AND ($nilku >= '75'))
			{
			$nilkux = '2,67';
			}
		
		else if (($nilku <= '85') AND ($nilku >= '81'))
			{
			$nilkux = '3,00';
			}
		
		else if (($nilku <= '90') AND ($nilku >= '86'))
			{
			$nilkux = '3,33';
			}
		
		else if (($nilku <= '95') AND ($nilku >= '91'))
			{
			$nilkux = '3.67';
			}
		
		else if (($nilku <= '100') AND ($nilku >= '96'))
			{
			$nilkux = '4.00';
			}
		
		else 
			{
			$nilkux = '';
			}

		
		$xnil6 = $nilkux;
		$xpel_sikap = $xnil6;


		if (($xpel_sikap <= "4.00") AND ($xpel_sikap >= "3.66"))
			{
			$xpel_sikap_ket = "SB";
			}
		else if (($xpel_sikap < "3.66") AND ($xpel_sikap >= "2.66"))
			{
			$xpel_sikap_ket = "B";
			}
		else if (($xpel_sikap < "2.66") AND ($xpel_sikap >= "1.66"))
			{
			$xpel_sikap_ket = "C";
			}
		else if ($xpel_sikap < "1.66")
			{
			$xpel_sikap_ket = "K";
			}
		else 
			{
			$xpel_sikap_ket = "";
			}



		$xnil7 = $xpel_sikap_ket;



		//ke mysql
		$qcc = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
								"FROM m_siswa, siswa_kelas ".
								"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
								"AND siswa_kelas.kd_tapel = '$tapelkd' ".
								"AND siswa_kelas.kd = '$xskkdxx'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);

		//jika ada
		if ($tcc != 0)
			{
			//entry...
			$qcc1 = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$xskkdxx' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$tcc1 = mysql_num_rows($qcc1);



			//jika ada, update
			if ($tcc1 != 0)
				{
				mysql_query("UPDATE siswa_nilai_raport SET rata_sikap_amat = '$xnil1', ".
								"nil_sikap_dirisendiri = '$xnil2', ".
								"nil_sikap_antarteman = '$xnil3', ".
								"nil_sikap_catatanguru = '$xnil4', ".
								"rata_sikap = '$xnil5', ".
								"nil_raport_sikap_a = '$xnil6', ".
								"nil_k_sikap = '$xnilctxx', ".
								"nil_raport_sikap_p = '$xnil7' ".										
								"WHERE kd_siswa_kelas = '$xskkdxx' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
				}

			//jika blm ada, insert
			else
				{
				mysql_query("INSERT INTO siswa_nilai_raport(kd, kd_siswa_kelas, kd_smt, kd_prog_pddkn, ".
								"rata_sikap_amat, nil_sikap_dirisendiri, nil_sikap_antarteman, ".
								"nil_sikap_catatanguru, rata_sikap, nil_raport_sikap_a, ".
								"nil_raport_sikap_p, nil_k_sikap, postdate) VALUES ".
								"('$xyzb', '$xskkdxx', '$smtkd', '$progkd', ".
								"'$xnil1', '$xnil2', '$xnil3', ".
								"'$xnil4', '$xnil5', '$xnil6', ".
								"'$xnil7', '$xnilctxx', '$today')");
				}


			}



		}


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&smtkd=$smtkd&kelkd=$kelkd&".
			"progkd=$progkd&page=$page";
	xloc($ke);
	exit();
	}







//ke import
if ($_POST['btnIM'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jndks = nosql($_POST['jnskd']);


	//re-direct
	$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
	xloc($ke);
	exit();
	}





//import
if ($_POST['btnIM2'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);
	$filex_namex = strip(strtolower($_FILES['filex_xls']['name']));

	//nek null
	if (empty($filex_namex))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
		pekem($pesan,$ke);
		}
	else
		{
		//deteksi .xls
		$ext_filex = substr($filex_namex, -4);

		if ($ext_filex == ".xls")
			{
			//nilai
			$path1 = "../../filebox";
			$path2 = "../../filebox/excel";
			chmod($path1,0777);
			chmod($path2,0777);

			//nama file import, diubah menjadi baru...
			$filex_namex2 = "file_importnya.xls";

			//mengkopi file
			copy($_FILES['filex_xls']['tmp_name'],"../../filebox/excel/$filex_namex2");

			//chmod
                        $path3 = "../../filebox/excel/$filex_namex2";
			chmod($path1,0755);
			chmod($path2,0777);
			chmod($path3,0777);


			//re-direct
			$ke = "nil_sikap_import.php?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&filex_namex2=$filex_namex2";
			xloc($ke);
			exit();
			}
		else
			{
			//re-direct
			$pesan = "Bukan File .xls . Harap Diperhatikan...!!";
			$ke = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&progkd=$progkd&jnskd=$jnskd&s=import";
			pekem($pesan,$ke);
			exit();
			}
		}
	}





//export
if ($_POST['btnEX'])
	{
	//nilai
	$tapelkd = nosql($_POST['tapelkd']);
	$smtkd = nosql($_POST['smtkd']);
	$kelkd = nosql($_POST['kelkd']);
	$progkd = nosql($_POST['progkd']);
	$jnskd = nosql($_POST['jnskd']);

	//require
	include("../../inc/class/excel/excelwriter.inc.php");
	
	


	//mapel e...
	$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
							"WHERE kd = '$progkd'");
	$rowstdx = mysql_fetch_assoc($qstdx);
	$stdx_kd = nosql($rowstdx['kd']);
	$stdx_jnskd = nosql($rowstdx['kd_jenis']);
	$stdx_pel = strip(balikin($rowstdx['xpel']));


	//nama file e...
	$excelfile = "Nilai_sikap_$stdx_pel.xls";
	$i_judul = "Nilai_sikap_$stdx_pel";
	
	
	//lokasi hasil konversi
	$lokasi	   = '../../filebox/excel/';
	$excel=new ExcelWriter($lokasi.$excelfile);
	
	

	//bikin...
	$myArr = array("NO","NIS","NAMA","DIRISENDIRI","ANTARTEMAN","CATATANGURU","NILAI_AKHIR","RAPORT_A","RAPORT_P");
	$excel->writeLine($myArr);





	//data
	$qdt = mysql_query("SELECT m_siswa.*, siswa_kelas.*, siswa_kelas.kd AS skkd ".
							"FROM m_siswa, siswa_kelas ".
							"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
							"AND siswa_kelas.kd_tapel = '$tapelkd' ".
							"AND siswa_kelas.kd_kelas = '$kelkd' ".
							"ORDER BY m_siswa.nama ASC");
	$rdt = mysql_fetch_assoc($qdt);

	do
		{
		//nilai
		$dt_nox = $dt_nox + 1;
		$dt_skkd = nosql($rdt['skkd']);
		$dt_no = nosql($rdt['no_absen']);
		$dt_nis = nosql($rdt['nis']);
		$dt_nama = balikin($rdt['nama']);

		//nil prog_pddkn
		$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
								"WHERE kd_siswa_kelas = '$dt_skkd' ".
								"AND kd_smt = '$smtkd' ".
								"AND kd_prog_pddkn = '$progkd'");
		$rxpel = mysql_fetch_assoc($qxpel);
		$txpel = mysql_num_rows($qxpel);
		$xpel_nil_dirisendiri = nosql($rxpel['nil_sikap_dirisendiri']);
		$xpel_nil_antarteman = nosql($rxpel['nil_sikap_antarteman']);
		$xpel_nil_catatanguru = nosql($rxpel['nil_sikap_catatanguru']);
		$xpel_rata_sikap = nosql($rxpel['rata_sikap']);
		$xpel_raport_a = balikin($rxpel['nil_raport_sikap_a']);
		$xpel_raport_p = balikin($rxpel['nil_raport_sikap_p']);




		//ciptakan
		$myArr2 = array($dt_nox,$dt_nis,$dt_nama,$xpel_nil_dirisendiri,$xpel_nil_antarteman,$xpel_nil_catatanguru,$xpel_rata_sikap,$xpel_raport_a,$xpel_raport_p);
		$excel->writeLine($myArr2);
		
		}
	while ($rdt = mysql_fetch_assoc($qdt));




	$excel -> close();
	
	
	$ke = "$lokasi$excelfile";
	xloc($ke);
	exit();
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////










//focus....focus...
if (empty($smtkd))
	{
	$diload = "document.formx.smt.focus();";
	}






//isi *START
ob_start();

//menu
require("../../inc/menu/admentri.php");

//isi_menu
$isi_menu = ob_get_contents();
ob_end_clean();







//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post" action="'.$filenya.'" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="../index.php?tapelkd='.$tapelkd.'" title="Daftar Mata Pelajaran">Daftar Mata Pelajaran</a>]</td>
</tr>
</table>


<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Tahun Pelajaran : ';
//terpilih
$qtpx = mysql_query("SELECT * FROM m_tapel ".
						"WHERE kd = '$tapelkd'");
$rowtpx = mysql_fetch_assoc($qtpx);
$tpx_kd = nosql($rowtpx['kd']);
$tpx_thn1 = nosql($rowtpx['tahun1']);
$tpx_thn2 = nosql($rowtpx['tahun2']);

echo '<strong>'.$tpx_thn1.'/'.$tpx_thn2.'</strong>,

Kelas : ';
//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxno = nosql($rowbtx['no']);
$btxkelas = balikin($rowbtx['kelas']);

echo '<strong>'.$btxkelas.'</strong>
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Mata Pelajaran : ';
//terpilih
$qstdx = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd = '$progkd'");
$rowstdx = mysql_fetch_assoc($qstdx);
$stdx_kd = nosql($rowstdx['kd']);
$stdx_jnskd = nosql($rowstdx['kd_jenis']);
$stdx_pel = balikin($rowstdx['prog_pddkn']);

//jenis
$qjnsx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
			"WHERE kd = '$stdx_jnskd'");
$rjnsx = mysql_fetch_assoc($qjnsx);
$tjnsx = mysql_num_rows($qjnsx);
$jnsx_jenis = balikin($rjnsx['jenis']);

echo '<strong>'.$jnsx_jenis.' --> '.$stdx_pel.'</strong>,

Semester : ';
echo "<select name=\"smt\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd = '$smtkd'");
$rowstx = mysql_fetch_assoc($qstx);
$stx_kd = nosql($rowstx['kd']);
$stx_no = nosql($rowstx['no']);
$stx_smt = nosql($rowstx['smt']);

echo '<option value="'.$stx_kd.'">'.$stx_smt.'</option>';

$qst = mysql_query("SELECT * FROM m_smt ".
						"WHERE kd <> '$smtkd' ".
						"ORDER BY smt ASC");
$rowst = mysql_fetch_assoc($qst);

do
	{
	$st_kd = nosql($rowst['kd']);
	$st_smt = nosql($rowst['smt']);

	echo '<option value="'.$filenya.'?tapelkd='.$tapelkd.'&kelkd='.$kelkd.'&progkd='.$progkd.'&smtkd='.$st_kd.'">'.$st_smt.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>,


<input name="tapelkd" type="hidden" value="'.$tapelkd.'">
<input name="kelkd" type="hidden" value="'.$kelkd.'">
<input name="smtkd" type="hidden" value="'.$smtkd.'">
<input name="jnskd" type="hidden" value="'.$stdx_jnskd.'">
<input name="progkd" type="hidden" value="'.$progkd.'">
</td>
</tr>
</table>
<br>';


//nek drg
if (empty($tapelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>TAHUN PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($kelkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($smtkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>SEMESTER Belum Dipilih...!</strong></font>
	</p>';
	}

else if (empty($progkd))
	{
	echo '<p>
	<font color="#FF0000"><strong>MATA PELAJARAN Belum Dipilih...!</strong></font>
	</p>';
	}

else
	{
	//jika import
	if ($s == "import")
		{
		echo '<p>
		Silahkan Masukkan File yang akan Di-Import :
		<br>
		<input name="filex_xls" type="file" size="30">
		<br>
		<input name="s" type="hidden" value="'.$s.'">
		<input name="btnBTL" type="submit" value="BATAL">
		<input name="btnIM2" type="submit" value="IMPORT >>">
		</p>';
		}
	else
		{
		//daftar siswa
		$p = new Pager();
		$start = $p->findStart($limit);

		$sqlcount = "SELECT m_siswa.*, m_siswa.kd AS mskd, siswa_kelas.*, siswa_kelas.kd AS skkd ".
						"FROM m_siswa, siswa_kelas ".
						"WHERE siswa_kelas.kd_siswa = m_siswa.kd ".
						"AND siswa_kelas.kd_tapel = '$tapelkd' ".
						"AND siswa_kelas.kd_kelas = '$kelkd' ".
						"ORDER BY m_siswa.nama ASC";
		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?tapelkd=$tapelkd&kelkd=$kelkd&smtkd=$smtkd&jnskd=$jnskd&progkd=$progkd";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);



		echo '<input name="btnIM" type="submit" value="IMPORT">
		<input name="btnEX" type="submit" value="EXPORT">
		<table width="1000" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong>NIS</strong></td>
		<td><strong>NAMA</strong></td>
		<td width="50"><strong>OBSERVASI PENGAMATAN</strong></td>
		<td width="50"><strong>PENILAIAN DIRI SENDIRI</strong></td>
		<td width="50"><strong>PENILAIAN ANTAR TEMAN</strong></td>
		<td width="50"><strong>JURNAL CATATAN GURU</strong></td>
		<td width="50"><strong>NR</strong></td>
		<td width="50"><strong>NILAI</strong></td>
		<td width="50"><strong>PREDIKAT</strong></td>
		<td width="250"><strong>CATATAN</strong></td>
		</tr>';


		do
			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			//nilainya
			$i_nomer = $i_nomer + 1;
			$i_mskd = nosql($data['mskd']);
			$i_skkd = nosql($data['skkd']);
			$i_nis = nosql($data['nis']);
			$i_nama = balikin($data['nama']);





			//nil mapel
			$qxpel = mysql_query("SELECT * FROM siswa_nilai_raport ".
									"WHERE kd_siswa_kelas = '$i_skkd' ".
									"AND kd_smt = '$smtkd' ".
									"AND kd_prog_pddkn = '$progkd'");
			$rxpel = mysql_fetch_assoc($qxpel);
			$txpel = mysql_num_rows($qxpel);
			$xpel_nil_amat = nosql($rxpel['rata_sikap_amat']);
			$xpel_nil_dirisendiri = nosql($rxpel['nil_sikap_dirisendiri']);
			$xpel_nil_antarteman = nosql($rxpel['nil_sikap_antarteman']);
			$xpel_nil_catatanguru = nosql($rxpel['nil_sikap_catatanguru']);
			$xpel_rata_sikap = nosql($rxpel['rata_sikap']);
			$xpel_raport_a = balikin($rxpel['nil_raport_sikap_a']);
			$xpel_raport_p = balikin($rxpel['nil_raport_sikap_p']);
			$xpel_catatan = balikin($rxpel['nil_k_sikap']);

			
			//jika null
			if (empty($xpel_nil_amat))
				{	
				//ambil nilai observasi
				$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
										"FROM siswa_sikap_observasi ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$kelkd' ".
										"AND kd_mapel = '$progkd' ". 
										"AND kd_siswa = '$i_mskd'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_rata_amatt = nosql($rxpel['total']);
				$nilku = ($xpel_rata_amatt / 20) * 100;
				$xpel_rata_amat = $nilku;
				
			
				$xpel_nil_amat = $xpel_rata_amat;
				}
				
				
			//jika null
			if (empty($xpel_nil_dirisendiri))
				{
				//ambil nilai diri sendiri
				$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
										"FROM siswa_sikap_dirisendiri ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$kelkd' ".
										"AND kd_mapel = '$progkd' ". 
										"AND kd_siswa = '$i_mskd'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_nil_dirisendirii = nosql($rxpel['total']);
				$nilku = ($xpel_nil_dirisendirii / 20) * 100;
				
				$xpel_nil_dirisendiri = $nilku;
				}
				
			
			

			//jika null
			if (empty($xpel_nil_antarteman))
				{
				//ambil nilai antar teman
				$qxpel = mysql_query("SELECT SUM(pilihan) AS total ".
										"FROM siswa_sikap_antarteman ".
										"WHERE kd_tapel = '$tapelkd' ".
										"AND kd_kelas = '$kelkd' ".
										"AND kd_mapel = '$progkd' ". 
										"AND kd_siswa2 = '$i_mskd'");
				$rxpel = mysql_fetch_assoc($qxpel);
				$txpel = mysql_num_rows($qxpel);
				$xpel_nil_antartemann = nosql($rxpel['total']);
				$nilku = ($xpel_nil_antartemann / 20) * 100;
				
				$xpel_nil_antarteman = $nilku;
				}
			


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>
			<input name="skkd'.$i_nomer.'" type="hidden" value="'.$i_skkd.'">
			'.$i_nis.'
			</td>
			<td>
			'.$i_nama.'
			</td>

			<td>
			<input name="nil_rata_amat'.$i_nomer.'" type="text" value="'.$xpel_nil_amat.'" size="3" style="text-align:right">
			</td>

			<td>
			<input name="nil_nil_dirisendiri'.$i_nomer.'" type="text" value="'.$xpel_nil_dirisendiri.'" size="3" style="text-align:right"y>
			</td>
			<td>
			<input name="nil_nil_antarteman'.$i_nomer.'" type="text" value="'.$xpel_nil_antarteman.'" size="3" style="text-align:right">
			</td>
			<td>
			<input name="nil_nil_catatanguru'.$i_nomer.'" type="text" value="'.$xpel_nil_catatanguru.'" size="3" style="text-align:right">
			</td>
			<td>
			<input name="nil_nr'.$i_nomer.'" type="text" value="'.$xpel_rata_sikap.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_a'.$i_nomer.'" type="text" value="'.$xpel_raport_a.'" size="3" style="text-align:right" class="input" readonly>
			</td>
			<td>
			<input name="nil_raport_p'.$i_nomer.'" type="text" value="'.$xpel_raport_p.'" size="3" style="text-align:right" class="input" readonly>
			</td>

			<td>
			<input name="nil_catatan'.$i_nomer.'" type="text" value="'.$xpel_catatan.'" size="25">
			</td>
			</tr>';
			}
		while ($data = mysql_fetch_assoc($result));


		echo '</table>
		<table width="400" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="btnSMP" type="submit" value="SIMPAN">
		<input name="page" type="hidden" value="'.$page.'">
		'.$pagelist.'
		</td>
		</tr>
		</table>';
		}
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");


//diskonek
xfree($qbw);
xclose($koneksi);
exit();
?>
