<div class="header">
   	<h2 style="margin-left: 20px">USER LISTS</h2>
    <div class="alert alert-success" style="display: none;">                	
    </div>
        <button data-toggle="tooltip" title="Add Users" class="btn btn-success btn-xs" style="margin-left: 20px;margin-top: 10px" onclick="add_user()" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-plus"></i></button>
            <div class="body table-responsive">
            	<table id="table_id" class="table table-hover js-basic-example dataTable" >
                   	<thead>
                        <tr>
	                        <th>Name</th>
	                       	<th>ID Card Number</th>
	                        <th>NIK</th>
	                        <th>ID Card Photo</th>
	                        <th>Photo Employee Card</th>
	                        <th>Phone Number</th>
	                        <th>Level</th>
	                        <th>Units</th>
	                        <th>Opsi</th>
                        </tr>
                    </thead>

                    <tbody>
                    
                    </tbody>
                </table>
            </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		 //datatables
        table = $('#table_id').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "searchDelay": 2000,
             
            "ajax": {
                "url": "<?php echo site_url('users/get_data_users')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
            { 
                "orderable": false, 
                "targets": [ 3, 4, 7, 8], 
                
                // "width": "9%", "targets": 4,
                // "width": "9%", "targets": 8,
            },
            { width: '120px', targets: 0},
            { width: '50px', targets: 3},
            { width: '60px', targets: 4},
            { width: '5px', targets: 7},

            ],
 
        });
        $('#table_id').on('draw.dt', function () {
                    $('[data-toggle="tooltip"]').tooltip();
        });
        
        $('[data-toggle="tooltip"]').tooltip();
	});

	$(document).ready(function(){
        $("#nik").keyup(delay(function (e) {
		   	var nik = $('#nik').val();
		   	var no_ktp = $('#no_ktp').val();
		   	
		   	if(nik != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cekNIK",
			    method: "POST",
			    data: {nik:nik},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#nik_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> NIK already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#nik_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> NIK is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#nik_result').html('');
		   	}
	  	},  800));

	  	$("#nik_edit").keyup(delay(function (e) {
		   	var nik_edit = $('#nik_edit').val();
		   	// var no_ktp = $('#no_ktp').val();
		   	
		   	if(nik_edit != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cekNIK_edit",
			    method: "POST",
			    data: {nik_edit:nik_edit},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#nik_edit_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> NIK already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#nik_edit_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> NIK is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#nik_edit_result').html('');
		   	}
	  	},  800));
	});

	$(document).ready(function(){
        $("#no_ktp").keyup(delay(function (e) {
		   	var no_ktp = $('#no_ktp').val();
		   	
		   	if(no_ktp != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cek_no_ktp",
			    method: "POST",
			    data: {no_ktp:no_ktp},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#no_ktp_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> ID Card Number already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#no_ktp_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> ID Card Number is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#no_ktp_result').html('');
		   	}
	  	},  800));

	  	$("#no_ktp_edit").keyup(delay(function (e) {
		   	var no_ktp_edit = $('#no_ktp_edit').val();
		   	
		   	if(no_ktp_edit != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cek_no_ktp_edit",
			    method: "POST",
			    data: {no_ktp_edit:no_ktp_edit},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#no_ktp_edit_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> ID Card Number already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#no_ktp_edit_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> ID Card Number is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#no_ktp_edit_result').html('');
		   	}
	  	},  800));
	});

	$(document).ready(function(){
        $("#no_hp").keyup(delay(function (e) {
		   	var no_hp = $('#no_hp').val();
		   	
		   	if(no_hp != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cek_no_hp",
			    method: "POST",
			    data: {no_hp:no_hp},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#no_hp_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> Phone Number already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#no_hp_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Phone Number is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#no_hp_result').html('');
		   	}
	  	},  800));

	  	$("#no_hp_edit").keyup(delay(function (e) {
		   	var no_hp_edit = $('#no_hp_edit').val();
		   	
		   	if(no_hp_edit != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cek_no_hp_edit",
			    method: "POST",
			    data: {no_hp_edit:no_hp_edit},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#no_hp_edit_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> Phone Number already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#no_hp_edit_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Phone Number is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#no_hp_edit_result').html('');
		   	}
	  	},  800));
	});

	$(document).ready(function(){
        $("#id_telegram").keyup(delay(function (e) {
		   	var id_telegram = $('#id_telegram').val();
		   	
		   	if(id_telegram != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cek_id_telegram",
			    method: "POST",
			    data: {id_telegram:id_telegram},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#id_telegram_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> ID Telegram already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#id_telegram_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> ID Telegram is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#id_telegram_result').html('');
		   	}
	  	},  800));

	  	$("#id_telegram_edit").keyup(delay(function (e) {
		   	var id_telegram_edit = $('#id_telegram_edit').val();
		   	
		   	if(id_telegram_edit != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>users/cek_id_telegram_edit",
			    method: "POST",
			    data: {id_telegram_edit:id_telegram_edit},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#id_telegram_edit_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> ID Telegram already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#id_telegram_edit_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> ID Telegram is available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#id_telegram_edit_result').html('');
		   	}
	  	},  800));
	});

	function delay(callback, ms) {
	  var timer = 0;
	  return function() {
	    var context = this, args = arguments;
	    clearTimeout(timer);
	    timer = setTimeout(function () {
	      callback.apply(context, args);
	    }, ms || 0);
	  };
	}

	$(document).ready(function(){
        $("#no_ktp").keyup(function () {
		    $(".pesan-no_ktp").hide();
		});
		$("#nama").keyup(function () {
		    $(".pesan-nama").hide();
		});
		$("#instansi").keyup(function () {
		    $(".pesan-instansi").hide();
		});
		$('#posisi').keyup(function(){
		    $(".pesan-posisi").hide();
		});
		$('#no_hp').keyup(function(){
		    $(".pesan-no_hp").hide();
		});
		$('#nik').keyup(function(){
		    $(".pesan-nik").hide();
		});
		$('#id_telegram').keyup(function(){
		    $(".pesan-id_telegram").hide();
		});
		$('#level').change(function(){
		    $(".pesan-level").hide();
		});
		$('#userfile').change(function(){
		    $(".pesan-userfile").hide();
		});
		$('#userfile1').change(function(){
		    $(".pesan-userfile1").hide();
		});
		$("#no_ktp_edit").keyup(function () {
		    $(".pesan-no_ktp").hide();
		});
		$("#nama_edit").keyup(function () {
		    $(".pesan-nama").hide();
		});
		$("#instansi_edit").keyup(function () {
		    $(".pesan-instansi").hide();
		});
		$('#posisi_edit').keyup(function(){
		    $(".pesan-posisi").hide();
		});
		$('#no_hp_edit').keyup(function(){
		    $(".pesan-no_hp").hide();
		});
		$('#nik_edit').keyup(function(){
		    $(".pesan-nik").hide();
		});
		$('#id_telegram_edit').keyup(function(){
		    $(".pesan-id_telegram").hide();
		});
		$('#level1_edit').change(function(){
		    $(".pesan-level").hide();
		});
		$('#userfile_edit').change(function(){
		    $(".pesan-userfile").hide();
		});
		$('#userfile1_edit').change(function(){
		    $(".pesan-userfile1").hide();
		});
	});

	var save_method;
	var table;

	function add_user() {
		save_method = 'add';
		$('#form')[0].reset();
		$('#modal_form_user').val('');
		$('#nik_result').html('');
		$('#no_ktp_result').html('');
		$('#no_hp_result').html('');
		$('#id_telegram_result').html('');
		$(".pesan-no_ktp").hide();
		$(".pesan-nama").hide();
		$(".pesan-instansi").hide();
		$(".pesan-posisi").hide();
		$(".pesan-no_hp").hide();
		$(".pesan-nik").hide();
		$(".pesan-id_telegram").hide();
		$(".pesan-level").hide();
		$(".pesan-userfile").hide();
		$(".pesan-userfile1").hide();
		$(".pesan-type_userfile").hide();
		$(".pesan-type_userfile1").hide();
		$('#sub_button').attr("disabled", false);
		$("#modal_form_user_title").text('Add User');
		$('#modal_form_add_user').modal('show');
	}

	function save() {
		var url;

		if(save_method == 'add') {
			url = '<?php echo site_url('Users/addUser') ;?>';

			var no_ktp = $('#no_ktp').val().length;			
			var nama = $('#nama').val().length;			
			var instansi = $('#instansi').val().length;			
			var posisi = $('#posisi').val().length;			
			var no_hp = $('#no_hp').val().length;			
			var nik = $('#nik').val().length;			
			var id_telegram = $('#id_telegram').val().length;			
			var level = $('#level').val().length;			
			var userfile = $('#userfile').val().length;			
			var userfile1 = $('#userfile1').val().length;			

				if (no_ktp == 0 || nama == 0 || instansi == 0 || posisi == 0 || no_hp == 0 || nik == 0 || id_telegram == 0 || level == 0 || userfile == 0 || userfile1 == 0) {				
					if (no_ktp == 0) {				
						$(".pesan-no_ktp").css('display','block');
					}
					if (nama == 0) {				
						$(".pesan-nama").css('display','block');
					}
					if (instansi == 0) {				
						$(".pesan-instansi").css('display','block');
					}
					if (posisi == 0) {				
						$(".pesan-posisi").css('display','block');
					}
					if (no_hp == 0) {				
						$(".pesan-no_hp").css('display','block');
					}
					if (nik == 0) {				
						$(".pesan-nik").css('display','block');
					}
					if (id_telegram == 0) {				
						$(".pesan-id_telegram").css('display','block');
					}
					if (level == 0) {				
						$(".pesan-level").css('display','block');
					}
					if (userfile == 0) {				
						$(".pesan-userfile").css('display','block');
					}
					if (userfile1 == 0) {				
						$(".pesan-userfile1").css('display','block');
					}
					return false;
				}
		}

		var formData = new FormData($('#form')[0]);
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: formData,
	        contentType: false,
	        processData: false,
	        dataType: "JSON",
	        success: function(data) {
	 		 		$('#modal_form_add_user').modal('hide');
	                reload_table();
	                if(save_method == 'add') {
						toastr.success('Add User Successfully!', 'Success', {timeOut: 5000})
					} else {
						toastr.success('Edit User Successfully!', 'Success', {timeOut: 5000})
					}
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            toastr.error('Failed Add or Edit User!', 'Failed', {timeOut: 5000})
	        }
	    });
	}

	function save_edit() {
		var url;

		if (save_method == 'update') {
			url = '<?php echo site_url('Users/user_update') ;?>';

			var no_ktp = $('#no_ktp_edit').val().length;			
			var nama = $('#nama_edit').val().length;			
			var instansi = $('#instansi_edit').val().length;			
			var posisi = $('#posisi_edit').val().length;			
			var no_hp = $('#no_hp_edit').val().length;			
			var nik = $('#nik_edit').val().length;			
			var id_telegram = $('#id_telegram_edit').val().length;			
			var level = $('#level1_edit').val().length;						


				if (no_ktp == 0 || nama == 0 || instansi == 0 || posisi == 0 || no_hp == 0 || nik == 0 || id_telegram == 0 || level == 0) {				
					if (no_ktp == 0) {				
						$(".pesan-no_ktp").css('display','block');
					}
					if (nama == 0) {				
						$(".pesan-nama").css('display','block');
					}
					if (instansi == 0) {				
						$(".pesan-instansi").css('display','block');
					}
					if (posisi == 0) {				
						$(".pesan-posisi").css('display','block');
					}
					if (no_hp == 0) {				
						$(".pesan-no_hp").css('display','block');
					}
					if (nik == 0) {				
						$(".pesan-nik").css('display','block');
					}
					if (id_telegram == 0) {				
						$(".pesan-id_telegram").css('display','block');
					}
					if (level == 0) {				
						$(".pesan-level").css('display','block');
					}
					return false;
				}
		}

		var formData = new FormData($('#form2')[0]);
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: formData,
	        contentType: false,
	        processData: false,
	        dataType: "JSON",
	        success: function(data) {
	 		 		$('#modal_form_edit_user').modal('hide');
	                reload_table();
	                if(save_method == 'add') {
						toastr.success('Add User Successfully!', 'Success', {timeOut: 5000})
					} else {
						toastr.success('Edit User Successfully!', 'Success', {timeOut: 5000})
					}
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            toastr.error('Failed Add or Edit User!', 'Failed', {timeOut: 5000})
	        }
	    });
	}

	function edit_user(id_user) {
		save_method = 'update';
		$('#form2')[0].reset();
		$('#nik_result').html('');
		$('#nik_edit_result').html('');
		$('#no_ktp_result').html('');
		$('#no_ktp_edit_result').html('');
		$('#no_hp_result').html('');
		$('#no_hp_edit_result').html('');
		$('#id_telegram_result').html('');
		$('#id_telegram_edit_result').html('');
		$(".pesan-no_ktp").hide();
		$(".pesan-nama").hide();
		$(".pesan-instansi").hide();
		$(".pesan-posisi").hide();
		$(".pesan-no_hp").hide();
		$(".pesan-nik").hide();
		$(".pesan-id_telegram").hide();
		$(".pesan-level").hide();
		$(".pesan-userfile").hide();
		$(".pesan-userfile1").hide();
		$(".pesan-type_userfile").hide();
		$(".pesan-type_userfile1").hide();
		$('#modal_form_edit_user').modal('show');
		$('#sub_button').attr("disabled", false);

		//load data dari AJAX
		$.ajax({
			url: "<?php echo site_url('users/ajax_edit/') ;?>"+id_user,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				$('[name="id_user_edit"]').val(data.id_user);
				$('[name="no_ktp_edit"]').val(data.no_ktp);
				$('[name="nama_edit"]').val(data.nama);
				$('[name="instansi_edit"]').val(data.instansi);
				$('[name="posisi_edit"]').val(data.posisi);
				$('[name="no_hp_edit"]').val(data.no_hp);
				$('[name="nik_edit"]').val(data.nik);
				$('[name="id_telegram_edit"]').val(data.id_telegram);
				$('[name="level_edit"]').val(data.level);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error Get Data From AJAX');
			}
		});
	}

	function delete_user(id) {	
			$.ajax({
				url: "<?php echo site_url('users/delete_user/') ;?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					toastr.success('Delete User Successfully!', 'Success', {timeOut: 5000})
					$('#modal_delete').modal('hide');
					table.ajax.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error Deleting Data');
				}
			});
	}

	function view_units(id){
		window.location.href = "<?php echo site_url('users/view_units/') ;?>"+id;
	}

	function delete_modal(id){
        $.ajax({
				url: "<?php echo site_url('users/get_name_for_delete/') ;?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$("#text_hapus").empty();
					$('#button_delete').attr('onclick', 'delete_user('+id+')');
					$('#modal_delete_title').text('Are you sure?');
					htmlString = "Are you sure you want to delete <b>"+data.nama+"</b>?"
			        $("#text_hapus").append(htmlString);
			        $('#modal_delete').modal('show');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error Deleting Data');
				}
		});
	}

	function reload_table(){
	    table.ajax.reload(null,false); //reload datatable ajax 
	}

	function view_file(id_user){
		$.ajax({
					url: '<?php echo base_url('Users/view_file') ;?>/'+id_user,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
					 var fileInput = "<?php echo site_url('../../simaru/assets/images') ;?>/"+data.foto_ktp;
					 // var fileInput = "<?php echo site_url('assets/upload/dokumen/') ;?>/"+data.foto_ktp;
					 var extension = fileInput.substr((fileInput.lastIndexOf('.') +1));
					  if (/(jpg)$/ig.test(extension)) {
					    $('#jpg').attr('src', '<?php echo site_url('../../simaru/assets/images') ;?>/'+data.foto_ktp);
					    // $('#jpg').attr('src', '<?php echo site_url('assets/upload/dokumen/') ;?>/'+data.foto_ktp);
					    $('#modal_jpg_title').text("View Photo");
                		$('#modal_jpg').modal('show');
                		$("#modal_jpg").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }
					  else if (/(png)$/ig.test(extension)) {
						$('#png').attr('src', '<?php echo site_url('../../simaru/assets/images') ;?>/'+data.foto_ktp);
						 // $('#png').attr('src', '<?php echo site_url('assets/upload/dokumen/') ;?>/'+data.foto_ktp);
                		$('#modal_png_title').text("View Photo");
                		$('#modal_png').modal('show');
                		$("#modal_png").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error');
					}
				});
	}

	function view_file2(id_user){
		$.ajax({
					url: '<?php echo base_url('Users/view_file') ;?>/'+id_user,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
					 var fileInput = "<?php echo site_url('../../simaru/assets/images') ;?>/"+data.foto_ktp;
					 // var fileInput = "<?php echo site_url('assets/upload/dokumen/') ;?>/"+data.foto_ktp;
					 var extension = fileInput.substr((fileInput.lastIndexOf('.') +1));
					  if (/(jpg)$/ig.test(extension)) {
					    $('#jpg').attr('src', '<?php echo site_url('../../simaru/assets/images') ;?>/'+data.foto_karpeg);
					    // $('#jpg').attr('src', '<?php echo site_url('assets/upload/dokumen/') ;?>/'+data.foto_karpeg);
					    $('#modal_jpg_title').text("View Photo");
                		$('#modal_jpg').modal('show');
                		$("#modal_jpg").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }
					  else if (/(png)$/ig.test(extension)) {
						$('#png').attr('src', '<?php echo site_url('../../simaru/assets/images') ;?>/'+data.foto_karpeg);
						// $('#png').attr('src', '<?php echo site_url('assets/upload/dokumen/') ;?>/'+data.foto_karpeg);
                		$('#modal_png_title').text("View Photo");
                		$('#modal_png').modal('show');
                		$("#modal_png").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error');
					}
				});
	}

	function detail_user(id_user){
	    $.ajax({
	                    url: '<?php echo base_url('users/detail_user') ;?>/'+id_user,
	                    success: function(data) {    
	                        $("#table_details_user").html(data);
	                        $('#modal_details_title').text("View Details User");
	                        $('#modal_detail').modal('show'); // show bootstrap modal
	                    },
	                    error: function(jqXHR, textStatus, errorThrown) {
	                        alert('Error');
	                    }
	                });
	}

	// Validasi Tipe file
		// Start Validasi Tipe file
	(function($) {
    $.fn.checkFileType = function(options) {
        var defaults = {
            allowedExtensions: [],
            success: function() {},
            error: function() {}
        };
        options = $.extend(defaults, options);

        return this.each(function() {

            $(this).on('change', function() {
                var value = $(this).val(),
                    file = value.toLowerCase(),
                    extension = file.substring(file.lastIndexOf('.') + 1);

                if ($.inArray(extension, options.allowedExtensions) == -1) {
                    options.error();
                    $(this).focus();
                } else {
                    options.success();

                }

            });

        });
    };

	})(jQuery);

	$(function() {
	    $('#userfile').checkFileType({
	        allowedExtensions: ['jpg', 'png'],
	        success: function() {
	        	$(".pesan-type_userfile").hide();
	            $('#sub_button').attr("disabled", false);
	        },
	        error: function() {
	            $(".pesan-type_userfile").css('display','block');
	            $('#sub_button').attr("disabled", true);
	        }
	    });
	    $('#userfile1').checkFileType({
	        allowedExtensions: ['jpg', 'png'],
	        success: function() {
	        	$(".pesan-type_userfile1").hide();
	            $('#sub_button').attr("disabled", false);
	        },
	        error: function() {
	            $(".pesan-type_userfile1").css('display','block');
	            $('#sub_button').attr("disabled", true);
	        }
	    });
	    $('#userfile_edit').checkFileType({
	        allowedExtensions: ['jpg', 'png'],
	        success: function() {
	        	$(".pesan-type_userfile").hide();
	            $('#sub_button').attr("disabled", false);
	        },
	        error: function() {
	            $(".pesan-type_userfile").css('display','block');
	            $('#sub_button').attr("disabled", true);
	        }
	    });
	    $('#userfile1_edit').checkFileType({
	        allowedExtensions: ['jpg', 'png'],
	        success: function() {
	        	$(".pesan-type_userfile1").hide();
	            $('#sub_button').attr("disabled", false);
	        },
	        error: function() {
	            $(".pesan-type_userfile1").css('display','block');
	            $('#sub_button').attr("disabled", true);
	        }
	    });
	});
		// End Validasi Tipe file
</script>

<!-- Modal Add User-->
            <div class="modal fade" id="modal_form_add_user" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">ADD USER</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form" action="#">
                            	<input type="hidden" value="" name="id_user">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="no_ktp">ID Card Number</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="no_ktp" name="no_ktp" class="form-control" placeholder="Masukkan Nomor KTP">
                                        </div>
                                        <span id="no_ktp_result"></span>
	        							<span class="pesan pesan-no_ktp">Please fill out ID Card Number field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="nama">Name</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama">
                                        </div>
	        							<span class="pesan pesan-nama">Please fill out Name field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="instansi">Agency</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="instansi" name="instansi" class="form-control" placeholder="Masukkan Instansi">
                                        </div>
	        							<span class="pesan pesan-instansi">Please fill out Agency field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="posisi">Position</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="posisi" name="posisi" class="form-control" placeholder="Masukkan Posisi">
                                        </div>
	        							<span class="pesan pesan-posisi">Please fill out Position field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="userfile">ID Card Photo</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" name="userfile" id="userfile" class="form-control" size="20">
                                        </div>
	        							<span class="pesan pesan-userfile">Please fill out ID Card Photo field!</span>
	        							<span class="pesan pesan-type_userfile">Upload error: The filetype you are attempting to upload is not allowed. Please insert files with file types: .jpg or .png</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="userfile1">Photo Employee Card</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" name="userfile1" id="userfile1" class="form-control" size="20">
                                        </div>
	        							<span class="pesan pesan-userfile1">Please fill out Photo Employee Card field!</span>
	        							<span class="pesan pesan-type_userfile1">Upload error: The filetype you are attempting to upload is not allowed. Please insert files with file types: .jpg or .png</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="no_hp">Phone Number</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="no_hp" name="no_hp" class="form-control" placeholder="Masukkan Nomor Telepon">
                                        </div>
                                        <span id="no_hp_result"></span>
	        							<span class="pesan pesan-no_hp">Please fill out Phone Number field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="nik">NIK</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK">
                                        </div>
                                        <span id="nik_result"></span>
	        							<span class="pesan pesan-nik">Please fill out NIK field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="id_telegram">ID Telegram</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="id_telegram" name="id_telegram" class="form-control" placeholder="Masukkan ID Telegram">
                                        </div>
                                        <span id="id_telegram_result"></span>
	        							<span class="pesan pesan-id_telegram">Please fill out ID Telegram field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="level">Level</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
		                                    <?php if($this->session->userdata('level')=='SuperAdmin') : ?>
		                                    <select class="form-control show-tick" name="level" id="level">
		                                        <option value="">-- Please select --</option>
		                                        <option value="User">User</option>
		                                        <option value="Admin">Admin</option>
		                                        <option value="SuperAdmin">Super Admin</option>
		                                    </select>
		                                    <?php endif; ?>
		                                    <?php if($this->session->userdata('level')=='Admin') : ?>
		                                    <select class="form-control show-tick" name="level" id="level">
		                                        <option value="">-- Please select --</option>
		                                        <option value="User">User</option>
		                                    </select>
		                                    <?php endif; ?>
                                		</div>
	        							<span class="pesan pesan-level">Please fill out Level field!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="save()" id="sub_button" class="btn btn-success waves-effect">SAVE</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End Modal add-->

<!-- Modal Edit User -->
            <div class="modal fade" id="modal_form_edit_user" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">EDIT USER</h4>
                        </div>
                        <div class="modal-body">
                            <form id="form2" action="#">
                            	<input type="hidden" value="" name="id_user_edit">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="no_ktp">ID Card Number</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="no_ktp_edit" name="no_ktp_edit" class="form-control" placeholder="Masukkan Nomor KTP">
                                        </div>
                                        <span id="no_ktp_edit_result"></span>
	        							<span class="pesan pesan-no_ktp">Please fill out ID Card Number field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="nama">Name</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="nama_edit" name="nama_edit" class="form-control" placeholder="Masukkan Nama">
                                        </div>
	        							<span class="pesan pesan-nama">Please fill out Name field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="instansi">Agency</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="instansi_edit" name="instansi_edit" class="form-control" placeholder="Masukkan Instansi">
                                        </div>
	        							<span class="pesan pesan-instansi">Please fill out Agency field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="posisi">Position</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" id="posisi_edit" name="posisi_edit" class="form-control" placeholder="Masukkan Posisi">
                                        </div>
	        							<span class="pesan pesan-posisi">Please fill out Position field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="userfile">ID Card Photo</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" name="userfile_edit" id="userfile_edit" class="form-control" size="20">
                                        </div>
	        							<span class="pesan pesan-userfile">Please fill out ID Card Photo field!</span>
	        							<span class="pesan pesan-type_userfile">Upload error: The filetype you are attempting to upload is not allowed. Please insert files with file types: .jpg or .png</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="userfile1">Photo Employee Card</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" name="userfile1_edit" id="userfile1_edit" class="form-control" size="20">
                                        </div>
	        							<span class="pesan pesan-userfile1">Please fill out Photo Employee Card field!</span>
	        							<span class="pesan pesan-type_userfile1">Upload error: The filetype you are attempting to upload is not allowed. Please insert files with file types: .jpg or .png</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="no_hp">Phone Number</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="no_hp_edit" name="no_hp_edit" class="form-control" placeholder="Masukkan Nomor Telepon">
                                        </div>
                                        <span id="no_hp_edit_result"></span>
	        							<span class="pesan pesan-no_hp">Please fill out Phone Number field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="nik">NIK</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="nik_edit" name="nik_edit" class="form-control" placeholder="Masukkan NIK">
                                        </div>
                                        <span id="nik_edit_result"></span>
	        							<span class="pesan pesan-nik">Please fill out NIK field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="id_telegram">ID Telegram</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="number" id="id_telegram_edit" name="id_telegram_edit" class="form-control" placeholder="Masukkan ID Telegram">
                                        </div>
                                        <span id="id_telegram_edit_result"></span>
	        							<span class="pesan pesan-id_telegram">Please fill out ID Telegram field!</span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
                                    <label for="level">Level</label>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
                                    <div class="form-group">
                                        <div class="form-line">
		                                    <?php if($this->session->userdata('level')=='SuperAdmin') : ?>
		                                    <select class="form-control show-tick" name="level_edit" id="level1_edit">
		                                        <option value="">-- Please select --</option>
		                                        <option value="User">User</option>
		                                        <option value="Admin">Admin</option>
		                                        <option value="SuperAdmin">Super Admin</option>
		                                    </select>
		                                    <?php endif; ?>
		                                    <?php if($this->session->userdata('level')=='Admin') : ?>
		                                    <select class="form-control show-tick" name="level_edit" id="level1_edit" disabled="">
		                                        <option value="">-- Please select --</option>
		                                        <option value="User">User</option>
		                                        <option value="Admin">Admin</option>
		                                    </select>
		                                    <?php endif; ?>
                                		</div>
	        							<span class="pesan pesan-level">Please fill out Level field!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="save_edit()" id="sub_button" class="btn btn-success waves-effect">SAVE</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End Modal add-->

<!-- Modal Delete -->
<div id="modal_delete" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE5CD;</i>
				</div>				
				<h4 class="modal-title" id="modal_delete_title"></h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p id="text_hapus"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
				<button type="button" id="button_delete" class="btn btn-danger">Delete</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal JPG -->
<div class="modal fade" id="modal_jpg" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px; right: 50px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_jpg_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="jpg" style="width: 750px; height: auto;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal PNG -->
<div class="modal fade" id="modal_png" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px; right: 50px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_png_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="png" style="width: 750px; height: auto;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Details User -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width: 263px; left: 320px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_details_title"></h4>
      </div>
      <div class="modal-body">
        <form name="form1" id="form1">
            <table class="table table-responsive" >
                    <thead>
                            <tr>
                                <th>Agency</th>
                                <th>Position</th>
                           </tr>
                    </thead>
                       
                    <tbody id="table_details_user">
                
                    </tbody>
            </table>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="close_modal()" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->