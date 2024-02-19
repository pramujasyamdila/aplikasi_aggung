<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wilayah extends CI_Controller
{
   public function __construct()
   {

      parent::__construct();
      $this->load->library('form_validation');
      $this->load->model('Wilayah/Wilayah_model');
   }
   public function dataKabupaten($id_provinsi) //klpd
   {
      $data = $this->Wilayah_model->getKabupaten($id_provinsi);
      echo '<option value="">--Kabupaten--</option>';
      foreach ($data as $key => $value) {
         echo '<option value="' . $value['id_kabupaten'] . '">' . $value['nama_kabupaten'] . '</option>';
      }
   }

   // public function dataKecamatan($id_kabupaten) //satuan kerja
   // {
   // 	$data= $this->M_wilayah->getKecamatan($id_kabupaten);
   // 	echo '<option value="">pilih Kecamatan</option>';
   // 	foreach ($data as $key => $value) {
   // 		echo '<option value="'.$value['id_kecamatan'].'">'.$value['nama_kecamatan'].'</option>';
   // 	}
   // }


}
