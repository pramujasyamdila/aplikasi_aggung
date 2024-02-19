<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Datapenyedia_model extends CI_Model
{
    var $table = 'tbl_paket';
    var $colum_order = array('id_paket', 'nama_paket');
    var $order = array('id_paket', 'nama_paket');

    private function _get_data_query()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = tbl_paket.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_paket.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = tbl_paket.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = tbl_paket.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = tbl_paket.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = tbl_paket.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = tbl_paket.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = tbl_paket.id_produk_dl_negri', 'left');
        $this->db->where('tbl_paket.status_tahap_tender', 2);
        if (isset($_POST['nama_paket'], $_POST['id_jenis_pengadaan']) && $_POST['nama_paket'] != '' && $_POST['id_jenis_pengadaan'] != '') {
            $this->db->like('tbl_paket.nama_paket', $_POST['nama_paket']);
            $this->db->like('tbl_paket.id_jenis_pengadaan', $_POST['id_jenis_pengadaan']);
        }
        if (isset($_POST['search']['value'])) {
            $this->db->like('nama_paket', $_POST['search']['value']);
            // $this->db->or_like('data_kerja', $_POST['search']['value']);
            // $this->db->or_like('jabatan', $_POST['search']['value']);
            // $this->db->or_like('status', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_paket', 'DESC');
        }
    }

    public function getdatatable() //nam[ilin data pake ini
    {
        $this->_get_data_query(); //ambil data dari get yg di atas
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_data()
    {
        $this->_get_data_query(); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    // BATASSS====================


    // gey byid sumber dana
    public function getSumberDana($id_paket)
    {
        $this->db->select('*');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get('tbl_sumber_dana');
        return $query->result();
    }
    // end get byid sumber dana

    //get jadwal pemilihan 
    public function getJadwalPemilihan($id_paket)
    {
        $this->db->select('*');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get('tbl_jadwal_pemilihan');
        return $query->result_array();
    }
    // end get byid jadwal pemilihan

    // gey byid lokasi Pekerjaan
    public function getLokasiPekerjaan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_lokasi_pekerjaan');
        $this->db->join('tbl_provinsi', 'tbl_provinsi.id_provinsi = tbl_lokasi_pekerjaan.id_provinsi', 'left');
        $this->db->join('tbl_kabupaten', 'tbl_kabupaten.id_kabupaten = tbl_lokasi_pekerjaan.id_kabupaten', 'left');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result();
    }
    public function getByid($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = tbl_paket.id_tahun_anggaran', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = tbl_paket.id_jenis_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_paket.id_unit_kerja', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = tbl_paket.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = tbl_paket.id_metode_pemilihan', 'left');
        $this->db->join('tbl_metode_evaluasi', 'tbl_metode_evaluasi.id_metode_evaluasi = tbl_paket.id_metode_evaluasi', 'left');
        $this->db->join('tbl_jadwal_kualifikasi', 'tbl_jadwal_kualifikasi.id_kualifikasi = tbl_paket.id_kualifikasi', 'left');
        $this->db->join('tbl_metode_dokumen', 'tbl_metode_dokumen.id_metode_dokumen = tbl_paket.id_metode_dokumen', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = tbl_paket.id_produk_dl_negri', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = tbl_paket.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = tbl_paket.id_panitia', 'left');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function create($data)
    {
        $this->db->insert('tbl_vendor_identitas_prusahaan', $data);
        return $this->db->affected_rows();
    }

    public function update_identitas($data, $where)
    {
        $this->db->update('tbl_vendor_identitas_prusahaan', $data, $where);
        return $this->db->affected_rows();
    }


    //  Dataaa Untuk Ijin Usaha
    var $column_izin_usaha = array('id_izin_usaha', 'nama_izin_usaha', 'no_izin_usaha', 'masa_berlaku_izin_usaha', 'intansi_pemberi', 'kualifikasi_izin_usaha', 'dokumen_izin_usaha', 'status_sesuai', 'alasan');
    private function _get_izin_usaha($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_izin_usaha');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_izin_usaha as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_izin_usaha) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_izin_usaha[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_izin_usaha', 'DESC');
        }
    }
    public function getdatatable_izin_usaha($id_izin_usaha) //nam[ilin data pake ini
    {
        $this->_get_izin_usaha($id_izin_usaha); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_izin_usaha($id_izin_usaha)
    {
        $this->_get_izin_usaha($id_izin_usaha); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_izin_usaha()
    {
        $this->db->from('tbl_vendor_izin_usaha');
        $this->db->where('id_vendor');
        return $this->db->count_all_results();
    }


    // get   by id
    public function get_izin_usaha_Byid($id_izin_usaha)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_izin_usaha');
        $this->db->where('id_izin_usaha', $id_izin_usaha);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_izin_usaha($data)
    {
        $this->db->insert('tbl_vendor_izin_usaha', $data);
        return $this->db->affected_rows();
    }
    public function update_id_izin_usaha($where, $data)
    {
        $this->db->update('tbl_vendor_izin_usaha', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_id_izin_usaha($id_izin_usaha)
    {
        $this->db->delete('tbl_vendor_izin_usaha', ['id_izin_usaha' => $id_izin_usaha]);
    }

    // 
    //  Dataaa Untuk AKTA
    var $column_akta = array('id_akta_pendirian', 'no_akta_pendirian', 'tanggal_surat_akta_pendirian', 'notaris_akta_pendirian', 'file_dokumen_akta_pendirian', 'status_sesuai', 'alasan');
    private function _get_akta($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_akta_pendirian');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_akta as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_akta) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_akta[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_akta_pendirian', 'DESC');
        }
    }
    public function getdatatable_akta($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_akta($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_akta($id_vendor)
    {
        $this->_get_akta($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_akta()
    {
        $this->db->from('tbl_vendor_akta_pendirian');
        $this->db->where('id_vendor');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_akta($id_akta_pendirian)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_akta_pendirian');
        $this->db->where('id_akta_pendirian', $id_akta_pendirian);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_akta($data)
    {
        $this->db->insert('tbl_vendor_akta_pendirian', $data);
        return $this->db->affected_rows();
    }
    public function update_akta($where, $data)
    {
        $this->db->update('tbl_vendor_akta_pendirian', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_akta($id_akta_pendirian)
    {
        $this->db->delete('tbl_vendor_akta_pendirian', ['id_akta_pendirian' => $id_akta_pendirian]);
    }


    // DATA UNTUK PEMILIK
    var $column_pemilik = array('id_pemilik', 'nama_pemilik', 'no_ktp_pemilik', 'alamat_pemilik', 'saham_pemilik', 'file_bukti_pemilik', 'status_sesuai', 'alasan');
    private function _get_pemilik($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_pemilik');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_pemilik as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_pemilik) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_pemilik[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_pemilik', 'DESC');
        }
    }

    public function getdatatable_pemilik($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_pemilik($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_pemilik($id_vendor)
    {
        $this->_get_pemilik($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_pemilik()
    {
        $this->db->from('tbl_vendor_pemilik');
        $this->db->where('id_vendor');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_pemilik($id_pemilik)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pemilik');
        $this->db->where('id_pemilik', $id_pemilik);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_pemilik($data)
    {
        $this->db->insert('tbl_vendor_pemilik', $data);
        return $this->db->affected_rows();
    }
    public function update_pemilik($where, $data)
    {
        $this->db->update('tbl_vendor_pemilik', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_pemilik($id_pemilik)
    {
        $this->db->delete('tbl_vendor_pemilik', ['id_pemilik' => $id_pemilik]);
    }


    // DATA UNTUK Pengurus
    var $column_pengurus = array('id_pengurus', 'nama_pengurus', 'no_ktp_pengurus', 'alamat_pengurus', 'jabatan_pengurus', 'mulai_pengurus', 'selesai_pengurus', 'file_bukti_pengurus', 'status_sesuai', 'alasan');
    private function _get_pengurus($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_pengurus');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_pengurus as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_pengurus) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_pengurus[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_pengurus', 'DESC');
        }
    }
    public function getdatatable_pengurus($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_pengurus($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_pengurus($id_vendor)
    {
        $this->_get_pengurus($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_pengurus()
    {
        $this->db->from('tbl_vendor_pengurus');
        $this->db->where('id_vendor');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_pengurus($id_pengurus)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pengurus');
        $this->db->where('id_pengurus', $id_pengurus);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_pengurus($data)
    {
        $this->db->insert('tbl_vendor_pengurus', $data);
        return $this->db->affected_rows();
    }
    public function update_pengurus($where, $data)
    {
        $this->db->update('tbl_vendor_pengurus', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_pengurus($id_pengurus)
    {
        $this->db->delete('tbl_vendor_pengurus', ['id_pengurus' => $id_pengurus]);
    }


    // DATA UNTUK tenaga_ahli
    private function _get_tenaga_ahli($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_tenaga_ahli');
        $this->db->where('id_vendor', $id_vendor);
        if (isset($_POST['search']['value'])) {
            $this->db->like('nama_tenaga_ahli', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_tenaga_ahli', 'DESC');
        }
    }
    public function getdatatable_tenaga_ahli($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_tenaga_ahli($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_tenaga_ahli($id_vendor)
    {
        $this->_get_tenaga_ahli($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_tenaga_ahli()
    {
        $this->db->from('tbl_vendor_tenaga_ahli');
        $this->db->where('id_vendor');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_tenaga_ahli($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_tenaga_ahli');
        $this->db->where('tbl_vendor_tenaga_ahli.id_tenaga_ahli', $id_tenaga_ahli);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_tenaga_ahli($data)
    {
        $this->db->insert('tbl_vendor_tenaga_ahli', $data);
        return $this->db->affected_rows();
    }
    public function update_tenaga_ahli($where, $data)
    {
        $this->db->update('tbl_vendor_tenaga_ahli', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_tenaga_ahli($id_tenaga_ahli)
    {
        $this->db->delete('tbl_vendor_tenaga_ahli', ['id_tenaga_ahli' => $id_tenaga_ahli]);
        $this->db->delete('tbl_vendor_cv', ['id_tenaga_ahli' => $id_tenaga_ahli]);
        $this->db->delete('tbl_vendor_pendidikan', ['id_tenaga_ahli' => $id_tenaga_ahli]);
        $this->db->delete('tbl_vendor_sertifikat', ['id_tenaga_ahli' => $id_tenaga_ahli]);
        $this->db->delete('tbl_vendor_bahasa', ['id_tenaga_ahli' => $id_tenaga_ahli]);
    }


    // INI UNTUK GET CV/PENGALAMAN
    public function get_byid_vendor_cv($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_cv');
        $this->db->where('tbl_vendor_cv.id_tenaga_ahli', $id_tenaga_ahli);
        $query = $this->db->get();
        return $query->result_array();
    }
    // INI UNTUK GET PENDIDIKAN
    public function get_byid_vendor_pendidikan($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pendidikan');
        $this->db->where('tbl_vendor_pendidikan.id_tenaga_ahli', $id_tenaga_ahli);
        $query = $this->db->get();
        return $query->result_array();
    }
    // INI UNTUK GET SERTIFIKAT
    public function get_byid_vendor_sertifikat($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_sertifikat');
        $this->db->where('tbl_vendor_sertifikat.id_tenaga_ahli', $id_tenaga_ahli);
        $query = $this->db->get();
        return $query->result_array();
    }
    // INI UNTUK GET BAHASA
    public function get_byid_vendor_bahasa($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bahasa');
        $this->db->where('tbl_vendor_bahasa.id_tenaga_ahli', $id_tenaga_ahli);
        $query = $this->db->get();
        return $query->result_array();
    }


    // UNTUK CV CRUD MODEL
    private function _get_cv($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_cv');
        $this->db->where('id_tenaga_ahli', $id_tenaga_ahli);
        if (isset($_POST['search']['value'])) {
            $this->db->like('tahun_cv', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_cv', 'DESC');
        }
    }
    public function getdatatable_cv($id_tenaga_ahli) //nam[ilin data pake ini
    {
        $this->_get_cv($id_tenaga_ahli); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_cv($id_tenaga_ahli)
    {
        $this->_get_cv($id_tenaga_ahli); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_cv()
    {
        $this->db->from('tbl_vendor_cv');
        $this->db->where('id_cv');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_cv($id_cv)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_cv');
        $this->db->where('id_cv', $id_cv);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_cv($data)
    {
        $this->db->insert('tbl_vendor_cv', $data);
        return $this->db->affected_rows();
    }
    public function update_cv($where, $data)
    {
        $this->db->update('tbl_vendor_cv', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_cv($id_cv)
    {
        $this->db->delete('tbl_vendor_cv', ['id_cv' => $id_cv]);
    }

    // UNTUK Sertifikat CRUD MODEL
    private function _get_sertifikat($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_sertifikat');
        $this->db->where('id_tenaga_ahli', $id_tenaga_ahli);
        if (isset($_POST['search']['value'])) {
            $this->db->like('tahun_sertifikat', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_sertifikat', 'DESC');
        }
    }
    public function getdatatable_sertifikat($id_tenaga_ahli) //nam[ilin data pake ini
    {
        $this->_get_sertifikat($id_tenaga_ahli); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_sertifikat($id_tenaga_ahli)
    {
        $this->_get_sertifikat($id_tenaga_ahli); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_sertifikat()
    {
        $this->db->from('tbl_vendor_sertifikat');
        $this->db->where('id_sertifikat');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_sertifikat($id_sertifikat)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_sertifikat');
        $this->db->where('id_sertifikat', $id_sertifikat);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_sertifikat($data)
    {
        $this->db->insert('tbl_vendor_sertifikat', $data);
        return $this->db->affected_rows();
    }
    public function update_sertifikat($where, $data)
    {
        $this->db->update('tbl_vendor_sertifikat', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_sertifikat($id_sertifikat)
    {
        $this->db->delete('tbl_vendor_sertifikat', ['id_sertifikat' => $id_sertifikat]);
    }

    // UNTUK pendidikan CRUD MODEL
    private function _get_pendidikan($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pendidikan');
        $this->db->where('id_tenaga_ahli', $id_tenaga_ahli);
        if (isset($_POST['search']['value'])) {
            $this->db->like('tahun_pendidikan', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_pendidikan', 'DESC');
        }
    }
    public function getdatatable_pendidikan($id_tenaga_ahli) //nam[ilin data pake ini
    {
        $this->_get_pendidikan($id_tenaga_ahli); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_pendidikan($id_tenaga_ahli)
    {
        $this->_get_pendidikan($id_tenaga_ahli); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_pendidikan()
    {
        $this->db->from('tbl_vendor_pendidikan');
        $this->db->where('id_pendidikan');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_pendidikan($id_pendidikan)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pendidikan');
        $this->db->where('id_pendidikan', $id_pendidikan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_pendidikan($data)
    {
        $this->db->insert('tbl_vendor_pendidikan', $data);
        return $this->db->affected_rows();
    }
    public function update_pendidikan($where, $data)
    {
        $this->db->update('tbl_vendor_pendidikan', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_pendidikan($id_pendidikan)
    {
        $this->db->delete('tbl_vendor_pendidikan', ['id_pendidikan' => $id_pendidikan]);
    }

    // UNTUK bahasa CRUD MODEL
    private function _get_bahasa($id_tenaga_ahli)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bahasa');
        $this->db->where('id_tenaga_ahli', $id_tenaga_ahli);
        if (isset($_POST['search']['value'])) {
            $this->db->like('uraian_bahasa', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_bahasa', 'DESC');
        }
    }
    public function getdatatable_bahasa($id_tenaga_ahli) //nam[ilin data pake ini
    {
        $this->_get_bahasa($id_tenaga_ahli); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_bahasa($id_tenaga_ahli)
    {
        $this->_get_bahasa($id_tenaga_ahli); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_bahasa()
    {
        $this->db->from('tbl_vendor_bahasa');
        $this->db->where('id_bahasa');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_bahasa($id_bahasa)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bahasa');
        $this->db->where('id_bahasa', $id_bahasa);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_bahasa($data)
    {
        $this->db->insert('tbl_vendor_bahasa', $data);
        return $this->db->affected_rows();
    }
    public function update_bahasa($where, $data)
    {
        $this->db->update('tbl_vendor_bahasa', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_bahasa($id_bahasa)
    {
        $this->db->delete('tbl_vendor_bahasa', ['id_bahasa' => $id_bahasa]);
    }

    // UNTUK PERALATAN
    private function _get_peralatan($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_peralatan');
        $this->db->where('id_vendor', $id_vendor);
        if (isset($_POST['search']['value'])) {
            $this->db->like('nama_peralatan', $_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_peralatan', 'DESC');
        }
    }
    public function getdatatable_peralatan($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_peralatan($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_peralatan($id_vendor)
    {
        $this->_get_peralatan($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_peralatan()
    {
        $this->db->from('tbl_vendor_peralatan');
        $this->db->where('id_peralatan');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_peralatan($id_peralatan)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_peralatan');
        $this->db->where('id_peralatan', $id_peralatan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_peralatan($data)
    {
        $this->db->insert('tbl_vendor_peralatan', $data);
        return $this->db->affected_rows();
    }
    public function update_peralatan($where, $data)
    {
        $this->db->update('tbl_vendor_peralatan', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_peralatan($id_peralatan)
    {
        $this->db->delete('tbl_vendor_peralatan', ['id_peralatan' => $id_peralatan]);
    }

    // UNTUK PENGALAMAN
    var $column_pengalaman = array('id_pengalaman', 'nama_pekerjaan_pengalaman', 'instansi_pengalaman', 'nomor_dan_tanggal_kontrak', 'nilai_kontrak', 'nilai_sharing', 'tanggal_kontrak', 'selesai_kontrak', 'referensi_kontrak', 'bukti_pengalaman', 'status_sesuai', 'alasan', 'id_pengalaman');
    private function _get_pengalaman($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_pengalaman');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_pengalaman as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_pengalaman) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_pengalaman[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_pengalaman', 'DESC');
        }
    }
    public function getdatatable_pengalaman($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_pengalaman($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_pengalaman($id_vendor)
    {
        $this->_get_pengalaman($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function count_all_data_pengalaman()
    {
        $this->db->from('tbl_vendor_pengalaman');
        $this->db->where('id_pengalaman');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_pengalaman($id_pengalaman)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pengalaman');
        $this->db->where('id_pengalaman', $id_pengalaman);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_pengalaman($data)
    {
        $this->db->insert('tbl_vendor_pengalaman', $data);
        return $this->db->affected_rows();
    }
    public function update_pengalaman($where, $data)
    {
        $this->db->update('tbl_vendor_pengalaman', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_pengalaman($id_pengalaman)
    {
        $this->db->delete('tbl_vendor_pengalaman', ['id_pengalaman' => $id_pengalaman]);
    }

    // UNTUK PAJAK
    var $column_pajak = array('id_pajak', 'nama_pajak_vendor', 'tanggal_pajak_vendor', 'file_bukti_pajak_vendor', 'status_sesuai', 'alasan');
    private function _get_pajak($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_pajak');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_pajak as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_pajak) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_pajak[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_pajak', 'DESC');
        }
    }
    public function getdatatable_pajak($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_pajak($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_pajak($id_vendor)
    {
        $this->_get_pajak($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_pajak()
    {
        $this->db->from('tbl_vendor_pajak');
        $this->db->where('id_pajak');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_pajak($id_pajak)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pajak');
        $this->db->where('id_pajak', $id_pajak);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_pajak($data)
    {
        $this->db->insert('tbl_vendor_pajak', $data);
        return $this->db->affected_rows();
    }
    public function update_pajak($where, $data)
    {
        $this->db->update('tbl_vendor_pajak', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_pajak($id_pajak)
    {
        $this->db->delete('tbl_vendor_pajak', ['id_pajak' => $id_pajak]);
    }

    // UNTUK KEUANGANM
    var $column_keuangan = array('id_keuangan', 'tahun_audit', 'status_audit', 'bukti', 'status_sesuai', 'alasan');
    private function _get_keuangan($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_keuangan');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_keuangan as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_keuangan) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_keuangan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_keuangan', 'DESC');
        }
    }
    public function getdatatable_keuangan($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_keuangan($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_keuangan($id_vendor)
    {
        $this->_get_keuangan($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_keuangan()
    {
        $this->db->from('tbl_vendor_keuangan');
        $this->db->where('id_keuangan');
        return $this->db->count_all_results();
    }

    // get   by id
    public function get_byid_keuangan($id_keuangan)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_keuangan');
        $this->db->where('id_keuangan', $id_keuangan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create_keuangan($data)
    {
        $this->db->insert('tbl_vendor_keuangan', $data);
        return $this->db->affected_rows();
    }
    public function update_keuangan($where, $data)
    {
        $this->db->update('tbl_vendor_keuangan', $data, $where);
        return $this->db->affected_rows();
    }
    // HAPUS  
    public function deletedata_keuangan($id_keuangan)
    {
        $this->db->delete('tbl_vendor_keuangan', ['id_keuangan' => $id_keuangan]);
    }

    public function get_all_persyaratan($session_id_jenis_pengadaan)
    {

        $query = $this->db->query("SELECT * FROM tbl_persyaratan_vms WHERE id_persyaratan_vms != 10");
        return $query->result_array();
    }
    public function get_all_persyaratan_pemborongan()
    {
        $query = $this->db->query("SELECT * FROM tbl_persyaratan_vms");
        return $query->result_array();
    }


    // BUAT NIB
    var $column_nib = array('id_nib', 'nomor_nib', 'masa_berlaku_awal', 'file_bukti_nib_vendor', 'status_sesuai', 'alasan');
    private function _get_nib($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_nib');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_nib as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_nib) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_nib[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_nib', 'DESC');
        }
    }
    public function getdatatable_nib($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_nib($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_nib($id_vendor)
    {
        $this->_get_nib($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_nib()
    {
        $this->db->from('tbl_vendor_nib');
        $this->db->where('id_nib');
        return $this->db->count_all_results();
    }

    public function create_nib($data)
    {
        $this->db->insert('tbl_vendor_nib', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_nib($id_pajak)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_nib');
        $this->db->where('id_nib', $id_pajak);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_nib($id_nib)
    {
        $this->db->delete('tbl_vendor_nib', ['id_nib' => $id_nib]);
    }
    // END NIB


    //TDP
    var $column_tdp = array('id_tdp', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_tdp_vendor', 'status_sesuai', 'alasan');
    private function _get_tdp($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_tdp');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_tdp as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_nib) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_tdp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_tdp', 'DESC');
        }
    }
    public function getdatatable_tdp($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_tdp($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_tdp($id_vendor)
    {
        $this->_get_tdp($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_tdp($id_vendor)
    {
        $this->db->from('tbl_vendor_tdp');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_tdp($data)
    {
        $this->db->insert('tbl_vendor_tdp', $data);
        return $this->db->affected_rows();
    }

    public function deletedata_tdp($id_tdp)
    {
        $this->db->delete('tbl_vendor_tdp', ['id_tdp' => $id_tdp]);
    }

    public function get_byid_tdp($id_tdp)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_tdp');
        $this->db->where('id_tdp', $id_tdp);
        $query = $this->db->get();
        return $query->row_array();
    }
    //END TDP

    // siup
    var $column_siup = array('id_siup', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_siup_vendor', 'status_sesuai', 'alasan');
    private function _get_siup($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_siup');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_siup as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_siup) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_siup[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_siup', 'DESC');
        }
    }
    public function getdatatable_siup($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_siup($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_siup($id_vendor)
    {
        $this->_get_siup($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_siup($id_vendor)
    {
        $this->db->from('tbl_vendor_siup');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_siup($data)
    {
        $this->db->insert('tbl_vendor_siup', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_siup($id_siup)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_siup');
        $this->db->where('id_siup', $id_siup);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_siup($id_siup)
    {
        $this->db->delete('tbl_vendor_siup', ['id_siup' => $id_siup]);
    }
    // end siup

    // npwp
    var $column_npwp = array('id_npwp', 'npwp', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_npwp_vendor', 'status_sesuai', 'alasan');
    private function _get_npwp($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_npwp');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_npwp as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_npwp) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_npwp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_npwp', 'DESC');
        }
    }
    public function getdatatable_npwp($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_npwp($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_npwp($id_vendor)
    {
        $this->_get_npwp($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_npwp($id_vendor)
    {
        $this->db->from('tbl_vendor_npwp');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_npwp($data)
    {
        $this->db->insert('tbl_vendor_npwp', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_npwp($id_npwp)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_npwp');
        $this->db->where('id_npwp', $id_npwp);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_npwp($id_npwp)
    {
        $this->db->delete('tbl_vendor_npwp', ['id_npwp' => $id_npwp]);
    }
    // end npwp


    //SKPKP
    var $column_skpkp = array('id_skpkp', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_skpkp_vendor', 'status_sesuai', 'alasan');
    private function _get_skpkp($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_skpkp');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_skpkp as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_skpkp) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_skpkp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_skpkp', 'DESC');
        }
    }
    public function getdatatable_skpkp($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_skpkp($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_skpkp($id_vendor)
    {
        $this->_get_skpkp($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_skpkp($id_vendor)
    {
        $this->db->from('tbl_vendor_skpkp');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_skpkp($data)
    {
        $this->db->insert('tbl_vendor_skpkp', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_skpkp($id_skpkp)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_skpkp');
        $this->db->where('id_skpkp', $id_skpkp);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_skpkp($id_skpkp)
    {
        $this->db->delete('tbl_vendor_skpkp', ['id_skpkp' => $id_skpkp]);
    }
    //END SKPKP

    //SPPT
    var $column_sppt = array('id_sppt', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_sppt_vendor', 'status_sesuai', 'alasan');
    private function _get_sppt($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_sppt');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_sppt as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_sppt) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_sppt[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_sppt', 'DESC');
        }
    }
    public function getdatatable_sppt($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_sppt($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_sppt($id_vendor)
    {
        $this->_get_sppt($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_sppt($id_vendor)
    {
        $this->db->from('tbl_vendor_sppt');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_sppt($data)
    {
        $this->db->insert('tbl_vendor_sppt', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_sppt($id_sppt)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_sppt');
        $this->db->where('id_sppt', $id_sppt);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_sppt($id_sppt)
    {
        $this->db->delete('tbl_vendor_sppt', ['id_sppt' => $id_sppt]);
    }
    //END SPPT

    //SIUJK
    var $column_siujk = array('id_siujk', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_siujk_vendor', 'status_sesuai', 'alasan');
    private function _get_siujk($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_siujk');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_siujk as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_siujk) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_siujk[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_siujk', 'DESC');
        }
    }
    public function getdatatable_siujk($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_siujk($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_siujk($id_vendor)
    {
        $this->_get_siujk($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_siujk($id_vendor)
    {
        $this->db->from('tbl_vendor_siujk');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_siujk($data)
    {
        $this->db->insert('tbl_vendor_siujk', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_siujk($id_siujk)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_siujk');
        $this->db->where('id_siujk', $id_siujk);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_siujk($id_siujk)
    {
        $this->db->delete('tbl_vendor_siujk', ['id_siujk' => $id_siujk]);
    }
    //END SPPT

    // KTP
    var $column_KTP = array('id_ktp', 'no_ktp', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_ktp_vendor', 'status_sesuai', 'alasan');
    private function _get_ktp($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_ktp');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_KTP as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_KTP) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_KTP[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_ktp', 'DESC');
        }
    }
    public function getdatatable_ktp($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_ktp($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_ktp($id_vendor)
    {
        $this->_get_ktp($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_ktp($id_vendor)
    {
        $this->db->from('tbl_vendor_ktp');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_ktp($data)
    {
        $this->db->insert('tbl_vendor_ktp', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_ktp($id_ktp)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_ktp');
        $this->db->where('id_ktp', $id_ktp);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_ktp($id_ktp)
    {
        $this->db->delete('tbl_vendor_ktp', ['id_ktp' => $id_ktp]);
    }
    // END KTP

    // SBU
    var $column_sbu = array('tbl_vendor_sbu.id_sbu', 'kode_sbu', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_sbu_vendor', 'status_sesuai', 'alasan');
    private function _get_sbu($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_sbu');
        $this->db->join('tbl_sbu', 'tbl_vendor_sbu.id_sbu_master = tbl_sbu.id_sbu', 'left');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_sbu as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_sbu) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_sbu[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('tbl_vendor_sbu.id_sbu_vendor', 'DESC');
        }
    }
    public function getdatatable_sbu($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_sbu($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_sbu($id_vendor)
    {
        $this->_get_sbu($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_sbu($id_vendor)
    {
        $this->db->from('tbl_vendor_sbu');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_sbu($data)
    {
        $this->db->insert('tbl_vendor_sbu', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_sbu($id_sbu)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_sbu');
        $this->db->where('id_sbu_vendor', $id_sbu);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_sbu($id_sbu)
    {
        $this->db->delete('tbl_vendor_sbu', ['id_sbu_vendor' => $id_sbu]);
    }
    //END SBU

    //DOMISILI
    var $column_domisili = array('id_domisili', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_domisili_vendor', 'status_sesuai', 'alasan');
    private function _get_domisili($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_domisili');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_domisili as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_domisili) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_domisili[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_domisili', 'DESC');
        }
    }
    public function getdatatable_domisili($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_domisili($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_domisili($id_vendor)
    {
        $this->_get_domisili($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_domisili($id_vendor)
    {
        $this->db->from('tbl_vendor_domisili');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_domisili($data)
    {
        $this->db->insert('tbl_vendor_domisili', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_domisili($id_domisili)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_domisili');
        $this->db->where('id_domisili', $id_domisili);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_domisili($id_domisili)
    {
        $this->db->delete('tbl_vendor_domisili', ['id_domisili' => $id_domisili]);
    }
    //END DOMISILI

    //bagan
    var $column_bagan = array('id_bagan', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_bagan_vendor', 'status_sesuai', 'alasan');
    private function _get_bagan($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_bagan');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_bagan as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_bagan) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_bagan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_bagan', 'DESC');
        }
    }
    public function getdatatable_bagan($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_bagan($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_bagan($id_vendor)
    {
        $this->_get_bagan($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_bagan($id_vendor)
    {
        $this->db->from('tbl_vendor_bagan');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_bagan($data)
    {
        $this->db->insert('tbl_vendor_bagan', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_bagan($id_bagan)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bagan');
        $this->db->where('id_bagan', $id_bagan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_bagan($id_bagan)
    {
        $this->db->delete('tbl_vendor_bagan', ['id_bagan' => $id_bagan]);
    }
    //END bagan

    //KETENAGA KERJAAN
    var $column_bpjs_ketenagakerjaan = array('id_bpjs_ketenagakerjaan', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_bpjs_ketenagakerjaan_vendor', 'status_sesuai', 'alasan');
    private function _get_bpjs_ketenagakerjaan($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_bpjs_ketenagakerjaan');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_bpjs_ketenagakerjaan as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_bpjs_ketenagakerjaan) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_bpjs_ketenagakerjaan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_bpjs_ketenagakerjaan', 'DESC');
        }
    }
    public function getdatatable_bpjs_ketenagakerjaan($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_bpjs_ketenagakerjaan($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_bpjs_ketenagakerjaan($id_vendor)
    {
        $this->_get_bpjs_ketenagakerjaan($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_bpjs_ketenagakerjaan($id_vendor)
    {
        $this->db->from('tbl_vendor_bpjs_ketenagakerjaan');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_bpjs_ketenagakerjaan($data)
    {
        $this->db->insert('tbl_vendor_bpjs_ketenagakerjaan', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_bpjs_ketenagakerjaan($id_bpjs_ketenagakerjaan)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bpjs_ketenagakerjaan');
        $this->db->where('id_bpjs_ketenagakerjaan', $id_bpjs_ketenagakerjaan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_bpjs_ketenagakerjaan($id_bpjs_ketenagakerjaan)
    {
        $this->db->delete('tbl_vendor_bpjs_ketenagakerjaan', ['id_bpjs_ketenagakerjaan' => $id_bpjs_ketenagakerjaan]);
    }
    //END KETENAGAKERJAAN

    // kesehatan
    var $column_bpjs_kesehatan = array('id_bpjs_kesehatan', 'masa_berlaku_awal', 'masa_berlaku_akhir', 'file_bukti_bpjs_kesehatan_vendor', 'status_sesuai', 'alasan');
    private function _get_bpjs_kesehatan($id_vendor)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_vendor_bpjs_kesehatan');
        $this->db->where('id_vendor', $id_vendor);
        foreach ($this->column_bpjs_kesehatan as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_bpjs_kesehatan) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_bpjs_kesehatan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_bpjs_kesehatan', 'DESC');
        }
    }
    public function getdatatable_bpjs_kesehatan($id_vendor) //nam[ilin data pake ini
    {
        $this->_get_bpjs_kesehatan($id_vendor); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_bpjs_kesehatan($id_vendor)
    {
        $this->_get_bpjs_kesehatan($id_vendor); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_bpjs_kesehatan($id_vendor)
    {
        $this->db->from('tbl_vendor_bpjs_kesehatan');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->count_all_results();
    }

    public function create_bpjs_kesehatan($data)
    {
        $this->db->insert('tbl_vendor_bpjs_kesehatan', $data);
        return $this->db->affected_rows();
    }

    public function get_byid_bpjs_kesehatan($id_bpjs_kesehatan)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bpjs_kesehatan');
        $this->db->where('id_bpjs_kesehatan', $id_bpjs_kesehatan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function deletedata_bpjs_kesehatan($id_bpjs_kesehatan)
    {
        $this->db->delete('tbl_vendor_bpjs_kesehatan', ['id_bpjs_kesehatan' => $id_bpjs_kesehatan]);
    }
    //end kesehatan

    public function get_all_identitas($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor LEFT JOIN tbl_vendor_identitas_prusahaan ON tbl_vendor.id_vendor = tbl_vendor_identitas_prusahaan.id_vendor LEFT JOIN tbl_provinsi ON tbl_provinsi.id_provinsi = tbl_vendor_identitas_prusahaan.id_provinsi LEFT JOIN tbl_kabupaten ON tbl_kabupaten.id_kabupaten = tbl_vendor_identitas_prusahaan.id_kabupaten LEFT JOIN tbl_area ON tbl_vendor_identitas_prusahaan.id_area = tbl_area.id_area LEFT JOIN tbl_jenis_pengadaan ON tbl_vendor_identitas_prusahaan.id_jenis_pengadaan = tbl_jenis_pengadaan.id_jenis_pengadaan WHERE tbl_vendor.id_vendor = $id_vendor");
        return $query->row_array();
    }

    public function get_izin_usaha($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_izin_usaha WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_akta($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_akta_pendirian WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_pemilik($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_pemilik WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_pengurus($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_pengurus WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_tenaga_ahli($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_tenaga_ahli WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_peralatan($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_peralatan WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_pengalaman($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_pengalaman WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_pajak($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_pajak WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_neraca_keuangan($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_keuangan WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_nib($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_nib WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_tdp($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_tdp WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_siup($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_siup WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_npwp($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_npwp WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_skpkp($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_skpkp WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_sppt($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_sppt WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_siujk($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_siujk WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_ktp($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_ktp WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_sbu($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_sbu WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_domisili($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_domisili WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_bagan($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_bagan WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_ketenaga_kerjaan($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_bpjs_ketenagakerjaan WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_ketenaga_kesehatan($id_vendor)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_bpjs_kesehatan WHERE id_vendor = $id_vendor");
        return $query->result_array();
    }

    public function get_validator()
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai');
        $this->db->where('tbl_pegawai.id_role', 4);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_area()
    {
        $query = $this->db->query("SELECT * FROM tbl_area");
        return $query->result_array();
    }

    // ini Untuk Cek vendor Ketikas Sudah Tervalidasi
    public function cek_sudah_tervaldiasi_dokumen($id_vendor)
    {
        $get_row_vendor = $this->db->query("SELECT * FROM tbl_vendor_identitas_prusahaan WHERE id_vendor = $id_vendor")->row_array();
        $session_vendor_pengadaan = $this->session->userdata('id_jenis_pengadaan');
        if ($get_row_vendor['bentuk_usaha'] == 'Perseorangan(Konsultan)') {
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            // $this->db->join('tbl_vendor_izin_usaha', 'tbl_vendor.id_vendor = tbl_vendor_izin_usaha.id_vendor', 'left');
            // $this->db->join('tbl_vendor_akta_pendirian', 'tbl_vendor.id_vendor = tbl_vendor_akta_pendirian.id_vendor', 'left');
            $this->db->join('tbl_vendor_pemilik', 'tbl_vendor.id_vendor = tbl_vendor_pemilik.id_vendor', 'left');
            $this->db->join('tbl_vendor_pengurus', 'tbl_vendor.id_vendor = tbl_vendor_pengurus.id_vendor', 'left');
            // $this->db->join('tbl_vendor_tenaga_ahli', 'tbl_vendor.id_vendor = tbl_vendor_tenaga_ahli.id_vendor', 'left');
            // $this->db->join('tbl_vendor_peralatan', 'tbl_vendor.id_vendor = tbl_vendor_peralatan.id_vendor', 'left');
            $this->db->join('tbl_vendor_pengalaman', 'tbl_vendor.id_vendor = tbl_vendor_pengalaman.id_vendor', 'left');
            $this->db->join('tbl_vendor_pajak', 'tbl_vendor.id_vendor = tbl_vendor_pajak.id_vendor', 'left');
            // $this->db->join('tbl_vendor_keuangan', 'tbl_vendor.id_vendor = tbl_vendor_keuangan.id_vendor', 'left');
            // $this->db->join('tbl_vendor_nib', 'tbl_vendor.id_vendor = tbl_vendor_nib.id_vendor', 'left');
            // $this->db->join('tbl_vendor_tdp', 'tbl_vendor.id_vendor = tbl_vendor_tdp.id_vendor', 'left');
            // $this->db->join('tbl_vendor_siup', 'tbl_vendor.id_vendor = tbl_vendor_siup.id_vendor', 'left');
            $this->db->join('tbl_vendor_npwp', 'tbl_vendor.id_vendor = tbl_vendor_npwp.id_vendor', 'left');
            // $this->db->join('tbl_vendor_skpkp', 'tbl_vendor.id_vendor = tbl_vendor_skpkp.id_vendor', 'left');
            // $this->db->join('tbl_vendor_sppt', 'tbl_vendor.id_vendor = tbl_vendor_sppt.id_vendor', 'left');
            // $this->db->join('tbl_vendor_siujk', 'tbl_vendor.id_vendor = tbl_vendor_siujk.id_vendor', 'left');
            $this->db->join('tbl_vendor_ktp', 'tbl_vendor.id_vendor = tbl_vendor_ktp.id_vendor', 'left');
            // $this->db->join('tbl_vendor_sbu', 'tbl_vendor.id_vendor = tbl_vendor_sbu.id_vendor', 'left');
            // $this->db->join('tbl_vendor_domisili', 'tbl_vendor.id_vendor = tbl_vendor_domisili.id_vendor', 'left');
            // $this->db->join('tbl_vendor_bagan', 'tbl_vendor.id_vendor = tbl_vendor_bagan.id_vendor', 'left');
            $this->db->join('tbl_vendor_bpjs_kesehatan', 'tbl_vendor.id_vendor = tbl_vendor_bpjs_kesehatan.id_vendor', 'left');
            $this->db->join('tbl_vendor_bpjs_ketenagakerjaan', 'tbl_vendor.id_vendor = tbl_vendor_bpjs_ketenagakerjaan.id_vendor', 'left');
            // $this->db->where('tbl_vendor_izin_usaha.status_sesuai', 1);
            // $this->db->where('tbl_vendor_akta_pendirian.status_sesuai', 1);
            $this->db->where('tbl_vendor_pemilik.status_sesuai', 1);
            $this->db->where('tbl_vendor_pengurus.status_sesuai', 1);
            // $this->db->where('tbl_vendor_tenaga_ahli.status_sesuai', 1);
            // $this->db->where('tbl_vendor_peralatan.status_sesuai', 1);
            $this->db->where('tbl_vendor_pengalaman.status_sesuai', 1);
            $this->db->where('tbl_vendor_pajak.status_sesuai', 1);
            // $this->db->where('tbl_vendor_keuangan.status_sesuai', 1);
            // $this->db->where('tbl_vendor_nib.status_sesuai', 1);
            // $this->db->where('tbl_vendor_tdp.status_sesuai', 1);
            //$this->db->where('tbl_vendor_siup.status_sesuai', 1);
            $this->db->where('tbl_vendor_npwp.status_sesuai', 1);
            // $this->db->where('tbl_vendor_skpkp.status_sesuai', 1);
            // $this->db->where('tbl_vendor_sppt.status_sesuai', 1);
            //$this->db->where('tbl_vendor_siujk.status_sesuai', 1);
            $this->db->where('tbl_vendor_ktp.status_sesuai', 1);
            // if ($session_vendor_pengadaan == 2 || $session_vendor_pengadaan == 3) {
            //     $this->db->where('tbl_vendor_sbu.status_sesuai', 1);
            // } else {
            // }
            // $this->db->where('tbl_vendor_domisili.status_sesuai', 1);
            // $this->db->where('tbl_vendor_bagan.status_sesuai', 1);
            //$this->db->where('tbl_vendor_bpjs_kesehatan.status_sesuai', 1);
            //$this->db->where('tbl_vendor_bpjs_ketenagakerjaan.status_sesuai', 1);
            $this->db->where('tbl_vendor.id_vendor', $id_vendor);
        } else {
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $this->db->join('tbl_vendor_izin_usaha', 'tbl_vendor.id_vendor = tbl_vendor_izin_usaha.id_vendor', 'left');
            $this->db->join('tbl_vendor_akta_pendirian', 'tbl_vendor.id_vendor = tbl_vendor_akta_pendirian.id_vendor', 'left');
            $this->db->join('tbl_vendor_pemilik', 'tbl_vendor.id_vendor = tbl_vendor_pemilik.id_vendor', 'left');
            $this->db->join('tbl_vendor_pengurus', 'tbl_vendor.id_vendor = tbl_vendor_pengurus.id_vendor', 'left');
            // $this->db->join('tbl_vendor_tenaga_ahli', 'tbl_vendor.id_vendor = tbl_vendor_tenaga_ahli.id_vendor', 'left');
            // $this->db->join('tbl_vendor_peralatan', 'tbl_vendor.id_vendor = tbl_vendor_peralatan.id_vendor', 'left');
            $this->db->join('tbl_vendor_pengalaman', 'tbl_vendor.id_vendor = tbl_vendor_pengalaman.id_vendor', 'left');
            $this->db->join('tbl_vendor_pajak', 'tbl_vendor.id_vendor = tbl_vendor_pajak.id_vendor', 'left');
            $this->db->join('tbl_vendor_keuangan', 'tbl_vendor.id_vendor = tbl_vendor_keuangan.id_vendor', 'left');
            $this->db->join('tbl_vendor_nib', 'tbl_vendor.id_vendor = tbl_vendor_nib.id_vendor', 'left');
            $this->db->join('tbl_vendor_tdp', 'tbl_vendor.id_vendor = tbl_vendor_tdp.id_vendor', 'left');
            $this->db->join('tbl_vendor_siup', 'tbl_vendor.id_vendor = tbl_vendor_siup.id_vendor', 'left');
            $this->db->join('tbl_vendor_npwp', 'tbl_vendor.id_vendor = tbl_vendor_npwp.id_vendor', 'left');
            $this->db->join('tbl_vendor_skpkp', 'tbl_vendor.id_vendor = tbl_vendor_skpkp.id_vendor', 'left');
            $this->db->join('tbl_vendor_sppt', 'tbl_vendor.id_vendor = tbl_vendor_sppt.id_vendor', 'left');
            $this->db->join('tbl_vendor_siujk', 'tbl_vendor.id_vendor = tbl_vendor_siujk.id_vendor', 'left');
            $this->db->join('tbl_vendor_ktp', 'tbl_vendor.id_vendor = tbl_vendor_ktp.id_vendor', 'left');
            $this->db->join('tbl_vendor_sbu', 'tbl_vendor.id_vendor = tbl_vendor_sbu.id_vendor', 'left');
            $this->db->join('tbl_vendor_domisili', 'tbl_vendor.id_vendor = tbl_vendor_domisili.id_vendor', 'left');
            $this->db->join('tbl_vendor_bagan', 'tbl_vendor.id_vendor = tbl_vendor_bagan.id_vendor', 'left');
            $this->db->join('tbl_vendor_bpjs_kesehatan', 'tbl_vendor.id_vendor = tbl_vendor_bpjs_kesehatan.id_vendor', 'left');
            $this->db->join('tbl_vendor_bpjs_ketenagakerjaan', 'tbl_vendor.id_vendor = tbl_vendor_bpjs_ketenagakerjaan.id_vendor', 'left');
            $this->db->where('tbl_vendor_izin_usaha.status_sesuai', 1);
            $this->db->where('tbl_vendor_akta_pendirian.status_sesuai', 1);
            $this->db->where('tbl_vendor_pemilik.status_sesuai', 1);
            $this->db->where('tbl_vendor_pengurus.status_sesuai', 1);
            // $this->db->where('tbl_vendor_tenaga_ahli.status_sesuai', 1);
            // $this->db->where('tbl_vendor_peralatan.status_sesuai', 1);
            $this->db->where('tbl_vendor_pengalaman.status_sesuai', 1);
            $this->db->where('tbl_vendor_pajak.status_sesuai', 1);
            $this->db->where('tbl_vendor_keuangan.status_sesuai', 1);
            $this->db->where('tbl_vendor_nib.status_sesuai', 1);
            $this->db->where('tbl_vendor_tdp.status_sesuai', 1);
            //$this->db->where('tbl_vendor_siup.status_sesuai', 1);
            $this->db->where('tbl_vendor_npwp.status_sesuai', 1);
            $this->db->where('tbl_vendor_skpkp.status_sesuai', 1);
            $this->db->where('tbl_vendor_sppt.status_sesuai', 1);
            //$this->db->where('tbl_vendor_siujk.status_sesuai', 1);
            $this->db->where('tbl_vendor_ktp.status_sesuai', 1);
            if ($session_vendor_pengadaan == 2 || $session_vendor_pengadaan == 3) {
                $this->db->where('tbl_vendor_sbu.status_sesuai', 1);
            } else {
            }
            $this->db->where('tbl_vendor_domisili.status_sesuai', 1);
            $this->db->where('tbl_vendor_bagan.status_sesuai', 1);
            //$this->db->where('tbl_vendor_bpjs_kesehatan.status_sesuai', 1);
            //$this->db->where('tbl_vendor_bpjs_ketenagakerjaan.status_sesuai', 1);
            $this->db->where('tbl_vendor.id_vendor', $id_vendor);
        }

        $this->db->group_by('tbl_vendor.id_vendor');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_notifikasi($data, $where)
    {
        $this->db->update('tbl_vendor', $data, $where);
        return $this->db->affected_rows();
    }

    public function get_jenis_pengadaan()
    {
        $this->db->select('*');
        $this->db->from('tbl_jenis_pengadaan');
        return $this->db->get()->result_array();
    }

    public function get_sbu_master()
    {
        $id_jenis_pengadaan = $this->session->userdata('id_jenis_pengadaan');
        if ($id_jenis_pengadaan == 2) {
            $this->db->select('*');
            $this->db->from('tbl_sbu');
            $this->db->where_not_in('id_sbu', [1, 2]);
            $query = $this->db->get();
            return $query->result_array();
        } else if ($id_jenis_pengadaan == 3) {
            $this->db->select('*');
            $this->db->from('tbl_sbu');
            $this->db->where_in('id_sbu', [1, 2, 8]);
            $query = $this->db->get();
            return $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->from('tbl_sbu');
            $this->db->where_in('id_sbu', [1, 2, 6]);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function tidak_punya_pengalaman($data)
    {
        $this->db->insert('tbl_vendor_pengalaman', $data);
        return $this->db->affected_rows();
    }

    public function tidak_punya_siup($data)
    {
        $this->db->insert('tbl_vendor_siup', $data);
        return $this->db->affected_rows();
    }

    public function tidak_punya_siujk($data)
    {
        $this->db->insert('tbl_vendor_siujk', $data);
        return $this->db->affected_rows();
    }

    public function tidak_punya_bpjsketenagakerjaan($data)
    {
        $this->db->insert('tbl_vendor_bpjs_ketenagakerjaan', $data);
        return $this->db->affected_rows();
    }

    public function tidak_punya_bpjskesehatan($data)
    {
        $this->db->insert('tbl_vendor_bpjs_kesehatan', $data);
        return $this->db->affected_rows();
    }
}
