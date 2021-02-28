<?php
/* Developed by : Fitra Arrafiq
Copyright Allright Reserved. */
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(array('User', 'Gaji_bulanan', 'Karyawan', 'Jabatan', 'Golongan', 'Tingkat_jabatan', 'Bonus_kinerja', 'Bonus_lebaran', 'Guru_terbaik', 'Kenaikan_gaji'));
    }

    public function index($bulan = "")
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            date_default_timezone_set('Asia/Jakarta');
            if (empty($bulan)) {
                $bulan = date('n');
            }
            $bulan = str_replace("'", '', $bulan);
            $bulan = preg_replace('/[^A-Za-z0-9\-]/', '', $bulan);
            $view['bulan'] = $bulan;
            $view['title']                               = 'Dashboard';
            $view['pageName']                            = 'home';
            $view['countKaryawan']                       = $this->Karyawan->countKaryawan();
            $view['getGenderWoman']                      = $this->Karyawan->getGender('LK');
            $view['getGenderMan']                        = $this->Karyawan->getGender('PR');
            $view['showDataIndex']                       = $this->Karyawan->showDataIndex();
            $view['getGajiBulananGuru']                  = $this->Gaji_bulanan->getDataGajiBulanan('Guru', $bulan);
            $view['getGajiBulananAdministrasi']          = $this->Gaji_bulanan->getDataGajiBulanan('Administrasi', $bulan);
            $view['getGajiBulananKeuangan']              = $this->Gaji_bulanan->getDataGajiBulanan('Keuangan', $bulan);
            $view['getGajiBulananManajemen']             = $this->Gaji_bulanan->getDataGajiBulanan('Manajemen', $bulan);
            $view['getGajiBulananKeamananDanKebersihan'] = $this->Gaji_bulanan->getDataGajiBulanan('Keamanan dan Kebersihan', $bulan);
            $view['getGajiBulanan']                      = $this->Gaji_bulanan->getGajiBulanan();
            $view['visualizeGajiBulananPerbulan'] = $this->Gaji_bulanan->visualizeGajiBulananPerbulan();
            $this->load->view('index', $view);
        }
    }

    public function gaji_bulanan($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']           = 'Gaji Bulanan';
            $view['pageName']        = 'gajiBulanan';
            $view['getKaryawan']     = $this->Karyawan->getData();
            $view['getGajiTambahan'] = $this->Gaji_bulanan->getGajiTambahan();


            if ($param == 'getAllData') {
                $dt    = $this->Gaji_bulanan->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id   = $row->id;
                    $th1  = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2  = '<div style="width:70px">' . get_btn_group1('ubah("' . $id . '")', (($this->session->userdata('role') == 'administrator') || ($this->session->userdata('role') == 'keuangan' && ($row->approve_yayasan == 1)) || ($this->session->userdata('role') == 'yayasan')) ? 'hapus("' . $id . '")' : 'pesan()') .  (($this->session->userdata('role') == 'yayasan') ? get_btn_export('print("' . $id . '")') : (get_btn_export($row->approve_yayasan == 0 ? 'pesan()' : 'print("' . $id . '")'))) . '</div>';
                    $th3 =  '<div style="font-size:13px;">' . ((($this->session->userdata('role') == 'yayasan') && ($row->approve_yayasan == 0)) ? btn_approve('approve("' . $id . '")') : ($row->approve_yayasan == 0 ? '<div class="badge btn-warning" style="color:red"><li class="fa fa-close"></li> Belum diapprove</div>' : '<div class="badge bg-green" style="color:white"><li class="fa fa-arrow-right"></li> Telah diapprove</div>')) . '</div>';
                    $th4  = '<div style="font-size:12px;">' . $row->nama_karyawan . '</div>';
                    $th5  = '<div style="font-size:12px;">' . tgl_indo($row->tanggal) . '</div>';
                    $th6  = '<div style="font-size:12px;">' . $row->nama_golongan . '</div>';
                    $th7  = '<div style="font-size:12px;">' . rupiah_format($row->gaji_pokok) . '</div>';
                    $th8  = '<div style="font-size:12px;">' . $row->nama_jabatan . '</div>';
                    $th9  = '<div style="font-size:12px;">' . rupiah_format($row->uang_transport) . '</div>';
                    $th10 = '<div style="font-size:12px;">' . rupiah_format($row->tunjangan_kinerja) . '</div>';
                    $th11 = '<div style="font-size:12px;">' . rupiah_format($row->tunjangan_jabatan) . '</div>';
                    $th12 = '<div style="font-size:12px;">' . rupiah_format($row->uang_extra_kurikuler) . '</div>';
                    $th13 = '<div style="font-size:12px;">' . rupiah_format($row->uang_lembur) . '</div>';
                    $th14 = '<div style="font-size:12px;">' . rupiah_format($row->bonus_lain) . '</div>';
                    $th15 = '<div style="font-size:12px;">' . rupiah_format($row->total_potongan) . '</div>';
                    $th16 = '<div style="font-size:12px;">' . rupiah_format($row->total_gaji) . '</div>';

                    $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8, $th9, $th10, $th11, $th12, $th13, $th14, $th15, $th16));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Gaji_bulanan->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tanggal", "Tanggal", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("uang_transport", "Tambahan Transport", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tunjangan_kinerja", "Tambahan tunjangan kinerja", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tunjangan_jabatan", "Tambahan tunjangan jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("uang_extra_kurikuler", "Tambahan tunjangan extrakurikuler", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("uang_lembur", "Tambahan Tunjangan Lembur", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("bonus_lain", "Tunjangan hari raya", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("total_potongan", "Total Potongan", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getGaji                = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $data['id_karyawan']          = htmlspecialchars($this->input->post('id_karyawan'));
                    $data['tanggal']              = htmlspecialchars($this->input->post('tanggal'));
                    $data['uang_transport']       = htmlspecialchars($this->input->post('uang_transport'));
                    $data['tunjangan_kinerja']    = htmlspecialchars($this->input->post('tunjangan_kinerja'));
                    $data['tunjangan_jabatan']    = htmlspecialchars($this->input->post('tunjangan_jabatan'));
                    $data['uang_extra_kurikuler'] = htmlspecialchars($this->input->post('uang_extra_kurikuler'));
                    $data['uang_lembur']          = htmlspecialchars($this->input->post('uang_lembur'));
                    $data['bonus_lain']           = htmlspecialchars($this->input->post('bonus_lain'));
                    $data['total_potongan']       = htmlspecialchars($this->input->post('total_potongan'));
                    $data['total_gaji']           = ((($getGaji[0]->total_gaji) + ($this->input->post('uang_transport')) + ($this->input->post('tunjangan_kinerja')) + ($this->input->post('tunjangan_jabatan')) + ($this->input->post('uang_extra_kurikuler')) + ($this->input->post('uang_lembur')) + ($this->input->post('bonus_lain'))) - ($this->input->post('total_potongan')));
                    $result['messages']             = '';
                    $result                 = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Gaji_bulanan->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("uang_transport", "Tambahan Transport", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tunjangan_kinerja", "Tambahan tunjangan kinerja", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tunjangan_jabatan", "Tambahan tunjangan jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("uang_extra_kurikuler", "Tambahan tunjangan extrakurikuler", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("uang_lembur", "Tambahan Tunjangan Lembur", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("bonus_lain", "Tunjangan hari raya", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("total_potongan", "Total Potongan", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']                   = htmlspecialchars($this->input->post('id'));
                    $getGaji                = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $data['tanggal']              = htmlspecialchars($this->input->post('tanggal'));
                    $data['id_karyawan']          = htmlspecialchars($this->input->post('id_karyawan'));
                    $data['uang_transport']       = htmlspecialchars($this->input->post('uang_transport'));
                    $data['tunjangan_kinerja']    = htmlspecialchars($this->input->post('tunjangan_kinerja'));
                    $data['tunjangan_jabatan']    = htmlspecialchars($this->input->post('tunjangan_jabatan'));
                    $data['uang_extra_kurikuler'] = htmlspecialchars($this->input->post('uang_extra_kurikuler'));
                    $data['uang_lembur']          = htmlspecialchars($this->input->post('uang_lembur'));
                    $data['bonus_lain']           = htmlspecialchars($this->input->post('bonus_lain'));
                    $data['total_potongan']       = htmlspecialchars($this->input->post('total_potongan'));
                    $data['total_gaji']           = ((($getGaji[0]->total_gaji) + ($this->input->post('uang_transport')) + ($this->input->post('tunjangan_kinerja')) + ($this->input->post('tunjangan_jabatan')) + ($this->input->post('uang_extra_kurikuler')) + ($this->input->post('uang_lembur')) + ($this->input->post('bonus_lain'))) - ($this->input->post('total_potongan')));

                    $result['messages'] = '';
                    $result     = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Gaji_bulanan->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->Gaji_bulanan->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            } else if ($param == 'approve') {
                $this->Gaji_bulanan->approve($id);
                $result = array('status' => 'success', 'msg' => 'Telah diapprove !');
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    public function bonusKinerja($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']           = 'Bonus Kinerja';
            $view['pageName']        = 'bonusKinerja';
            $view['getKaryawan']     = $this->Karyawan->getData();
            $view['getGajiTambahan'] = $this->Gaji_bulanan->getGajiTambahan();
            if ($param == 'getAllData') {
                $dt    = $this->Bonus_kinerja->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = $row->id;
                    $th1 = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2  = '<div style="width:70px">' . get_btn_group1('ubah("' . $id . '")', (($this->session->userdata('role') == 'administrator') || ($this->session->userdata('role') == 'keuangan' && ($row->approve_yayasan == 1)) || ($this->session->userdata('role') == 'yayasan')) ? 'hapus("' . $id . '")' : 'pesan()') .  (($this->session->userdata('role') == 'yayasan') ? get_btn_export('print("' . $id . '")') : (get_btn_export($row->approve_yayasan == 0 ? 'pesan()' : 'print("' . $id . '")'))) . '</div>';
                    $th3 =  '<div style="font-size:13px;">' . ((($this->session->userdata('role') == 'yayasan') && ($row->approve_yayasan == 0)) ? btn_approve('approve("' . $id . '")') : ($row->approve_yayasan == 0 ? '<div class="badge btn-warning" style="color:red"><li class="fa fa-close"></li> Belum diapprove</div>' : '<div class="badge bg-green" style="color:white"><li class="fa fa-arrow-right"></li> Telah diapprove</div>')) . '</div>';
                    $th4 = '<div style="font-size:12px;">' . $row->nama_karyawan . '</div>';
                    $th5 = '<div style="font-size:12px;">' . $row->nama_jabatan . '</div>';
                    $th6 = '<div style="font-size:12px;">' . tgl_indo($row->tanggal)  . '</div>';
                    $th7 = '<div style="font-size:12px;">' . ($row->nilai_kpi) . ' % </div>';
                    $th8 = '<div style="font-size:12px;">' . rupiah_format($row->jumlah_bonus) . '</div>';

                    get_btn_group1('ubah("' . $id . '")', $this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'yayasan' ? 'hapus("' . $id . '")' : 'pesan()');

                    $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Bonus_kinerja->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tanggal", "Tanggal Bonus", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("nilai_kpi", "Nilai KPI", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getGajiPokok   = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $data['id_karyawan']  = htmlspecialchars($this->input->post('id_karyawan'));
                    $data['tanggal']      = htmlspecialchars($this->input->post('tanggal'));
                    $data['nilai_kpi']    = htmlspecialchars($this->input->post('nilai_kpi'));
                    $data['jumlah_bonus'] = ($getGajiPokok[0]->gaji_pokok * ($data['nilai_kpi'] / 100));
                    $data['total_gaji']   = ($getGajiPokok[0]->total_gaji + $data['jumlah_bonus']);

                    $result['messages']      = '';
                    $getBonusKinerja = $this->Bonus_kinerja->getBonusKinerja($this->input->post('id_karyawan'));
                    if (!$getBonusKinerja) {
                        $result = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                        $this->Bonus_kinerja->addData($data);
                    } else {
                        $result = array('status' => 'error', 'msg' => 'Gagal, Bonus Kinerja karyawan sudah ditetapkan !');
                    }
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tanggal", "Tanggal Bonus", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("nilai_kpi", "Nilai KPI", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']           = htmlspecialchars($this->input->post('id'));
                    $getGajiPokok   = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $data['id_karyawan']  = htmlspecialchars($this->input->post('id_karyawan'));
                    $data['tanggal']      = htmlspecialchars($this->input->post('tanggal'));
                    $data['nilai_kpi']    = htmlspecialchars($this->input->post('nilai_kpi'));
                    $data['jumlah_bonus'] = ($getGajiPokok[0]->gaji_pokok * ($data['nilai_kpi'] / 100));
                    $data['total_gaji']   = ($getGajiPokok[0]->total_gaji + $data['jumlah_bonus']);

                    $result['messages'] = '';
                    $result     = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Bonus_kinerja->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->Bonus_kinerja->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            } else if ($param == 'approve') {
                $this->Bonus_kinerja->approve($id);
                $result = array('status' => 'success', 'msg' => 'Telah diapprove !');
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    public function bonusLebaran($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']           = 'Bonus Lebaran';
            $view['pageName']        = 'bonusLebaran';
            $view['getKaryawan']     = $this->Karyawan->getData();
            $view['getGajiTambahan'] = $this->Gaji_bulanan->getGajiTambahan();
            if ($param == 'getAllData') {
                $dt    = $this->Bonus_lebaran->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = $row->id;
                    $th1 = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2  = '<div style="width:70px">' . get_btn_group1('ubah("' . $id . '")', (($this->session->userdata('role') == 'administrator') || ($this->session->userdata('role') == 'keuangan' && ($row->approve_yayasan == 1)) || ($this->session->userdata('role') == 'yayasan')) ? 'hapus("' . $id . '")' : 'pesan()') .  (($this->session->userdata('role') == 'yayasan') ? get_btn_export('print("' . $id . '")') : (get_btn_export($row->approve_yayasan == 0 ? 'pesan()' : 'print("' . $id . '")'))) . '</div>';
                    $th3 =  '<div style="font-size:13px;">' . ((($this->session->userdata('role') == 'yayasan') && ($row->approve_yayasan == 0)) ? btn_approve('approve("' . $id . '")') : ($row->approve_yayasan == 0 ? '<div class="badge btn-warning" style="color:red"><li class="fa fa-close"></li> Belum diapprove</div>' : '<div class="badge bg-green" style="color:white"><li class="fa fa-arrow-right"></li> Telah diapprove</div>')) . '</div>';
                    $th4 = '<div style="font-size:12px;">' . $row->nama_karyawan . '</div>';
                    $th5 = '<div style="font-size:12px;">' . $row->nama_jabatan . '</div>';
                    $th6 = '<div style="font-size:12px;">' . tgl_indo($row->tanggal) . '</div>';
                    $th7 = '<div style="font-size:12px;">' . rupiah_format($row->total_gaji_bonus) . '</div>';
                    $data[]    = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Bonus_lebaran->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tanggal", "Tanggal Bonus", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getGaji            = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $data['id_karyawan']      = htmlspecialchars($this->input->post('id_karyawan'));
                    $data['tanggal']          = htmlspecialchars($this->input->post('tanggal'));
                    $data['total_gaji_bonus'] = ($getGaji[0]->gaji_pokok);
                    $result['messages']         = '';
                    $result             = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Bonus_lebaran->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tanggal", "Tanggal Bonus", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']               = htmlspecialchars($this->input->post('id'));
                    $getGaji            = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $data['id_karyawan']      = htmlspecialchars($this->input->post('id_karyawan'));
                    $data['tanggal']          = htmlspecialchars($this->input->post('tanggal'));
                    $data['total_gaji_bonus'] = ($getGaji[0]->gaji_pokok);
                    $result['messages']         = '';
                    $result             = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Bonus_lebaran->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->Bonus_lebaran->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            } else if ($param == 'approve') {
                $this->Bonus_lebaran->approve($id);
                $result = array('status' => 'success', 'msg' => 'Telah diapprove !');
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    public function bonusGuruTerbaik($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']           = 'Bonus Guru Terbaik';
            $view['pageName']        = 'bonusGuruTerbaik';
            $view['getKaryawan']     = $this->Karyawan->getData();
            $view['getGajiTambahan'] = $this->Gaji_bulanan->getGajiTambahan();
            if ($param == 'getAllData') {
                $dt    = $this->Guru_terbaik->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = $row->id;
                    $th1 = '<div style="font-size:12px;">' . ++$start . '</div>';
                    // $th2 = get_btn_group2('ubah("' . $id . '")', $this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'yayasan' ? 'hapus("' . $id . '")' : 'pesan()', 'ubahGbr("' . $id . '")') . get_btn_export($this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'yayasan' ? 'print("' . $id . '")' : 'pesan()');
                    $th2  = '<div style="width:70px">' . get_btn_group2('ubah("' . $id . '")', (($this->session->userdata('role') == 'administrator') || ($this->session->userdata('role') == 'keuangan' && ($row->approve_yayasan == 1)) || ($this->session->userdata('role') == 'yayasan')) ? 'hapus("' . $id . '")' : 'pesan()', 'ubahGbr("' . $id . '")') .  (($this->session->userdata('role') == 'yayasan') ? get_btn_export('print("' . $id . '")') : (get_btn_export($row->approve_yayasan == 0 ? 'pesan()' : 'print("' . $id . '")'))) . '</div>';
                    $th3 =  '<div style="font-size:13px;">' . ((($this->session->userdata('role') == 'yayasan') && ($row->approve_yayasan == 0)) ? btn_approve('approve("' . $id . '")') : ($row->approve_yayasan == 0 ? '<div class="badge btn-warning" style="color:red"><li class="fa fa-close"></li> Belum diapprove</div>' : '<div class="badge bg-green" style="color:white"><li class="fa fa-arrow-right"></li> Telah diapprove</div>')) . '</div>';
                    $th4 = '<div style="font-size:12px;">' . $row->nama_karyawan . '</div>';
                    $th5 = '<div style="font-size:12px;">' . tgl_indo($row->tanggal) . '</div>';
                    $th6 = empty($row->upload_portofolio) ? btn_uploadGbr('ubahGbr("' . $id . '")') . '<br> <div class="text-center"><small style="color:blue;" >Silahkan Upload dokumen !</small></div>' : '<div style="font-size:12px;"><img src="../gambar/' . $row->upload_portofolio . '" width="100px" height=""></div>';
                    $th7 = '<div style="font-size:12px;">' . $row->keterangan . '</div>';
                    $th8 = '<div style="font-size:12px;">' . rupiah_format($row->jumlah_bonus) . '</div>';
                    $data[]    = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6, $th7, $th8));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Guru_terbaik->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'tambahData') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("keterangan", "Keterangan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jumlah_bonus", "Jumlah Bonus", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getGaji        = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $db['id_karyawan']  = htmlspecialchars($this->input->post('id_karyawan'));
                    $db['tanggal']      = htmlspecialchars($this->input->post('tanggal'));
                    $db['keterangan']   = htmlspecialchars($this->input->post('keterangan'));
                    $db['jumlah_bonus'] = htmlspecialchars($this->input->post('jumlah_bonus'));
                    $db['total_gaji']   = ($getGaji[0]->total_gaji + $db['jumlah_bonus']);
                    $result['messages']     = '';
                    $result         = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Guru_terbaik->addData($db);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'addData') {
                $config['upload_path']   = "./gambar";
                $config['allowed_types'] = 'gif|jpg|png|jpeg|png|bmp';
                $config['remove_spaces'] = TRUE;
                if (!empty($_FILES['upload_portofolio']['name'])) {
                    $this->load->library('upload', $config);
                    $getGaji = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));

                    $db['upload_portofolio'] = $_FILES['upload_portofolio']['name'];
                    $db['id_karyawan']       = htmlspecialchars($this->input->post('id_karyawan'));
                    $db['tanggal']           = htmlspecialchars($this->input->post('tanggal'));
                    $db['keterangan']        = htmlspecialchars($this->input->post('keterangan'));
                    $db['jumlah_bonus']      = htmlspecialchars($this->input->post('jumlah_bonus'));
                    $db['total_gaji']        = ($getGaji[0]->total_gaji + $db['jumlah_bonus']);

                    $cekData = $this->Guru_terbaik->getData();
                    if ($cekData[0]->upload_portofolio != $db['upload_portofolio']) {
                        $this->Guru_terbaik->simpan_upload(str_replace(' ', '_', $db['upload_portofolio']), $db['id_karyawan'], $db['tanggal'], $db['keterangan'], $db['jumlah_bonus'], $db['total_gaji']);
                        $this->upload->do_upload('upload_portofolio');
                        $this->session->set_flashdata('alert', 'Berhasil Mengupload Data !');
                        redirect('administrator/bonusGuruTerbaik');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal Mengupload Data, Gambar yang anda pilih sudah ada!');
                        redirect('administrator/bonusGuruTerbaik');
                    }
                }
            } else if ($param == 'update') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("keterangan", "Keterangan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jumlah_bonus", "Jumlah Bonus", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getGaji = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));

                    $db['id']           = htmlspecialchars($this->input->post('id'));
                    $db['id_karyawan']  = htmlspecialchars($this->input->post('id_karyawan'));
                    $db['tanggal']      = htmlspecialchars($this->input->post('tanggal'));
                    $db['keterangan']   = htmlspecialchars($this->input->post('keterangan'));
                    $db['jumlah_bonus'] = htmlspecialchars($this->input->post('jumlah_bonus'));
                    $db['total_gaji']   = ($getGaji[0]->total_gaji + $db['jumlah_bonus']);
                    $result['messages']     = '';
                    $result         = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Guru_terbaik->update($db['id'], $db);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'updateGbr') {
                $config['upload_path']   = "./gambar";
                $config['allowed_types'] = 'gif|jpg|png|jpeg|png|bmp';
                $config['remove_spaces'] = TRUE;
                if (!empty($_FILES['upload_portofolio']['name'])) {
                    $this->load->library('upload', $config);
                    $getGaji             = $this->Gaji_bulanan->getGajiKar($this->input->post('id_karyawan'));
                    $db['id']                = htmlspecialchars($this->input->post('id'));
                    $db['upload_portofolio'] = $_FILES['upload_portofolio']['name'];
                    $cekData             = $this->Guru_terbaik->getData();
                    if ($cekData[0]->upload_portofolio != str_replace(' ', '_', $db['upload_portofolio'])) {
                        $this->Guru_terbaik->updateGbr($db['id'], str_replace(' ', '_', $db['upload_portofolio']));
                        $this->upload->do_upload('upload_portofolio');

                        redirect('administrator/bonusGuruTerbaik');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal Mengupload Data, Gambar yang anda pilih sudah ada !');
                        redirect('administrator/bonusGuruTerbaik');
                    }
                }
            } else if ($param == 'delete') {
                $this->Guru_terbaik->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            } else if ($param == 'approve') {
                $this->Guru_terbaik->approve($id);
                $result = array('status' => 'success', 'msg' => 'Telah diapprove !');
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    public function golongan($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']       = 'Golongan Gaji';
            $view['pageName']    = 'golonganGaji';
            $view['getJabatan']  = $this->Jabatan->getData();
            $view['getGolongan'] = $this->Tingkat_jabatan->getData();

            if ($param == 'getAllData') {
                $dt    = $this->Golongan->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id   = $row->id;
                    $th1  = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2  = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                    $th3  = '<div style="font-size:12px;">' . ($row->level) . '</div>';
                    $th4  = '<div style="font-size:12px;">' . ($row->nama_golongan) . '</div>';
                    $th5  = '<div style="font-size:12px;">' . ($row->nama_jabatan) . '</div>';
                    $th6  = '<div style="font-size:12px;">' . rupiah_format($row->jumlah_gaji_pokok) . '</div>';
                    $th7  = '<div style="font-size:12px;">' . rupiah_format($row->t_jalan_jalan) . '</div>';
                    $th8  = '<div style="font-size:12px;">' . rupiah_format($row->t_kesehatan) . '</div>';
                    $th9  = '<div style="font-size:12px;">' . rupiah_format($row->t_pelatihan) . '</div>';
                    $th10 = '<div style="font-size:12px;">' . rupiah_format($row->t_cuti_tahunan) . '</div>';
                    $th11 = '<div style="font-size:12px;">' . rupiah_format($row->t_study_banding) . '</div>';
                    $th12 = '<div style="font-size:12px;">' . rupiah_format($row->t_umroh) . '</div>';
                    $th13 = '<div style="font-size:12px;">' . rupiah_format($row->kenaikan_gaji_20_persen) . '</div>';
                    $th14 = '<div style="font-size:12px;">' . rupiah_format($row->total_gaji) . '</div>';
                    $th15 = '<div style="font-size:12px;">' . tgl_indo($row->create_date) . '</div>';
                    $data[]     = gathered_data(array($th1, $th2, $th3, $th4, $th6, $th7, $th8, $th9, $th10, $th11, $th12, $th13, $th14, $th15));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Golongan->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("level", "Level", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jumlah_gaji_pokok", "Jumlah Gaji Pokok", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_jalan_jalan", "Tunjangan Jalan-jalan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_kesehatan", "Tunjangan Kesehatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_pelatihan", "Tunjangan Pelatihan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_cuti_tahunan", "Tunjangan cuti Tahunan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_study_banding", "Tunjangan Study Banding", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_umroh", "Tunjangan Umroh", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("kenaikan_gaji_20_persen", "Kenaikan Gaji 20%", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_tingkat_jabatan", "Tingkat Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getTingkatJabatan         = $this->Jabatan->getByIdTingkatJabatan($this->input->post('id_tingkat_jabatan'));
                    $data['level']                   = htmlspecialchars($this->input->post('level'));
                    $data['jumlah_gaji_pokok']       = htmlspecialchars($this->input->post('jumlah_gaji_pokok'));
                    $data['t_jalan_jalan']           = htmlspecialchars($this->input->post('t_jalan_jalan'));
                    $data['t_pelatihan']             = htmlspecialchars($this->input->post('t_pelatihan'));
                    $data['t_kesehatan']             = htmlspecialchars($this->input->post('t_kesehatan'));
                    $data['t_cuti_tahunan']          = htmlspecialchars($this->input->post('t_cuti_tahunan'));
                    $data['t_study_banding']         = htmlspecialchars($this->input->post('t_study_banding'));
                    $data['t_umroh']                 = htmlspecialchars($this->input->post('t_umroh'));
                    $data['kenaikan_gaji_20_persen'] = htmlspecialchars($this->input->post('kenaikan_gaji_20_persen'));
                    $data['total_gaji']              = ($data['jumlah_gaji_pokok'] + $data['t_jalan_jalan'] + $data['t_kesehatan'] + $data['t_pelatihan'] + $data['t_cuti_tahunan'] + $data['t_study_banding'] + $data['t_umroh'] +  $data['kenaikan_gaji_20_persen']);
                    // $data['id_jabatan']              =  $getTingkatJabatan->id;
                    $data['id_tingkat_jabatan'] = htmlspecialchars($this->input->post('id_tingkat_jabatan'));
                    $data['create_date']        = $this->input->post('create_date');
                    $result['messages']           = '';
                    $getTingkatJabatan    = $this->Jabatan->getById($this->input->post('id_jabatan'));
                    $result               = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Golongan->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("level", "Level", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jumlah_gaji_pokok", "Jumlah Gaji Pokok", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_jalan_jalan", "Tunjangan Jalan-jalan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_kesehatan", "Tunjangan Kesehatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_pelatihan", "Tunjangan Pelatihan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_cuti_tahunan", "Tunjangan cuti Tahunan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_study_banding", "Tunjangan Study Banding", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("t_umroh", "Tunjangan Umroh", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("kenaikan_gaji_20_persen", "Kenaikan Gaji 20%", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_tingkat_jabatan", "Tingkat Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']                      = htmlspecialchars($this->input->post('id'));
                    $data['level']                   = htmlspecialchars($this->input->post('level'));
                    $data['jumlah_gaji_pokok']       = htmlspecialchars($this->input->post('jumlah_gaji_pokok'));
                    $data['t_jalan_jalan']           = htmlspecialchars($this->input->post('t_jalan_jalan'));
                    $data['t_kesehatan']             = htmlspecialchars($this->input->post('t_kesehatan'));
                    $data['t_pelatihan']             = htmlspecialchars($this->input->post('t_pelatihan'));
                    $data['t_cuti_tahunan']          = htmlspecialchars($this->input->post('t_cuti_tahunan'));
                    $data['t_study_banding']         = htmlspecialchars($this->input->post('t_study_banding'));
                    $data['t_umroh']                 = htmlspecialchars($this->input->post('t_umroh'));
                    $data['kenaikan_gaji_20_persen'] = htmlspecialchars($this->input->post('kenaikan_gaji_20_persen'));
                    $data['total_gaji']              = ($data['jumlah_gaji_pokok'] + $data['t_jalan_jalan'] + $data['t_kesehatan'] + $data['t_pelatihan'] + $data['t_cuti_tahunan'] + $data['t_study_banding'] + $data['t_umroh'] + $data['kenaikan_gaji_20_persen']);
                    // $data['id_jabatan']              =  $getTingkatJabatan->id;
                    $getTingkatJabatan    = $this->Jabatan->getByIdTingkatJabatan($this->input->post('id_tingkat_jabatan'));
                    $data['id_tingkat_jabatan'] = htmlspecialchars($this->input->post('id_tingkat_jabatan'));
                    $data['create_date']        = $this->input->post('create_date');
                    $result['messages']           = '';
                    $result               = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Golongan->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $getDataKaryawan = $this->Karyawan->getByIdGolongan($id);
                if (empty($getDataKaryawan->id_golongan)) {
                    $this->Golongan->delete($id);
                    $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                } else {
                    $result = array('status' => 'error', 'msg' => 'Gagal dihapus, Data sedang digunakan !');
                }
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    function jabatan($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']             = 'Jabatan';
            $view['pageName']          = 'jabatan';
            $view['getJabatan']        = $this->Jabatan->getData();
            $view['getTingkatJabatan'] = $this->Jabatan->getTingkatJabatan();
            if ($param == 'getAllData') {
                $dt    = $this->Jabatan->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = $row->id;
                    $th1 = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2 = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                    $th3 = '<div style="font-size:12px;">' . $row->nama_jabatan . '</div>';
                    $th4 = '<div style="font-size:12px;">' . $row->tingkat_jabatan . '</div>';
                    $th5 = '<div style="font-size:12px;">' . tgl_indo($row->create_date) . '</div>';
                    $data[]    = gathered_data(array($th1, $th2, $th3, $th4, $th5));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Jabatan->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("nama_jabatan", "Nama Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tingkat_jabatan", "Tingkat Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['nama_jabatan']       = htmlspecialchars($this->input->post('nama_jabatan'));
                    $data['id_tingkat_jabatan'] = htmlspecialchars($this->input->post('tingkat_jabatan'));
                    $data['create_date']        = htmlspecialchars($this->input->post('create_date'));
                    $result['messages']           = '';
                    $result               = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Jabatan->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("nama_jabatan", "Nama Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("tingkat_jabatan", "Tingkat Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']                 = htmlspecialchars($this->input->post('id'));
                    $data['nama_jabatan']       = htmlspecialchars($this->input->post('nama_jabatan'));
                    $data['id_tingkat_jabatan'] = htmlspecialchars($this->input->post('tingkat_jabatan'));
                    $data['create_date']        = htmlspecialchars($this->input->post('create_date'));
                    $result['messages']           = '';
                    $result               = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Jabatan->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $cekJabatan = $this->Jabatan->getIdJabByGolongan($id);
                if (empty($cekJabatan)) {
                    $this->Jabatan->delete($id);
                    $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                } else {
                    $result = array('status' => 'error', 'msg' => 'Gagal, Dokumen sedang digunakan oleh data golongan!');
                }
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    function tingkatJabatan($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']      = 'Tingkat Jabatan';
            $view['pageName']   = 'tingkatJabatan';
            $view['getJabatan'] = $this->Tingkat_jabatan->getData();
            if ($param == 'getAllData') {
                $dt    = $this->Tingkat_jabatan->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = $row->id;
                    $th1 = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2 = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                    $th3 = '<div style="font-size:12px;">' . $row->nama . '</div>';
                    $th4 = '<div style="font-size:12px;">' . tgl_indo($row->create_date) . '</div>';
                    $data[]    = gathered_data(array($th1, $th2, $th3, $th4));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Tingkat_jabatan->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("nama", "Nama Tingkatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['nama']        = htmlspecialchars($this->input->post('nama'));
                    $data['create_date'] = htmlspecialchars($this->input->post('create_date'));
                    $result['messages']    = '';
                    $result        = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Tingkat_jabatan->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("nama", "Nama Tingkatan", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']          = htmlspecialchars($this->input->post('id'));
                    $data['nama']        = htmlspecialchars($this->input->post('nama'));
                    $data['create_date'] = htmlspecialchars($this->input->post('create_date'));
                    $result['messages']    = '';
                    $result        = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Tingkat_jabatan->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->Tingkat_jabatan->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    function karyawan($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']          = 'Karyawan';
            $view['pageName']       = 'karyawan';
            $view['getJabatan']     = $this->Jabatan->getData();
            $view['getGolongan']    = $this->Golongan->getDataGolongan();
            $view['getDataGol']     = $this->Golongan->getData();
            $view['getGenderWoman'] = $this->Karyawan->getGender('PR');
            $view['getGenderMan']   = $this->Karyawan->getGender('LK');

            if ($param == 'getAllData') {
                $dt    = $this->Karyawan->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = $row->id_karyawan;
                    $th1 = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2 = get_btn_group1('ubah("' . $id . '")', 'hapus("' . $id . '")');
                    // $th3  = '<div style="font-size:12px;">' . $row->role . '</div>';
                    $th4  = '<div style="font-size:12px;">' . $row->nama_karyawan . '</div>';
                    $th5  = '<div style="font-size:12px;">' . $row->tgl_lahir . '</div>';
                    $th6  = '<div style="font-size:12px;">' . $row->jk . '</div>';
                    $th7  = '<div style="font-size:12px;">' . ($row->email) . '</div>';
                    $th8  = '<div style="font-size:12px;">' . ($row->no_hp) . '</div>';
                    $th9  = '<div style="font-size:12px;">' . ($row->alamat) . '</div>';
                    $th10 = '<div style="font-size:12px;">' . ($row->nama_jabatan) . '</div>';
                    $th11 = '<div style="font-size:12px;">' . ($row->jurusan) . '</div>';
                    $th12 = '<div style="font-size:12px;">' . ($row->universitas) . '</div>';
                    $th13 = '<div style="font-size:12px;">' . ($row->pendidikan_terakhir) . '</div>';
                    $th14 = '<div style="font-size:12px;">' . ($row->tahun_masuk) . '</div>';
                    $th15 = '<div style="font-size:12px;">' . ($row->status) . '</div>';
                    $th16 = '<div style="font-size:12px;">' . ($row->gambar) . '</div>';
                    $th17 = '<div style="font-size:12px;">' . ($row->level) . '</div>';
                    $th18 = '<div style="font-size:12px;">' . rupiah_format($row->gaji_pokok) . '</div>';
                    $th19 = '<div style="font-size:12px;">' . rupiah_format($row->total_gaji) . '</div>';

                    $th20 = '<div style="font-size:12px;">' . tgl_indo($row->create_date) . '</div>';
                    $data[]     = gathered_data(array($th1, $th2, $th4, $th5, $th6, $th7, $th8, $th9, $th10, $th11, $th12, $th13, $th14, $th15, $th16, $th17, $th18, $th19, $th20));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Karyawan->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("nama_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jk", "Jenis Kelamin", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_jabatan", "Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("status", "Status", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_golongan", "Golongan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $getGolongan = $this->Golongan->getGajiByGolongan($this->input->post('id_golongan'));
                    // $data['role']                = htmlspecialchars($this->input->post('role'));
                    $data['nama_karyawan']       = htmlspecialchars($this->input->post('nama_karyawan'));
                    $data['tgl_lahir']           = htmlspecialchars($this->input->post('tgl_lahir'));
                    $data['jk']                  = htmlspecialchars($this->input->post('jk'));
                    $data['email']               = htmlspecialchars($this->input->post('email'));
                    $data['no_hp']               = htmlspecialchars($this->input->post('no_hp'));
                    $data['alamat']              = htmlspecialchars($this->input->post('alamat'));
                    $data['id_jabatan']          = htmlspecialchars($this->input->post('id_jabatan'));
                    $getTingkatJabatan = $this->Karyawan->getIdTingkatJabatanByIdJabatan($data['id_jabatan']);
                    $data['id_tingkat_jabatan']  = $getTingkatJabatan[0]->id_tingkat_jabatan;
                    $data['jurusan']             = htmlspecialchars($this->input->post('jurusan'));
                    $data['universitas']         = htmlspecialchars($this->input->post('universitas'));
                    $data['pendidikan_terakhir'] = htmlspecialchars($this->input->post('pendidikan_terakhir'));
                    $data['tahun_masuk']         = htmlspecialchars($this->input->post('tahun_masuk'));
                    $data['status']              = htmlspecialchars($this->input->post('status'));
                    $data['gambar']              = htmlspecialchars($this->input->post('gambar'));
                    $data['id_golongan']         = htmlspecialchars($this->input->post('id_golongan'));
                    $data['gaji_pokok']          = $getGolongan[0]->jumlah_gaji_pokok;
                    $data['total_gaji']          = $getGolongan[0]->total_gaji;
                    $data['create_date']         = $this->input->post('create_date');
                    $result['messages']            = '';
                    $result                = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->Karyawan->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                // $this->form_validation->set_rules("role", "Role Pengguna", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("nama_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("jk", "Jenis Kelamin", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_jabatan", "Jabatan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("status", "Status", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("id_golongan", "Golongan", "trim|required", array('required' => '{field} Wajib diisi !'));

                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id_karyawan'] = $this->input->post('id_karyawan');
                    $getGolongan   = $this->Golongan->getGajiByGolongan($this->input->post('id_golongan'));
                    // $data['role']                = htmlspecialchars($this->input->post('role'));
                    $data['nama_karyawan']       = htmlspecialchars($this->input->post('nama_karyawan'));
                    $data['tgl_lahir']           = htmlspecialchars($this->input->post('tgl_lahir'));
                    $data['jk']                  = htmlspecialchars($this->input->post('jk'));
                    $data['email']               = htmlspecialchars($this->input->post('email'));
                    $data['no_hp']               = htmlspecialchars($this->input->post('no_hp'));
                    $data['alamat']              = htmlspecialchars($this->input->post('alamat'));
                    $data['id_jabatan']          = htmlspecialchars($this->input->post('id_jabatan'));
                    $getTingkatJabatan = $this->Karyawan->getIdTingkatJabatanByIdJabatan($data['id_jabatan']);
                    $data['id_tingkat_jabatan']  = $getTingkatJabatan[0]->id_tingkat_jabatan;
                    $data['jurusan']             = htmlspecialchars($this->input->post('jurusan'));
                    $data['universitas']         = htmlspecialchars($this->input->post('universitas'));
                    $data['pendidikan_terakhir'] = htmlspecialchars($this->input->post('pendidikan_terakhir'));
                    $data['tahun_masuk']         = htmlspecialchars($this->input->post('tahun_masuk'));
                    $data['status']              = htmlspecialchars($this->input->post('status'));
                    $data['gambar']              = htmlspecialchars($this->input->post('gambar'));
                    $data['id_golongan']         = htmlspecialchars($this->input->post('id_golongan'));
                    $data['gaji_pokok']          = $getGolongan[0]->jumlah_gaji_pokok;
                    $data['total_gaji']          = $getGolongan[0]->total_gaji;
                    $data['create_date']         = $this->input->post('create_date');
                    $result['messages']            = '';
                    $result                = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->Karyawan->update($data['id_karyawan'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $getKenaikanGaji               = $this->Kenaikan_gaji->getKenaikanGajiByIdKaryawan($id);
                $getIdKenaikanGajiByIdKaryawan = $this->Kenaikan_gaji->getIdKenaikanGajiByIdKaryawan($id);
                // if ($getKenaikanGaji) {
                $result = array('status' => 'error', 'msg' => 'Gagal dihapus, Data sedang digunakan untuk data kenaikan gaji !');
                // } else {
                $this->Karyawan->delete($id);
                if (!empty($getKenaikanGaji)) {
                    $this->Kenaikan_gaji->delete($getIdKenaikanGajiByIdKaryawan->id);
                }
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                // }
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    public function slipGajiBulanan($id)
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $this->load->library('pdfgenerator');
            $view['getSlipGaji'] = $this->Gaji_bulanan->getSlipGaji($id);
            $this->load->view('page_admin/slipGajiBulanan', $view);
        }
    }

    public function slipBonusGuruTerbaik($id)
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $this->load->library('pdfgenerator');
            $view['getSlipGaji'] = $this->Guru_terbaik->getSlipGaji($id);
            $this->load->view('page_admin/slipBonusGuruTerbaik', $view);
        }
    }

    public function slipBonusKinerja($id)
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $this->load->library('pdfgenerator');
            $view['getSlipGaji'] = $this->Bonus_kinerja->getSlipGaji($id);
            $this->load->view('page_admin/slipBonusKinerja', $view);
        }
    }

    public function slipBonusLebaran($id)
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $this->load->library('pdfgenerator');
            $view['getSlipGaji'] = $this->Bonus_lebaran->getSlipGaji($id);
            $this->load->view('page_admin/slipBonuslebaran', $view);
        }
    }

    public function slipKenaikanGaji($id)
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $this->load->library('pdfgenerator');
            $view['getSlipGaji'] = $this->Kenaikan_gaji->getSlipGaji($id);
            $this->load->view('page_admin/slipKenaikanGaji', $view);
        }
    }

    function kenaikanGaji($param = '', $id = '')
    {
        $userOnById = $this->User->getOnlineUserById($this->session->userdata('id'));
        $temp       = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else if (count_time_since(strtotime($userOnById[0]->time_online)) > 7100) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['title']       = 'Kenaikan Gaji';
            $view['pageName']    = 'kenaikanGaji';
            $view['getJabatan']  = $this->Kenaikan_gaji->getData();
            $view['getKaryawan'] = $this->Karyawan->getData();
            if ($param == 'getAllData') {
                $dt    = $this->Kenaikan_gaji->getAllData();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = $row->id;
                    $th1 = '<div style="font-size:12px;">' . ++$start . '</div>';
                    $th2 = get_btn_group1('ubah("' . $id . '")', $this->session->userdata('role') == 'administrator' || $this->session->userdata('role') == 'yayasan' ? 'hapus("' . $id . '")' : 'pesan()');
                    $th3 = '<div style="font-size:12px;">' . $row->nama_karyawan . '</div>';
                    $th4 = '<div style="font-size:12px;">' . $row->persentase . ' % </div>';
                    $th5 = '<div style="font-size:12px;">' . rupiah_format($row->jumlah_kenaikan) . '</div>';
                    $th6 = '<div style="font-size:12px;">' . rupiah_format($row->total_gaji) . '</div>';
                    $data[]    = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'getById') {
                $data = $this->Kenaikan_gaji->getById($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("persentase", "Persentase Kenaikan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id_karyawan']     = htmlspecialchars($this->input->post('id_karyawan'));
                    $gajiKaryawan      = $this->Karyawan->getDataKaryawanById($data['id_karyawan']);
                    $data['persentase']      = htmlspecialchars($this->input->post('persentase'));
                    $data['jumlah_kenaikan'] = $gajiKaryawan[0]->gaji_pokok * ($data['persentase'] / 100);
                    $data['total_gaji']      = ($gajiKaryawan[0]->gaji_pokok + $data['jumlah_kenaikan']);

                    $data_karyawan['gaji_pokok'] = $data['total_gaji'];

                    $result['messages'] = '';
                    // Function to get Data Karyawan
                    $getIdKaryawan      = $this->Kenaikan_gaji->getByIdKaryawan($data['id_karyawan']);
                    $getTotGajiKaryawan = ($gajiKaryawan[0]->total_gaji + $data['jumlah_kenaikan']);
                    if ($getIdKaryawan) {
                        $result = array('status' => 'error', 'msg' => 'Data Gagal di record atau data sudah ada !');
                    } else {
                        $result = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                        $this->Kenaikan_gaji->addData($data);
                        $this->Karyawan->updateGaji($data['id_karyawan'], $data_karyawan['gaji_pokok'], $getTotGajiKaryawan);
                    }
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("id_karyawan", "Nama Karyawan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("persentase", "Persentase Kenaikan", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']               = htmlspecialchars($this->input->post('id'));
                    $kenaikanGaji       = $this->Kenaikan_gaji->getById($data['id']);
                    $data['id_karyawan']      = htmlspecialchars($this->input->post('id_karyawan'));
                    $getDataGaji        = $this->Karyawan->getDataKaryawanById($data['id_karyawan']);
                    $data['persentase']       = htmlspecialchars($this->input->post('persentase'));
                    $data['jumlah_kenaikan']  = $getDataGaji[0]->gaji_pokok * ($data['persentase'] / 100);
                    $data['total_gaji']       = (($getDataGaji[0]->gaji_pokok + $data['jumlah_kenaikan']) - $kenaikanGaji->jumlah_kenaikan);
                    $result['messages']         = '';
                    $result             = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $data_karyawan['gaji_pokok']       = (($getDataGaji[0]->gaji_pokok + $data['jumlah_kenaikan']) - $kenaikanGaji->jumlah_kenaikan);
                    $getTotGajiKaryawan = (($getDataGaji[0]->total_gaji + $data['jumlah_kenaikan']) - $kenaikanGaji->jumlah_kenaikan);
                    $this->Karyawan->updateGaji($data['id_karyawan'], $data_karyawan['gaji_pokok'], $getTotGajiKaryawan);
                    $this->Kenaikan_gaji->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $getData    = $this->Kenaikan_gaji->getById($id);
                $getByIdKar = $this->Kenaikan_gaji->getKenaikanGajiByIdKaryawan($getData->id_karyawan);
                if (!$getByIdKar) {
                    $this->Kenaikan_gaji->delete($id);
                    $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                } else {
                    $result = array('status' => 'error', 'msg' => 'Gagal dihapus, data sedang digunakan !');
                }
                echo json_encode(array('result' => $result));
                die;
            }
            $this->load->view('index', $view);
        }
    }

    public function reportGajiBulanan($param = '', $id = '')
    {
        # code...
    }

    public function pengguna($param = '', $id = '')
    {
        $temp = $this->User->getuserById($this->session->userdata('id'));
        if (!$this->session->userdata('loggedIn')) {
            $this->session->set_flashdata('result_login', 'Silahkan Log in untuk mengakses sistem !');
            redirect('/auth/');
        } else if ($temp[0]->online_status != "online") {
            $this->session->set_flashdata('result_login', 'Silahkan Log in kembali untuk mengakses sistem !');
            redirect('auth/force_logout');
        } else {
            $view['pageName']    = 'pengguna';
            $view['title']       = 'Data Pengguna Sistem';
            $view['getKaryawan'] = $this->Karyawan->getData();
            if ($param == 'getAllData') {
                $dt    = $this->User->get_all_data_ajax();
                $start = $this->input->post('start');
                $data  = array();
                foreach ($dt['data'] as $row) {
                    $id  = ($row->id);
                    $th1 = ++$start;
                    $th2 = get_btn_group1('ubah(' . $id . ')', 'hapus(' . $id . ')');
                    $th3 = $row->first_name;
                    // $th4 = $row->last_name;
                    $th4 = '<i>' . $row->username . '</i>';
                    $th5 = $row->role;
                    $data[]    = gathered_data(array($th1, $th2, $th3, $th4, $th5));
                }
                $dt['data'] = $data;
                echo json_encode($dt);
                die;
            } else if ($param == 'addData') {
                $this->form_validation->set_rules("first_name", "First Name", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("username", "Username", "trim|required|is_unique[users.username]", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("password", "Password", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("role", "Role", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi Belum Benar!');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['first_name'] = htmlspecialchars($this->input->post('first_name'));
                    $data['username']   = htmlspecialchars($this->input->post('username'));
                    $data['password']   = md5($this->input->post('password'));
                    $data['role']       = htmlspecialchars($this->input->post('role'));
                    $result['messages']   = '';
                    $result       = array('status' => 'success', 'msg' => 'Data berhasil dikirimkan');
                    $this->User->addData($data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'getById') {
                $data = $this->User->get_by_id($id);
                echo json_encode(array('data' => $data));
                die;
            } else if ($param == 'update') {
                $this->form_validation->set_rules("first_name", "First Name", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("username", "Username", "trim|required", array('required' => '{field} Wajib diisi !'));
                // $this->form_validation->set_rules("password", "Password", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_rules("role", "Role", "trim|required", array('required' => '{field} Wajib diisi !'));
                $this->form_validation->set_error_delimiters('<small id="text-error" style="color:red;">*', '</small>');
                if ($this->form_validation->run() == FALSE) {
                    $result = array('status' => 'error', 'msg' => 'Data yang anda isi belum benar !');
                    foreach ($_POST as $key => $value) {
                        $result['messages'][$key] = form_error($key);
                    }
                } else {
                    $data['id']         = ($this->input->post('id'));
                    $data['first_name'] = htmlspecialchars($this->input->post('first_name'));
                    $data['username']   = htmlspecialchars($this->input->post('username'));
                    // $data['password']     = md5($this->input->post('password'));
                    $data['role']     = htmlspecialchars($this->input->post('role'));
                    $result['messages'] = '';
                    $result     = array('status' => 'success', 'msg' => 'Data Berhasil diubah');
                    $this->User->update($data['id'], $data);
                }
                $csrf = array(
                    'token' => $this->security->get_csrf_hash()
                );
                echo json_encode(array('result' => $result, 'csrf' => $csrf));
                die;
            } else if ($param == 'delete') {
                $this->User->delete($id);
                $result = array('status' => 'success', 'msg' => 'Data berhasil dihapus !');
                echo json_encode(array('result' => $result));
                die;
            }

            $this->load->view('index', $view);
        }
    }
}

/* End of file Administrator.php */
