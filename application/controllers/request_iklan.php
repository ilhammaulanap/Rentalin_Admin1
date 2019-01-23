<?php


class request_iklan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_permintaan');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['data']=$this->m_permintaan->get_all();        
        $this->load->view('Template/header');
        $this->load->view('iklan/tb_reqiklan',$data);
        $this->load->view('template/footer');

    } 


    public function read($id) 
    {
        $row = $this->m_permintaan->get_by_id($id);
        
        if ($row) {
            $data = array(
                'id_iklan' => $row->id_iklan,
                'judul_iklan' => $row->judul_iklan,
                'type_mobil' => $row->type_mobil,
                'merk' => $row->merk,
                'transmisi' => $row->transmisi,
                'tahun_mobil' => $row->tahun_mobil,
                'no_telp' => $row->no_telp,
                'alamat' => $row->alamat,
                'harga' => $row->harga,
                'status_iklan' => $row->status_iklan,
                'deskripsi' => $row->deskripsi,
                'tgl_iklan' => $row->tgl_iklan,
                'photo1' => $row->photo1,
            );
            $this->load->view('template/header');
            $this->load->view('iklan/tb_reqiklan_read', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('request_iklan'));
        }
    }

    public function update($id)
    {
      $row = $this->m_permintaan->get_by_id($id);
        
        if ($row) {
            $data = array(

                'button' => 'Update',
                'action' =>site_url('request_iklan/update_action'),
                'id_iklan' => $row->id_iklan,
                'judul_iklan' =>set_value('judul_iklan',$row->judul_iklan),
                'type_mobil' => $row->type_mobil,
                'merk' => $row->merk,
                'transmisi' => $row->transmisi,
                'tahun_mobil' => $row->tahun_mobil,
                'no_telp' => $row->no_telp,
                'alamat' => $row->alamat,
                'harga' => $row->harga,
                'status_iklan' => $row->status_iklan,
                'deskripsi' => $row->deskripsi,
                'verifikasi_iklan' => $row->verifikasi_iklan,
                'tgl_iklan' => $row->tgl_iklan,
                'photo1' => $row->photo1,
            );
            $this->load->view('template/header');
            $this->load->view('iklan/tb_iklan_form', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('request_iklan'));
        }

    }

    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('ID_MOBIL', TRUE));
        } else {
            $data['data'] = array(
                'judul_iklan' => $this->input->post('judul_iklan',FALSE),
                'type_mobil' => $this->input->post('type_mobil',TRUE),
                'merk' => $this->input->post('merk',TRUE),
                'transmisi' => $this->input->post('transmisi',TRUE),
                'tahun_mobil' => $this->input->post('tahun_mobil',TRUE),
                'no_telp' => $this->input->post('no_telp',TRUE),
                'alamat' => $this->input->post('alamat',TRUE),
                'harga' => $this->input->post('harga',TRUE),
                'tgl_iklan' => $this->input->post('tgl_iklan',TRUE),
                'verifikasi_iklan' => $this->input->post('verifikasi_iklan',TRUE),
            );

           


            $this->m_permintaan->update($this->input->post('id_iklan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('request_iklan'));
        }
    }

}