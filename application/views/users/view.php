<div class="header">
    <h2 style="margin-left: 20px">LIST UNITS</h2>
    <!---->
    <div class="alert alert-success" style="display: none;">                	
        </div>
        	<?php if($this->session->userdata('level') == "Admin"): ?>
             	<?php 
	             $id_user = $this->uri->segment(3);
				 $cek_level = $this->view_units_model->cek_level($id_user);
	             if($cek_level == "User" || $cek_level == "Admin"): ?>
             		<button class="btn btn-success btn-xs" data-toggle="tooltip" title="Add Units" style="margin-left: 20px;margin-top: 10px" onclick="add_unit()" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-plus"></i></button>
             	<?php endif; ?>
			<?php endif; ?>
			<?php if($this->session->userdata('level') == "SuperAdmin"): ?>
             	<button class="btn btn-success btn-xs" data-toggle="tooltip" title="Add Units" style="margin-left: 20px;margin-top: 10px" onclick="add_unit()" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-plus"></i></button>
			<?php endif; ?>
            <div class="body table-responsive">
	            <table id="table_id" class="table table-hover js-basic-example dataTable" >
	                <thead>
	                    <tr>
	                        <th>UNIT NAME</th>
	                        <th>EMPLOYEE NAME</th>
	                        <th>ACTION</th>
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

		var id = '<?php echo $this->uri->segment(3) ?>';

        table = $('#table_id').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "searchDelay": 2000,
             
            "ajax": {
                "url": "<?php echo site_url('users/get_data_unit_member/')?>"+id,
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
		$('#id_unit').change(function(){
		    $(".pesan-unit").hide();
		});
	});

	var save_method;
	var table;

	function add_unit() {
		save_method = 'add';
		$('#form')[0].reset();
		$(".pesan-unit").hide();

		$.ajax({
		        url : "<?php echo site_url('users/list_unit/')?>"+id,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {
		        	$("#id_unit").empty();
		        	$.each(data,function(i){
		        		htmlString = "<option value='"+data[i]['id_unit']+"'>"+data[i]['nama_unit']+"</option>"
		        		$("#id_unit").append(htmlString);
		        	});
		        	
		        	$("#id_unit").multiselect('destroy');
		        	$('#id_unit').multiselect({
							includeSelectAllOption: true,
							enableCaseInsensitiveFiltering: true
					});
					
		        	$('#modal_form').modal('show');
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error get data from ajax');
		        }
		});
	}

	var id = '<?php echo $this->uri->segment(3) ?>';

	function save() {
		var url;

		if(save_method == 'add') {
			url = "<?php echo site_url('Users/addUnits/') ;?>"+id;
		}

		if ($("select[name='id_unit[]'] option:selected").length == 0) {				
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
				toastr.success('Add Units Successfully!', 'Success', {timeOut: 5000})
				table.ajax.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / upader data');
			}
		});
	}

	function delete_units(id) {
			$.ajax({
				url: "<?php echo site_url('users/delete_units/') ;?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					toastr.success('Delete Units Successfully!', 'Success', {timeOut: 5000})
					$('#modal_delete').modal('hide');
					table.ajax.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error Deleting Data');
				}
			});
	}

	function delete_modal(id){
		$('#button_delete').attr('onclick', 'delete_units('+id+')');
        $('#modal_delete').modal('show');
	}
</script>

<!-- Modal Add Units -->
<div id="modal_form" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Units</h4>
      </div>
      <div class="modal-body form">
        	<form id="form" action="#" class="form-horizontal">
               	<div class="row clearfix">
	        		<div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 form-control-label">
	        				<label>Unit Name</label>
	        		</div>
        			<div class="col-lg-9 col-md-9 col-sm-7 col-xs-6">
	        			<div class="form-group">
	        				<!-- <div class="form-line"> -->
		        				<select  name="id_unit[]" id="id_unit" multiple="multiple" title="Choose Units">
	                        		
	                        	</select>
	                        <!-- </div> -->
	                        <span class="pesan pesan-unit">Please fill out Unit Name field!</span>
	        			</div>
	        		</div>
	        	</div>
        	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="save()" class="btn btn-primary">Submit</button>
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
				<h4 class="modal-title">Are you sure?</h4>	
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