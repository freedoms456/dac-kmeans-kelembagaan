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
		dd($_POST);
		// Kriteria
		$kriteria = [
			["namaKriteria" => "Diklat", "bobot" => "0.2"],
			["namaKriteria" => "Sertifikasi", "bobot" => "0.3"],
			["namaKriteria" => "Bahasa", "bobot" => "0.1"],
			["namaKriteria" => "TPA", "bobot" => "0.2"],
			["namaKriteria" => "Nilai_SKP", "bobot" => "0.2"],
		
		];
		$csvData = $this->csvreader->parse_csv($_FILES['userfile']['tmp_name']);
		if(!empty($csvData)){
			$arrayDataPegawai = array();
			foreach($csvData as $row){ 
				$memData = array(
					'Pegawai' => $row['pegawai'],
					'pegawai_pendidikan' => $row['pegawai_pendidikan'],
					'pegawai_perwakilan' => $row['perwakilan'],
					'jabatan_nama' => $row['jabatan_nama'],
					'Diklat' => $row['diklat'],
					'Sertifikasi' => $row['sertifikasi'],
					'Bahasa' => $row['bahasa'],
					'TPA' => $row['tpa'],
					'Nilai_SKP' => $row['nilai_skp'],
					'Tahun' => $row['tahun'],
				);
				array_push($arrayDataPegawai,$memData);
			}
			
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
		
			  	// Hitung Normalisasi Benefit dan assign ke setiap pegawai
				foreach ($arrayDataPegawai as $n) {
					$c = array();
					foreach ($hasilMaxDariSetiapKriteria as $hmdsk) {
						array_push($c, array(
							'nama_kriteria' => $hmdsk['nama_kriteria'],
							'hasil' => $n[$hmdsk['nama_kriteria']] / $hmdsk['hasil'],
						));
					}
					array_push($nilaiHasilBagiAntaraNilaiKriteriaDanNilaiMaxKriteria, array(
						'Pegawai' => $n['Pegawai'],
						'pegawai_pendidikan' => $n['pegawai_pendidikan'],
						'pegawai_perwakilan' => $n['pegawai_perwakilan'],
						'jabatan_nama' => $n['jabatan_nama'],
						'tahun' => $n['Tahun'],
						'hasil_akhir' => $c,
					));
				}

				// Dibobotin dan nambah nilai akhir
				foreach ($nilaiHasilBagiAntaraNilaiKriteriaDanNilaiMaxKriteria as $n) {
				$val = array(
					'Pegawai' => $n['Pegawai'],
					'Pendidikan' => $n['pegawai_pendidikan'],
					'Jabatan' => $n['jabatan_nama'],
					'Tahun' => $n['tahun'],
					'Pegawai Perwakilan' => $n['pegawai_perwakilan'],
				
					'Diklat' => ($n['hasil_akhir'][0]['hasil'] * $kriteria[0]['bobot']),
					'Sertifikasi' => ($n['hasil_akhir'][1]['hasil'] * $kriteria[1]['bobot']),
					'Bahasa' => ($n['hasil_akhir'][2]['hasil'] * $kriteria[2]['bobot']),
					'TPA' => ($n['hasil_akhir'][2]['hasil'] * $kriteria[3]['bobot']),
					'Nilai_Skp' => ($n['hasil_akhir'][2]['hasil'] * $kriteria[4]['bobot']),
					'total_nilai' => ($n['hasil_akhir'][0]['hasil'] * $kriteria[0]['bobot']) +
					($n['hasil_akhir'][1]['hasil'] * $kriteria[1]['bobot']) +
					($n['hasil_akhir'][2]['hasil'] * $kriteria[2]['bobot']) +
					($n['hasil_akhir'][3]['hasil'] * $kriteria[3]['bobot']) +
					($n['hasil_akhir'][4]['hasil'] * $kriteria[4]['bobot']),
		
				);
				array_push($nilaiFinal,$val);
				}

				//   EXPORT TO CSV
				  $delimiter = ","; 
				  $filename = "SAW_" . date('Y-m-d') . ".csv"; 
				  $f = fopen('php://memory', 'w'); 
				  $fields = array();
				  foreach ($nilaiFinal[0] as $k => $a){
					array_push($fields,$k);
					
				  };
				  fputcsv($f, $fields, $delimiter); 
				  foreach($nilaiFinal as $n){
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
