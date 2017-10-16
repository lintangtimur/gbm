<?php
	
	
	class dashboard_model extends CI_Model {
		
		public function __construct() {
			parent::__construct();
		}
		
		private $_table1 = "ate";
		private $_table2 = "m_mapping_taksonomi";
		private $_table3 = "jawab_ate";
		private $_table4 = "taks_ate";
		private $_table6 = "penanggung_jawab_taksonomi";
		private $_table5 = "lampiran_ate";
		private $_tbluser = "user";
		private $_tbllog = "log_ate";
		private $_tbl_taksonomi="taksonomi";
		private $_tbl_maps_taks="mapp_taks";
		
		
		private function _key($key) {
			if (!is_array($key)) {
				$key = array($this->_tbl_taksonomi.'.ate_id' => $key);
			}
			return $key;
		}
		
		
		function lastmessage()
		{
			$q=$this->db->get_where("kms_m_message",array("msg_status"=>'1'))->row();
			$msg=$q->msg_content;
			return $msg;
		}
		
		function count_ate_unanswered($user_id)
		{
			//            SELECT "a"."ate_perihal", "a"."ate_isi", "b"."user_id", "c"."jawab_ate_id", "d"."user_nama"
			//            FROM "kms_taks_ate" e
			//            INNER JOIN "kms_ate" a ON "a"."ate_id" = "e"."ate_id"
			//            INNER JOIN "kms_penanggung_jawab_taksonomi" b ON "e"."mapp_taks_id" = "b"."mapp_taks_id"
			//            LEFT JOIN "kms_jawab_ate" c ON "c"."ate_id" = "a"."ate_id"
			//            INNER JOIN "kms_user" d ON "a"."user_id" = "d"."user_id"
			//            WHERE "c"."jawab_ate_id" IS NULL
			//            AND "b"."user_id" =  '1403190001'
			
            $query = array(); 
            $this->db->select("a.ate_perihal, a.ate_isi, b.user_id, c.jawab_ate_id,d.user_nama");
            $this->db->from($this->_table4." e");
            $this->db->join($this->_table1." a","a.ate_id = e.ate_id","INNER");
            $this->db->join($this->_table6." b","e.mapp_taks_id = b.mapp_taks_id","INNER");
            $this->db->join($this->_table3." c","c.ate_id = a.ate_id","LEFT");
            $this->db->join($this->_tbluser." d","a.user_id = d.user_id","INNER");
            $this->db->where(array("c.jawab_ate_id IS NULL"=>NULL,"b.user_id"=>$user_id)); 
            $query = $this->db->get();
            $query = $query->result_array();  
            return $query; 
		}
		
		function count_unapproved_taks($user_id)
		{
            $this->db->select("a.taks_id");
            $this->db->from($this->_tbl_taksonomi." a");
            $this->db->join($this->_tbl_maps_taks." b","a.taks_id = b.taks_id","INNER");
            $this->db->join($this->_table2." c","b.mapp_taks_id = c.mapp_taks_id","INNER");
            $this->db->join($this->_table6." d","d.mapp_taks_id = c.mapp_taks_id","INNER");
            $this->db->where(array("b.kms_mapp_taks_stats"=>"F","d.user_id"=>$user_id));
            
            $query = $this->db->get();
            $query = $query->result_array();  
            return $query;
            
            //return $this->db->count_all_results();
		}
        
        /* added by tri */
        function count_unapproved_k_int($user_id)
		{
            $query = $this->db->query( "
			select distinct ketentuan_intern_id from 
			(SELECT
			A .ketentuan_intern_stats,
			A .ketentuan_intern_perihal,
			A.ketentuan_intern_id,
			B .mapp_taks_id,
			C.mapp_taks_nama,
			D.user_id
			
			FROM
			kms_ketentuan_internal A
			LEFT JOIN kms_ketentuan_intern_taks B ON A .ketentuan_intern_id = B.ketentuan_intern_id
			LEFT JOIN kms_m_mapping_taksonomi C ON B.mapp_taks_id = C.mapp_taks_id
			LEFT JOIN kms_penanggung_jawab_taksonomi D ON B.mapp_taks_id = D.mapp_taks_id
			
			WHERE A.ketentuan_intern_stats='O' 
			AND D.user_id = '$user_id'
			) 
			as foo 
			");
            $query = $query->result_array();  
            
            // print_debug($this->db->last_query());
            
            return $query;
			
		}
        
        /* added by tri */
        function count_unapproved_elibrary($user_id)
		{
            $query = $this->db->query( "
			select distinct elib_id from 
			(SELECT
			A .elib_id,
			A .elib_judul,
			B.mapp_taks_id,
			D.user_id
			FROM
			kms_elibrary A
			LEFT JOIN kms_taks_elib B ON A .elib_id = B.elib_id
			LEFT JOIN kms_m_mapping_taksonomi C ON B.mapp_taks_id = C .mapp_taks_id
			LEFT JOIN kms_penanggung_jawab_taksonomi D ON B.mapp_taks_id = D.mapp_taks_id
			WHERE
			elib_stats = 'O'
			AND D.user_id = '$user_id'
			) 
			as foo 
			");
            $query = $query->result_array();  
            return $query;
			
		}
        
		
		public function data($key='')
		{
			$this->db->select("*");
			$this->db->from($this->_tbl_taksonomi);
			
			
			if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
			
			return $this->db;
		}
		public function count_data($key='')
		{
			$filter = array();
			//$filter["$this->_table1.user_id"] = $this->session->userdata('user_id');
			$kata_kunci = $this->input->post('keywords');
			$lower = strtolower($kata_kunci);
			if (!empty($kata_kunci)){
				$filter['OR']["LOWER(taks_perihal) LIKE '%{$lower}%' "] = NULL;
				$filter['OR']["LOWER(taks_abstract) LIKE '%{$lower}%' "] = NULL;
			}
			
			$rec=$this->data($filter)->get();
			return $total = $rec->num_rows();
		}
		public function data_table_data( $limit = 3, $offset = 1)
		{
			$html ="<div class='span12'>";
			// data filtering
			$filter = array();
			//$filter["$this->_table1.user_id"] = $this->session->userdata('user_id');
			$kata_kunci = $this->input->post('keywords');
			$lower = strtolower($kata_kunci);
			if (!empty($kata_kunci)){
				$filter['OR']["LOWER(taks_perihal) LIKE '%{$lower}%' "] = NULL;
				$filter['OR']["LOWER(taks_abstract) LIKE '%{$lower}%' "] = NULL;
			}
			
			$rec=$this->data($filter)->get();
			$total = $rec->num_rows();
			$this->db->limit($limit, ($offset * $limit) - $limit);
			$record = $this->data($filter)->get();
			//$no = (($offset-1) * $limit) +1;
			if($total>0){
				foreach ($record->result() as $row) {
					$html .="<div class='well blue'>
					<div class='well-content clearfix'>
					<h5><a href='".base_url('kms_main/taksonomi_knowledge/detail/'.$row->taks_id)."'>$row->taks_perihal</a></h5>
					<p>".substr($row->taks_abstract,0,250)."... <a href='".base_url('kms_main/taksonomi_knowledge/detail/'.$row->taks_id)."'>Read more</a></p>
					
					</div>
					</div>";
				}
			}else
			{
				$html .="<div class='well-content'>
				<div class='alert alert-error'>
				Tidak ditemukan data yang sesuai.
				</div>
				</div>";
			}
			$html .="</div>";
			return $html;
		}
		
		
        
        public function get_suggest_elibrary($user_id)
        {
            $html = "";
            $query = $this->db->query( "
			SELECT distinct
			elib_id
			FROM
			kms_keahlian_user
			LEFT JOIN(
			SELECT
			A .elib_id,
			A .elib_judul,
			A .elib_stats,
			B.mapp_taks_id,
			D.keahlian_id
			FROM
			kms_elibrary A
			LEFT JOIN kms_taks_elib B ON A .elib_id = B.elib_id
			LEFT JOIN kms_m_mapping_taksonomi C ON B.mapp_taks_id = C .mapp_taks_id
			LEFT JOIN kms_view_user_ahli_taks D ON D.mapp_taks_id = B.mapp_taks_id
			WHERE
			A .elib_stats = 'P'
			)AS foo ON foo.keahlian_id = kms_keahlian_user.keahlian_id 
			
			WHERE kms_keahlian_user.user_id = '$user_id'
			");
            $query = $query->result_array();
            
            // print_debug($query);
            
            $jum = count($query);
            if($jum > 0)
            {
                $html       .= "    <div class='alert alert-info' style='padding: 8px 30px 8px 14px !important;'> 
				<strong>Info $jum dokumen baru di eLibrary sesuai keahlian anda!</strong> </div>"; 
                $towrite    = ''; 
                $arr_elib_id = array();
                
                $i = 1;
                foreach($query as $key=>$val)
                {
                    $arr_elib_id[]  = $val['elib_id'];
                    $temp           = ''; 
                    $temp           = $val['elib_id'];
                    $towrite        .= "'$temp'";
                    $towrite        .= ($jum > $i) ? (', ') : ('');
                    $i++; 
				} 
                
                $query2 = $this->db->query( " select * from kms_elibrary where elib_id in($towrite)  ");
                $query2 = $query2->result_array(); 
                
                foreach($query2 as $val)
                {
                    $link = "<a href='".base_url('kms_main/elibrary/detail/'.$val['elib_id'])."'><i class='icon-zoom-in'></i> Detail</a>";
                    $html .="<div class='alert alert-info' style='padding: 8px 30px 8px 14px !important;'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>".hgenerator::switch_tanggal($val['elib_tgl_berlaku'])." </strong>
					<br>".$val['elib_judul']."<br>$link  </div>";
				} 
			}
            else
            {
                
			} 
            return $html; 
		}
        
        public function get_suggest_elibrary2($user_id)
        {
            $html = "";
            $query = $this->db->query( "
			SELECT distinct
			elib_id
			FROM
			kms_keahlian_user
			LEFT JOIN(
			SELECT
			A .elib_id,
			A .elib_judul,
			A .elib_stats,
			B.mapp_taks_id,
			D.keahlian_id
			FROM
			kms_elibrary A
			LEFT JOIN kms_taks_elib B ON A .elib_id = B.elib_id
			LEFT JOIN kms_m_mapping_taksonomi C ON B.mapp_taks_id = C .mapp_taks_id
			LEFT JOIN kms_view_user_ahli_taks D ON D.mapp_taks_id = B.mapp_taks_id
			WHERE
			A .elib_stats = 'P'
			)AS foo ON foo.keahlian_id = kms_keahlian_user.keahlian_id 
			
			WHERE kms_keahlian_user.user_id = '$user_id'
			");
            $query = $query->result_array();
            
            // print_debug($query);
            
            $jum = count($query);
            if($jum > 0)
            {
                $html       .=  "<div  style='cursor: pointer;' status='close'>
				<strong><span id='keterangan-icon-ultah'><i class='icon-plus'></i></span>
				<span class='icon info'><i class='icon-bell'></i></span> Info $jum dokumen baru di eLibrary sesuai keahlian anda! </strong><br/>
				</div>"; 
                $towrite    = ''; 
                $arr_elib_id = array();
                
				//                $i = 1;
				//                foreach($query as $key=>$val)
				//                {
				//                    $arr_elib_id[]  = $val['elib_id'];
				//                    $temp           = ''; 
				//                    $temp           = $val['elib_id'];
				//                    $towrite        .= "'$temp'";
				//                    $towrite        .= ($jum > $i) ? (', ') : ('');
				//                    $i++; 
				//                } 
				//                
				//                $query2 = $this->db->query( " select * from kms_elibrary where elib_id in($towrite)  ");
				//                $query2 = $query2->result_array(); 
				//                
				//                foreach($query2 as $val)
				//                {
				//                    $link = "<a href='".base_url('kms_main/elibrary/detail/'.$val['elib_id'])."'><i class='icon-zoom-in'></i> Detail</a>";
				//                    $html .="<div class='alert alert-info' style='padding: 8px 30px 8px 14px !important;'>
				//                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
				//                    <strong>".hgenerator::switch_tanggal($val['elib_tgl_berlaku'])." </strong>
				//                                                <br>".$val['elib_judul']."<br>$link  </div>";
				//                } 
			}
            else
            {
                
			} 
            return $html; 
		}
        
        public function get_suggest_elibrary3($user_id)
        {
            $html = "";
            $query = $this->db->query( "
			SELECT distinct
			elib_id
			FROM
			kms_keahlian_user
			LEFT JOIN(
			SELECT
			A .elib_id,
			A .elib_judul,
			A .elib_stats,
			B.mapp_taks_id,
			D.keahlian_id
			FROM
			kms_elibrary A
			LEFT JOIN kms_taks_elib B ON A .elib_id = B.elib_id
			LEFT JOIN kms_m_mapping_taksonomi C ON B.mapp_taks_id = C .mapp_taks_id
			LEFT JOIN kms_view_user_ahli_taks D ON D.mapp_taks_id = B.mapp_taks_id
			WHERE
			A .elib_stats = 'P'
			)AS foo ON foo.keahlian_id = kms_keahlian_user.keahlian_id 
			
			WHERE kms_keahlian_user.user_id = '$user_id'
			");
            $query = $query->result_array();
            
            // print_debug($query);
            
            $jum = count($query);
            if($jum > 0)
            {
				//                $html       .=  "<div  style='cursor: pointer;' status='close'>
				//                    <strong><span id='keterangan-icon-ultah'><i class='icon-plus'></i></span>
				//                    <span class='icon info'><i class='icon-bell'></i></span> Info $jum dokumen baru di eLibrary sesuai keahlian anda! </strong><br/>
				//                        </div>"; 
                $towrite    = ''; 
                $arr_elib_id = array();
                
                $i = 1;
                foreach($query as $key=>$val)
                {
                    $arr_elib_id[]  = $val['elib_id'];
                    $temp           = ''; 
                    $temp           = $val['elib_id'];
                    $towrite        .= "'$temp'";
                    $towrite        .= ($jum > $i) ? (', ') : ('');
                    $i++; 
				} 
                
                $query2 = $this->db->query( " select * from kms_elibrary where elib_id in($towrite)  ");
                $query2 = $query2->result_array(); 
                
                foreach($query2 as $val)
                {
                    $link = "<a href='".base_url('kms_main/elibrary/detail/'.$val['elib_id'])."'><i class='icon-zoom-in'></i> Detail</a>";
                    
                    $html .= "<div style='border-bottom: 1px dashed #3a87ad; '> ";
                    
                    $html .="  
					<strong>".hgenerator::switch_tanggal($val['elib_tgl_berlaku'])." </strong>
					<br>".$val['elib_judul']."<br>$link   ";
                    
                    $html .= "</div>";
				} 
			}
            else
            {
                
			} 
            return $html; 
		}
        
        
        public function get_info($user_id)
		{
            $html =" ";
            $q=$this->db->query("SELECT DISTINCT
			kms_taksonomi.taks_id,
			kms_taksonomi.taks_perihal,
			kms_taksonomi.taks_tgl_input,
			kms_taksonomi.taks_jam_input
			FROM
			kms_keahlian_user
			INNER JOIN kms_mapping_keahlian_taks ON kms_keahlian_user.keahlian_id = kms_mapping_keahlian_taks.keahlian_id
			INNER JOIN kms_mapp_taks ON kms_mapp_taks.mapp_taks_id = kms_mapping_keahlian_taks.mapp_taks_id
			INNER JOIN kms_taksonomi ON kms_taksonomi.taks_id = kms_mapp_taks.taks_id
			INNER JOIN kms_m_mapping_taksonomi ON kms_mapp_taks.mapp_taks_id = kms_m_mapping_taksonomi.mapp_taks_id
			WHERE
			kms_keahlian_user.user_id = '$user_id'
			and kms_mapp_taks.kms_mapp_taks_stats ='A'
			ORDER BY
			kms_taksonomi.taks_tgl_input DESC,
			kms_taksonomi.taks_jam_input DESC
			LIMIT 5 OFFSET 0");
            
            $jum = 0;
            if($q->num_rows()>0)
            {
                $jum = $q->num_rows();
                $html .="<div class='alert alert-info' style='padding: 8px 30px 8px 14px !important;'>
				
				<strong>Info $jum keilmuan baru sesuai keahlian anda!</strong>
                </div>";
                foreach($q->result() as $row)
                {
					$link = "<a href='".base_url('kms_main/taksonomi_knowledge/detail/'.$row->taks_id)."'><i class='icon-zoom-in'></i> Detail</a>";
					$html .="<div class='alert alert-info' style='padding: 8px 30px 8px 14px !important;'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>".hgenerator::switch_tanggal($row->taks_tgl_input)." $row->taks_jam_input</strong>
					<br>$row->taks_perihal<br>$link
					</div>";
				}
			}
            return $html;
		}
        
        public function get_suggest_takso1($user_id)
        {
            $html = "";
            $query = $this->db->query( "
			SELECT DISTINCT
			kms_taksonomi.taks_id,
			kms_taksonomi.taks_perihal,
			kms_taksonomi.taks_tgl_input,
			kms_taksonomi.taks_jam_input
			FROM
			kms_keahlian_user
			INNER JOIN kms_mapping_keahlian_taks ON kms_keahlian_user.keahlian_id = kms_mapping_keahlian_taks.keahlian_id
			INNER JOIN kms_mapp_taks ON kms_mapp_taks.mapp_taks_id = kms_mapping_keahlian_taks.mapp_taks_id
			INNER JOIN kms_taksonomi ON kms_taksonomi.taks_id = kms_mapp_taks.taks_id
			INNER JOIN kms_m_mapping_taksonomi ON kms_mapp_taks.mapp_taks_id = kms_m_mapping_taksonomi.mapp_taks_id
			WHERE
			kms_keahlian_user.user_id = '$user_id'
			and kms_mapp_taks.kms_mapp_taks_stats ='A'
			ORDER BY
			kms_taksonomi.taks_tgl_input DESC,
			kms_taksonomi.taks_jam_input DESC
			LIMIT 5 OFFSET 0
			");
            $query = $query->result_array();
            
            // print_debug($query);
            
            $jum = count($query);
            if($jum > 0)
            {
                $html       .=  "<div  style='cursor: pointer;' status='close'>
				<strong><span id='keterangan-icon-ultah'><i class='icon-plus'></i></span>
				<span class='icon info'><i class='icon-bell'></i></span> Info $jum keilmuan baru sesuai keahlian anda! </strong><br/>
				</div>"; 
                $towrite    = ''; 
                $arr_elib_id = array();
                
				//                $i = 1;
				//                foreach($query as $key=>$val)
				//                {
				//                    $arr_elib_id[]  = $val['elib_id'];
				//                    $temp           = ''; 
				//                    $temp           = $val['elib_id'];
				//                    $towrite        .= "'$temp'";
				//                    $towrite        .= ($jum > $i) ? (', ') : ('');
				//                    $i++; 
				//                } 
				//                
				//                $query2 = $this->db->query( " select * from kms_elibrary where elib_id in($towrite)  ");
				//                $query2 = $query2->result_array(); 
				//                
				//                foreach($query2 as $val)
				//                {
				//                    $link = "<a href='".base_url('kms_main/elibrary/detail/'.$val['elib_id'])."'><i class='icon-zoom-in'></i> Detail</a>";
				//                    $html .="<div class='alert alert-info' style='padding: 8px 30px 8px 14px !important;'>
				//                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
				//                    <strong>".hgenerator::switch_tanggal($val['elib_tgl_berlaku'])." </strong>
				//                                                <br>".$val['elib_judul']."<br>$link  </div>";
				//                } 
			}
            else
            {
                
			} 
            return $html; 
		}
        
        public function get_suggest_takso2($user_id)
        {
            $html = "";
            $query = $this->db->query( "
			SELECT DISTINCT 
			kms_taksonomi.taks_id,
			kms_taksonomi.taks_perihal,
			kms_taksonomi.taks_tgl_input,
			kms_taksonomi.taks_jam_input
			FROM
			kms_keahlian_user
			INNER JOIN kms_mapping_keahlian_taks ON kms_keahlian_user.keahlian_id = kms_mapping_keahlian_taks.keahlian_id
			INNER JOIN kms_mapp_taks ON kms_mapp_taks.mapp_taks_id = kms_mapping_keahlian_taks.mapp_taks_id
			INNER JOIN kms_taksonomi ON kms_taksonomi.taks_id = kms_mapp_taks.taks_id
			INNER JOIN kms_m_mapping_taksonomi ON kms_mapp_taks.mapp_taks_id = kms_m_mapping_taksonomi.mapp_taks_id
			WHERE
			kms_keahlian_user.user_id = '$user_id'
			and kms_mapp_taks.kms_mapp_taks_stats ='A'
			ORDER BY
			kms_taksonomi.taks_tgl_input DESC,
			kms_taksonomi.taks_jam_input DESC
			LIMIT 5 OFFSET 0
			");
            $query = $query->result_array();
            
            // print_debug($query);
            
            $jum = count($query);
            if($jum > 0)
            {
				//                $html       .=  "<div  style='cursor: pointer;' status='close'>
				//                    <strong><span id='keterangan-icon-ultah'><i class='icon-plus'></i></span>
				//                    <span class='icon info'><i class='icon-bell'></i></span> Info $jum dokumen baru di eLibrary sesuai keahlian anda! </strong><br/>
				//                        </div>"; 
                $towrite    = ''; 
                $arr_elib_id = array();
                
                $i = 1;
                foreach($query as $key=>$val)
                {
                    $arr_elib_id[]  = $val['taks_id'];
                    $temp           = ''; 
                    $temp           = $val['taks_id'];
                    $towrite        .= "'$temp'";
                    $towrite        .= ($jum > $i) ? (', ') : ('');
                    $i++; 
				} 
                
                $query2 = $this->db->query( " select * from kms_taksonomi where taks_id in($towrite)  ");
                $query2 = $query2->result_array(); 
                
                // print_debug($query2);
                
                foreach($query2 as $val)
                {
                    $link = "<a href='".base_url('kms_main/taksonomi_knowledge/detail/'.$val['taks_id'])."'><i class='icon-zoom-in'></i> Detail</a>";
                    
                    $html .= "<div style='border-bottom: 1px dashed #3a87ad; '> ";
                    
                    $html .=" 
					<strong>".hgenerator::switch_tanggal($val['taks_tgl_input'])." </strong>
					<br>".$val['taks_perihal']."<br>$link   ";
                    
                    $html .= "</div>";
				} 
			}
            else
            {
                
			} 
            return $html; 
		}
		
		public function picbelumlaporan(){
			$html = '';
			$query = "SELECT a.`NAMA_USER` 
			FROM m_user a
			WHERE a.`ID_USER` NOT IN (SELECT `ID_USER` 
			FROM `progres_program` b 
			WHERE DATE_FORMAT(b.`TGL_PROGRESS`, '%d-%m-%Y') = DATE_FORMAT(CURDATE(), '%d-%m-%Y'))";
			$query = $this->db->query($query);
			$arr = $query->result_array();
			$jum = count($arr);
			$html = "<ul>";
			if($jum > 0){
				foreach($arr as $key=>$val){
					$html .= "<li>";
					$html .= $val['NAMA_USER'];
					$html .= "</li>";
				}
			}
			$html .= "</ul>";
			return $html;
		}
        
		public function picsudahlaporan(){
			$html = '';
			$query = "SELECT a.`NAMA_USER`, b.`TGL_PROGRESS`, SUBSTR(b.`KET_PROGRESS`, 1, 200) AS KET, b.`PERSEN_PROGRESS`
			FROM m_user a, `progres_program` b
			WHERE a.`ID_USER` = b.`ID_USER` AND
			a.`ID_USER` IN (SELECT `ID_USER` FROM `progres_program` b WHERE b.`TGL_PROGRESS` = CURDATE())";
			$query = $this->db->query($query);
			$arr = $query->result_array();
			$jum = count($arr);
			$html = "<ul>";
			if($jum > 0){
				foreach($arr as $key=>$val){
					$html .= "<li>";
					$html .= $val['NAMA_USER'];
					$html .= "Keterngan Progress : ";
					$html .= $val['KET_PROGRESS'];
					$html .= "</li>";
				}
			}
			$html .= "</ul>";
			return $html;
		}
		
		public function databelumverifikasi(){
			$html = '';
			$query = "SELECT (SELECT nama_user FROM m_user b WHERE b.ID_USER = a.ID_USER) AS nama, b.`NAMA_PROGRAM`, a.`PERSEN_PROGRESS`,
			SUBSTR(a.`KET_PROGRESS`, 1, 200) AS KET
			FROM `progres_program` a, m_program b
			WHERE a.`ID_PROGRAM` = b.`ID_PROGRAM`
			AND DATE_FORMAT(a.`TGL_PROGRESS`, '%d-%m-%Y') = DATE_FORMAT(CURDATE(), '%d-%m-%Y')";
			$query = $this->db->query($query);
			$arr = $query->result_array();
			$jum = count($arr);
			$html = "<ul>";
			if($jum > 0){
				foreach($arr as $key=>$val){
					$html .= "<li>";
					$html .= $val['NAMA_USER'];
					$html .= ' : ';
					$html .= $val['NAMA_PROGRAM'];
					$html .= ' - ';
					$html .= $val['PERSEN_PROGRESS'];
					$html .= "</li>";
				}
			}
			$html .= "</ul>";
			return $html;
		}
		
	}	