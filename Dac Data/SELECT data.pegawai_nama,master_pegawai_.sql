SELECT data.pegawai_nama,master_pegawai_fixx.pegawai_pendidikan,master_pegawai_fixx.perwakilan , data.diklat as diklat, data.sertifikasi as sertifikasi,
  data.bahasa as bahasa, data.tpa as tpa , data.nilai_skp as nilai_skp, YEAR(data.skp_tahun) as tahun
FROM(
SELECT fulldata.pegawai_nama, SUM(fulldata.jumlah_jp_diklat) as diklat, sum(fulldata.bobot_sertifikasi) as sertifikasi,
  MAX(fulldata.bobot_bahasa) as bahasa, SUM(fulldata.nilai_tpa) as tpa , sum(master_pegawai_skp.skp_nilai) as nilai_skp, YEAR(master_pegawai_skp.skp_tahun) as skp_tahun,fulldata.tpa_tahun, fulldata.pegawai_diklat_tahun
  FROM(
    SELECT diklattpaskpbhs.pegawai_nama , MAX(diklattpaskpbhs.nilai_tpa) as nilai_tpa , MAX(diklattpaskpbhs.jumlah_jp_diklat) as jumlah_jp_diklat,
      max(diklattpaskpbhs.bobot_bahasa) as bobot_bahasa, count(master_pegawai_sertifikasi.sertifikasi_nama) as bobot_sertifikasi, diklattpaskpbhs.tpa_tahun, diklattpaskpbhs.pegawai_diklat_tahun
      FROM(
       SELECT diklatskp.pegawai_nama , MAX(diklatskp.nilai_tpa) as nilai_tpa , MAX(diklatskp.jumlah_jp_diklat) as jumlah_jp_diklat,
        COUNT(master_pegawai_bahasa.bahasa_nama) as bobot_bahasa, diklatskp.tpa_tahun, diklatskp.pegawai_diklat_tahun
        FROM(
         SELECT diklat.pegawai_nama,sum(master_pegawai_tpa.tpa_nilai) as nilai_tpa,SUM(diklat.jumlah_jp_diklat) as jumlah_jp_diklat,YEAR(master_pegawai_tpa.tpa_tahun) as tpa_tahun,diklat.pegawai_diklat_tahun
          FROM (
            SELECT YEAR(master_pegawai_diklat.pegawai_diklat_tahun) as pegawai_diklat_tahun, matrix_pegawai.pegawai_nama,sum(master_pegawai_diklat.diklat_jp) as jumlah_jp_diklat
              from matrix_pegawai 
              LEFT JOIN master_pegawai_diklat  on master_pegawai_diklat.pegawai_nama  =  matrix_pegawai.pegawai_nama  
              GROUP BY  matrix_pegawai .pegawai_nama , YEAR(master_pegawai_diklat.pegawai_diklat_tahun)
            ) as diklat
          LEFT JOIN master_pegawai_tpa on diklat.pegawai_nama = master_pegawai_tpa.pegawai_nama 
          WHERE YEAR(master_pegawai_tpa.tpa_tahun) = diklat.pegawai_diklat_tahun
          GROUP BY  diklat.pegawai_nama,YEAR(master_pegawai_tpa.tpa_tahun), diklat.pegawai_diklat_tahun
         ) as diklatskp
        left JOIN master_pegawai_bahasa on diklatskp.pegawai_nama = master_pegawai_bahasa.pegawai_nama
        group by diklatskp.pegawai_nama ,diklatskp.tpa_tahun, diklatskp.pegawai_diklat_tahun
        ) as diklattpaskpbhs
        left JOIN master_pegawai_sertifikasi on diklattpaskpbhs.pegawai_nama =  master_pegawai_sertifikasi.pegawai_nama 
         group by diklattpaskpbhs.pegawai_nama,diklattpaskpbhs.tpa_tahun, diklattpaskpbhs.pegawai_diklat_tahun)  as fulldata
  left join master_pegawai_skp on master_pegawai_skp.pegawai_nama = fulldata.pegawai_nama 
    WHERE YEAR(master_pegawai_skp.skp_tahun) = fulldata.pegawai_diklat_tahun
  GROUP by fulldata.pegawai_nama , YEAR(master_pegawai_skp.skp_tahun), fulldata.tpa_tahun, fulldata.pegawai_diklat_tahun
) as data
LEFT JOIN master_pegawai_fixx on data.pegawai_nama = master_pegawai_fixx.pegawai_nama 
