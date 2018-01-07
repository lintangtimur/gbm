
<?php
    if ($JENIS=='XLS'){
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Persediaan_BBM.xls");

        echo "
        <style>

        table.tdetail {
            border-collapse: collapse;
            width:100%;
            font-size: 10px;
            font-family:arial;
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;  
        }

        table.tdetail thead {background-color: #CED8F6}

        </style>

        ";
    } else {
        echo "
        <style>
        table.tdetail {
            border-collapse: collapse;
            width:100%;
            font-size: 10px;
            background-color: #CED8F6;
            font-family:arial;
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;  
        }

        table.tdetail tbody tr:nth-child(even) {background-color: #f2f2f2}
        table.tdetail tbody tr:nth-child(odd) {background-color: #FFF}

        </style>

        ";   
    }
?>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="8"><h3>LAPORAN PERSEDIAAN BBM</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>    
</table>

<table border="0" style="width:100%;">
    <?php 
        $jml_lv=4;
        if ($ID_REGIONAL){
            $jml_lv= $jml_lv-1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">REGIONAL '.$ID_REGIONAL_NAMA.'</td></tr>';
        }
        if ($COCODE){
            $jml_lv= $jml_lv-1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">WILAYAH '.$COCODE_NAMA.'</td></tr>';
        }
        if ($PLANT){
            $jml_lv= $jml_lv-1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">AREA '.$PLANT_NAMA.'</td></tr>';
        }
        if ($STORE_SLOC){
            $jml_lv= $jml_lv-1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">RAYON '.$STORE_SLOC_NAMA.'</td></tr>';
        }
        if ($BULAN){
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">BLTH '.$TAHUN.''.$BULAN.'</td></tr>';
        } else {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun '.$TAHUN.'</td></tr>';
        }
    ?> 
    <tr><td></td><td></td><td></td><td></td><td></td></tr> 
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <?php
            if ($jml_lv>1){
                echo '<th colspan="'.$jml_lv.'">Level</th>';
            } else if ($jml_lv==1){
                echo '<th rowspan="2">Level 3</th>';
            }
        ?>
        <!-- <th colspan="4">Level</th> -->
        <th rowspan="2">Pembangkit</th>
        <th rowspan="2">Bahan Bakar</th>
        <th rowspan="2">Tgl Mutasi Persediaan</th>
        <th rowspan="2">Stok Awal (L)</th>
        <th colspan="2">Penerimaan (L)</th>
        <th colspan="2">Pemakaian (L)</th>
        <th rowspan="2">Volume Opname (L)</th>
        <th rowspan="2">Dead Stok (L)</th>
        <th rowspan="2">Max Pemakaian (L)</th>
        <th colspan="2">Stok (L)</th>
        <th rowspan="2">SHO (Hari)</th>
    </tr>
    <tr>
        <?php
            if ($jml_lv == 3){
                echo '<th>1</th>';
                echo '<th>2</th>';
                echo '<th>3</th>';
            } else if ($jml_lv == 2) {
                echo '<th>2</th>';
                echo '<th>3</th>';
            }
        ?>
        <!-- <th>0</th> 
        <th>1</th>
        <th>2</th>
        <th>3</th> -->
        <th>Terima Pemasok</th>
        <th>Terima Unit Lain</th>
        <th>Sendiri</th>
        <th>Kirim</th>
        <th>Akhir</th>
        <th>Akhir Efektif</th>
    </tr>
    </thead>

    <tbody>
    <?php
        $x=0;
        foreach($data as $row):
        $x++;    
    ?>
    <tr>
        <td style="text-align:center;"><?php echo $x ?></td>

        <?php
            if ($jml_lv == 3){
                echo '<td>'.$row->LEVEL1.'</td>';
                echo '<td>'.$row->LEVEL2.'</td>';
                echo '<td>'.$row->LEVEL3.'</td>';
            } else if ($jml_lv == 2) {
                echo '<td>'.$row->LEVEL2.'</td>';
                echo '<td>'.$row->LEVEL3.'</td>';
            } else if ($jml_lv == 1) {
                echo '<td>'.$row->LEVEL3.'</td>';
            }
        ?>

        <!-- <td><?php echo $row->LEVEL0 ?></td>
        <td><?php echo $row->LEVEL1 ?></td>
        <td><?php echo $row->LEVEL2 ?></td>
        <td><?php echo $row->LEVEL3 ?></td> -->
        <td><?php echo $row->LEVEL4 ?></td>
        <td><?php echo $row->NAMA_JNS_BHN_BKR ?></td>
        <td style="text-align:center;"><?php echo $row->TGL_MUTASI_PERSEDIAAN ?></td>

        <?php
            // if ($JENIS=='XLS'){
            //     $STOCK_AWAL = !empty($row->STOCK_AWAL) ? $row->STOCK_AWAL : '0';
            //     $TERIMA_PEMASOK = !empty($row->TERIMA_PEMASOK) ? $row->TERIMA_PEMASOK : '0';
            //     $TERIMA_UNITLAIN = !empty($row->TERIMA_UNITLAIN) ? $row->TERIMA_UNITLAIN : '0';
            //     $PEMAKAIAN_SENDIRI = !empty($row->PEMAKAIAN_SENDIRI) ? $row->PEMAKAIAN_SENDIRI : '0';
            //     $PEMAKAIAN_KIRIM = !empty($row->PEMAKAIAN_KIRIM) ? $row->PEMAKAIAN_KIRIM : '0';
            //     $VOLUME_STOCKOPNAME = !empty($row->VOLUME_STOCKOPNAME) ? $row->VOLUME_STOCKOPNAME : '0';
            //     $DEAD_STOCK = !empty($row->DEAD_STOCK) ? $row->DEAD_STOCK : '0';
            //     $STOCK_AKHIR_REAL = !empty($row->STOCK_AKHIR_REAL) ? $row->STOCK_AKHIR_REAL : '0';
            //     $STOCK_AKHIR_EFEKTIF = !empty($row->STOCK_AKHIR_EFEKTIF) ? $row->STOCK_AKHIR_EFEKTIF : '0';
            //     $SHO = !empty($row->SHO) ? $row->SHO : '0'; 
            // } else {
                $STOCK_AWAL = !empty($row->STOCK_AWAL) ? number_format($row->STOCK_AWAL,2,',','.') : '0,00';
                $TERIMA_PEMASOK = !empty($row->TERIMA_PEMASOK) ? number_format($row->TERIMA_PEMASOK,2,',','.') : '0,00';
                $TERIMA_UNITLAIN = !empty($row->TERIMA_UNITLAIN) ? number_format($row->TERIMA_UNITLAIN,2,',','.') : '0,00';
                $PEMAKAIAN_SENDIRI = !empty($row->PEMAKAIAN_SENDIRI) ? number_format($row->PEMAKAIAN_SENDIRI,2,',','.') : '0,00';
                $PEMAKAIAN_KIRIM = !empty($row->PEMAKAIAN_KIRIM) ? number_format($row->PEMAKAIAN_KIRIM,2,',','.') : '0,00';
                $VOLUME_STOCKOPNAME = !empty($row->VOLUME_STOCKOPNAME) ? number_format($row->VOLUME_STOCKOPNAME,2,',','.') : '0,00';
                $DEAD_STOCK = !empty($row->DEAD_STOCK) ? number_format($row->DEAD_STOCK,2,',','.') : '0,00';
                $MAX_PEMAKAIAN = !empty($row->MAX_PEMAKAIAN) ? number_format($row->MAX_PEMAKAIAN,2,',','.') : '0,00';
                $STOCK_AKHIR_REAL = !empty($row->STOCK_AKHIR_REAL) ? number_format($row->STOCK_AKHIR_REAL,2,',','.') : '0,00';
                $STOCK_AKHIR_EFEKTIF = !empty($row->STOCK_AKHIR_EFEKTIF) ? number_format($row->STOCK_AKHIR_EFEKTIF,2,',','.') : '0,00';
                $SHO = !empty($row->SHO) ? number_format($row->SHO,2,',','.') : '0,00'; 
            // }
        ?>
        <td style="text-align:right;"><?php echo $STOCK_AWAL ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_PEMASOK ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_UNITLAIN ?></td>
        <td style="text-align:right;"><?php echo $PEMAKAIAN_SENDIRI ?></td>
        <td style="text-align:right;"><?php echo $PEMAKAIAN_KIRIM ?></td>
        <td style="text-align:right;"><?php echo $VOLUME_STOCKOPNAME ?></td>
        <td style="text-align:right;"><?php echo $DEAD_STOCK ?> </td> 
        <td style="text-align:right;"><?php echo $MAX_PEMAKAIAN ?> </td>
        <td style="text-align:right;"><?php echo $STOCK_AKHIR_REAL ?></td>
        <td style="text-align:right;"><?php echo $STOCK_AKHIR_EFEKTIF ?></td>
        <td style="text-align:right;"><?php echo $SHO ?></td>
    </tr>
    <?php
        endforeach;

        if ($x==0){
            echo '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr> 
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr> 
</table><br>