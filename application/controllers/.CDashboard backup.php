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
	function min_attribute_in_array($array, $prop) {
		return min(array_map(function($o) use($prop) {
								return $o[$prop];
							 },
							 $array));
	} 
	function do_upload(){
		// dd($_POST);
		
		$postLength = count($_POST['kriteria'])  ;
		// dd($_POST);
		$kriteria = array();
		for($a=0;$a<$postLength; $a++){
			$tempKriteria = array (
				"namaKriteria" => $_POST['kriteria'][$a],
				"bobot" => $_POST['bobot'][$a],
				"jenis" => "cost"
			);
			array_push($kriteria,$tempKriteria);
	
		}
		// dd($kriteria);
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
			  $hasilMaxMinDariSetiapKriteria = array();
                
			  //hasil pembagian antara nilai kriteria dan nilai max kriteria

				//   Cari nilai max disetiap kriteria
			  foreach ($kriteria as $k) {
				if($k['jenis'] == "cost"){
					$min = $this -> min_attribute_in_array($arrayDataPegawai, $k['namaKriteria']);
				array_push($hasilMaxMinDariSetiapKriteria, array(
                    'nama_kriteria' => $k['namaKriteria'],
                    'hasil' => $min,
					'jenis' => 'cost'
				));
				} else {
				$max = $this -> max_attribute_in_array($arrayDataPegawai, $k['namaKriteria']);
				array_push($hasilMaxMinDariSetiapKriteria, array(
                    'nama_kriteria' => $k['namaKriteria'],
                    'hasil' => $max,
					'jenis' => 'benefit'
                ));
				}
			  }
			  	$row = $nilaitotal = 0;
			  	// Hitung Normalisasi Benefit dan assign ke setiap pegawai
				foreach ($arrayDataPegawai as $n) {
					foreach ($hasilMaxMinDariSetiapKriteria as $hmdsk) {
						if($hmdsk['jenis'] = "cost"){
							if($hmdsk['hasil'] == 0){
								$arrayDataPegawai[$row][$hmdsk['nama_kriteria']] = 1;
							} else {
							$arrayDataPegawai[$row][$hmdsk['nama_kriteria']] =$hmdsk['hasil'] /  $arrayDataPegawai[$row][$hmdsk['nama_kriteria']] ;
							}
							
						}else {
							$arrayDataPegawai[$row][$hmdsk['nama_kriteria']] = $arrayDataPegawai[$row][$hmdsk['nama_kriteria']] / $hmdsk['hasil'];
						}
					
						
					}
					foreach($kriteria as $k){
						$arrayDataPegawai[$row][$k['namaKriteria']] = $arrayDataPegawai[$row][$k['namaKriteria']] * $k['bobot'];
						$nilaitotal +=  $arrayDataPegawai[$row][$k['namaKriteria']];
					}
					$arrayDataPegawai[$row]['total_nilai'] = $nilaitotal;
					
					$nilaitotal = 0;
					$row++;
				}
				dd($arrayDataPegawai);

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
