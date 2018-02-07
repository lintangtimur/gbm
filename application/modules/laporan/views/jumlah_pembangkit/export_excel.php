<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: text/html');
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment; filename=Laporan_Jumlah_Pembangkit_BBM.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><h3>LAPORAN JUMLAH PEMBANGKIT BBM</h3></td>
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
        // if ($BULAN) {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">BLTH ' . $TAHUN . '' . $BULAN . '</td></tr>';
        // } else {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TAHUN . '</td></tr>';
        // }
        // if ($TGLAWAL) {
        //     $tAwal       = substr($TGLAWAL, 0, 2);
        //     $taunAwal    = substr($TGLAWAL, 4, 7);
        //     $blnAwal     = substr($TGLAWAL, 2, 2);
        //     $tglAwal     = $taunAwal . '-' . $blnAwal . '-' . $tAwal;
        //
        //     $tAkhir       = substr($TGLAKHIR, 0, 2);
        //     $taunAkhir    = substr($TGLAKHIR, 4, 7);
        //     $blnAkhir     = substr($TGLAKHIR, 2, 2);
        //     $tglAkhir     = $taunAkhir . '-' . $blnAkhir . '-' . $tAkhir;
        //     if ($TGLAWAL == '-' and $TGLAKHIR == '-') {
        //         $tglAwal  = 'Awal';
        //         $tglAkhir = 'Akhir';
        //     }
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Periode ' . $tglAwal . ' s/d ' . $tglAkhir . '</td></tr>';
        // } else {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TGLAKHIR . '</td></tr>';
        // }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Unit</th>
        <th rowspan="2">Jumlah Pembangkit</th>
        <th rowspan="2">Pembangkit Aktif</th>
        <th rowspan="2">Pembangkit Non Aktif</th>
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
              $UNIT                              = !empty($row->UNIT) ? $row->UNIT : '-';
              $TOTAL_PEMBANGKIT                  = !empty($row->TOTAL_PEMBANGKIT) ? $row->TOTAL_PEMBANGKIT : '0';
              $PEMBANGKIT_AKTIF                  = !empty($row->PEMBANGKIT_AKTIF) ? $row->PEMBANGKIT_AKTIF : '0';
              $PEMBANGKIT_NON_AKTIF              = !empty($row->PEMBANGKIT_NON_AKTIF) ? $row->PEMBANGKIT_NON_AKTIF : '0';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:left;"><?php echo $UNIT ?></td>
        <td style="text-align:center;"><?php echo $TOTAL_PEMBANGKIT ?></td>
        <td style="text-align:center;"><?php echo $PEMBANGKIT_AKTIF ?></td>
        <td style="text-align:center;"><?php echo $PEMBANGKIT_NON_AKTIF ?></td>
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
