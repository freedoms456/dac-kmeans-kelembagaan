<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
    function do_upload_old(){
		// dd($_POST);
		
		$postLength = count($_POST['kriteria'])  ;
		// dd($_POST);
		$kriteria = array();
		for($a=0;$a<$postLength; $a++){
			$tempKriteria = array (
				"namaKriteria" => $_POST['kriteria'][$a],
				"bobot" => $_POST['bobot'][$a]
			);
			array_push($kriteria,$tempKriteria);
	
		}
		
		$csvData = $this->csvreader->parse_csv($_FILES['userfile']['tmp_name']);
		if(!empty($csvData)){
			$arrayDataPegawai = array();
			foreach($csvData as $row){ 
				foreach($kriteria as $k){
					$row[$k['namaKriteria']] = $row[$k['namaKriteria']];
				}
				array_push($arrayDataPegawai,$row);
			}

			  //hasil max setiap kriteria dalam bentuk array
			  $hasilMaxDariSetiapKriteria = array();
                
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
					array_push($hasilMaxDariSetiapKriteria, array(
						'nama_kriteria' => $k['namaKriteria'],
						'hasil' => $max,
						'jenis' => 'benefit'
					));
				}
			  }
			  	$row = $nilaitotal = 0;
			  	// Hitung Normalisasi Benefit dan assign ke setiap pegawai
				foreach ($arrayDataPegawai as $n) {
					foreach ($hasilMaxDariSetiapKriteria as $hmdsk) {
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

    function do_upload(){
       
        $spreadsheet = new Spreadsheet();
        
        // extend supaya multi type
        $inputFileType = 'Xlsx';

        // jagain kalo ga ada file
        $inputFileName = $_FILES['userfile']['tmp_name'];;

            
        if(!empty($inputFileName)){

            // reading & extract file
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            
            $spreadsheet  = $reader->load($inputFileName);

            // extract ke worksheet
            $worksheet = $spreadsheet->getActiveSheet();
                
            $rows = $worksheet->toArray();

            // jagain barangkali tidak ada header
            $rows_header = $rows[0];
            
            $kriteria = array();

            // ini untuk arrPegawai
            $kriteria_header = array();

            // bisa buat input
			
			
			// dd($kriteria_header);
			// for ($i=0; $i < $idx_start_kriteria ; $i++) { 
            //     array_push($kriteria_header, $rows_header[$i]) ;
            // }
            foreach ($rows_header as $head) {
                // dd($head);
				if(!preg_match("/kriteria+_+[a-zA-Z0-9._-]+[=]/", strtolower($head))){
					array_push($kriteria_header,$head);
				} 
            	   else if(preg_match("/kriteria+_+[a-zA-Z0-9._-]+[=]/", strtolower($head))) {
                    $temp = $this->multiexplode(array("riteria_","="),$head);
                    $k = null;
                    if((int)$temp[2] < 0) {
                        $k = array('namaKriteria' => strtolower($temp[1]), 'bobot' => ($temp[2]  * -1), 'jenis' => 'cost');
                    } else {
                        $k = array('namaKriteria' => strtolower($temp[1]), 'bobot' => $temp[2], 'jenis' => 'benefit');
                    }
					
                    array_push($kriteria, $k);

                    array_push($kriteria_header, $temp[1]);
                }
			
            }

			

            $arrayDataPegawai = array();

            foreach ($rows as $k => $r) {
                if ($k < 1) continue;     
			
                $temp_each = array(); 
                
                foreach ($kriteria_header as $key => $kh) {
				
                    $kh = strtolower($kh);
                    $temp_each[$kh] = $r[$key];
				

                }  
			
                
                array_push($arrayDataPegawai, $temp_each);
            }

			

         
            /*
            foreach($csvData as $row){ 
                foreach($kriteria as $k){
                    $row[$k['namaKriteria']] = $row[$k['namaKriteria']];
                }
                array_push($arrayDataPegawai,$row);
            }
            */


              //hasil max setiap kriteria dalam bentuk array
              $hasilMaxDariSetiapKriteria = array();
                
              //hasil pembagian antara nilai kriteria dan nilai max kriteria
				
                //   Cari nilai max disetiap kriteria
              foreach ($kriteria as $k) {
				if($k['jenis'] == "cost"){
					$min = $this -> min_attribute_in_array($arrayDataPegawai, $k['namaKriteria']);
				array_push($hasilMaxDariSetiapKriteria, array(
                    'nama_kriteria' => $k['namaKriteria'],
                    'hasil' => $min,
					'jenis' => 'cost'
				));
				
				} else {
					$max = $this -> max_attribute_in_array($arrayDataPegawai, $k['namaKriteria']);
					array_push($hasilMaxDariSetiapKriteria, array(
						'nama_kriteria' => $k['namaKriteria'],
						'hasil' => $max,
						'jenis' => 'benefit'
					));
				}
              }
                $row = $nilaitotal = 0;
                // Hitung Normalisasi Benefit dan assign ke setiap pegawai
                foreach ($arrayDataPegawai as $n) {
					foreach ($hasilMaxDariSetiapKriteria as $hmdsk) {
						if($hmdsk['jenis'] == "cost"){
							if($hmdsk['hasil'] == 0){
								$arrayDataPegawai[$row][$hmdsk['nama_kriteria']] = 1;
							} else {
							$arrayDataPegawai[$row][$hmdsk['nama_kriteria']] = $hmdsk['hasil'] /  $arrayDataPegawai[$row][$hmdsk['nama_kriteria']] ;
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

    function multiexplode($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);

        $launch = explode($delimiters[0], $ready);

        return  $launch;
    }
}
