<?php
	class Upload_model extends CI_Model{
		function __construct() {
    		parent::__construct();
    	}

    	function M_notice (){
			parent::Model();
		}

		function insertNotices($arrayOfNoticeFiles){
			$tableName  = "tbl_dokumen";
			$inputArray = $arrayOfNoticeFiles;
	 
			$data = array(
				'document_foldername'				=> $inputArray["document_foldername"],
				'document_filename'					=> $inputArray["document_filename"]
			);
	 
			$this->db->insert($tableName, $data); 
		}
	}