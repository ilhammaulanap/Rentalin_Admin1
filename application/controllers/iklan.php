<?php


class iklan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_iklan_admin');
    }

    public function index()
    {
        $data['data']=$this->M_iklan_admin->get_all();        
        $this->load->view('Template/header');
        $this->load->view('iklan/tb_iklan_list',$data);
        $this->load->view('template/footer');
    } 


    public function read($id) 
    {
        $row = $this->M_iklan_admin->get_by_id($id);
        
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
            $this->load->view('iklan/tb_iklan_read', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('iklan'));
        }
    }


     public function update($id) 
    {
        $row = $this->M_iklan_admin->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('iklan/update_action'),
                'id_iklan' => set_value('id_iklan', $row->id_iklan),
                'judul_iklan' => set_value('judul_iklan', $row->id_iklan),
                'type_mobil' => set_value('type_mobil', $row->type_mobil),
                'merk' => set_value('merk', $row->merk),
                'transmisi' => set_value('transmisi', $row->transmisi),
                'tahun_mobil' => set_value('tahun_mobil', $row->tahun_mobil),
                'no_telp' => set_value('no_telp', $row->no_telp),
                'alamat' => set_value('alamat', $row->alamat),
                'harga' => set_value('harga', $row->harga),
                'status_iklan' => set_value('status_iklan', $row->status_iklan),
                'deskripsi' => set_value('deskripsi', $row->deskripsi),
                'tgl_iklan' => set_value('tgl_iklan', $row->tgl_iklan),
                'verifikasi_iklan' => set_value('verifikasi_iklan', $row->verifikasi_iklan),
                'photo1' => set_value('photo1', $row->photo1),
            );


            $this->load->view('template/header');
            $this->load->view('mobil/tb_mobil_form', $data);
            $this->load->view('template/footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mobil'));
        }
    }

    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_iklan', TRUE));
        } else {
            $data['data'] = array(
                'judul_iklan' => $this->input->post('judul_iklan',TRUE),
                'MERK_MOBIL' => $this->input->post('MERK_MOBIL',TRUE),
                'DESKRIPSI_MOBIL' => $this->input->post('DESKRIPSI_MOBIL',TRUE),
                'TAHUN_MOBIL' => $this->input->post('TAHUN_MOBIL',TRUE),
                'KAPASITAS_MOBIL' => $this->input->post('KAPASITAS_MOBIL',TRUE),
                'HARGA_MOBIL' => $this->input->post('HARGA_MOBIL',TRUE),
                'WARNA_MOBIL' => $this->input->post('WARNA_MOBIL',TRUE),
                'BENSIN_MOBIL' => $this->input->post('BENSIN_MOBIL',TRUE),
                'PLAT_NO_MOBIL' => $this->input->post('PLAT_NO_MOBIL',TRUE),
                'STATUS_SEWA' => $this->input->post('STATUS_SEWA',TRUE),
                'STATUS_MOBIL' => $this->input->post('STATUS_MOBIL',TRUE),
            );

            $data["fasilitas"]=array();
            $data["photo"]=array();
            $fasilitas=$this->input->post('FASILITAS',TRUE);

            if ($fasilitas) {
                foreach ($fasilitas as $row) {
                    $data["fasilitas"][]=array('ID_FASILITAS'=> $row);
                }
            }

            $nama_photo=date("YmdHis").".jpg";
            $config=$this->config_image($nama_photo,"./upload/mobil");
            $this->upload->initialize($config);
                
            if($this->upload->do_upload('PHOTO')){
                $data["photo"]=array('IMAGE'=> $nama_photo);
            }


            $this->M_mobil_admin->update($this->input->post('ID_MOBIL', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('mobil'));
        }
    }
    

}