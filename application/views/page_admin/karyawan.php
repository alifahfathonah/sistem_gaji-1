<!-- <style>
    #chartdiv {
        width: 40%;
        height: 200px;
    }
    /** 
 * @Author: fitra 
 * @Date: 2021-01-23 23:25:18 
 * @Desc: This system is created by fitra arrafiq(fitraarrafiq@gmail.com) 
 * Hukum Copyright berlaku sejak sistem ini mulai dikembangkan.
 */
 
</style> -->

<!-- Resources -->
<!-- <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" /> -->

<!-- Chart code -->
<!-- <script>
    var chart = AmCharts.makeChart("chartdiv", {
        "type": "pie",
        "theme": "none",
        "dataProvider": [{
            "country": "Perempuan",
            "litres": <?php echo $getGenderWoman[0]->tot_gender; ?>
        }, {
            "country": "Laki-laki",
            "litres": <?php echo $getGenderMan[0]->tot_gender; ?>
        }, ],
        "valueField": "litres",
        "titleField": "country",
        "balloon": {
            "fixedPosition": true
        },
        "export": {
            "enabled": false
        }
    });
</script> -->

<script>
    console.log('');
    document.addEventListener("DOMContentLoaded", function(event) {
        table = $('#data').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "responsive": true,
            "dataType": 'JSON',
            // "dom": 'Bfrtip',
            // "buttons": [
            //     'excel',
            //     'pdf',
            //     'print'
            // ],
            "ajax": {
                "url": "<?php echo site_url('administrator/karyawan/getAllData') ?>",
                "type": "POST",
                "data": {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "center"
            }]
        });
    });

    var save_method;

    function updateAllTable() {
        table.ajax.reload();
    }

    function tambah() {
        save_method = 'add';
        $('#form_inputan')[0].reset();
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $('#modal').modal('show');
        $('.reset').show();
    }

    function ubah(id) {
        save_method = 'update';
        $('#form_inputan')[0].reset();
        $('#modal').modal('show');
        $('.form-group').removeClass('has-error')
            .removeClass('has-success')
            .find('#text-error').remove();
        $.ajax({
            url: "<?php echo site_url('administrator/karyawan/getById/'); ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(resp) {
                data = resp.data
                $('[name="id_karyawan"]').val(data.id_karyawan);
                $('[name="role"]').val(data.role);
                $('[name="nama_karyawan"]').val(data.nama_karyawan);
                $('[name="tgl_lahir"]').val(data.tgl_lahir);
                $('[name="jk"]').val(data.jk);
                $('[name="email"]').val(data.email);
                $('[name="password"]').val(data.password);
                $('[name="no_hp"]').val(data.no_hp);
                $('[name="alamat"]').val(data.alamat);
                $('[name="id_jabatan"]').val(data.id_jabatan);
                $('[name="jurusan"]').val(data.jurusan);
                $('[name="universitas"]').val(data.universitas);
                $('[name="pendidikan_terakhir"]').val(data.pendidikan_terakhir);
                $('[name="tahun_masuk"]').val(data.tahun_masuk);
                $('[name="status"]').val(data.status);
                $('[name="gambar"]').val(data.gambar);
                $('[name="id_golongan"]').val(data.id_golongan);
                $('[name="create_date"]').val(data.create_date);
                $('.reset').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error Get Data From Ajax');
            }
        });

    }

    function hapus(id) {
        swal({
                title: "Apakah Yakin Akan Dihapus?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: "Ya",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: "<?php echo site_url('administrator/karyawan/delete'); ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    success: function(resp) {
                        data = resp.result;
                        updateAllTable();
                        return swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            type: data['status']
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error Deleting Data');
                    }
                });
            });
    }

    function cekJabGol() {
        <?php if (empty($getJabatan)) { ?>
            alert('Anda tidak dapat mengisi data karyawan, karena data jabatan tidak ditemukan sama sekali, silahkan isi data jabatan terlebih dahulu !');
            window.location = '<?php echo base_url('administrator/jabatan') ?>';
        <?php } else if (empty($getGolongan)) { ?>
            alert('Anda tidak dapat mengisi data karyawan, karena data golongan tidak ditemukan sama sekali, silahkan isi data golongan terlebih dahulu !');
            window.location = '<?php echo base_url('administrator/golongan') ?>';
        <?php } else { ?>
            tambah();
        <?php } ?>
    }

    function simpan() {
        var token_name = '<?php echo $this->security->get_csrf_token_name(); ?>'
        var csrf_hash = ''
        var url;
        if (save_method == 'add') {
            url = '<?php echo base_url() ?>administrator/karyawan/addData';
        } else {
            url = '<?php echo base_url() ?>administrator/karyawan/update';
        }
        swal({
                title: "Apakah anda sudah yakin ?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                cancelButtonText: "Kembali",
                confirmButtonText: "Ya",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $('#form_inputan').serialize(),
                    dataType: "JSON",
                    success: function(resp) {
                        data = resp.result
                        csrf_hash = resp.csrf['token'];
                        $('#form_inputan input[name=' + token_name + ']').val(csrf_hash);
                        if (data['status'] == 'success') {
                            updateAllTable();
                            $('.form-group').removeClass('has-error')
                                .removeClass('has-success')
                                .find('#text-error').remove();
                            $("#form_inputan")[0].reset();
                            $('#modal').modal('hide');
                        } else {
                            $.each(data['messages'], function(key, value) {
                                var element = $('#' + key);
                                element.closest('div.form-group')
                                    .removeClass('has-error')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success')
                                    .find('#text-error')
                                    .remove();
                                element.after(value);
                            });
                        }
                        swal({
                            html: true,
                            timer: 1300,
                            showConfirmButton: false,
                            title: data['msg'],
                            type: data['status']
                        });
                    }

                });
            });
    }
</script>

<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <div id="chartdiv"></div>
                <h2>Data Karyawan</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <button class="btn btn-primary btn-sm" type="button" onclick="cekJabGol();">
                    <li class="fa fa-plus"></li> Tambah Data</button>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>

                </ul>
                <div class="text-right">
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="data" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="font-size: 10px;">No</th>
                                        <th style="font-size: 10px;">Tools</th>
                                        <!-- <th style="font-size: 10px;">Role</th> -->
                                        <th style="font-size: 10px;">Nama Karyawan</th>
                                        <th style="font-size: 10px;">Tanggal Lahir</th>
                                        <th style="font-size: 10px;">Jenis Kelamin</th>
                                        <th style="font-size: 10px;">Email</th>
                                        <th style="font-size: 10px;">No Hp</th>
                                        <th style="font-size: 10px;">Alamat</th>
                                        <th style="font-size: 10px;">Nama Jabatan</th>
                                        <th style="font-size: 10px;">Jurusan</th>
                                        <th style="font-size: 10px;">Universitas</th>
                                        <th style="font-size: 10px;">Pendidikan Terakhir</th>
                                        <th style="font-size: 10px;">Tahun Masuk</th>
                                        <th style="font-size: 10px;">Status</th>
                                        <th style="font-size: 10px;">Foto</th>
                                        <th style="font-size: 10px;"> Golongan</th>
                                        <th style="font-size: 10px;">Gaji Pokok</th>
                                        <th style="font-size: 10px;">Gaji Keseluruhan</th>
                                        <th style="font-size: 10px;">Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <li class="fa fa-list"></li> Form Data Karyawan
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php echo form_open('', array('id' => 'form_inputan', 'method' => 'post')); ?>
            <div class="modal-body">
                <?php echo form_input(array('id' => 'id_karyawan', 'name' => 'id_karyawan', 'type' => 'hidden')); ?>
                <div class="row">
                    <div class="col-md-6">
                        <!-- <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Role<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <select name="role" id="role" class="form-control has-feedback-left">
                                    <option value="">Role</option>
                                    <option value="1">Administrator</option>
                                    <option value="2">Yayasan</option>
                                    <option value="3">Pegawai</option>

                                </select>
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div> -->
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Nama Karyawan<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Tanggal Lahir<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Jenis Kelamin <span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <select name="jk" id="jk" class="form-control has-feedback-left">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="LK">Laki-laki</option>
                                    <option value="PR">Perempuan</option>
                                </select>
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Email<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="email" name="email" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">No Hp<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="no_hp" name="no_hp" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Alamat<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="alamat" name="alamat" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Jabatan<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <select name="id_jabatan" id="id_jabatan" class="form-control has-feedback-left">
                                    <option value="">Pilih Jabatan</option>
                                    <?php foreach ($getJabatan as $row) { ?>
                                        <option value="<?php echo $row->id; ?>"><?php echo $row->nama_jabatan; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Jurusan<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="jurusan" name="jurusan" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Universitas<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="universitas" name="universitas" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Pendidikan Terakhir<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Tahun Masuk<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="tahun_masuk" name="tahun_masuk" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Status<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="status" name="status" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Foto<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <input type="text" id="gambar" name="gambar" class="form-control has-feedback-left">
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Golongan<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <select name="id_golongan" id="id_golongan" class="form-control has-feedback-left">
                                    <option value="">Pilih Golongan</option>
                                    <?php foreach ($getGolongan as $r) { ?>
                                        <option value="<?php echo $r->id ?>"><?php echo $r->nama_golongan . ' (' . $r->level . ')'; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-4 col-sm-3">Create Date<span class="required">*</span></label>
                            <div class="col-md-8 xdisplay_inputx form-group row has-feedback">
                                <?php date_default_timezone_set('Asia/Jakarta'); ?>
                                <input type="date" id="create_date" name="create_date" value="<?php echo date('Y-m-d'); ?>" class="form-control has-feedback-left" readonly>
                                <span class="fa fa-file form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" onclick="simpan()">Simpan</button>

            </div>
            <?php echo form_close() ?>
        </div>

    </div>
</div>