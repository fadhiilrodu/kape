<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Dompdf\Dompdf;

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->library('pagination');
        $this->load->helper('cookie');
        $this->load->model('barangMasuk_model');
        $this->load->model('barangKeluar_model');
      }

    public function barang_masuk_pdf()
    {
      $dompdf = new Dompdf();
      $tglawal = $this->input->post('tglawal');
      $tglakhir = $this->input->post('tglakhir');

      if($tglawal != '' && $tglakhir != ''){
        $data['data'] = $this->barangMasuk_model->lapdata($tglawal, $tglakhir)->result();
      }
      else{
        $data['data'] = $this->barangMasuk_model->dataJoin()->result();
      }

      $data['tglawal'] = $tglawal;
      $data['tglakhir'] = $tglakhir;

      $data['judul'] = 'Laporan Barang Masuk';
      // $mpdf = new \Mpdf\Mpdf();
      $html = $this->load->view('laporan/barang_masuk_pdf',$data,true);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4','potrait');
      $dompdf->render();
      $dompdf->stream();
      $mpdf->WriteHTML($html);
      $tgl = date('Ymd_his');
      $namaFile = 'Barang_masuk_'.$tgl.'.pdf';
      $mpdf->Output($namaFile, 'D');

    }

    public function barang_keluar_pdf()
    {
      $dompdf = new Dompdf();
      $tglawal = $this->input->post('tglawal');
      $tglakhir = $this->input->post('tglakhir');

      if($tglawal != '' && $tglakhir != ''){
        $data['data'] = $this->barangKeluar_model->lapdata($tglawal, $tglakhir)->result();
      }
      else{
        $data['data'] = $this->barangKeluar_model->dataJoin()->result();
      }

      $data['tglawal'] = $tglawal;
      $data['tglakhir'] = $tglakhir;

      $data['judul'] = 'Laporan Barang Keluar';
      // $mpdf = new \Mpdf\Mpdf();
      $html = $this->load->view('laporan/barang_keluar_pdf',$data,true);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4','potrait');
      $dompdf->render();
      $dompdf->stream();
      $mpdf->WriteHTML($html);
      $tgl = date('Ymd_his');
      $namaFile = 'Barang_keluar_'.$tgl.'.pdf';
      $mpdf->Output($namaFile, 'D');

    }



}