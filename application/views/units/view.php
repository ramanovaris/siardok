<div class="header">
    <h2 style="margin-left: 20px">MEMBER UNITS</h2>
    <!---->
    <div class="alert alert-success" style="display: none;">                	
        </div>
        	<?php if($this->session->userdata('level') == "SuperAdmin"): ?>
            	<button class="btn btn-success btn-xs" data-toggle="tooltip" title="Add Member" style="margin-left: 20px;margin-top: 10px" onclick="add_member()" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-plus"></i></button>
            <?php endif; ?>
            <?php if($this->session->userdata('level') == "Admin"): ?>
            	<button class="btn btn-success btn-xs" data-toggle="tooltip" title="Add Member" style="margin-left: 20px;margin-top: 10px" onclick="add_member_admin()" data-toggle="tooltip" data-placement="bottom"><i class="glyphicon glyphicon-plus"></i></button>
            <?php endif; ?>
            <div class="body table-responsive">
	            <table id="table_id" class="table table-hover js-basic-example dataTable" >
	                <thead>
	                    <tr>
	                        <th>NAME MEMBER</th>
	                        <th>MEMBER UNIT</th>
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
                "url": "<?php echo site_url('units/get_data_member/')?>"+id,
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
		$('#user_id').change(function(){
		    $(".pesan-user").hide();
		});
	});

	var save_method;
	var table;

	function add_member() {
		save_method = 'add';
		$('#form')[0].reset();
		$(".pesan-user").hide();

		$.ajax({
		        url : "<?php echo site_url('units/list_member/')?>"+id,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {
		        	$("#user_id").empty();
		        	$.each(data,function(i){
		        		htmlString = "<option value='"+data[i]['id_user']+"'>"+data[i]['nik']+" - "+data[i]['nama']+"</option>"
		        		$("#user_id").append(htmlString);
		        	});
		        	$("#user_id").multiselect('destroy');
		        	$('#user_id').multiselect({
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

	function add_member_admin() {
		save_method = 'add';
		$('#form')[0].reset();
		$(".pesan-user").hide();

		$.ajax({
		        url : "<?php echo site_url('units/list_member_admin/')?>"+id,
		        type: "GET",
		        dataType: "JSON",
		        success: function(data)
		        {
		        	$("#user_id_admin").empty();
		        	$.each(data,function(i){
		        		htmlString = "<option value='"+data[i]['id_user']+"'>"+data[i]['nik']+" - "+data[i]['nama']+"</option>"
		        		$("#user_id_admin").append(htmlString);
		        	});
		        	$("#user_id_admin").multiselect('destroy');
		        	$('#user_id_admin').multiselect({
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
			url = "<?php echo site_url('Units/addMember/') ;?>"+id;
		}

		if ($("select[name='user_id[]'] option:selected").length == 0) {				
					$(".pesan-user").css('display','block');
					return false;
		}

		$.ajax({
			url: url,
			type: "POST",
			data: $('#form').serialize(),
			dataType: "JSON",
			success: function(data) {
				$('#user_id option:selected').removeAttr('selected');
				$('#modal_form').modal('hide');
				toastr.success('Add Member Successfully!', 'Success', {timeOut: 5000})
				table.ajax.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / upader data');
			}
		});
	}

	function save_admin() {
		var url;

		if(save_method == 'add') {
			url = "<?php echo site_url('Units/addMember/') ;?>"+id;
		}

		if ($("select[name='user_id[]'] option:selected").length == 0) {				
					$(".pesan-user").css('display','block');
					return false;
		}

		$.ajax({
			url: url,
			type: "POST",
			data: $('#form').serialize(),
			dataType: "JSON",
			success: function(data) {
				$('#user_id_admin option:selected').removeAttr('selected');
				$('#modal_form').modal('hide');
				toastr.success('Add Member Successfully!', 'Success', {timeOut: 5000})
				table.ajax.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error adding / upader data');
			}
		});
	}

	function delete_member(id) {
			$.ajax({
				url: "<?php echo site_url('units/delete_member/') ;?>/"+id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					toastr.success('Delete Member Successfully!', 'Success', {timeOut: 5000})
					$('#modal_delete').modal('hide');
					table.ajax.reload();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error Deleting Data');
				}
			});
	}

	function delete_modal(id){
		$('#button_delete').attr('onclick', 'delete_member('+id+')');
        $('#modal_delete').modal('show');
	}
</script>

<!-- Modal Add User & Edit User -->
<div id="modal_form" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 500px;left: 81px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Member</h4>
      </div>
      <div class="modal-body form">
        	<form id="form" action="#" class="form-horizontal">
		        <div class="row clearfix">
	        		<div class="col-lg-5 col-md-4 col-sm-6 col-xs-7 form-control-label">
	        				<label>Employee Name</label>
	        		</div>
        			<div class="col-lg-7 col-md-8 col-sm-6 col-xs-5">
	        			<div class="form-group">
	        				<!-- <div class="form-line"> -->
	        					<?php if($this->session->userdata('level')=='SuperAdmin') : ?>
		        					<select  name="user_id[]" id="user_id" class="form-control show-tick" data-live-search="true" multiple title="Choose Member">
	                        	
                        			</select>
                        		<?php endif; ?>
                        		<?php if($this->session->userdata('level')=='Admin') : ?>
		        					<select  name="user_id[]" id="user_id_admin" class="form-control show-tick" data-live-search="true" multiple title="Choose Member">
	                        	
                        			</select>
                        		<?php endif; ?>
                        	<!-- </div> -->
                        	<span class="pesan pesan-user">Please fill out Employee Name field!</span>
	        			</div>
	        		</div>
	        	</div>
        	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php if($this->session->userdata('level')=='SuperAdmin') : ?>
        	<button type="button" onclick="save()" class="btn btn-primary">Submit</button>
        <?php endif; ?>
        <?php if($this->session->userdata('level')=='Admin') : ?>
        	<button type="button" onclick="save_admin()" class="btn btn-primary">Submit</button>
        <?php endif; ?>
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