<?php
defined('BASEPATH') or exit('No direct script access allowed');

class paket_model extends CI_Model
{
    var $table = 'tbl_unit_kerja';
    var $order = array('id_unit_kerja', 'id_unit_kerja', 'nama_unit_kerja', 'id_unit_kerja');

    private function _get_data_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->order as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like(
                        $item,
                        $_POST['search']['value']
                    );
                }

                if (count($this->order) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_unit_kerja', 'DESC');
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
    public function create($data)
    {
        $this->db->insert('tbl_unit_kerja', $data);
        return $this->db->affected_rows();
    }
    public function getByid($id_unit_kerja)
    {
        return $this->db->get_where($this->table, ['id_unit_kerja' => $id_unit_kerja])->row();
    }
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    public function delete($id_unit_kerja)
    {
        $this->db->delete($this->table, ['id_unit_kerja' => $id_unit_kerja]);
        return $this->db->affected_rows();
    }
    public function result_unit_kerja()
    {
        $this->db->select('*');
        $this->db->from('tbl_unit_kerja');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function row_result_unit_kerja($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_unit_kerja');
        $this->db->where('id_unit_kerja', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_by_id_paket($limit = null, $start = null, $nama_paket = null, $id_unit_kerja, $id_jenis_pengadaan = null, $id_metode_pemilihan = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = tbl_paket.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_paket.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = tbl_paket.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = tbl_paket.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = tbl_paket.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = tbl_paket.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = tbl_paket.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = tbl_paket.id_produk_dl_negri', 'left');
        $this->db->where('status_finalisasi_draft', 1);
        $this->db->where_not_in('status_soft_delete', 1);
        $this->db->where_not_in('tbl_paket.id_metode_pemilihan', 10);
        $this->db->where_not_in('tbl_paket.id_metode_pemilihan', 9);
        if (isset($nama_paket)) {
            $this->db->like('nama_paket', $nama_paket);
        }
        if (isset($id_unit_kerja)) {
            $this->db->where('tbl_paket.id_unit_kerja', $id_unit_kerja);
        }
        if (isset($id_jenis_pengadaan)) {
            $this->db->like('tbl_paket.id_jenis_pengadaan', $id_jenis_pengadaan);
        }
        if (isset($id_metode_pemilihan)) {
            $this->db->like('tbl_paket.id_metode_pemilihan', $id_metode_pemilihan);
        }
        $this->db->limit($limit, $start);
        $this->db->group_by('tbl_paket.id_paket');
        return $this->db->get()->result_array();
    }

    function numrows_produk($nama_paket = null, $id_unit_kerja, $id_jenis_pengadaan = null, $id_metode_pemilihan = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = tbl_paket.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_paket.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = tbl_paket.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = tbl_paket.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = tbl_paket.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = tbl_paket.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = tbl_paket.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = tbl_paket.id_produk_dl_negri', 'left');
        $this->db->where('status_finalisasi_draft', 1);
        $this->db->where_not_in('status_soft_delete', 1);
        $this->db->where_not_in('tbl_paket.id_metode_pemilihan', 10);
        $this->db->where_not_in('tbl_paket.id_metode_pemilihan', 9);
        if (isset($nama_paket)) {
            $this->db->like('nama_paket', $nama_paket);
        }
        if (isset($id_unit_kerja)) {
            $this->db->where('tbl_paket.id_unit_kerja', $id_unit_kerja);
        }
        if (isset($id_jenis_pengadaan)) {
            $this->db->like('tbl_paket.id_jenis_pengadaan', $id_jenis_pengadaan);
        }
        if (isset($id_metode_pemilihan)) {
            $this->db->like('tbl_paket.id_metode_pemilihan', $id_metode_pemilihan);
        }
        $this->db->group_by('tbl_paket.id_paket');
        return $this->db->get()->num_rows();
    }

    public function row_paket($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = tbl_paket.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_paket.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = tbl_paket.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = tbl_paket.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = tbl_paket.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = tbl_paket.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = tbl_paket.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = tbl_paket.id_produk_dl_negri', 'left');
        $this->db->where('tbl_paket.id_paket', $id_paket);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function rincian_hps($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_rincian_hps_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function count_rincian_hps($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_rincian_hps_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function dokumen_prakualifikasi($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_dokumen_kualifikasi_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function count_dokumen_prakualifikasi($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_dokumen_kualifikasi_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function dokumen_lelang($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_dokumen_lelang_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_lelang($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_dokumen_lelang_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function dokumen_penunjang($id_paket)
    {
        $this->db->select('*');
        $this->db->from('table_dokumen_penunjang');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_penunjang($id_paket)
    {
        $this->db->select('*');
        $this->db->from('table_dokumen_penunjang');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function dokumen_persyaratan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_persyaratan_tender');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_persyaratan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_persyaratan_tender');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // INI UNTUK BERITA ACARA

    public function dokumen_peringkat_teknis($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_peringkat');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_peringkat_teknis($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_peringkat');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function dokumen_hasil_penawaran($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_penawaran');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_hasil_penawaran($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_penawaran');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function dokumen_hasil_tender($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_tender');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_hasil_tender($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_tender');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function dokumen_informasi_lainya($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_lainnya');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_informasi_lainya($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_berita_acara_lainnya');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }
    // INI UNTUK SURAT PENUNJUKAN
    public function dokume_surat_penunjukan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dokumen_surat_penunjukan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_panitia_Byid2($id_panitia)
    {
        $this->db->select('*');
        $this->db->from('tbl_detail_panitia');
        $this->db->join('tbl_panitia', 'id_panitia', 'left');
        $this->db->join('tbl_role_panitia', 'id_role_panitia', 'left');
        $this->db->join('tbl_pegawai', 'tbl_detail_panitia.id_pegawai2 = tbl_pegawai.id_pegawai', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_pegawai.jabatan', 'left');
        $this->db->where('id_panitia', $id_panitia);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function ambil_semua_evaluasi($id_paket)
    {
        $query = $this->db->query("SELECT * FROM tbl_vendor_mengikuti_paket
		LEFT JOIN tbl_vendor ON tbl_vendor.id_vendor = tbl_vendor_mengikuti_paket.id_mengikuti_vendor
		LEFT JOIN tbl_rincian_hps_vendor ON tbl_vendor_mengikuti_paket.id_mengikuti_paket_vendor = tbl_rincian_hps_vendor.id_vendor
		WHERE id_mengikuti_paket_vendor = $id_paket");
        return $query->result_array();
    }

    function numrows_vendor($id_paket, $username_vendor = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_mengikuti_paket');
        $this->db->join('tbl_vendor', 'tbl_vendor_mengikuti_paket.id_mengikuti_vendor = tbl_vendor.id_vendor', 'left');
        $this->db->where('tbl_vendor_mengikuti_paket.id_mengikuti_paket_vendor', $id_paket);
        if (isset($username_vendor)) {
            $this->db->like('username_vendor', $username_vendor);
        }
        $this->db->group_by('tbl_vendor_mengikuti_paket.id_mengikuti_paket_vendor');
        return $this->db->get()->num_rows();
    }

    public function ambil_pemenang_tender($id_paket)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_mengikuti_paket');
        $this->db->join('tbl_vendor', 'tbl_vendor_mengikuti_paket.id_mengikuti_vendor = tbl_vendor.id_vendor', 'left');
        $this->db->where('tbl_vendor_mengikuti_paket.id_mengikuti_paket_vendor', $id_paket);
        $this->db->where('tbl_vendor_mengikuti_paket.pemenang_tender', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_by_id_vendor($limit = null, $start = null, $id_paket, $username_vendor = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_mengikuti_paket');
        $this->db->join('tbl_vendor', 'tbl_vendor_mengikuti_paket.id_mengikuti_vendor = tbl_vendor.id_vendor', 'left');
        $this->db->where('tbl_vendor_mengikuti_paket.id_mengikuti_paket_vendor', $id_paket);
        if (isset($username_vendor)) {
            $this->db->like('username_vendor', $username_vendor);
        }
        if (isset($nama_paket)) {
            $this->db->like('nama_paket', $nama_paket);
        }

        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }
    public function get_vendor($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor');
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->get()->row_array();
    }

    public function result_tbl_vendor_persyaratan($id_paket, $id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_persyaratan_tambahan');
        $this->db->where('id_paket', $id_paket);
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->get()->result_array();
    }

    public function result_dokumen_penawaran_vendor($id_paket, $id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_dokumen_lelang_baru');
        $this->db->where('id_paket', $id_paket);
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->get()->result_array();
    }

    public function result_dokumen_penawaran_harga_vendor($id_paket, $id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_rincian_hps_pdf_vendor');
        $this->db->where('id_paket', $id_paket);
        $this->db->where('id_vendor', $id_vendor);
        return $this->db->get()->result_array();
    }

    public function result_tbl_vendor_penunjukan($id_paket, $id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_mengikuti_paket');
        $this->db->join('tbl_vendor', 'tbl_vendor.id_vendor = tbl_vendor_mengikuti_paket.id_mengikuti_vendor', 'left');
        $this->db->join('tbl_paket', 'tbl_paket.id_paket = tbl_vendor_mengikuti_paket.id_mengikuti_paket_vendor', 'left');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = tbl_paket.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_paket.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = tbl_paket.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = tbl_paket.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = tbl_paket.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = tbl_paket.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = tbl_paket.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = tbl_paket.id_produk_dl_negri', 'left');
        $this->db->where('tbl_paket.status_tahap_tender', 2);
        $this->db->where('status_mengikuti_paket', 1);
        $this->db->where('id_mengikuti_paket_vendor', $id_paket);
        $this->db->where('id_mengikuti_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function row_vendor($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }

    var $field6 = array('id_paket', 'nama_paket', 'nama_paket', 'nama_paket', 'nama_paket', 'nama_paket');
    private function _get_all_paket($cari_all_paket = null)
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = tbl_paket.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = tbl_paket.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = tbl_paket.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = tbl_paket.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = tbl_paket.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = tbl_paket.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = tbl_paket.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = tbl_paket.id_produk_dl_negri', 'left');
        $this->db->where('status_finalisasi_draft', 1);
        $this->db->where_not_in('status_soft_delete', 1);
        $this->db->where_not_in('tbl_paket.id_metode_pemilihan', 10);
        $this->db->where_not_in('tbl_paket.id_metode_pemilihan', 9);
        if (isset($cari_all_paket)) {
            $this->db->like('tbl_paket.nama_paket', $cari_all_paket);
        }
        if (isset($cari_all_paket)) {
            $this->db->or_like('tbl_jenis_pengadaan.nama_jenis_pengadaan', $cari_all_paket);
        }
        foreach ($this->field6 as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like(
                        $item,
                        $_POST['search']['value']
                    );
                }

                if (count($this->field6) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->field6[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('tbl_paket.id_paket', 'DESC');
        }
    }

    public function GetdatatableSeacrhPaket($cari_all_paket) //nam[ilin data pake ini
    {
        $this->_get_all_paket($cari_all_paket); //ambil data dari get yg di atas
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_paket($cari_all_paket)
    {
        $this->_get_all_paket($cari_all_paket); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_seacrh_paket()
    {
        $this->db->from('tbl_paket');
        return $this->db->count_all_results();
    }

    public function ambil_vendor()
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor');
        $this->db->join('tbl_vendor_identitas_prusahaan', 'tbl_vendor.id_vendor = tbl_vendor_identitas_prusahaan.id_vendor', 'left');
        $this->db->join('tbl_provinsi', 'tbl_vendor_identitas_prusahaan.id_provinsi = tbl_provinsi.id_provinsi', 'left');
        $this->db->join('tbl_kabupaten', 'tbl_vendor_identitas_prusahaan.id_kabupaten = tbl_kabupaten.id_kabupaten', 'left');
        $this->db->where('status_vendor_baru', null);
        $this->db->where('tbl_vendor.status_aktive_vendor', 1);
        $this->db->group_by('tbl_vendor.id_vendor');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function create_pegawai_prima($data)
    {
        $this->db->insert('tbl_prima_user', $data);
        return $this->db->affected_rows();
    }

    public function tbl_vendor_izin_usaha($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_izin_usaha');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_akta_pendirian($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_akta_pendirian');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function tbl_vendor_pemilik($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pemilik');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_pengurus($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pengurus');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_tenaga_ahli($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_tenaga_ahli');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_pengalaman($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pengalaman');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_pajak($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_pajak');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_keuangan($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_keuangan');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_nib($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_nib');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_tdp($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_tdp');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_siup($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_siup');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tbl_vendor_npwp($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_npwp');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_skpkp($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_skpkp');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tbl_vendor_sppt($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_sppt');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_siujk($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_siujk');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_ktp($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_ktp');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_sbu($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_sbu');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_domisili($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_domisili');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_bagan($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bagan');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_bpjs_ketenagakerjaan($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bpjs_ketenagakerjaan');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function tbl_vendor_bpjs_kesehatan($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor_bpjs_kesehatan');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->result_array();
    }

    function cari_unit($nama_unit_kerja = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_unit_kerja');
        if (isset($nama_unit_kerja)) {
            $this->db->like('tbl_unit_kerja.nama_unit_kerja', $nama_unit_kerja);
        }
        $this->db->group_by('tbl_unit_kerja.nama_unit_kerja');
        return $this->db->get()->result_array();
    }

    public function count_paket()
    {
        $this->db->select('*');
        $this->db->from('tbl_paket');
        $this->db->where('status_paket_tender', 2);
        $this->db->where('status_tahap_tender', 2);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_vendor()
    {
        $this->db->select('*');
        $this->db->from('tbl_vendor');
        $this->db->where('status_aktive_vendor', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_unit()
    {
        $this->db->select('*');
        $this->db->from('tbl_unit_kerja');
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function result_produk()
    {
        $this->db->select('*');
        $this->db->from('tbl_produk_prima');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Tambahan Di Manjemen Dokumen
    public function ambil_data_pegawai($kode_otp)
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai');
        $this->db->where('otp_qrcode', $kode_otp);
        return $this->db->get()->row_array();
    }
    public function get_kode_tender($text = null, $table = null, $field = null)
    {
        $this->db->select_max('kode_tender_random');
        $this->db->like($field, $text, 'after');
        $this->db->order_by($field, 'desc');
        $this->db->limit(1);
        return $this->db->get($table)->row_array()[$field];
    }



    // INI UNTK TAMBAHAN DOKUMEN MANUAL
    var $table_manual = array('id_paket', 'nama_paket', 'nama_paket', 'nama_paket', 'nama_paket', 'nama_paket');
    private function _get_data_query_manual($id_unit_kerja)
    {
        $this->db->select('*');
        $this->db->from('d_paket_manual');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = d_paket_manual.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = d_paket_manual.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = d_paket_manual.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = d_paket_manual.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = d_paket_manual.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = d_paket_manual.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = d_paket_manual.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = d_paket_manual.id_produk_dl_negri', 'left');
        $this->db->where('d_paket_manual.id_unit_kerja', $id_unit_kerja);
        $i = 0;
        foreach ($this->table_manual as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like(
                        $item,
                        $_POST['search']['value']
                    );
                }

                if (count($this->table_manual) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_paket_manual.id_paket', 'DESC');
        }
    }

    public function getdatatable_manual($id_unit_kerja) //nam[ilin data pake ini
    {
        $this->_get_data_query_manual($id_unit_kerja); //ambil data dari get yg di atas
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_data_manual($id_unit_kerja)
    {
        $this->_get_data_query_manual($id_unit_kerja); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_manual($id_unit_kerja)
    {
        $this->db->select('*');
        $this->db->from('d_paket_manual');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = d_paket_manual.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = d_paket_manual.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = d_paket_manual.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = d_paket_manual.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = d_paket_manual.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = d_paket_manual.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = d_paket_manual.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = d_paket_manual.id_produk_dl_negri', 'left');
        $this->db->where('d_paket_manual.id_unit_kerja', $id_unit_kerja);
        return $this->db->count_all_results();
    }
    public function row_paket_manual($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_paket_manual');
        $this->db->join('tbl_tahun_anggaran', 'tbl_tahun_anggaran.id_tahun_anggaran = d_paket_manual.id_tahun_anggaran', 'left');
        $this->db->join('tbl_unit_kerja', 'tbl_unit_kerja.id_unit_kerja = d_paket_manual.id_unit_kerja', 'left');
        $this->db->join('tbl_sub_agency', 'tbl_sub_agency.id_sub_agency = d_paket_manual.id_sub_agency', 'left');
        $this->db->join('tbl_panitia', 'tbl_panitia.id_panitia = d_paket_manual.id_panitia', 'left');
        $this->db->join('tbl_jenis_anggaran', 'tbl_jenis_anggaran.id_jenis_anggaran = d_paket_manual.id_jenis_anggaran', 'left');
        $this->db->join('tbl_jenis_pengadaan', 'tbl_jenis_pengadaan.id_jenis_pengadaan = d_paket_manual.id_jenis_pengadaan', 'left');
        $this->db->join('tbl_metode_pemilihan', 'tbl_metode_pemilihan.id_metode_pemilihan = d_paket_manual.id_metode_pemilihan', 'left');
        $this->db->join('tbl_produk_dalam_luar_negri', 'tbl_produk_dalam_luar_negri.id_produk_dl_negri = d_paket_manual.id_produk_dl_negri', 'left');
        $this->db->where('d_paket_manual.id_paket', $id_paket);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function row_vendor_manual($id_vendor)
    {
        $this->db->select('*');
        $this->db->from('d_vendor');
        $this->db->where('id_vendor', $id_vendor);
        $query = $this->db->get();
        return $query->row_array();
    }



    // ININ UNTUK RINCIAN HPS MANUAL
    // RINCIAN HPS PDF
    var $pdf_hps_order = array('id_rincian_hps_pdf', 'nama_rincian_hps_pdf', 'file_rincian_hps_pdf', 'total_rincian_hps_pdf', 'id_rincian_hps_pdf');
    private function _getRincianHps_pdf($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_tbl_rincian_hps_pdf');
        $this->db->where('id_paket', $id_paket);
        $i = 0;
        foreach ($this->pdf_hps_order as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like(
                        $item,
                        $_POST['search']['value']
                    );
                }

                if (count($this->pdf_hps_order) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->pdf_hps_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_rincian_hps_pdf', 'DESC');
        }
    }


    public function getdatatableRincianHps_pdf($id_paket) //nam[ilin data pake ini
    {
        $this->_getRincianHps_pdf($id_paket); //ambil data dari get yg di atas
        if ($_POST['length'] != -3) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_RincianHps_pdf($id_paket)
    {
        $this->_getRincianHps_pdf($id_paket); //ambil data dari get yg di atas
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_dataRincianHps_pdf($id_paket)
    {
        $this->db->from('d_tbl_rincian_hps_pdf');
        $this->db->where('id_paket', $id_paket);
        return $this->db->count_all_results();
    }
    public function rincian_hps_manual($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_tbl_rincian_hps_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function create_pdf_rincian_hps($data)
    {
        $this->db->insert('d_tbl_rincian_hps_pdf', $data);
        return $this->db->affected_rows();
    }
    public function count_rincian_hps_manual($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_tbl_rincian_hps_pdf');
        $this->db->where('id_paket', $id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_by_rincian_hps_pdf2($id_rincian_hps_pdf)
    {
        $this->db->select('*');
        $this->db->from('d_tbl_rincian_hps_pdf');
        $this->db->where('id_rincian_hps_pdf', $id_rincian_hps_pdf);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function deletedata_rincian_hps_pdf($id_rincian_hps_pdf)
    {
        $this->db->delete('d_tbl_rincian_hps_pdf', ['id_rincian_hps_pdf' => $id_rincian_hps_pdf]);
    }

    // INI UNTUK DOKUMEN PENUNJANG
    // table dokumen pengadaan trankasi langsung
    private function _get_data_query_dokumen_penunjang($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_penunjang');
        $this->db->where('d_table_dokumen_penunjang.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_penunjang.nama_dokumen_penunjang', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_penunjang.id_dokumen_penunjang', 'DESC');
        }
    }

    public function getdatatable_dokumen_penunjang($id_paket)
    {
        $this->_get_data_query_dokumen_penunjang($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_penunjang($id_paket)
    {
        $this->_get_data_query_dokumen_penunjang($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_penunjang()
    {
        $this->db->from('d_table_dokumen_penunjang');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_penunjang($id_dokumen_penunjang)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_penunjang');
        $this->db->where('d_table_dokumen_penunjang.id_dokumen_penunjang', $id_dokumen_penunjang);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_penunjang($data)
    {
        $this->db->insert('d_table_dokumen_penunjang', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_penunjang($id_dokumen_penunjang)
    {
        $this->db->delete('d_table_dokumen_penunjang', ['id_dokumen_penunjang' => $id_dokumen_penunjang]);
    }

    // INI UNTUK DOKUMEN SYARAT TAMBAHAN
    private function _get_data_query_dokumen_tambahan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_tambahan');
        $this->db->where('d_table_dokumen_tambahan.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_tambahan.nama_dokumen_tambahan', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_tambahan.id_dokumen_tambahan', 'DESC');
        }
    }

    public function getdatatable_dokumen_tambahan($id_paket)
    {
        $this->_get_data_query_dokumen_tambahan($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_tambahan($id_paket)
    {
        $this->_get_data_query_dokumen_tambahan($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_tambahan()
    {
        $this->db->from('d_table_dokumen_tambahan');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_tambahan($id_dokumen_tambahan)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_tambahan');
        $this->db->where('d_table_dokumen_tambahan.id_dokumen_tambahan', $id_dokumen_tambahan);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_tambahan($data)
    {
        $this->db->insert('d_table_dokumen_tambahan', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_tambahan($id_dokumen_tambahan)
    {
        $this->db->delete('d_table_dokumen_tambahan', ['id_dokumen_tambahan' => $id_dokumen_tambahan]);
    }

    // INI UNTUK DOKUMEN SYARAT lelang
    private function _get_data_query_dokumen_lelang($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_lelang');
        $this->db->where('d_table_dokumen_lelang.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_lelang.nama_dokumen_lelang', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_lelang.id_dokumen_lelang', 'DESC');
        }
    }

    public function getdatatable_dokumen_lelang($id_paket)
    {
        $this->_get_data_query_dokumen_lelang($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_lelang($id_paket)
    {
        $this->_get_data_query_dokumen_lelang($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_lelang()
    {
        $this->db->from('d_table_dokumen_lelang');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_lelang($id_dokumen_lelang)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_lelang');
        $this->db->where('d_table_dokumen_lelang.id_dokumen_lelang', $id_dokumen_lelang);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_lelang($data)
    {
        $this->db->insert('d_table_dokumen_lelang', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_lelang($id_dokumen_lelang)
    {
        $this->db->delete('d_table_dokumen_lelang', ['id_dokumen_lelang' => $id_dokumen_lelang]);
    }


    // INI UNTUK DOKUMEN prakualifikasi
    private function _get_data_query_dokumen_prakualifikasi($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_prakualifikasi');
        $this->db->where('d_table_dokumen_prakualifikasi.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_prakualifikasi.nama_dokumen_prakualifikasi', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_prakualifikasi.id_dokumen_prakualifikasi', 'DESC');
        }
    }

    public function getdatatable_dokumen_prakualifikasi($id_paket)
    {
        $this->_get_data_query_dokumen_prakualifikasi($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_prakualifikasi($id_paket)
    {
        $this->_get_data_query_dokumen_prakualifikasi($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_prakualifikasi()
    {
        $this->db->from('d_table_dokumen_prakualifikasi');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_prakualifikasi($id_dokumen_prakualifikasi)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_prakualifikasi');
        $this->db->where('d_table_dokumen_prakualifikasi.id_dokumen_prakualifikasi', $id_dokumen_prakualifikasi);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_prakualifikasi($data)
    {
        $this->db->insert('d_table_dokumen_prakualifikasi', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_prakualifikasi($id_dokumen_prakualifikasi)
    {
        $this->db->delete('d_table_dokumen_prakualifikasi', ['id_dokumen_prakualifikasi' => $id_dokumen_prakualifikasi]);
    }
    // INI UNTUK BERITA ACARA DOKUMENYA
    // INI UNTUK DOKUMEN PERINGKAT TEKNIS
    private function _get_data_query_dokumen_peringkat_teknis($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_peringkat_teknis');
        $this->db->where('d_table_dokumen_peringkat_teknis.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_peringkat_teknis.nama_dokumen_peringkat_teknis', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_peringkat_teknis.id_dokumen_peringkat_teknis', 'DESC');
        }
    }

    public function getdatatable_dokumen_peringkat_teknis($id_paket)
    {
        $this->_get_data_query_dokumen_peringkat_teknis($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_peringkat_teknis($id_paket)
    {
        $this->_get_data_query_dokumen_peringkat_teknis($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_peringkat_teknis()
    {
        $this->db->from('d_table_dokumen_peringkat_teknis');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_peringkat_teknis($id_dokumen_peringkat_teknis)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_peringkat_teknis');
        $this->db->where('d_table_dokumen_peringkat_teknis.id_dokumen_peringkat_teknis', $id_dokumen_peringkat_teknis);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_peringkat_teknis($data)
    {
        $this->db->insert('d_table_dokumen_peringkat_teknis', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_peringkat_teknis($id_dokumen_peringkat_teknis)
    {
        $this->db->delete('d_table_dokumen_peringkat_teknis', ['id_dokumen_peringkat_teknis' => $id_dokumen_peringkat_teknis]);
    }

    // INI UNTUK DOKUMEN INFORMASI LAINYA
    private function _get_data_query_dokumen_info_lainya($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_info_lainya');
        $this->db->where('d_table_dokumen_info_lainya.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_info_lainya.nama_dokumen_info_lainya', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_info_lainya.id_dokumen_info_lainya', 'DESC');
        }
    }

    public function getdatatable_dokumen_info_lainya($id_paket)
    {
        $this->_get_data_query_dokumen_info_lainya($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_info_lainya($id_paket)
    {
        $this->_get_data_query_dokumen_info_lainya($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_info_lainya()
    {
        $this->db->from('d_table_dokumen_info_lainya');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_info_lainya($id_dokumen_info_lainya)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_info_lainya');
        $this->db->where('d_table_dokumen_info_lainya.id_dokumen_info_lainya', $id_dokumen_info_lainya);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_info_lainya($data)
    {
        $this->db->insert('d_table_dokumen_info_lainya', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_info_lainya($id_dokumen_info_lainya)
    {
        $this->db->delete('d_table_dokumen_info_lainya', ['id_dokumen_info_lainya' => $id_dokumen_info_lainya]);
    }

    // INI UNTUK DOKUMEN PENAWARAN
    private function _get_data_query_dokumen_penawaran($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_penawaran');
        $this->db->where('d_table_dokumen_penawaran.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_penawaran.nama_dokumen_penawaran', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_penawaran.id_dokumen_penawaran', 'DESC');
        }
    }

    public function getdatatable_dokumen_penawaran($id_paket)
    {
        $this->_get_data_query_dokumen_penawaran($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_penawaran($id_paket)
    {
        $this->_get_data_query_dokumen_penawaran($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_penawaran()
    {
        $this->db->from('d_table_dokumen_penawaran');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_penawaran($id_dokumen_penawaran)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_penawaran');
        $this->db->where('d_table_dokumen_penawaran.id_dokumen_penawaran', $id_dokumen_penawaran);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_penawaran($data)
    {
        $this->db->insert('d_table_dokumen_penawaran', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_penawaran($id_dokumen_penawaran)
    {
        $this->db->delete('d_table_dokumen_penawaran', ['id_dokumen_penawaran' => $id_dokumen_penawaran]);
    }


    // INI UNTUK DOKUMEN HASIL TENER
    private function _get_data_query_dokumen_hasil_tender($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_hasil_tender');
        $this->db->where('d_table_dokumen_hasil_tender.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_hasil_tender.nama_dokumen_hasil_tender', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_hasil_tender.id_dokumen_hasil_tender', 'DESC');
        }
    }

    public function getdatatable_dokumen_hasil_tender($id_paket)
    {
        $this->_get_data_query_dokumen_hasil_tender($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_hasil_tender($id_paket)
    {
        $this->_get_data_query_dokumen_hasil_tender($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_hasil_tender()
    {
        $this->db->from('d_table_dokumen_hasil_tender');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_hasil_tender($id_dokumen_hasil_tender)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_hasil_tender');
        $this->db->where('d_table_dokumen_hasil_tender.id_dokumen_hasil_tender', $id_dokumen_hasil_tender);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_hasil_tender($data)
    {
        $this->db->insert('d_table_dokumen_hasil_tender', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_hasil_tender($id_dokumen_hasil_tender)
    {
        $this->db->delete('d_table_dokumen_hasil_tender', ['id_dokumen_hasil_tender' => $id_dokumen_hasil_tender]);
    }

    // INI UNTUK PENUNJUKAN
    private function _get_data_query_dokumen_penunjukan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_penunjukan');
        $this->db->where('d_table_dokumen_penunjukan.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_penunjukan.nama_dokumen_penunjukan', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_penunjukan.id_dokumen_penunjukan', 'DESC');
        }
    }
    public function getdatatable_dokumen_penunjukan($id_paket)
    {
        $this->_get_data_query_dokumen_penunjukan($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_penunjukan($id_paket)
    {
        $this->_get_data_query_dokumen_penunjukan($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_penunjukan()
    {
        $this->db->from('d_table_dokumen_penunjukan');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_penunjukan($id_dokumen_penunjukan)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_penunjukan');
        $this->db->where('d_table_dokumen_penunjukan.id_dokumen_penunjukan', $id_dokumen_penunjukan);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_penunjukan($data)
    {
        $this->db->insert('d_table_dokumen_penunjukan', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_penunjukan($id_dokumen_penunjukan)
    {
        $this->db->delete('d_table_dokumen_penunjukan', ['id_dokumen_penunjukan' => $id_dokumen_penunjukan]);
    }


    // INI UTNUK ADD VENDOR BARU

    private function _get_data_query_get_vendor($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_vendor');
        $this->db->where('d_vendor.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_vendor.nama_vendor', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_vendor.id_vendor', 'DESC');
        }
    }
    public function get_vendor_id_paket($id_paket)
    {
        $this->_get_data_query_get_vendor($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_get_vendor_id_paket($id_paket)
    {
        $this->_get_data_query_get_vendor($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_get_vendor_id_paket()
    {
        $this->db->from('d_vendor');
        return $this->db->count_all_results();
    }
    public function update_pemenang_tender($id_vendor, $data)
    {
        $this->db->where('id_vendor', $id_vendor);
        $this->db->update('d_vendor', $data);
        return $this->db->affected_rows();
    }

    // INI UNTUK DOKUMEN manual
    private function _get_data_query_dokumen_manual()
    {
        $this->db->select('*');
        $this->db->from('d_dokumen_manual');
        if (isset($_POST['tanggal_dokumen_filter'], $_POST['nama_dokumen_filter']) && $_POST['tanggal_dokumen_filter'] != '' && $_POST['nama_dokumen_filter'] != '') {
            $this->db->like('d_dokumen_manual.tanggal_dokumen', $_POST['tanggal_dokumen_filter']);
            $this->db->or_like('d_dokumen_manual.tipe_dokumen', $_POST['nama_dokumen_filter']);
        }
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_dokumen_manual.nama_dokumen', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_dokumen_manual.id_dokumen_manual', 'DESC');
        }
    }

    public function getdatatable_dokumen_manual()
    {
        $this->_get_data_query_dokumen_manual();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_manual()
    {
        $this->_get_data_query_dokumen_manual();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_manual()
    {
        $this->db->from('d_dokumen_manual');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_manual($id_dokumen_manual)
    {
        $this->db->select('*');
        $this->db->from('d_dokumen_manual');
        $this->db->where('d_dokumen_manual.id_dokumen_manual', $id_dokumen_manual);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_manual($data)
    {
        $this->db->insert('d_dokumen_manual', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_manual($id_dokumen_manual)
    {
        $this->db->delete('d_dokumen_manual', ['id_dokumen_manual' => $id_dokumen_manual]);
    }

    // INI UNTK DOKUMENPOENGADAAN
    private function _get_data_query_dokumen_kerangka_acuan_kerja($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_kerangka_acuan_kerja');
        $this->db->where('d_table_dokumen_kerangka_acuan_kerja.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_kerangka_acuan_kerja.nama_dokumen_kerangka_acuan_kerja', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_kerangka_acuan_kerja.id_dokumen_kerangka_acuan_kerja', 'DESC');
        }
    }

    public function getdatatable_dokumen_kerangka_acuan_kerja($id_paket)
    {
        $this->_get_data_query_dokumen_kerangka_acuan_kerja($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_kerangka_acuan_kerja($id_paket)
    {
        $this->_get_data_query_dokumen_kerangka_acuan_kerja($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_kerangka_acuan_kerja()
    {
        $this->db->from('d_table_dokumen_kerangka_acuan_kerja');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_kerangka_acuan_kerja($id_dokumen_kerangka_acuan_kerja)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_kerangka_acuan_kerja');
        $this->db->where('d_table_dokumen_kerangka_acuan_kerja.id_dokumen_kerangka_acuan_kerja', $id_dokumen_kerangka_acuan_kerja);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_kerangka_acuan_kerja($data)
    {
        $this->db->insert('d_table_dokumen_kerangka_acuan_kerja', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_kerangka_acuan_kerja($id_dokumen_kerangka_acuan_kerja)
    {
        $this->db->delete('d_table_dokumen_kerangka_acuan_kerja', ['id_dokumen_kerangka_acuan_kerja' => $id_dokumen_kerangka_acuan_kerja]);
    }

    // INI UNTK DOKUMENSPESIFIKASI KHUSUS
    private function _get_data_query_dokumen_spesifikasi_khusus($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_spesifkasi_khusus');
        $this->db->where('d_table_dokumen_spesifkasi_khusus.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_spesifkasi_khusus.nama_dokumen_spesifikasi_khusus', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_spesifkasi_khusus.id_dokumen_spesifikasi_khusus', 'DESC');
        }
    }

    public function getdatatable_dokumen_spesifikasi_khusus($id_paket)
    {
        $this->_get_data_query_dokumen_spesifikasi_khusus($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_spesifikasi_khusus($id_paket)
    {
        $this->_get_data_query_dokumen_spesifikasi_khusus($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_spesifikasi_khusus()
    {
        $this->db->from('d_table_dokumen_spesifkasi_khusus');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_spesifikasi_khusus($id_dokumen_spesifikasi_khusus)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_spesifkasi_khusus');
        $this->db->where('d_table_dokumen_spesifkasi_khusus.id_dokumen_spesifikasi_khusus', $id_dokumen_spesifikasi_khusus);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_spesifikasi_khusus($data)
    {
        $this->db->insert('d_table_dokumen_spesifkasi_khusus', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_spesifikasi_khusus($id_dokumen_spesifikasi_khusus)
    {
        $this->db->delete('d_table_dokumen_spesifkasi_khusus', ['id_dokumen_spesifikasi_khusus' => $id_dokumen_spesifikasi_khusus]);
    }


    // INI UNTK DOKUMENSPESIFIKASI umum
    private function _get_data_query_dokumen_spesifikasi_umum($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_spesifkasi_umum');
        $this->db->where('d_table_dokumen_spesifkasi_umum.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_spesifkasi_umum.nama_dokumen_spesifikasi_umum', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_spesifkasi_umum.id_dokumen_spesifikasi_umum', 'DESC');
        }
    }

    public function getdatatable_dokumen_spesifikasi_umum($id_paket)
    {
        $this->_get_data_query_dokumen_spesifikasi_umum($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_spesifikasi_umum($id_paket)
    {
        $this->_get_data_query_dokumen_spesifikasi_umum($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_spesifikasi_umum()
    {
        $this->db->from('d_table_dokumen_spesifkasi_umum');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_spesifikasi_umum($id_dokumen_spesifikasi_umum)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_spesifkasi_umum');
        $this->db->where('d_table_dokumen_spesifkasi_umum.id_dokumen_spesifikasi_umum', $id_dokumen_spesifikasi_umum);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_spesifikasi_umum($data)
    {
        $this->db->insert('d_table_dokumen_spesifkasi_umum', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_spesifikasi_umum($id_dokumen_spesifikasi_umum)
    {
        $this->db->delete('d_table_dokumen_spesifkasi_umum', ['id_dokumen_spesifikasi_umum' => $id_dokumen_spesifikasi_umum]);
    }


    // INI UNTK DOKUEMN PERKIRAAN HPS_SENDIRI
    private function _get_data_query_dokumen_harga_perkiraan_sendiri_hps($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_harga_perkiraan_sendiri_hps');
        $this->db->where('d_table_dokumen_harga_perkiraan_sendiri_hps.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_harga_perkiraan_sendiri_hps.nama_dokumen_harga_perkiraan_sendiri_hps', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_harga_perkiraan_sendiri_hps.id_dokumen_harga_perkiraan_sendiri_hps', 'DESC');
        }
    }

    public function getdatatable_dokumen_harga_perkiraan_sendiri_hps($id_paket)
    {
        $this->_get_data_query_dokumen_harga_perkiraan_sendiri_hps($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_harga_perkiraan_sendiri_hps($id_paket)
    {
        $this->_get_data_query_dokumen_harga_perkiraan_sendiri_hps($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_harga_perkiraan_sendiri_hps()
    {
        $this->db->from('d_table_dokumen_harga_perkiraan_sendiri_hps');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_harga_perkiraan_sendiri_hps($id_dokumen_harga_perkiraan_sendiri_hps)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_harga_perkiraan_sendiri_hps');
        $this->db->where('d_table_dokumen_harga_perkiraan_sendiri_hps.id_dokumen_harga_perkiraan_sendiri_hps', $id_dokumen_harga_perkiraan_sendiri_hps);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_harga_perkiraan_sendiri_hps($data)
    {
        $this->db->insert('d_table_dokumen_harga_perkiraan_sendiri_hps', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_harga_perkiraan_sendiri_hps($id_dokumen_harga_perkiraan_sendiri_hps)
    {
        $this->db->delete('d_table_dokumen_harga_perkiraan_sendiri_hps', ['id_dokumen_harga_perkiraan_sendiri_hps' => $id_dokumen_harga_perkiraan_sendiri_hps]);
    }

    // INI UNTK DOKUMENSPESIFIKASI umum
    private function _get_data_query_dokumen_daftar_peralatan_yang_diperlukan($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_daftar_peralatan_yang_diperlukan');
        $this->db->where('d_table_dokumen_daftar_peralatan_yang_diperlukan.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_daftar_peralatan_yang_diperlukan.nama_dokumen_daftar_peralatan_yang_diperlukan', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_daftar_peralatan_yang_diperlukan.id_dokumen_daftar_peralatan_yang_diperlukan', 'DESC');
        }
    }

    public function getdatatable_dokumen_daftar_peralatan_yang_diperlukan($id_paket)
    {
        $this->_get_data_query_dokumen_daftar_peralatan_yang_diperlukan($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_daftar_peralatan_yang_diperlukan($id_paket)
    {
        $this->_get_data_query_dokumen_daftar_peralatan_yang_diperlukan($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_daftar_peralatan_yang_diperlukan()
    {
        $this->db->from('d_table_dokumen_daftar_peralatan_yang_diperlukan');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_daftar_peralatan_yang_diperlukan($id_dokumen_daftar_peralatan_yang_diperlukan)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_daftar_peralatan_yang_diperlukan');
        $this->db->where('d_table_dokumen_daftar_peralatan_yang_diperlukan.id_dokumen_daftar_peralatan_yang_diperlukan', $id_dokumen_daftar_peralatan_yang_diperlukan);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_daftar_peralatan_yang_diperlukan($data)
    {
        $this->db->insert('d_table_dokumen_daftar_peralatan_yang_diperlukan', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_daftar_peralatan_yang_diperlukan($id_dokumen_daftar_peralatan_yang_diperlukan)
    {
        $this->db->delete('d_table_dokumen_daftar_peralatan_yang_diperlukan', ['id_dokumen_daftar_peralatan_yang_diperlukan' => $id_dokumen_daftar_peralatan_yang_diperlukan]);
    }

    // DOKUMEN RANCANGAN KONTRAK
    private function _get_data_query_dokumen_rancangan_kontrak($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_rancangan_kontrak');
        $this->db->where('d_table_dokumen_rancangan_kontrak.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_rancangan_kontrak.nama_dokumen_rancangan_kontrak', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_rancangan_kontrak.id_dokumen_rancangan_kontrak', 'DESC');
        }
    }

    public function getdatatable_dokumen_rancangan_kontrak($id_paket)
    {
        $this->_get_data_query_dokumen_rancangan_kontrak($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_rancangan_kontrak($id_paket)
    {
        $this->_get_data_query_dokumen_rancangan_kontrak($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_rancangan_kontrak()
    {
        $this->db->from('d_table_dokumen_rancangan_kontrak');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_rancangan_kontrak($id_dokumen_rancangan_kontrak)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_rancangan_kontrak');
        $this->db->where('d_table_dokumen_rancangan_kontrak.id_dokumen_rancangan_kontrak', $id_dokumen_rancangan_kontrak);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_rancangan_kontrak($data)
    {
        $this->db->insert('d_table_dokumen_rancangan_kontrak', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_rancangan_kontrak($id_dokumen_rancangan_kontrak)
    {
        $this->db->delete('d_table_dokumen_rancangan_kontrak', ['id_dokumen_rancangan_kontrak' => $id_dokumen_rancangan_kontrak]);
    }


    // DOKUMEN KETEMTUAN UMUM KONTRAK
    private function _get_data_query_dokumen_ketentuan_umum_kontrak_kuk($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_ketentuan_umum_kontrak_kuk');
        $this->db->where('d_table_dokumen_ketentuan_umum_kontrak_kuk.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_ketentuan_umum_kontrak_kuk.nama_dokumen_ketentuan_umum_kontrak_kuk', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_ketentuan_umum_kontrak_kuk.id_dokumen_ketentuan_umum_kontrak_kuk', 'DESC');
        }
    }

    public function getdatatable_dokumen_ketentuan_umum_kontrak_kuk($id_paket)
    {
        $this->_get_data_query_dokumen_ketentuan_umum_kontrak_kuk($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_ketentuan_umum_kontrak_kuk($id_paket)
    {
        $this->_get_data_query_dokumen_ketentuan_umum_kontrak_kuk($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_ketentuan_umum_kontrak_kuk()
    {
        $this->db->from('d_table_dokumen_ketentuan_umum_kontrak_kuk');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_ketentuan_umum_kontrak_kuk($id_dokumen_ketentuan_umum_kontrak_kuk)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_ketentuan_umum_kontrak_kuk');
        $this->db->where('d_table_dokumen_ketentuan_umum_kontrak_kuk.id_dokumen_ketentuan_umum_kontrak_kuk', $id_dokumen_ketentuan_umum_kontrak_kuk);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_ketentuan_umum_kontrak_kuk($data)
    {
        $this->db->insert('d_table_dokumen_ketentuan_umum_kontrak_kuk', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_ketentuan_umum_kontrak_kuk($id_dokumen_ketentuan_umum_kontrak_kuk)
    {
        $this->db->delete('d_table_dokumen_ketentuan_umum_kontrak_kuk', ['id_dokumen_ketentuan_umum_kontrak_kuk' => $id_dokumen_ketentuan_umum_kontrak_kuk]);
    }
    // DOKUMEN K3
    private function _get_data_query_dokumen_k3($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_k3');
        $this->db->where('d_table_dokumen_k3.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_k3.nama_dokumen_k3', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_k3.id_dokumen_k3', 'DESC');
        }
    }

    public function getdatatable_dokumen_k3($id_paket)
    {
        $this->_get_data_query_dokumen_k3($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_k3($id_paket)
    {
        $this->_get_data_query_dokumen_k3($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_k3()
    {
        $this->db->from('d_table_dokumen_k3');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_k3($id_dokumen_k3)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_k3');
        $this->db->where('d_table_dokumen_k3.id_dokumen_k3', $id_dokumen_k3);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_k3($data)
    {
        $this->db->insert('d_table_dokumen_k3', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_k3($id_dokumen_k3)
    {
        $this->db->delete('d_table_dokumen_k3', ['id_dokumen_k3' => $id_dokumen_k3]);
    }



    // DOKUMEN gambar_rencana
    private function _get_data_query_dokumen_gambar_rencana($id_paket)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_gambar_rencana');
        $this->db->where('d_table_dokumen_gambar_rencana.id_paket', $id_paket);
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_gambar_rencana.nama_dokumen_gambar_rencana', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_gambar_rencana.id_dokumen_gambar_rencana', 'DESC');
        }
    }

    public function getdatatable_dokumen_gambar_rencana($id_paket)
    {
        $this->_get_data_query_dokumen_gambar_rencana($id_paket);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_gambar_rencana($id_paket)
    {
        $this->_get_data_query_dokumen_gambar_rencana($id_paket);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_gambar_rencana()
    {
        $this->db->from('d_table_dokumen_gambar_rencana');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_gambar_rencana($id_dokumen_gambar_rencana)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_gambar_rencana');
        $this->db->where('d_table_dokumen_gambar_rencana.id_dokumen_gambar_rencana', $id_dokumen_gambar_rencana);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_gambar_rencana($data)
    {
        $this->db->insert('d_table_dokumen_gambar_rencana', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_gambar_rencana($id_dokumen_gambar_rencana)
    {
        $this->db->delete('d_table_dokumen_gambar_rencana', ['id_dokumen_gambar_rencana' => $id_dokumen_gambar_rencana]);
    }



    // DOKUMEN vendor_manual
    private function _get_data_query_dokumen_vendor_manual($id_paket, $id_vendor)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_vendor_manual');
        $this->db->where('id_paket', '' . "" . $id_paket . "" . '');
        $this->db->where('id_vendor', '' . "" . $id_vendor . "" . '');
        if (isset($_POST['search']['value'])) {
            $this->db->like('d_table_dokumen_vendor_manual.nama_dokumen_vendor_manual', $_POST['search']['value']);
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('d_table_dokumen_vendor_manual.id_dokumen_vendor_manual', 'DESC');
        }
    }

    public function getdatatable_dokumen_vendor_manual($id_paket, $id_vendor)
    {
        $this->_get_data_query_dokumen_vendor_manual($id_paket, $id_vendor);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_dokumen_vendor_manual($id_paket, $id_vendor)
    {
        $this->_get_data_query_dokumen_vendor_manual($id_paket, $id_vendor);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_dokumen_vendor_manual()
    {
        $this->db->from('d_table_dokumen_vendor_manual');
        return $this->db->count_all_results();
    }

    public function by_id_dokumen_vendor_manual($id_dokumen_vendor_manual)
    {
        $this->db->select('*');
        $this->db->from('d_table_dokumen_vendor_manual');
        $this->db->where('d_table_dokumen_vendor_manual.id_dokumen_vendor_manual', $id_dokumen_vendor_manual);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function tambah_dokumen_vendor_manual($data)
    {
        $this->db->insert('d_table_dokumen_vendor_manual', $data);
        return $this->db->affected_rows();
    }

    public function delete_dokumen_vendor_manual($id_dokumen_vendor_manual)
    {
        $this->db->delete('d_table_dokumen_vendor_manual', ['id_dokumen_vendor_manual' => $id_dokumen_vendor_manual]);
    }
}
