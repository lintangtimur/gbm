
<?php
    if ($JENIS=='XLS'){
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Persediaan_BBM.xls");

        echo "
        <style>
        table {
            border-collapse: collapse;
            width:100%;
            font-size: 10px;
            font-family:arial;
        }

        table, td, th {
            border: 1px solid black;  
        }

        thead {background-color: #CED8F6}

        </style>

        ";
    } else {
        echo "
        <style>
        table {
            border-collapse: collapse;
            width:100%;
            font-size: 10px;
            background-color: #CED8F6;
            font-family:arial;
        }

        table, td, th {
            border: 1px solid black;  
        }

        tbody tr:nth-child(even) {background-color: #f2f2f2}
        tbody tr:nth-child(odd) {background-color: #FFF}

        </style>

        ";   
    }
?>

<h3>Laporan Persediaan BBM</h3>
<table>
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th colspan="4">Level</th>
        <th rowspan="2">Pembangkit</th>
        <th rowspan="2">Bahan Bakar</th>
        <th rowspan="2">Tgl Mutasi Persediaan</th>
        <th rowspan="2">Stok Awal (L)</th>
        <th colspan="2">Penerimaan (L)</th>
        <th colspan="2">Pemakaian (L)</th>
        <th rowspan="2">Volume Opname (L)</th>
        <th rowspan="2">Dead Stok (L)</th>
        <th colspan="2">Stok (L)</th>
        <th rowspan="2">SHO</th>
    </tr>
    <tr>
        <th>0</th>
        <th>1</th>
        <th>2</th>
        <th>3</th>
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
        <td><?php echo $row->LEVEL0 ?></td>
        <td><?php echo $row->LEVEL1 ?></td>
        <td><?php echo $row->LEVEL2 ?></td>
        <td><?php echo $row->LEVEL3 ?></td>
        <td><?php echo $row->LEVEL4 ?></td>
        <td><?php echo $row->NAMA_JNS_BHN_BKR ?></td>
        <td style="text-align:center;"><?php echo $row->TGL_MUTASI_PERSEDIAAN ?></td>

        <?php
            if ($JENIS=='XLS'){
                $STOCK_AWAL = !empty($row->STOCK_AWAL) ? $row->STOCK_AWAL : '0';
                $TERIMA_PEMASOK = !empty($row->TERIMA_PEMASOK) ? $row->TERIMA_PEMASOK : '0';
                $TERIMA_UNITLAIN = !empty($row->TERIMA_UNITLAIN) ? $row->TERIMA_UNITLAIN : '0';
                $PEMAKAIAN_SENDIRI = !empty($row->PEMAKAIAN_SENDIRI) ? $row->PEMAKAIAN_SENDIRI : '0';
                $PEMAKAIAN_KIRIM = !empty($row->PEMAKAIAN_KIRIM) ? $row->PEMAKAIAN_KIRIM : '0';
                $VOLUME_STOCKOPNAME = !empty($row->VOLUME_STOCKOPNAME) ? $row->VOLUME_STOCKOPNAME : '0';
                $DEAD_STOCK = !empty($row->DEAD_STOCK) ? $row->DEAD_STOCK : '0';
                $STOCK_AKHIR_REAL = !empty($row->STOCK_AKHIR_REAL) ? $row->STOCK_AKHIR_REAL : '0';
                $STOCK_AKHIR_EFEKTIF = !empty($row->STOCK_AKHIR_EFEKTIF) ? $row->STOCK_AKHIR_EFEKTIF : '0';
                $SHO = !empty($row->SHO) ? $row->SHO : '0'; 
            } else {
                $STOCK_AWAL = !empty($row->STOCK_AWAL) ? number_format($row->STOCK_AWAL,0,',','.') : '0';
                $TERIMA_PEMASOK = !empty($row->TERIMA_PEMASOK) ? number_format($row->TERIMA_PEMASOK,0,',','.') : '0';
                $TERIMA_UNITLAIN = !empty($row->TERIMA_UNITLAIN) ? number_format($row->TERIMA_UNITLAIN,0,',','.') : '0';
                $PEMAKAIAN_SENDIRI = !empty($row->PEMAKAIAN_SENDIRI) ? number_format($row->PEMAKAIAN_SENDIRI,0,',','.') : '0';
                $PEMAKAIAN_KIRIM = !empty($row->PEMAKAIAN_KIRIM) ? number_format($row->PEMAKAIAN_KIRIM,0,',','.') : '0';
                $VOLUME_STOCKOPNAME = !empty($row->VOLUME_STOCKOPNAME) ? number_format($row->VOLUME_STOCKOPNAME,0,',','.') : '0';
                $DEAD_STOCK = !empty($row->DEAD_STOCK) ? number_format($row->DEAD_STOCK,0,',','.') : '0';
                $STOCK_AKHIR_REAL = !empty($row->STOCK_AKHIR_REAL) ? number_format($row->STOCK_AKHIR_REAL,0,',','.') : '0';
                $STOCK_AKHIR_EFEKTIF = !empty($row->STOCK_AKHIR_EFEKTIF) ? number_format($row->STOCK_AKHIR_EFEKTIF,0,',','.') : '0';
                $SHO = !empty($row->SHO) ? number_format($row->SHO,3,',','.') : '0'; 
            }
        ?>
        <td style="text-align:right;"><?php echo $STOCK_AWAL ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_PEMASOK ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_UNITLAIN ?></td>
        <td style="text-align:right;"><?php echo $PEMAKAIAN_SENDIRI ?></td>
        <td style="text-align:right;"><?php echo $PEMAKAIAN_KIRIM ?></td>
        <td style="text-align:right;"><?php echo $VOLUME_STOCKOPNAME ?></td>
        <td style="text-align:right;"><?php echo $DEAD_STOCK ?> </td>
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