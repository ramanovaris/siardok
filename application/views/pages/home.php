                        <div class="header">
                            <h2>
                                TABLE DOCUMENT
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="active"><a href="#home" data-toggle="tab">Label Internal Documents</a></li>
                                <li role="presentation"><a href="#profile" data-toggle="tab">Label General Documents</a></li>
                                <li role="presentation"><a href="#messages" data-toggle="tab">Label Secret Documents</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="home">
                                    <table id="tabel_internal" class="table table-hover js-basic-example" style="width: 100%;">
                                            <thead>
                                                    <tr>
                                                        <th>Document Number</th>
                                                        <th>Document Name</th>
                                                        <th>Last Modified</th>
                                                        <th>Document Date</th>
                                                        <th>Expired Date</th>
                                                        <th>Upload By</th>
                                                        <th>Units</th>
                                                        <th>File</th>
                                                   </tr>
                                            </thead>
                                               
                                            <tbody>                             
                                                
                                            </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="profile">
                                    <table id="tabel_umum" class="table table-hover js-basic-example" style="width: 100%;">
                                            <thead>
                                                    <tr>
                                                        <th>Document Number</th>
                                                        <th>Document Name</th>
                                                        <th>Last Modified</th>
                                                        <th>Document Date</th>
                                                        <th>Expired Date</th>
                                                        <th>Upload By</th>
                                                        <th>File</th>
                                                   </tr>
                                            </thead>
                                               
                                            <tbody>                             
                                                
                                            </tbody>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="messages">
                                    <table id="tabel_rahasia" class="table table-hover js-basic-example" style="width: 100%;">
                                            <thead>
                                                    <tr>
                                                         <th>Document Number</th>
                                                        <th>Document Name</th>
                                                        <th>Last Modified</th>
                                                        <th>Document Date</th>
                                                        <th>Expired Date</th>
                                                        <th>Upload By</th>
                                                        <th>File</th>
                                                   </tr>
                                            </thead>
                                               
                                            <tbody>                             
                                                
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
<script>
	var table;
	var base_url = '<?php echo base_url();?>';
$(document).ready(function(){
        table = $('#tabel_internal').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "searchDelay": 2000,
             
            "ajax": {
                "url": "<?php echo site_url('pages/get_documents_internal')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
            { 
                "targets": [6,7], 
                "orderable": false, 
                // "width": "10%", "targets": 0
            },
            { width: '100px', targets: 0},
            { width: '120px', targets: 2},
            { width: '70px', targets: 4},
            { width: '50px', targets: 3},
            { width: '30px', targets: 6},
            { width: '30px', targets: 7},
            ],
        });
        $('#tabel_internal').on('draw.dt', function () {
                    $('[data-toggle="tooltip"]').tooltip();
        });
});

$(document).ready(function(){
        table = $('#tabel_umum').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "searchDelay": 2000,
             
            "ajax": {
                "url": "<?php echo site_url('pages/get_documents_umum')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
            { 
                "targets": [6], 
                "orderable": false, 
                // "width": "10%", "targets": 6
            },
            // { width: '1000px', targets: 6},
            ],
        });
        $('#tabel_umum').on('draw.dt', function () {
                    $('[data-toggle="tooltip"]').tooltip();
        });
});

$(document).ready(function(){
        table = $('#tabel_rahasia').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "searchDelay": 2000,
             
            "ajax": {
                "url": "<?php echo site_url('pages/get_documents_rahasia')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
            { 
                "targets": [5,6], 
                "orderable": false,
            },
            ],
        });
        $('#tabel_rahasia').on('draw.dt', function () {
                    $('[data-toggle="tooltip"]').tooltip();
        });
});

function close_modal(){
    $("#table_units tr").remove();

}

function view_units(id){
    $.ajax({
                    url: '<?php echo base_url('pages/view_units') ;?>/'+id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $.each(data,function(i){
                            htmlString = "<tr><td> - "+data[i]['nama_unit']+"</td></tr>"
                            $("#table_units").append(htmlString);
                        });
                        $('#myModal_title').text("View Units");
                        $('#myModal').modal('show'); // show bootstrap modal
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error');
                    }
                });
}

function view_file(id_document){
        $.ajax({
                    url: '<?php echo base_url('pages/view_file') ;?>/'+id_document,
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
</script>

<!-- Modal View Units -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="width: 263px; left: 320px;">
      <div class="modal-header">
        <h4 class="modal-title" id="myModal_title"></h4>
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