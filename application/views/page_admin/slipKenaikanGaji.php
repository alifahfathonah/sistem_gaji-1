<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kenaikan Gaji</title>
    <style type="text/css">
        #outtable {
            padding: 20px;
            padding-left: 20px;
            /* border: 1px solid #e3e3e3; */
            width: 700px;
            border-radius: 5px;
        }

        #outtable1 {
            padding-left: 20px;
            width: 100%;
        }

        .short {
            width: 50px;
        }

        .normal {
            width: 150px;
        }

        table {
            border-collapse: collapse;
            /* color: #5E5B5C; */
        }

        thead th {
            text-align: left;
            padding: 10px;
        }

        tbody td {
            padding: 10px;
        }

        tbody tr:nth-child(even) {
            background: #F6F5FA;
        }

        tbody tr:hover {
            background: #EAE9F5
        }

        .text-right {
            padding-left: 400px;
        }

        .text-left {
            padding-left: 100px;
        }
    </style>
</head>

<body>
    <script>
        window.print();
    </script>
    <h3 style="text-align: center;">Kenaikan Gaji</h3>
    <hr>
    <hr>
    <div id="outtable">
        <table>
            <h4>Yang bertanda tangan dibawah ini :</h4>
            <thead>
                <th>
                    <tr>
                        <th>Nama Karyawan</th>
                        <td>: <?php echo $getSlipGaji[0]->nama_karyawan ?></td>
                    </tr>
                    <tr>
                        <th>Persentase Kenaikan</th>
                        <td>: <?php echo $getSlipGaji[0]->persentase ?> %</td>
                    </tr>
                    <tr>
                        <th>Jumlah Kenaikan</th>
                        <td>: <?php echo rupiah_format($getSlipGaji[0]->jumlah_kenaikan); ?></td>
                    </tr>
                    <tr>
                        <th>Total Gaji</th>
                        <td>: <?php echo rupiah_format($getSlipGaji[0]->total_gaji); ?></td>
                    </tr>
                </th>
            </thead>
            <tbody>

            </tbody>
        </table>
        <br>
        <p>Dengan ini saya bertanggung jawab apabila terdapat kesalahan. saya siap untuk mengikuti syarat dan ketentuan yang berlaku.</p>
        <br>
        <div class="text-right">
            <?php echo indo_date(date('Y-m-d')); ?> <br>Penerima,
            <br><br><br><br>
            <?php echo $getSlipGaji[0]->nama_karyawan; ?>
        </div>
    </div>
</body>

</html>