SELECT fulldata.pegawai_nama, SUM(fulldata.nilai_tpa) as tpa , SUM(fulldata.jumlah_jp_diklat) as diklat,
  MAX(fulldata.bobot_bahasa) as bahasa, sum(fulldata.bobot_sertifikasi) as sertifikasi, sum(matirx_pegawai_skp.skp_nilai) as nilai_skp
  FROM(
    SELECT diklattpaskpbhs.pegawai_nama , MAX(diklattpaskpbhs.nilai_tpa) as nilai_tpa , MAX(diklattpaskpbhs.jumlah_jp_diklat) as jumlah_jp_diklat,
      max(diklattpaskpbhs.bobot_bahasa) as bobot_bahasa, count(matrix_pegawai_sertifikasi_fix.sertifikasi_nama) as bobot_sertifikasi
      FROM(
       SELECT diklatskp.pegawai_nama , MAX(diklatskp.nilai_tpa) as nilai_tpa , MAX(diklatskp.jumlah_jp_diklat) as jumlah_jp_diklat,
        COUNT(matrix_pegawai_bahasa.bahasa_nama) as bobot_bahasa
        FROM(
         SELECT diklat.pegawai_nama,sum(matrix_pegawai_tpa.tpa_nilai) as nilai_tpa,SUM(diklat.jumlah_jp_diklat) as jumlah_jp_diklat
          FROM (
            SELECT matrix_pegawai.pegawai_nama,sum(master_pegawai_diklat_fix.diklat_jp) as jumlah_jp_diklat
              from matrix_pegawai 
              LEFT JOIN master_pegawai_diklat_fix  on master_pegawai_diklat_fix.pegawai_nama  =  matrix_pegawai.pegawai_nama  
              AND master_pegawai_diklat_fix.pegawai_diklat_tahun = 2022
              GROUP BY  matrix_pegawai .pegawai_nama
            ) as diklat
          LEFT JOIN matrix_pegawai_tpa on diklat.pegawai_nama = matrix_pegawai_tpa.pegawai_nama AND matrix_pegawai_tpa.tpa_tahun = 2022
          GROUP BY  diklat.pegawai_nama
         ) as diklatskp
        left JOIN matrix_pegawai_bahasa on diklatskp.pegawai_nama = matrix_pegawai_bahasa.pegawai_nama
        group by diklatskp.pegawai_nama 
        ) as diklattpaskpbhs
        left JOIN matrix_pegawai_sertifikasi_fix on diklattpaskpbhs.pegawai_nama =  matrix_pegawai_sertifikasi_fix.pegawai_nama 
         group by diklattpaskpbhs.pegawai_nama)  as fulldata
  left join matirx_pegawai_skp on matirx_pegawai_skp.pegawai_nama = fulldata.pegawai_nama AND matirx_pegawai_skp.skp_tahun =2022
  GROUP by fulldata.pegawai_nama 



       

  SELECT fulldata.pegawai_nama, SUM(fulldata.jumlah_jp_diklat) as diklat, sum(fulldata.bobot_sertifikasi) as sertifikasi,
  MAX(fulldata.bobot_bahasa) as bahasa, SUM(fulldata.nilai_tpa) as tpa , sum(matirx_pegawai_skp.skp_nilai) as nilai_skp, matirx_pegawai_skp.skp_tahun,fulldata.tpa_tahun, fulldata.pegawai_diklat_tahun
  FROM(
    SELECT diklattpaskpbhs.pegawai_nama , MAX(diklattpaskpbhs.nilai_tpa) as nilai_tpa , MAX(diklattpaskpbhs.jumlah_jp_diklat) as jumlah_jp_diklat,
      max(diklattpaskpbhs.bobot_bahasa) as bobot_bahasa, count(matrix_pegawai_sertifikasi_fix.sertifikasi_nama) as bobot_sertifikasi, diklattpaskpbhs.tpa_tahun, diklattpaskpbhs.pegawai_diklat_tahun
      FROM(
       SELECT diklatskp.pegawai_nama , MAX(diklatskp.nilai_tpa) as nilai_tpa , MAX(diklatskp.jumlah_jp_diklat) as jumlah_jp_diklat,
        COUNT(matrix_pegawai_bahasa.bahasa_nama) as bobot_bahasa, diklatskp.tpa_tahun, diklatskp.pegawai_diklat_tahun
        FROM(
         SELECT diklat.pegawai_nama,sum(matrix_pegawai_tpa.tpa_nilai) as nilai_tpa,SUM(diklat.jumlah_jp_diklat) as jumlah_jp_diklat,matrix_pegawai_tpa.tpa_tahun,diklat.pegawai_diklat_tahun
          FROM (
            SELECT master_pegawai_diklat_fix.pegawai_diklat_tahun, matrix_pegawai.pegawai_nama,sum(master_pegawai_diklat_fix.diklat_jp) as jumlah_jp_diklat
              from matrix_pegawai 
              LEFT JOIN master_pegawai_diklat_fix  on master_pegawai_diklat_fix.pegawai_nama  =  matrix_pegawai.pegawai_nama  
              GROUP BY  matrix_pegawai .pegawai_nama , master_pegawai_diklat_fix.pegawai_diklat_tahun
            ) as diklat
          LEFT JOIN matrix_pegawai_tpa on diklat.pegawai_nama = matrix_pegawai_tpa.pegawai_nama 
          WHERE matrix_pegawai_tpa.tpa_tahun = diklat.pegawai_diklat_tahun
          GROUP BY  diklat.pegawai_nama,matrix_pegawai_tpa.tpa_tahun, diklat.pegawai_diklat_tahun
         ) as diklatskp
        left JOIN matrix_pegawai_bahasa on diklatskp.pegawai_nama = matrix_pegawai_bahasa.pegawai_nama
        group by diklatskp.pegawai_nama ,diklatskp.tpa_tahun, diklatskp.pegawai_diklat_tahun
        ) as diklattpaskpbhs
        left JOIN matrix_pegawai_sertifikasi_fix on diklattpaskpbhs.pegawai_nama =  matrix_pegawai_sertifikasi_fix.pegawai_nama 
         group by diklattpaskpbhs.pegawai_nama,diklattpaskpbhs.tpa_tahun, diklattpaskpbhs.pegawai_diklat_tahun)  as fulldata
  left join matirx_pegawai_skp on matirx_pegawai_skp.pegawai_nama = fulldata.pegawai_nama 
    WHERE matirx_pegawai_skp.skp_tahun = fulldata.pegawai_diklat_tahun
  GROUP by fulldata.pegawai_nama , matirx_pegawai_skp.skp_tahun, fulldata.tpa_tahun, fulldata.pegawai_diklat_tahun



       