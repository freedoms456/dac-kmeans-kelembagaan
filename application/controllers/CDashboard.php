<?php
class CDashboard extends CI_Controller{
    function __construct(){
        parent:: __construct();
		$this->load->library('CSVReader');
		$this->load->helper(array('form', 'url'));
    }
    function index(){
        $this->load->view('index');
    }
	// fungsi cari max attribute
	function max_attribute_in_array($array, $prop) {
		return max(array_map(function($o) use($prop) {
								return $o[$prop];
							 },
							 $array));
	} 
	function do_upload(){
		// dd($_POST);
		$postLength = count($_POST) -1 ;
		$kriteria = array();
		// for($a=0;$a<$postLength; $a++){
		// 	$tempKriteria = array (
		// 		"namaKriteria" => $_POST['kriteria'][$a],
		// 		"bobot" => $_POST['bobot'][$a]
		// 	);
		// 	array_push($kriteria,$tempKriteria);
	
		// }
		$kriteria = [
			["namaKriteria" => "diklat", "bobot" => "0.2"],
			["namaKriteria" => "sertifikasi", "bobot" => "0.3"],
			["namaKriteria" => "bahasa", "bobot" => "0.1"],
			["namaKriteria" => "tpa", "bobot" => "0.2"],
			["namaKriteria" => "nilai_skp", "bobot" => "0.2"],
		
		];
		
		$csvData = $this->csvreader->parse_csv($_FILES['userfile']['tmp_name']);
		if(!empty($csvData)){
			$arrayDataPegawai = array();
			foreach($csvData as $row){ 
				foreach($kriteria as $k){
					$row[$k['namaKriteria']] = $row[$k['namaKriteria']];
				}
				array_push($arrayDataPegawai,$row);
			}
			// dd($arrayDataPegawai);
			
			  //hasil max setiap kriteria dalam bentuk array
			  $hasilMaxDariSetiapKriteria = array();
			  $nilaiFinal = array();
                
			  //hasil pembagian antara nilai kriteria dan nilai max kriteria
			  $nilaiHasilBagiAntaraNilaiKriteriaDanNilaiMaxKriteria = array();

				//   Cari nilai max disetiap kriteria
			  foreach ($kriteria as $k) {
				$max = $this -> max_attribute_in_array($arrayDataPegawai, $k['namaKriteria']);
				array_push($hasilMaxDariSetiapKriteria, array(
                    'nama_kriteria' => $k['namaKriteria'],
                    'hasil' => $max,
                ));
			  }
			  	$row = $nilaitotal = 0;
			  	// Hitung Normalisasi Benefit dan assign ke setiap pegawai
				foreach ($arrayDataPegawai as $n) {
					foreach ($hasilMaxDariSetiapKriteria as $hmdsk) {
						$arrayDataPegawai[$row][$hmdsk['nama_kriteria']] = $arrayDataPegawai[$row][$hmdsk['nama_kriteria']] / $hmdsk['hasil'];
					
						
					}
					foreach($kriteria as $k){
						$arrayDataPegawai[$row][$k['namaKriteria']] = $arrayDataPegawai[$row][$k['namaKriteria']] * $k['bobot'];
						$nilaitotal +=  $arrayDataPegawai[$row][$k['namaKriteria']];
					}
					$arrayDataPegawai[$row]['total_nilai'] = $nilaitotal;
					
					$nilaitotal = 0;
					$row++;
				}

				// dd($arrayDataPegawai);

				// // Dibobotin dan nambah nilai akhir
				// foreach ($nilaiHasilBagiAntaraNilaiKriteriaDanNilaiMaxKriteria as $n) {
				// $val = array(
				// 	'pegawai_nama' => $n['pegawai_nama'],
				// 	'Pendidikan' => $n['pegawai_pendidikan'],
				// 	'Jabatan' => $n['jabatan_nama'],
				// 	'Tahun' => $n['tahun'],
				// 	'Pegawai Perwakilan' => $n['pegawai_perwakilan'],
				
				// 	'Diklat' => ($n['hasil_akhir'][0]['hasil'] * $kriteria[0]['bobot']),
				// 	'Sertifikasi' => ($n['hasil_akhir'][1]['hasil'] * $kriteria[1]['bobot']),
				// 	'Bahasa' => ($n['hasil_akhir'][2]['hasil'] * $kriteria[2]['bobot']),
				// 	'TPA' => ($n['hasil_akhir'][2]['hasil'] * $kriteria[3]['bobot']),
				// 	'Nilai_Skp' => ($n['hasil_akhir'][2]['hasil'] * $kriteria[4]['bobot']),
				// 	'total_nilai' => ($n['hasil_akhir'][0]['hasil'] * $kriteria[0]['bobot']) +
				// 	($n['hasil_akhir'][1]['hasil'] * $kriteria[1]['bobot']) +
				// 	($n['hasil_akhir'][2]['hasil'] * $kriteria[2]['bobot']) +
				// 	($n['hasil_akhir'][3]['hasil'] * $kriteria[3]['bobot']) +
				// 	($n['hasil_akhir'][4]['hasil'] * $kriteria[4]['bobot']),
		
				// );
				// array_push($nilaiFinal,$val);
				// }

				//   EXPORT TO CSV
				  $delimiter = ","; 
				  $filename = "SAW_" . date('Y-m-d') . ".csv"; 
				  $f = fopen('php://memory', 'w'); 
				  $fields = array();
				  foreach ($arrayDataPegawai[0] as $k => $a){
					array_push($fields,$k);
					
				  };
				  fputcsv($f, $fields, $delimiter); 
				  foreach($arrayDataPegawai as $n){
					fputcsv($f, $n, $delimiter); 
				  }

				  fseek($f, 0); 
				  header('Content-Type: text/csv'); 
				  header('Content-Disposition: attachment; filename="' . $filename . '";'); 
				   
				  fpassthru($f); 
			exit; 
		}
	
	}
   

}
