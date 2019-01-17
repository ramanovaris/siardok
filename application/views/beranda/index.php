<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To SIARDOK</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

     <!-- Wait Me Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>assets/css/themes/all-themes.css" rel="stylesheet" />

     <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
  
    <script src="<?php echo base_url(); ?>assets\plugins\bootstrap\js\jquery.min.js"></script>

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
</head>

<body class="theme-red">
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:;" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:;" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">SIARDOK</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="<?php echo base_url(); ?>login/sign_in" title="Login Users" data-toggle="tooltip" data-placement="bottom">
                            <span class="glyphicon glyphicon-lock"></span> 
                            <strong>LOGIN</strong></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <br>
    <br>
    <br>
        <div class="content">
            <div class="container-fluid ">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                            	<h2>TABLE DOCUMENT</h2>
                                <div class="alert alert-success" style="display: none;">
                                </div>               
                                <div class="body table-responsive">
                            	    <table id="table_id" class="table table-hover js-basic-example dataTable" >
                            	            <thead>
                            	                    <tr>
                            	                       	<th>Document Number</th>
                                                        <th>Document Name</th>
                                                        <th>Last Modified</th>
                                                        <th>Document Date</th>
                                                        <th>Expired Date</th>
                                                        <th>Document Label</th>
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
                    </div>
                </div>
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
                    "url": "<?php echo site_url('Beranda/get_data_documents')?>",
                    "type": "POST"
                },
     
                 
                "columnDefs": [
                { 
                    "targets": [7], 
                    "orderable": false, 
                },
                ],
            });
            $('#table_id').on('draw.dt', function () {
                        $('[data-toggle="tooltip"]').tooltip();
            });
        });

        function view_file(id_document){
            $.ajax({
                        url: '<?php echo base_url('Beranda/view_file') ;?>/'+id_document,
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
                              $(this).find('iframe').attr('src','<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file)
                            })
                            $('#modal_pdf_title').text("View Document");
                            $('#modal_pdf').modal('show'); // show bootstrap modal
                            $("#modal_pdf").css("z-index", "1500");
                            $("#modal_history").css("overflow-y", "scroll");
                          } 
                          else if (/(docx)$/ig.test(extension)) {
                            $('#modal_docx').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
                              $(this).find('iframe').attr('src','<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file)
                            })
                            $('#modal_docx_title').text("View Document");
                            $('#modal_docx').modal('show'); // show bootstrap modal
                            $("#modal_docx").css("z-index", "1500");
                            $("#modal_history").css("overflow-y", "scroll");
                          } 
                          else if (/(doc)$/ig.test(extension)) {
                            $('#modal_doc').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
                              $(this).find('iframe').attr('src','<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file)
                            })
                            $('#modal_doc_title').text("View Document");
                            $('#modal_doc').modal('show'); // show bootstrap modal
                            $("#modal_doc").css("z-index", "1500");
                            $("#modal_history").css("overflow-y", "scroll");
                          } 
                          else if (/(xlsx)$/ig.test(extension)) {
                            $('#modal_xlsx').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
                              $(this).find('iframe').attr('src','<?php echo site_url('assets/upload/dokumen') ;?>/'+data.file)
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

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.js"></script>

     <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Select Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/node-waves/waves.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-countto/jquery.countTo.js"></script>

    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.js"></script>

    <!-- ChartJs -->
    <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.bundle.js"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.resize.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.categories.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/flot-charts/jquery.flot.time.js"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-sparkline/jquery.sparkline.js"></script>

    <!-- Validation Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/jquery.validate.js"></script>

     <!-- Autosize Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/index.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/tables/jquery-datatable.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/examples/sign-in.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/forms/form-validation.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/pages/forms/basic-form-elements.js"></script>

    <!-- Demo Js -->
    <script src="<?php echo base_url(); ?>assets/js/demo.js"></script>
</body>

</html>