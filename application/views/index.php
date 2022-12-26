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
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>

				
				</ul>

				<!-- <div class="sidebar-cta">
					<div class="sidebar-cta-content">
						<strong class="d-inline-block mb-2">Upgrade to Pro</strong>
						<div class="mb-3 text-sm">
							Are you looking for more components? Check out our premium version.
						</div>
						<div class="d-grid">
							<a href="upgrade-to-pro.html" class="btn btn-primary">Upgrade to Pro</a>
						</div>
					</div>
				</div> -->
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<!-- <li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="message-square"></i>
								</div>
							</a>
							
						</li> -->
						<!-- <li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <span class="text-dark">Charles Hall</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Log out</a>
							</div>
						</li> -->
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3"><strong>Tools</strong> Perhitungan SAW </h1>

									<div class="row">
						<div class="col-xl-12 col-xxl-12 d-flex">
						<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Hitung SAW</h5>
								</div>
								<div class="card-body py-3">
								<?php echo form_open_multipart('CDashboard/do_upload');?>
									<div class="row">
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
									</div>
									<label class="form-label">Upload File</label>
										<div class="row">
											<div class="mb-3" style="width:100% ;">
												<input class="form-control form-control-lg" type="file" name="userfile" >
											</div>
											<div class="text-center mb-3" style="width:100% ;float:right;">
											<input type="submit" class="btn btn-primary w-50 float-right" style="float:right" name="importSubmit" value="Hitung SAW">
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
