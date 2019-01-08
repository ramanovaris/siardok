<div class="header">
    <h2 style="margin-left: 20px">UNIT LISTS</h2>
    <div class="alert alert-success" style="display: none;">                	
    </div>
             <button class="btn btn-success btn-xs" data-toggle="tooltip" title="Add Unit" style="margin-left: 20px;margin-top: 10px" onclick="add_unit()" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-plus"></i></button>
            <div class="body table-responsive">
	            <table id="table_id" class="table table-hover js-basic-example dataTable" >
	                <thead>
	                    <tr>
	                        <th>UNIT NAME</th>
	                        <th>MEMBER UNIT</th>
	                        <th>ACTION</th>
	                    </tr>
	                </thead>
	                
	                <tbody>                             
	                
	                </tbody>
	            </table>
        	</div>
		</div>

<!-- Modal Add User & Edit User -->
<div id="modal_form" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Units</h4>
      </div>
      <div class="modal-body form">
        	<form id="form" action="#" class="form-horizontal">
        		<input type="hidden" value="0" name="id_unit">
        		<div class="row clearfix">
	        		<div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
	        			<label for="txtUnitName">Unit Name</label>
	        		</div>
	        		<div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
		        		<div class="form-group">
		        			<div class="form-line">
		        				<input type="text" name="txtUnitName" id="txtUnitName" placeholder="Masukkan Nama Unit" class="form-control">
		        			</div>
		        			<span id="unit_result"></span>
		        			<span class="pesan pesan-unit">Please fill out Unit Name field!</span>
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

<script type="text/javascript">
	$(document).ready(function(){
		 //datatables
        table = $('#table_id').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "searchDelay": 2000,
             
            "ajax": {
                "url": "<?php echo site_url('units/get_data_unit')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],
 
        });
        $('#table_id').on('draw.dt', function () {
                    $('[data-toggle="tooltip"]').tooltip();
        });
        $('[data-toggle="tooltip"]').tooltip();
	});

	$(document).ready(function(){
		$("#txtUnitName").keyup(delay(function (e) {
		   	var nama_unit = $('#txtUnitName').val();
		   	
		   	if(nama_unit != ''){
			    $.ajax({
			    url: "<?php echo base_url(); ?>units/cekNamaUnit",
			    method: "POST",
			    data: {nama_unit:nama_unit},
			    success: function(response){
			    	if (response == 'taken') {
			    		$('#unit_result').html('<label class="text-danger"><span><i class="fa fa-times" aria-hidden="true"></i> Unit name already exists</span></label>');
			    		$('#sub_button').attr("disabled", true);
			    	} 
			    	else if (response == 'not_taken') {
			    		$('#unit_result').html('<label class="text-success"><span><i class="fa fa-check-circle-o" aria-hidden="true"></i> Unit name available</span></label>');
			    		$('#sub_button').attr("disabled", false);
			    	}
			    }
			    });
		   	}
		   	else{
		   		$('#unit_result').html('');
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
        $("#txtUnitName").keyup(function () {
		    $(".pesan-unit").hide();
		});
	});

	var save_method;
	var table;

	function add_unit() {
		save_method = 'add';
		$('#form')[0].reset();
		$('#unit_result').html('');
		$(".pesan-unit").hide();
		$('#modal_form').modal('show');
	}

	function save() {
		var url;

		if(save_method == 'add') {
			url = '<?php echo site_url('Units/addUnit') ;?>';
		} else {
			url = '<?php echo site_url('Units/unit_update') ;?>';
		}

		var unit = $('#txtUnitName').val().length;						

		if (unit == 0) {				
			$(".pesan-unit").css('display','block');
			return false;
		}
			
			

		$.ajax({
			url: url,
			type: "POST",
			data: $('#form').serialize(),
			dataType: "JSON",
			success: function(data) {
			
				$('#modal_form').modal('hide');
				if(save_method == 'add') {
					toastr.success('Add Unit Successfully!', 'Success', {timeOut: 5000})
				} else {
					toastr.success('Edit Unit Successfully!', 'Success', {timeOut: 5000})
				}
				table.ajax.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / upader data');
			}
		});
	}

	function edit_unit(id) {
		save_method = 'update';
		$('#form')[0].reset();
		$('#unit_result').html('');
		$(".pesan-unit").hide();

		//load data dari AJAX
		$.ajax({
			url: "<?php echo site_url('index.php/units/ajax_edit/') ;?>/"+id,
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				$('[name="id_unit"]').val(data.id_unit);
				$('[name="txtUnitName"]').val(data.nama_unit);

				$('#modal_form').modal('show');

				$('.modal-title').text('Edit Unit');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error Get Data From AJAX');
			}
		});
	}

	function delete_unit(id) {
			$.ajax({
				url: "<?php echo site_url('units/delete_unit/') ;?>"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					toastr.success('Delete Unit Successfully!', 'Success', {timeOut: 5000})
					$('#modal_delete').modal('hide');
					table.ajax.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error Deleting Data');
				}
			});
	}

	function view_member(id){
		window.location.href = "<?php echo site_url('units/view_member/') ;?>"+id;
	}

	function delete_modal(id){
		$('#button_delete').attr('onclick', 'delete_unit('+id+')');
        $('#modal_delete').modal('show');
        $('#modal_delete_title').text('Are you sure?');
	}
</script>

<!-- Modal Delete -->
<div id="modal_delete" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header">
				<div class="icon-box">
					<i class="material-icons">&#xE5CD;</i>
				</div>				
				<h4 id="modal_delete_title"></h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<p>Do you really want to delete these records? This process cannot be undone.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
				<button type="button" id="button_delete" class="btn btn-danger">Delete</button>
			</div>
		</div>
	</div>
</div>