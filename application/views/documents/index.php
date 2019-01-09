<div class="header">
	<h2 style="margin-left: 20px">TABLE DOCUMENT</h2>
    <div class="alert alert-success" style="display: none;">
    </div>               
    <button class="btn btn-success btn-xs" data-toggle="tooltip" title="Add Document" style="margin-left: 20px;margin-top: 10px" onclick="add_document()" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-plus"></i></button>
    <div class="body table-responsive">
	    <table id="table_id" class="table table-hover js-basic-example dataTable table-responsive" >
	            <thead>
	                    <tr>
	                       	<th>Document Number</th>
                          	<th>Document Name</th>
                            <th>Last Modified</th>
                           	<th>Document Date</th>
                           	<th>Expired Date</th>
                          	<th>Document Label</th>
                          	<th>Version</th>
                           	<th>File</th>
                           	<th>Units</th>
                           	<th>History</th>
	                        <th>Action</th>
	                   </tr>
	            </thead>
	               
	            <tbody>                             
	                
	            </tbody>
	    </table>
    </div>
</div>

<script type="text/javascript">
	var save_method; //for save method string
	var table;
	var base_url = '<?php echo base_url();?>';

	$(document).ready(function(){
		 //datatables
        table = $('#table_id').DataTable({ 
 
            "processing": true, 
            "serverSide": true,
            "order": [], 
            "searchDelay": 2000,
             
            "ajax": {
                "url": "<?php echo site_url('Documents/get_data_documents')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
                "width": "9%", "targets": 10,
                // "width": "1%", "targets": 3,
                
            },
            ],


            "fnRowCallback":function(nRow, aData ) {
            	var date = moment().format('YYYY-MM-DD');
	        	if (aData[4] < date) {
	        		$(nRow).css('background-color', '#ff9999');
	        	}
	        	if (aData[4] == date) {
	        		$(nRow).css('background-color', '#ff9999');
	        	}
	        	if (aData[4] == "0000-00-00") {
	        		$(nRow).css('background-color', '#ffffff');
	        	}
	        },
        });

        $('#table_id').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        $('[data-toggle="tooltip"]').tooltip();

		//datepicker
	    $('.datepicker').datepicker({
	        autoclose: true,
	        format: "yyyy-mm-dd",
	        todayHighlight: true,
	        orientation: "right",
	        todayBtn: true,
	        todayHighlight: true,  
	    });

	    $("#BroadcastId").attr('disabled','disabled');
	    
	    $('select[name="txtLabelDokumen"]').on('change', function(){
	    	if ($(this).val() == 'internal'){
	    		$.ajax({
		        url : "<?php echo site_url('Documents/select_dynamic')?>",
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {
		        	$("#txtUnitDokumen").empty();
		        	$("#BroadcastId").removeAttr('disabled');
		        	$.each(data,function(i){
		        		htmlString = "<option value='"+data[i]['id_unit']+"'>"+data[i]['nama_unit']+"</option>"
		        		$("#txtUnitDokumen").append(htmlString);
		        	});
		        	$("#txtUnitDokumen").multiselect('destroy');
		        	$('#txtUnitDokumen').multiselect({
							includeSelectAllOption: true,
							enableCaseInsensitiveFiltering: true
					});
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		    	});
	    	}
	    	else {
	    		$("#txtUnitDokumen").multiselect('destroy');
	    		$("#txtUnitDokumen").empty();
	    		$(".pesan-unit_dokumen").hide();
	    		$("#BroadcastId").attr('disabled','disabled');
	    	}
	    });
	});

	$(document).ready(function(){
        $("#txtNoDokumen").keyup(delay(function (e) {
		   	var no_document = $('#txtNoDokumen').val();
		   	
		   	if(no_document != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>Documents/cekNoDocuments",
			    method: "POST",
			    data: {no_document:no_document},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#unit_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> Document number already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#unit_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Document number available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#unit_result').html('');
		   	}
	  	},  2000));
	});

	$(document).ready(function(){
        $("#txtNoDokumen").keyup(function () {
		    $(".pesan-no_dokumen").hide();
		});
		$("#txtNamaDokumen").keyup(function () {
		    $(".pesan-nama_dokumen").hide();
		});
		$('#txtTanggalDokumen').change(function(){
		    $(".pesan-tanggal_dokumen").hide();
		});
		$('#txtLabelDokumen').change(function(){
		    $(".pesan-label_dokumen").hide();
		});
		$('#file').change(function(){
		    $(".pesan-file_dokumen").hide();
		});
		$('#txtUnitDokumen').change(function(){
		    $(".pesan-unit_dokumen").hide();
		});
		$('#txtVersionDokumen').keyup(function(){
		    $(".pesan-versi_dokumen").hide();
		});
	});

	$(document).ready(function(){
        $('select[name="txtLabelDokumen"]').on('change', function(){
		    	if ($(this).val() == 'internal'){
		    		if ($("select[name='txtUnitDokumen[]'] option:selected").length == 0) {				
						$(".pesan-unit_dokumen").css('display','block');
						return false;
					}
		    	}
		});
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

	function add_document(){
	    save_method = 'add';
	    $('#form')[0].reset(); // reset form on modals
	    $("#txtUnitDokumen").empty();
	    $("#txtUnitDokumen").multiselect('destroy');
	 	$("#BroadcastId").attr('disabled','disabled');
	    $('#modal_form').modal('show'); // show bootstrap modal
	    $('#modal_form_title').text("Add Documents"); // Set Title to Bootstrap modal title
	    $('#label-file').text('Upload File'); // label photo upload
	    $('#unit_result').html('');
	    $(".pesan-no_dokumen").hide();
		$(".pesan-nama_dokumen").hide();
		$(".pesan-tanggal_dokumen").hide();
		$(".pesan-label_dokumen").hide();
		$(".pesan-file_dokumen").hide();
		$(".pesan-unit_dokumen").hide();
		$(".pesan-versi_dokumen").hide();
		$(".pesan-type_file_dokumen").hide();
		$('#sub_button').attr("disabled", false);
	}

	function edit_document(id){
	    save_method = 'update';
	    $('#form')[0].reset(); // reset form on modals
	    $("#BroadcastId").removeAttr('disabled');
	    $('#unit_result').html('');
	    $(".pesan-no_dokumen").hide();
		$(".pesan-nama_dokumen").hide();
		$(".pesan-tanggal_dokumen").hide();
		$(".pesan-label_dokumen").hide();
		$(".pesan-file_dokumen").hide();
		$(".pesan-unit_dokumen").hide();
		$(".pesan-versi_dokumen").hide();
		$(".pesan-type_file_dokumen").hide();
		$('#sub_button').attr("disabled", false);
		$('#modal_form_title').text("Edit Documents"); // Set Title to Bootstrap modal title
	 
	    //Ajax Load data from ajax
	    $.ajax({
	        url : "<?php echo site_url('Documents/ajax_edit')?>/" + id,
	        type: "GET",
	        dataType: "JSON",
	        success: function(data)
	        {
	        	$("#txtUnitDokumen").empty();
		        $.each(data,function(i){   	
		        	$('[name="id_document"]').val(data[i]['id_document']);
			        $('[name="txtNoDokumen"]').val(data[i]['no_document']);
			        $('[name="txtNamaDokumen"]').val(data[i]['name_document']);
			        $('[name="txtTanggalDokumen"]').val(data[i]['document_date']);
			        $('[name="txtKadaluarsaDokumen"]').val(data[i]['expired_date']);
			        $('[name="txtVersionDokumen"]').val(data[i]['versi']);
			        $('[name="txtLabelDokumen"]').val(data[i]['document_label']);
			        var text = document.getElementById('txtLabelDokumen');
		            if(text.value == "internal"){
		            	htmlString = "<option value='"+data[i]['id_unit']+"'>"+data[i]['nama_unit']+"</option>"
		                $("#txtUnitDokumen").append(htmlString);
		            }
		            $("#txtUnitDokumen").multiselect('destroy');
		        	$('#txtUnitDokumen').multiselect({
							includeSelectAllOption: true,
							enableCaseInsensitiveFiltering: true
					});
		         });
	            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
	            // if(data.file)
	            // {
	            //     $('#label-file').text('Change File'); // label photo upload
	 
	            // }
	            // else
	            // {
	            //     $('#label-file').text('Upload file'); // label photo upload
	            // }
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error get data from ajax');
	        }
	    });
	}

	function reload_table(){
	    table.ajax.reload(null,false); //reload datatable ajax 
	}

	function save(){
	    var url;
	 
	    if(save_method == 'add') {
	        url = "<?php echo site_url('Documents/ajax_add')?>";

	        var document_number = $('#txtNoDokumen').val().length;			
			var document_name = $('#txtNamaDokumen').val().length;			
			var document_date = $('#txtTanggalDokumen').val().length;			
			var document_label = $('#txtLabelDokumen').val().length;
			var document_version = $('#txtVersionDokumen').val().length;
			var upload_file = $('#file').val().length;
			var label = $('#txtLabelDokumen').val();
			
		    if (document_number == 0 || document_name == 0 || document_date == 0 || document_label == 0 || upload_file == 0 || document_version == 0) {				
					if (document_number == 0) {				
						$(".pesan-no_dokumen").css('display','block');
					}
					if (document_name == 0) {				
						$(".pesan-nama_dokumen").css('display','block');
					}
					if (document_date == 0) {				
						$(".pesan-tanggal_dokumen").css('display','block');
					}
					if (document_label == 0) {				
						$(".pesan-label_dokumen").css('display','block');
					}
					if (document_version == 0) {				
						$(".pesan-versi_dokumen").css('display','block');
					}
					if (upload_file == 0) {				
						$(".pesan-file_dokumen").css('display','block');
					}
					return false;
			}
		    if(label == "internal"){
		        if ($("select[name='txtUnitDokumen[]'] option:selected").length == 0) {				
					$(".pesan-unit_dokumen").css('display','block');
					return false;
				}
		    }

	    } else {
	        url = "<?php echo site_url('Documents/ajax_update')?>";

	        var document_number = $('#txtNoDokumen').val().length;			
			var document_name = $('#txtNamaDokumen').val().length;			
			var document_date = $('#txtTanggalDokumen').val().length;			
			var document_label = $('#txtLabelDokumen').val().length;
			var document_version = $('#txtVersionDokumen').val().length;
			var label = $('#txtLabelDokumen').val();

		    if (document_number == 0 || document_name == 0 || document_date == 0 || document_label == 0 || document_version == 0) {				
					if (document_number == 0) {				
						$(".pesan-no_dokumen").css('display','block');
					}
					if (document_name == 0) {				
						$(".pesan-nama_dokumen").css('display','block');
					}
					if (document_date == 0) {				
						$(".pesan-tanggal_dokumen").css('display','block');
					}
					if (document_label == 0) {				
						$(".pesan-label_dokumen").css('display','block');
					}
					if (document_version == 0) {				
						$(".pesan-versi_dokumen").css('display','block');
					}
					return false;
			}
	    }
	 
	    // ajax adding data to database
	 
	    var formData = new FormData($('#form')[0]);
	    $.ajax({
	        url : url,
	        type: "POST",
	        data: formData,
	        contentType: false,
	        processData: false,
	        dataType: "JSON",
	        success: function(data) {
	 		 		$('#modal_form').modal('hide');
	                reload_table();
	                if(save_method == 'add') {
						toastr.success('Add Document Successfully!', 'Success', {timeOut: 5000})
					} else {
						toastr.success('Edit Document Successfully!', 'Success', {timeOut: 5000})
					}
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            toastr.error('Failed Add or Edit Documents!', 'Failed', {timeOut: 5000})
	        }
	    });
	}

	function delete_document(id) {
		$.ajax({
					url: "<?php echo site_url('documents/delete_document/') ;?>/"+id,
					type: "POST",
					dataType: "JSON",
					success: function(data) {
						toastr.success('Delete Document Successfully!', 'Success', {timeOut: 5000})
						$('#modal_delete').modal('hide');
						table.ajax.reload();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error Deleting Data');
					}
				});
	}
	
	function view_file(id_document){
		$.ajax({
					url: '<?php echo base_url('Documents/view_file') ;?>/'+id_document,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
					 var fileInput = "<?php echo site_url('assets/upload/dokumen') ;?>/"+data.file;
					 var extension = fileInput.substr((fileInput.lastIndexOf('.') +1));
					  if (/(jpg)$/ig.test(extension)) {
					    $('#jpg').attr('src', '<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file);
					    $('#modal_jpg_title').text("View Document");
                		$('#modal_jpg').modal('show');
                		$("#modal_jpg").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }
					  else if (/(png)$/ig.test(extension)) {
						$('#png').attr('src', '<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file);
                		$('#modal_png_title').text("View Document");
                		$('#modal_png').modal('show');
                		$("#modal_png").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(pdf)$/ig.test(extension)) {
					  	$('#modal_pdf').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_pdf_title').text("View Document");
						$('#modal_pdf').modal('show'); // show bootstrap modal
						$("#modal_pdf").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(docx)$/ig.test(extension)) {
						$('#modal_docx').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_docx_title').text("View Document");
						$('#modal_docx').modal('show'); // show bootstrap modal
						$("#modal_docx").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(doc)$/ig.test(extension)) {
						$('#modal_doc').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_doc_title').text("View Document");
						$('#modal_doc').modal('show'); // show bootstrap modal
						$("#modal_doc").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(xlsx)$/ig.test(extension)) {
						$('#modal_xlsx').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_xlsx_title').text("View Document");
						$('#modal_xlsx').modal('show'); // show bootstrap modal
						$("#modal_xlsx").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(gif)$/ig.test(extension)) {
					    $('#gif').attr('src', '<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file);
                		$('#modal_gif_title').text("View Document");
                		$('#modal_gif').modal('show');
                		$("#modal_gif").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }


					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert('Error');
					}
				});
	}

	function send_document(id) {
		$.ajax({
					url: "<?php echo site_url('documents/send_document/') ;?>"+id,
					type: "POST",
					dataType: "JSON",
					success: function(data) {
						toastr.success('Broadcast Document Successfully!', 'Success', {timeOut: 5000})
						$('#modal_broadcast').modal('hide');
						table.ajax.reload();
					},
					error: function(jqXHR, textStatus, errorThrown) {
						toastr.warning("Broadcast Document Failed! Because documents don't have units", "Failed", {timeOut: 5000})
					}
		});
	}

	function close_modal(){
    	$("#table_units tr").remove();
	}

	function view_units(id){
	    $.ajax({
	                    url: '<?php echo base_url('documents/view_units') ;?>/'+id,
	                    type: "GET",
	                    dataType: "JSON",
	                    success: function(data) {
	                        $.each(data,function(i){
	                            htmlString = "<tr><td> - "+data[i]['nama_unit']+"</td></tr>"
	                            $("#table_units").append(htmlString);
	                        });
	                        $('#modal_units_title').text("View Units");
	                        $('#modal_units').modal('show'); // show bootstrap modal
	                    },
	                    error: function(jqXHR, textStatus, errorThrown) {
	                        alert('Error');
	                    }
	                });
	}

	function view_history(id){
		$('#modal_history_title').text("View History Documents");

	    $.ajax({
	                    url: '<?php echo base_url('documents/view_history') ;?>/'+id,
	                    type: "GET",
	                    dataType: "JSON",
	                    success: function(data) {
	                    	$("#table_history").empty();
	                        $.each(data,function(i){
	                            htmlString = "<tr>"+"<td>"+data[i]['no_document']+"</td>"+"<td>"+data[i]['name_document']+"</td>"+"<td>"+data[i]['upload_date']+"</td>"+"<td>"+data[i]['document_date']+"</td>"+"<td>"+data[i]['expired_date']+"</td>"+"<td>"+data[i]['document_label']+"</td>"+"</td>"+"<td>"+data[i]['versi']+"</td>"+"<td>"+"<a href='javascript:void(0);' class='btn-primary btn-xs' onclick='view_file_history("+data[i]['id_history']+")' title='View File' data-toggle='tooltip' data-placement='bottom'><i class='glyphicon glyphicon-eye-open'></i></a>"+"</td>"+"</tr>"
	                            $("#table_history").append(htmlString);
	                        });
	                        $('#modal_history').modal('show'); // show bootstrap modal
	                    },
	                    error: function(jqXHR, textStatus, errorThrown) {
	                        alert('Error');
	                    }
	                });
	}

	function delete_modal(id){
        $.ajax({
				url: "<?php echo site_url('documents/get_name_document_for_delete/') ;?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$("#text_hapus").empty();
					htmlString = "Are you sure you want to delete <b>"+data.name_document+"</b>?"
			        $("#text_hapus").append(htmlString);
			        $('#modal_delete_title').text("Are you sure?");
					$('#button_delete').attr('onclick', 'delete_document('+id+')');
			        $('#modal_delete').modal('show');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error Deleting Data');
				}
		});
	}

	function send_document_modal(id){
        $.ajax({
				url: "<?php echo site_url('documents/get_name_document_for_broadcast/') ;?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					$("#text_broadcast").empty();
					htmlString = "Are you sure you want to broadcast document <b>"+data.name_document+"</b>?"
			        $("#text_broadcast").append(htmlString);
			        $('#modal_broadcast_title').text("Are you sure?");
					$('#button_broadcast').attr('onclick', 'send_document('+id+')');
			        $('#modal_broadcast').modal('show');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error Deleting Data');
				}
		});
	}

	function view_file_history(id_history){
		$.ajax({
					url: '<?php echo base_url('Documents/view_file_history') ;?>/'+id_history,
					type: "GET",
					dataType: "JSON",
					success: function(data) {
					 var fileInput = "<?php echo site_url('assets/upload/dokumen') ;?>/"+data.file;
					 var extension = fileInput.substr((fileInput.lastIndexOf('.') +1));
					  if (/(jpg)$/ig.test(extension)) {
					    $('#jpg').attr('src', '<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file);
                		$('#modal_jpg_title').text("View Document");
                		$('#modal_jpg').modal('show');
                		$("#modal_jpg").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }
					  else if (/(png)$/ig.test(extension)) {
						$('#png').attr('src', '<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file);
                		$('#modal_png_title').text("View Document");
                		$('#modal_png').modal('show');
                		$("#modal_png").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(pdf)$/ig.test(extension)) {
					  	$('#modal_pdf').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_pdf_title').text("View Document");
						$('#modal_pdf').modal('show'); // show bootstrap modal
						$("#modal_pdf").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(docx)$/ig.test(extension)) {
						$('#modal_docx').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_docx_title').text("View Document");
						$('#modal_docx').modal('show'); // show bootstrap modal
						$("#modal_docx").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(doc)$/ig.test(extension)) {
						$('#modal_doc').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_doc_title').text("View Document");
						$('#modal_doc').modal('show'); // show bootstrap modal
						$("#modal_doc").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(xlsx)$/ig.test(extension)) {
						$('#modal_xlsx').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
						  $(this).find('iframe').attr('src','https://docs.google.com/gview?url=https://siardok.000webhostapp.com/assets/upload/dokumen/'+data.file+'&embedded=true')
						})
						$('#modal_xlsx_title').text("View Document");
						$('#modal_xlsx').modal('show'); // show bootstrap modal
						$("#modal_xlsx").css("z-index", "1500");
						$("#modal_history").css("overflow-y", "scroll");
					  } 
					  else if (/(gif)$/ig.test(extension)) {
					    $('#gif').attr('src', '<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file);
                		$('#modal_gif_title').text("View Document");
                		$('#modal_gif').modal('show');
                		$("#modal_gif").css("z-index", "1500");
                		$("#modal_history").css("overflow-y", "scroll");
					  }


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
	    $('#file').checkFileType({
	        allowedExtensions: ['jpg', 'gif', 'png', 'pdf', 'xlsx', 'docx', 'doc'],
	        success: function() {
	        	$(".pesan-type_file_dokumen").hide();
	            $('#sub_button').attr("disabled", false);
	        },
	        error: function() {
	            $(".pesan-type_file_dokumen").css('display','block');
	            $('#sub_button').attr("disabled", true);
	        }
	    });
	});
		// End Validasi Tipe file
</script>


<!-- Modal Add Dokumen & Edit Dokumen -->
<div id="modal_form" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal_form_title"></h4>
      </div>
      <div class="modal-body form">
        	<form id="form" action="#" class="form-horizontal">
        		<input type="hidden" value="" name="id_document">
        		<div class="row clearfix">
	        		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label">
	        			<label for="txtNoDokumen">Document Number</label>
	        		</div>
	        		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
		        		<div class="form-group">
		        			<div class="form-line">
		        				<input type="text" name="txtNoDokumen" id="txtNoDokumen" placeholder="Masukkan No Dokumen" class="form-control">
		        			</div>
		        			<span id="unit_result"></span>
		        			<span class="pesan pesan-no_dokumen">Please fill out Document Number field!</span>
		        		</div>
		        	</div>

		        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label">
	        			<label for="txtNamaDokumen">Document Name</label>
	        		</div>
	        		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
		        		<div class="form-group">
		        			<div class="form-line">
		        				<input type="text" name="txtNamaDokumen" id="txtNamaDokumen" placeholder="Masukkan Nama Dokumen" class="form-control">
		        			</div>
		        			<span class="pesan pesan-nama_dokumen">Please fill out Document Name field!</span>
		        		</div>
		        	</div>

		        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label">
	        			<label for="txtTanggalDokumen">Document Date</label>
	        		</div>
	        		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
		        		<div class="form-group">
		        			<div class="form-line">
		        				<input type="text" name="txtTanggalDokumen" id="txtTanggalDokumen" placeholder="yyyy-mm-dd" class="form-control datepicker">
		        			</div>
		        			<span class="pesan pesan-tanggal_dokumen">Please fill out Document Date field!</span>
		        		</div>
		        	</div>

		        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label">
	        			<label for="txtKadaluarsaDokumen">Expired Date Document</label>
	        		</div>
	        		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
		        		<div class="form-group">
		        			<div class="form-line">
		        				<input type="text" name="txtKadaluarsaDokumen" placeholder="yyyy-mm-dd" class="form-control datepicker">
		        			</div>
		        		</div>
		        	</div>

		        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label">
	        			<label for="txtVersionDokumen">Version Document</label>
	        		</div>
	        		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
		        		<div class="form-group">
		        			<div class="form-line">
		        				<input type="text" name="txtVersionDokumen" id="txtVersionDokumen" placeholder="Masukkan Versi Dokumen" class="form-control">
		        			</div>
		        			<span class="pesan pesan-versi_dokumen">Please fill out Version Document field!</span>
		        		</div>
		        	</div>	

		        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label">
	        			<label for="txtLabelDokumen">Document Label</label>
	        		</div>
	        		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
		        		<div class="form-group">
		        			<div class="form-line">
		        				<select  name="txtLabelDokumen" id="txtLabelDokumen" class="form-control show-tick">
	                        		<option value="">--PILIH--</option>
	                        		<option value="rahasia">Rahasia</option>
	                        		<option value="umum">Umum</option>
	                        		<option value="internal">Internal</option>
                        		</select>
                        	</div>
		        			<span class="pesan pesan-label_dokumen">Please fill out Document Label field!</span>
		        		</div>
		        	</div>

		        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label">
	        			<label for="txtLabelDokumen">Units</label>
	        		</div>
	        		<div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
		        		<div class="form-group">
		        				<select  name="txtUnitDokumen[]" id="txtUnitDokumen" multiple title="Pilih Units" class="form-control show-tick" data-live-search="true" multiple>
	                        		

                        		</select>
                        		<br>
		        	        	<br>
		        			<span class="pesan pesan-unit_dokumen">Please fill out Units field!</span>
		        		</div>
		        	</div>

		        	<div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label" id="label-file">Upload File </label>
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
                                <input name="file" id="file" type="file">
                                <span class="pesan pesan-file_dokumen">Please fill out File field!</span>
                                <span class="pesan pesan-type_file_dokumen">Upload error: The filetype you are attempting to upload is not allowed. Please insert files with file types: .jpg, .png, .gif, .pdf, .doc, .docx, .xlsx</span>
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-lg-4 col-md-4 col-sm-6 col-xs-5 form-control-label" id="label-file">Broadcast File</label>
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-7">
                                <input type="checkbox" id="BroadcastId" name="BroadcastId">
                                <label for="BroadcastId">Broadcast</label>
                            </div>
                    </div>
		        </div>
        	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="save()" id="sub_button" class="btn btn-primary">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal PDF -->
<div class="modal fade" id="modal_pdf" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px; right: 50px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_pdf_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="pdf" frameborder="0" height="500px" width="100%"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

<!-- Modal GIF -->
<div class="modal fade" id="modal_gif" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px; right: 50px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_gif_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="gif" style="width: 750px; height: auto;">
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

<!-- Modal DOCX -->
<div class="modal fade" id="modal_docx" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px; right: 50px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_docx_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="docx" frameborder="0" height="500px" width="100%"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal DOC -->
<div class="modal fade" id="modal_doc" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px; right: 50px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_doc_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="doc" frameborder="0" height="500px" width="100%"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal XLSX -->
<div class="modal fade" id="modal_xlsx" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 800px; right: 50px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_xlsx_title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="xlsx" frameborder="0" height="500px" width="100%"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal View Units -->
<div class="modal fade" id="modal_units" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width: 263px; left: 320px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_units_title"></h4>
      </div>
      <div class="modal-body">
        <form name="form1" id="form1">
            <table class="table table-responsive" >
                    <thead>
                            <tr>
                                <th>UNITS DOCUMENTS</th>
                           </tr>
                    </thead>
                       
                    <tbody id="table_units">
                
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

<!-- Modal View History Documents -->
<div class="modal fade" id="modal_history" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width: 900px; left: 60px;">
      <div class="modal-header">
        <h4 class="modal-title" id="modal_history_title"></h4>
      </div>
      <div class="modal-body">
        <form name="form1" id="form1">
            <table class="table table-responsive" >
                    <thead>
                            <tr>
                                <th>Document Number</th>
	                          	<th>Document Name</th>
	                            <th>Last Modified</th>
	                           	<th>Document Date</th>
	                           	<th>Expired Date</th>
	                          	<th>Document Label</th>
	                          	<th>Version</th>
	                           	<th>File</th>
                           </tr>
                    </thead>
                       
                    <tbody id="table_history">
                
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

<!-- Modal Broadcast -->
<div id="modal_broadcast" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">send</i>
				</div>				
				<h4 class="modal-title" id="modal_broadcast_title"></h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p id="text_broadcast"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
				<button type="button" id="button_broadcast" class="btn btn-danger">Send Broadcast</button>
			</div>
		</div>
	</div>
</div>     