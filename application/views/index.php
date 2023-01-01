<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Tim KMeans BPK </title>

	<link href="assets/static/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
          <span class="align-middle">TIM KMeans BPK</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Pages
					</li>

					<li class="sidebar-item active">
						<a class="sidebar-link" href="index.html">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Tools</span>
            </a>
					</li>

				
				</ul>

			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">
					<div class="row">
					<div class="col-md-4">
							<div class="card">
								<div class="card-body">
								
								<h1 class="h3 mb-3" style=""><strong>Tim Kmeans</strong> Tool Perhitungan SAW </h1>
								<p>Kami Menyediakan Tool Perhitungan Dinamis yang dapat mempermudah penggunaan metode SAW untuk Kepentingan Instansi </p>
								<img src="http://nadyafriska.000webhostapp.com/logo-bpk-kaltara.png" style="display: block; width: 150px; margin:0 auto;">
								</div>
							</div>
						</div>
						<div class="col-md-8">
						<div class="card">
								<div class="card-body">

								<h1 class="h3 mb-3" style=""><strong>Cara </strong>Menggunakan Tools </h1>
								<a href="<?= base_url() ?>/uploads/sampleData.xlsx"><input type="submit" class="btn btn-success float-right"  name="template" value="Download Template" /></a>
								<p>
									<br>
										1. Silahkan Download Template yang disediakan . <br>
										2. Silahkan ubah baris atas sesuai kebutuhan.<br>
										3. Jika salah satu kolom merupakan kriteria yang ingin dihitung, silahkan isi dengan format: <br>kriteria_<strong>Nama Kriteria</strong>=<strong>jumlah bobot</strong>.
										<br>
										4. Jika Kriteria Berjenis Cost, silahkan tambahkan tanda <strong> - </strong> sebelum jumlah bobot. Contoh: <br></p>
										<div style="padding:5px 10px; border: 1px solid black" >
										a. Terdapat kolom <strong>kriteria_Usia=-20</strong> <br>
										Maka kolom Usia merupakan Sebuah Kriteria . berjenis cost dan memiliki bobot 20 <br>
										b. Terdapat kolom <strong>kriteria_Nilai_Tes=30</strong> <br>
										Maka kolom Nilai Tes merupakan Sebuah Kriteria . berjenis Benefit dan memiliki bobot 30 <br>
										c. Terdapat kolom <strong>Pegawai</strong> <br>
										Maka kolom Pegawai bukan merupakan Sebuah Kriteria (hanya kolom keterangan)
										</div> <br>
										<p>
										5. Pada Baris Selanjutnya, isilah data sesuai keinginan.<br>
										6. Upload File ke Form Yang disediakan, lalu pilih Hitung SAW.<br>
										7. File Akan terunduh dengan format csv.
									</p>
									
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12 col-xxl-12 d-flex">
						<div class="card flex-fill w-100">
								<div class="card-header">
								<h1 class="h3 mb-3" style=""><strong>Form</strong> Hitung SAW </h1>
								</div>
								<div class="card-body py-3">
								<?php echo form_open_multipart('CDashboard/do_upload');?>
									<!-- <div class="row">
										<div class="table-responsive">  
										<label class="form-label">Kriteria</label>
											<table class="table table-bordered" id="dynamic_field">  
												<tr class="dyanamic-rows">  
													<td><input type="text" name="kriteria[]" placeholder="Tuliskan Kriteria" class="form-control name_list" required="" /></td>  
													<td><input type="text" name="bobot[]" placeholder="Tuliskan Bobot Kriteria" class="form-control name_list" required="" /></td>  
													<td><button type="button" name="add" id="add" class="btn btn-primary">Tambah Kriteria</button></td>  
												</tr>  
											</table>  
										</div>
									</div> -->
									<label class="form-label">Upload File</label>
										<div class="row">
											<div class="mb-3" style="width:100% ;">
												<input class="form-control form-control-lg" type="file" name="userfile" >
											</div>
											<div class="text-center mb-3" style="width:100% ;float:right;">
											<input type="submit" class="btn btn-primary w-100 float-right" style="float:right" name="importSubmit" value="Hitung SAW">
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						

					</div>
					
				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a>								&copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="assets/static/js/app.js"></script>
	<script
		src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
		integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo="
		crossorigin="anonymous"></script>
	

</body>


<script type="text/javascript">
    $(document).ready(function(){      
      var i=1;  
   
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="kriteria[]" placeholder="Tuliskan Kriteria" class="form-control name_list" required /></td><td><input type="text" name="bobot[]" placeholder="Tuliskan Bobot Kriteria" class="form-control name_list" required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });
  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
  
    });  
</script>
</html>
