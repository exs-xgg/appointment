	<div id="top-bar" class="container">
			<div class="row">
				<div class="span4">
					<form method="POST" class="search_form">

					</form>
				</div>
				<div class="span8">
					<div class="account pull-right">
						<ul class="user-menu">
							<?php
								if(!$this->ion_auth->logged_in())
								{
									echo('<li><a href="'.base_url('index.php/dashboard/login').'">Login</a></li>');
								}
								else
								{
									$fullName = $this->ion_auth->user()->row();
									echo('<li><a href="'.base_url('index.php/dashboard/login').'">Hi '.$fullName->first_name.'!</a></li>');
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="wrapper" class="container">
			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">
					<a href="index.html" class="logo pull-left"><img src="<?php echo base_url('asset/include/themes/images/logos.png'); ?>" class="site_logo" alt="
					"></a>
					<nav id="menu" class="pull-right">
						<ul>
							<li><a href="<?php echo base_url(''); ?>">Home</a>
							</li>
							<li><a href="<?php echo base_url('index.php/about'); ?>">About Us</a></li>
							<li><a href="<?php echo base_url('index.php/contact'); ?>">Contact</a>
							</li>
						</ul>
					</nav>
				</div>
			</section>
			<section class="main-content">
				<!-- -->

				<div class="navbar-inner">
					<nav id="menu" class="pull-left">
						<ul>
							<li><a href="<?php echo base_url('/index.php/dashboard'); ?>">Calendar</a></li>
							<li><a href="<?php echo base_url('/index.php/dashboard/profile'); ?>">Profile</a></li>

							<?php
								if($this->ion_auth->in_group("admin"))
								{
									echo '<li><a href="'.base_url('index.php/dashboard/appointment').'">Appointments</a></li>';
									echo '<li><a href="'.base_url('index.php/dashboard/services').'">Services</a></li>';
									echo '<li><a href="'.base_url('index.php/dashboard/users').'">Users</a></li>';
								}
							?>

							<li><a href="<?php echo base_url('index.php/dashboard/logout'); ?>">Logout</a></li>
						</ul>
					</nav>
				</div>

				<br>
				<iframe id="txtArea1" style="display:none"></iframe>
				<div class="tab-content">
					<div class="well">
						<div class="well-body">
							<h3>SELECT DATE RANGE TO VIEW RECORDS</h3>
							<div class="">
								<div class="">
									
										<label>Start Date</label><input type="date" id="start_date">
									
									
										<label>End Date</label><input type="date" id="end_date">
									
									<br>
										<button class="btn btn-primary" onclick="searchRecs()">SEARCH RECORDS</button>&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-success" id="btnExport" onclick="fnExcelReport();" disabled> EXPORT TO EXCEL </button>
									
								</div>
							</div>
						</div>
					</div>
					
					<table class="table" id="rec_tbl">
				    <thead>
				      <tr>
						<th>Date</th>
						<th>Client Name</th>
				        <th>Time Start</th>
				        <th>Time End</th>
						<th>Service Type</th>
						<th>Status</th>
				      </tr>
				    </thead>
				    <tbody>
							
				    </tbody>
				  </table>
				</div>


			</section>
			<section id="footer-bar">
			</section>
			<section id="copyright">
				<span>Copyright 2019 All right reserved.</span>
			</section>
		</div>
		<script>
			function searchRecs(){
				$("#btnExport").attr("disabled");
				var url = window.location.href;
        		var arr = url.split("/");
				$start_date = $("#start_date").val();
				$end_date = $("#end_date").val();
				$.get({
					url: window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/searchRecords?start_date=" + $start_date + "&end_date=" + $end_date,
					success: function(res){
						
						$("#rec_tbl tbody").empty();
						console.table(JSON.parse(res));
						res = JSON.parse(res);
						res.forEach(function(v)
						{	
							var class_anuna = "";
							var anuna = ((v.is_cancelled=='1') ? '0' : ((v.is_show=='1') ? '9' : '1' ) );
							switch (anuna) {
								case '0':
									class_anuna = 'danger';
									anuna = "Cancelled";
									break;
								case '9':
									class_anuna = 'success';
									anuna = "Showed Up";
									break;
								case '1':
									class_anuna = 'warning';
									anuna = "Pending";
									break;
							
								default:
									break;
							}
							var rts = moment(v.start.split("T")[1].substr(0,5),"HH:mm").format('hh:mm A');
							var rte = moment(v.end.split("T")[1].substr(0,5),"HH:mm").format('hh:mm A');;
							var rf = v.title.split(" / ");
							$('#rec_tbl tbody').append('<tr>\
							<td>' + moment(v.start).format("MM-DD-YYYY") + '</td>\
						<td>'+ rf[0] + '</td>\
				        <td>'+ rts + '</td>\
				        <td>'+ rte + '</td>\
						<td>'+ rf[1] + '</td>\
						<td class="badge badge-'+class_anuna+'">' + anuna + '</td></tr>');
						});
					}
				});
				
				$("#btnExport").removeAttr("disabled");
			}


			function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('rec_tbl'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Report.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}
		</script>

    
