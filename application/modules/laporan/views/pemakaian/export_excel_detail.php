
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Detail_Laporan_Pemakaian_BBM.xls');

        echo '
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

        ';
    } else {
        echo '
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

        ';
    }
?>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="8"><h3>DETAIL LAPORAN PEMAKAIAN BBM</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <?php
        $jml_lv=4;
        if ($ID_REGIONAL) {
            $jml_lv= $jml_lv - 1; //3
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">REGIONAL ' . $ID_REGIONAL_NAMA . '</td></tr>';
        }
        if ($COCODE) {
            $jml_lv= $jml_lv - 1; //2
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">WILAYAH ' . $COCODE_NAMA . '</td></tr>';
        }
        if ($PLANT) {
            $jml_lv= $jml_lv - 1; //1
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">AREA ' . $PLANT_NAMA . '</td></tr>';
        }
        if ($STORE_SLOC) {
            $jml_lv= $jml_lv - 1; //0
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">RAYON ' . $STORE_SLOC_NAMA . '</td></tr>';
        }
        if ($TGL_AWAL) {
            $tAwal       = substr($TGL_AWAL, 0, 2);
            $taunAwal    = substr($TGL_AWAL, 4, 7);
            $blnAwal     = substr($TGL_AWAL, 2, 2);
            $tglAwal     = $taunAwal . '-' . $blnAwal . '-' . $tAwal;

            $tAkhir       = substr($TGL_AKHIR, 0, 2);
            $taunAkhir    = substr($TGL_AKHIR, 4, 7);
            $blnAkhir     = substr($TGL_AKHIR, 2, 2);
            $tglAkhir     = $taunAkhir . '-' . $blnAkhir . '-' . $tAkhir;
            if ($TGL_AWAL == '-' and $TGL_AKHIR == '-') {
                $tglAwal  = 'Awal';
                $tglAkhir = 'Akhir';
            }
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Periode ' . $tglAwal . ' s/d ' . $tglAkhir . '</td></tr>';
        } else {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TGL_AKHIR . '</td></tr>';
        }
        // if ($BULAN) {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">BLTH ' . $TAHUN . '' . $BULAN . '</td></tr>';
        // } else {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TAHUN . '</td></tr>';
        // }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th colspan="4">Level</th>
        <th rowspan="2" width="100px;">Unit Pembangkit</th>
        <th rowspan="2">Jenis BBM</th>
        <th rowspan="2">Jenis Pemakaian</th>
        <th rowspan="2">No Pemakaian</th>
        <th rowspan="2">Tanggal Catat</th>
        <th rowspan="2">Tanggal Pengakuan</th>
        <th rowspan="2">Total Volume Pemakaian (L)</th>
        <th rowspan="2">Keterangan</th>
    </tr>
    <tr>
      <th>0</th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
    </tr>
    </thead>

    <tbody>
    <?php
        $x=0;
        foreach ($data as $row):
        $x++;
    ?>
    <tr>
      <?php
              $LEVEL0                              = !empty($row->LEVEL0) ? $row->LEVEL0 : '-';
              $LEVEL1                              = !empty($row->LEVEL1) ? $row->LEVEL1 : '-';
              $LEVEL2                              = !empty($row->LEVEL2) ? $row->LEVEL2 : '-';
              $LEVEL3                              = !empty($row->LEVEL3) ? $row->LEVEL3 : '-';
              $UNIT                                = !empty($row->UNIT) ? $row->UNIT : '-';
              $NAMA_JNS_BHN_BKR                    = !empty($row->NAMA_JNS_BHN_BKR) ? $row->NAMA_JNS_BHN_BKR : '-';
              $JENIS_PEMAKAIAN                     = !empty($row->JENIS_PEMAKAIAN) ? $row->JENIS_PEMAKAIAN : '-';
              $NO_PEMAKAIAN                        = !empty($row->NO_PEMAKAIAN) ? $row->NO_PEMAKAIAN : '-';
              $TGL_CATAT                           = !empty($row->TGL_CATAT) ? $row->TGL_CATAT : '-';
              $TGL_PENGAKUAN_PAKAI                 = !empty($row->TGL_PENGAKUAN_PAKAI) ? $row->TGL_PENGAKUAN_PAKAI : '-';
              $VOLUME_PEMAKAIAN                    = !empty($row->VOLUME_PEMAKAIAN) ? number_format($row->VOLUME_PEMAKAIAN, 0, ',', '.') : '0';
              $KETERANGAN                          = !empty($row->KETERANGAN) ? $row->KETERANGAN : '-';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:left;"><?php echo $LEVEL0 ?></td>
        <td style="text-align:left;"><?php echo $LEVEL1 ?></td>
        <td style="text-align:left;"><?php echo $LEVEL2 ?></td>
        <td style="text-align:left;"><?php echo $LEVEL3 ?></td>
        <td style="text-align:left;"><?php echo $UNIT ?></td>
        <td style="text-align:center;"><?php echo $NAMA_JNS_BHN_BKR ?></td>
        <td style="text-align:center;"><?php echo $JENIS_PEMAKAIAN ?></td>
        <td style="text-align:center;"><?php echo $NO_PEMAKAIAN ?></td>
        <td style="text-align:center;"><?php echo $TGL_CATAT ?></td>
        <td style="text-align:center;"><?php echo $TGL_PENGAKUAN_PAKAI ?></td>
        <td style="text-align:right;"><?php echo $VOLUME_PEMAKAIAN ?></td>
        <td style="text-align:center;"><?php echo $KETERANGAN ?></td>
    </tr>
    <?php
        endforeach;

        if ($x == 0) {
            echo '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
