<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function index()
    {
        $this->load->view('index');
    }

    public function json()
    {
        $this->load->library('datatables');
        $this->datatables->select('id, nama, file');
        $this->datatables->from('tbl_file');
        $this->datatables->add_column(
            'aksi',
            '<a href="javascript:void(0);" class="lihat btn btn-sm btn-primary" data-id="$1">Lihat
            <a href="' . base_url('home/edit?id=$1') . '" class="edit btn btn-sm btn-warning" data-id="$1">Edit
            <a href="javascript:void(0);" class="hapus btn btn-sm btn-danger" data-id="$1">Hapus',
            'id'
        );
        return print_r($this->datatables->generate());
    }

    public function getDataById()
    {
        $id     = $this->input->post('id');
        $result = $this->db->select('*')->where('id', $id)->get('tbl_file')->row();
        echo json_encode($result);
    }

    public function tambah()
    {
        $this->load->view('tambah');
    }

    public function add()
    {
        $data['nama'] = $this->input->post('nama');
        $data['file'] = $_FILES['file_berkas'];
        if ($data['file']) {
            $config['allowed_types'] = 'jpeg|jpg|png|svg|pdf';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/file/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_berkas')) {
                $data['file'] = $this->upload->data('file_name');
                $this->db->insert('tbl_file', $data);
                redirect('home');
            } else {
                redirect('home/tambah');
            }
        }
    }

    public function edit()
    {
        $id = $this->input->get('id');
        $data['data'] = $this->db->get_where('tbl_file', ['id' => $id])->row_array();
        $this->load->view('edit', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data['data'] = $this->db->get_where('tbl_file', ['id' => $id])->row_array();
        $nama = $this->input->post('nama');
        $file = $_FILES['file_berkas'];

        if ($file) {
            $config['allowed_types'] = 'gif|jpg|png|svg|pdf';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/file/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_berkas')) {
                $old_file = $data['data']['file'];
                if ($old_file != NULL) {
                    unlink(FCPATH . '/assets/file/' . $old_file);
                }

                $new_file = $this->upload->data('file_name');
                $this->db->set('file', $new_file);
            } else {
                redirect('home/edit?id=' . $id);
            }
        }
        $this->db->set('nama', $nama);
        $this->db->where('id', $id);
        $this->db->update('tbl_file');
        redirect('/');
    }

    public function delete()
    {
        $id   = $this->input->post('id_hapus3');
        $prevFile  = $this->db->get_where('tbl_file', ['id' => $id])->row_array()['file'];

        // if ($prevFile != 'no_thumbnail.png') {
        unlink(FCPATH . 'assets/file/' . $prevFile);
        // }

        $this->db->delete('tbl_file', ['id' => $id]);
        $delete = $this->db->affected_rows();
        echo json_encode($delete);
    }
}

/* End of file Home.php */
