<?php

/**
 * @module DASHBOARD
 * @author  RAKHMAT WIJAYANTO
 * @created at 10 NOVEMBER 2017
 * @modified at 10 NOVEMBER 2017
 */
class grafik_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "DUMMY_GRAFIK"; //nama table setelah mom_
    private $_tablePersediaanBBM="REKAP_MUTASI_PERSEDIAAN";

    public function report(){
        $query = $this->db->query("SELECT DATE_FORMAT(a.tanggal,'%m') bulan,DATE_FORMAT(a.tanggal,'%M %Y') blth,DATE_FORMAT(a.tanggal,'%Y%m') blth2, ROUND(AVG(a.Harga),2) avgHargaKurs, ROUND(AVG(a.hsdnoppn),2) avgHargaHsd, ROUND(AVG(a.mfonoppn),2) avgHargaMfo, ROUND(AVG(a.rmopshsd),2) avgHargaMops, DATE_FORMAT(a.tanggal,'%Y') tahun FROM DUMMY_GRAFIK a WHERE DATE_FORMAT(a.tanggal,'%Y')= YEAR(NOW()) GROUP BY a.blth;");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    } 

    public function getVolMfo($data){
       
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT SUM(B.STOCK_AKHIR_REAL) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
		        FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'MFO' AND MONTH(A.TGL_MUTASI_PERSEDIAAN) = '11' AND YEAR(A.TGL_MUTASI_PERSEDIAAN) = '2017' 
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

    }

    public function getVolHsd($data){
       
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT SUM(B.STOCK_AKHIR_REAL) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
		        FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'HSD' AND MONTH(A.TGL_MUTASI_PERSEDIAAN) = '11' AND YEAR(A.TGL_MUTASI_PERSEDIAAN) = '2017' 
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }

     public function getVolBio($data)
     {

        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


       
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT SUM(B.STOCK_AKHIR_REAL) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
		        FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'BIO' AND MONTH(A.TGL_MUTASI_PERSEDIAAN) = '11' AND YEAR(A.TGL_MUTASI_PERSEDIAAN) = '2017' 
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }
    

     public function getVolHsdBio($data){
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


       
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT SUM(B.STOCK_AKHIR_REAL) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
		        FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'HSD+BIO' AND MONTH(A.TGL_MUTASI_PERSEDIAAN) = '11' AND YEAR(A.TGL_MUTASI_PERSEDIAAN) = '2017' 
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }

     public function getVolIdo($data)
     {

        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];  
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';


        
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $PARAM = "F.ID_REGIONAL != '' ";
        }
        else if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "F.ID_REGIONAL = '$ID'";
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "E.COCODE  = '$COCODE'";
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "D.PLANT = '$PLANT'";
        } elseif ($SLOC == '') {
            $PARAM = "C.STORE_SLOC = '$STORE_SLOC'";
        } 
        else {
           $PARAM = "B.SLOC = '$SLOC'";
        }
        $sql = "SELECT SUM(B.STOCK_AKHIR_REAL) AS STOK FROM(SELECT * FROM (SELECT B.LEVEL4, A.TGL_MUTASI_PERSEDIAAN,G.NAMA_JNS_BHN_BKR,
                A.DEAD_STOCK,
                A.STOCK_AKHIR_REAL,A.STOCK_AKHIR_EFEKTIF,A.SHO,F.NAMA_REGIONAL,E.LEVEL1, D.LEVEL2, C.LEVEL3
		        FROM REKAP_MUTASI_PERSEDIAAN A
                INNER JOIN MASTER_LEVEL4 B ON B.SLOC=A.SLOC 
                INNER JOIN MASTER_LEVEL3 C ON C.STORE_SLOC = B.STORE_SLOC
                INNER JOIN MASTER_LEVEL2 D ON D.PLANT = B.PLANT
                INNER JOIN MASTER_LEVEL1 E ON E.COCODE=D.COCODE
                INNER JOIN MASTER_REGIONAL F ON F.ID_REGIONAL=E.ID_REGIONAL
                INNER JOIN M_JNS_BHN_BKR G ON G.ID_JNS_BHN_BKR=A.ID_JNS_BHN_BKR
                WHERE $PARAM AND G.NAMA_JNS_BHN_BKR = 'IDO' AND MONTH(A.TGL_MUTASI_PERSEDIAAN) = '11' AND YEAR(A.TGL_MUTASI_PERSEDIAAN) = '2017' 
                AND A.IS_AKTIF_MUTASI_PERSEDIAAN = '1'
                ORDER BY A.TGL_MUTASI_PERSEDIAAN DESC)
                AS A 
                GROUP BY A.NAMA_REGIONAL, A.LEVEL1,A.LEVEL2,A.LEVEL3,A.LEVEL4,A.NAMA_JNS_BHN_BKR) AS B
        ";
         
       $query = $this->db->query($sql);
        
        return $query->result();

     }

     public function getTableMfo($data)
     {
        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('MFO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

     public function getTableBio($data)
     {

        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('BIO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

     public function getTableHsd($data)
     {

        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('HSD','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }
        

     }

     public function getTableHsdBio($data)
     {

        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('HSD+BIO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

     public function getTableIdo($data)
     {

        
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC']; 
        $BULAN = $data['BULAN'];   
        $TAHUN = $data['TAHUN'];   
        $PARAM = '';

          
      
        if ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='00') {
            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == ''&& $ID =='') {
            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Pusat','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        }
        elseif ($COCODE == '' && $PLANT == '' && $STORE_SLOC == '' &&  $SLOC == '') {
            $PARAM = "$ID";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Regional','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($PLANT == '' && $STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$COCODE";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 1','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($STORE_SLOC == '' && $SLOC == '') {
            $PARAM = "$PLANT";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 2','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } elseif ($SLOC == '') {
            $PARAM = "$STORE_SLOC";

            $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 3','$PARAM')";
            $query = $this->db->query($sql);
            
            return $query->result();
        } else{
           $PARAM = "$SLOC";

           $sql="CALL dashboard ('IDO','$BULAN','$TAHUN','Level 4','$PARAM')";
           $query = $this->db->query($sql);
           
           return $query->result();
        }

     }

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
        }
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            return $option;    
        }
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            return $option;    
        }
    }

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            return $option;    
        }
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->SLOC] = $row->LEVEL4;
            }
            return $option;    
        }
    }

    public function options_bulan() {
        $option = array();
        $option[''] = '--Pilih Bulan--';
        $option['01'] = 'Januari';
        $option['02'] = 'Febuari';
        $option['03'] = 'Maret';
        $option['04'] = 'April';
        $option['05'] = 'Mei';
        $option['06'] = 'Juni';
        $option['07'] = 'Juli';
        $option['08'] = 'Agustus';
        $option['09'] = 'September';
        $option['10'] = 'Oktober';
        $option['11'] = 'November';
        $option['12'] = 'Desember';
        return $option;
    }

    public function options_tahun() {
        $year = date("Y"); 

        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function get_level($lv='', $key=''){ 
        switch ($lv) {
            case "R":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "0":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "1":
                $q = "SELECT D.COCODE, D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_LEVEL1 D 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE COCODE='$key' ";
                break;
            case "2":
                $q = "SELECT C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL2 C 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE PLANT='$key' ";
                break;
            case "3":
                $q = "SELECT B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL3 B
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE STORE_SLOC='$key' ";
                break;
            case "4":
                $q = "SELECT A.SLOC, A.LEVEL4, B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL4 A
                LEFT JOIN MASTER_LEVEL3 B ON B.STORE_SLOC=A.STORE_SLOC 
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE SLOC='$key' ";
                break;
            case "5":
                $q = "SELECT a.LEVEL3, a.STORE_SLOC
                FROM MASTER_LEVEL3 a
                INNER JOIN MASTER_LEVEL2 b ON a.PLANT = b.PLANT
                INNER JOIN MASTER_LEVEL4 c ON a.STORE_SLOC = c.STORE_SLOC AND a.PLANT = c.PLANT
                WHERE c.STATUS_LVL2=1 AND a.PLANT = '$key' ";
                break;
        } 

        $query = $this->db->query($q)->result();
        return $query;
    }
      
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */