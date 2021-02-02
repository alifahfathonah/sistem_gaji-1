<style>
  #chartdiv {
    width: 100%;
    height: 400px;
    font-size: 11px;
  }

  #chartdiv1 {
    width: 100%;
    height: 400px;
    font-size: 11px;
  }
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
  var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "none",
    "categoryField": "bulan",
    "rotate": false,
    "startDuration": 1,
    "categoryAxis": {
      "gridPosition": "start",
      "position": "left"
    },
    "trendLines": [],
    "graphs": [{
        "balloonText": "keamanan:[[value]]",
        "fillAlphas": 0.8,
        "id": "AmGraph-1",
        "lineAlpha": 0.2,
        "title": "Keamanan dan Kebersihan",
        "type": "column",
        "valueField": "keamanan",
      },
      {
        "balloonText": "Administrasi:[[value]]",
        "fillAlphas": 0.8,
        "id": "AmGraph-2",
        "lineAlpha": 0.2,
        "title": "Administrasi",
        "type": "column",
        "valueField": "Administrasi"
      },
      {
        "balloonText": "Keuangan:[[value]]",
        "fillAlphas": 0.8,
        "id": "AmGraph-3",
        "lineAlpha": 0.2,
        "title": "Keuangan",
        "type": "column",
        "valueField": "Keuangan"
      },
      {
        "balloonText": "guru:[[value]]",
        "fillAlphas": 0.8,
        "id": "AmGraph-4",
        "lineAlpha": 0.2,
        "title": "guru",
        "type": "column",
        "valueField": "guru"
      },
      {
        "balloonText": "manajemen:[[value]]",
        "fillAlphas": 0.8,
        "id": "AmGraph-5",
        "lineAlpha": 0.2,
        "title": "manajemen",
        "type": "column",
        "valueField": "manajemen"
      },

    ],
    "guides": [],
    "valueAxes": [{
      "id": "ValueAxis-1",
      "position": "top",
      "axisAlpha": 0
    }],
    "allLabels": [],
    "balloon": {},
    "titles": [],
    "legend": {
      "autoMargins": true,
      "equalWidths": false,
      "horizontalGap": 10,
      "markerSize": 10,
      "useGraphSettings": true,
      "valueAlign": "left",
      "valueWidth": 0,
      "position": "top"
    },
    "dataProvider": [{
      "bulan": "<?php echo getBulan($bulan); ?>",
      "manajemen": <?php echo empty($getGajiBulananManajemen[0]->totalGaji) ? '0' : $getGajiBulananManajemen[0]->totalGaji; ?>,
      "guru": <?php echo empty($getGajiBulananGuru[0]->totalGaji) ? '0' : $getGajiBulananGuru[0]->totalGaji; ?>,
      "Keuangan": <?php echo empty($getGajiBulananKeuangan[0]->totalGaji) ? '0' : $getGajiBulananKeuangan[0]->totalGaji; ?>,
      "Administrasi": <?php echo empty($getGajiBulananAdministrasi[0]->totalGaji) ? '0' : $getGajiBulananAdministrasi[0]->totalGaji; ?>,
      "keamanan": <?php echo empty($getGajiBulananKeamananDanKebersihan[0]->totalGaji) ? '0' : $getGajiBulananKeamananDanKebersihan[0]->totalGaji; ?>
    }, ],
    "export": {
      "enabled": true
    }

  });
</script>

<!-- Chart code -->
<script>
  am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    var chart = am4core.create("chartdiv1", am4charts.XYChart);

    var data = [];

    chart.data = [
      <?php foreach ($visualizeGajiBulananPerbulan as $row) { ?> {
          "year": "<?php echo getBulan($row->bulan); ?>",
          "income": <?php echo $row->tot_gaji; ?>,
        },
      <?php } ?>
    ];

    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.ticks.template.disabled = true;
    categoryAxis.renderer.line.opacity = 0;
    categoryAxis.renderer.grid.template.disabled = true;
    categoryAxis.renderer.minGridDistance = 40;
    categoryAxis.dataFields.category = "year";
    categoryAxis.startLocation = 0.4;
    categoryAxis.endLocation = 0.6;


    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.tooltip.disabled = true;
    valueAxis.renderer.line.opacity = 0;
    valueAxis.renderer.ticks.template.disabled = true;
    valueAxis.min = 0;

    var lineSeries = chart.series.push(new am4charts.LineSeries());
    lineSeries.dataFields.categoryX = "year";
    lineSeries.dataFields.valueY = "income";
    lineSeries.tooltipText = "Total Gaji Bulan {year} : {valueY.value}";
    lineSeries.fillOpacity = 0.5;
    lineSeries.strokeWidth = 3;
    lineSeries.propertyFields.stroke = "lineColor";
    lineSeries.propertyFields.fill = "lineColor";

    var bullet = lineSeries.bullets.push(new am4charts.CircleBullet());
    bullet.circle.radius = 6;
    bullet.circle.fill = am4core.color("#fff");
    bullet.circle.strokeWidth = 3;

    chart.cursor = new am4charts.XYCursor();
    chart.cursor.behavior = "panX";
    chart.cursor.lineX.opacity = 0;
    chart.cursor.lineY.opacity = 0;

    chart.scrollbarX = new am4core.Scrollbar();
    chart.scrollbarX.parent = chart.bottomAxesContainer;

  }); // end am4core.ready()
</script>
<div class="right_col" role="main">
  <div class="row">
    <h4>Dashboard</h4>
  </div>
  <!-- top tiles -->
  <div class="row" style="display: inline-block;width:500px;">
    <div class="tile_count">
      <div class="col-md-4 col-sm-4  tile_stats_count bg-blue">
        <span class="count_top "><i class="fa fa-user"></i> Jumlah Karyawan</span>
        <div class="count" style="font-size: 20px;"><?php echo $countKaryawan[0]->jml_karyawan ?></div>
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count bg-blue">
        <span class="count_top"><i class="fa fa-clock-o"></i> Laki-laki </span>
        <div class="count" style="font-size: 20px;"><?php echo $getGenderWoman[0]->tot_gender ?></div>
      </div>
      <div class="col-md-4 col-sm-4  tile_stats_count bg-blue">
        <span class="count_top"><i class="fa fa-clock-o"></i> Perempuan </span>
        <div class="count" style="font-size: 20px;"><?php echo $getGenderMan[0]->tot_gender ?></div>
      </div>
    </div>
  </div>
  <!-- /top tiles -->
  <?php if ($this->session->userdata('role') == 'administrator') { ?>
    <div class="row">

      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Data Karyawan</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a>
              </li>
            </ul>
            <div class="text-right">
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                  <div class="text-right">

                  </div>
                  <table id="data" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 0;
                      foreach ($showDataIndex as $row) { ?>
                        <tr>
                          <th style="font-size: 12px;"><?php echo ++$no; ?></th>
                          <th style="font-size: 12px;"><?php echo $row->nama_karyawan; ?></th>
                          <th style="font-size: 12px;"><?php echo $row->alamat; ?></th>
                          <th style="font-size: 12px;"><?php echo $row->nama_jabatan; ?></th>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php } ?>

  <?php if ($this->session->userdata('role') == 'yayasan' || $this->session->userdata('role') == 'keuangan') { ?>
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="dashboard_graph">
          <div class="row x_title">
            <div class="col-md-12">
              <h5 style="color:black">Grafik Total Gaji Bulanan <small>(Dilihat dari total gaji perbulan pada tahun <?php echo date('Y'); ?>)</small></h5>
              <div class="text-right">

              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-9 ">
            <div id="chartdiv1" class="demo-placeholder"></div>
          </div>
          <div class="col-md-12">
            <h5 style="color:black">Grafik Gaji Bulanan <small>(Dilihat dari total gaji bulanan berdasarkan tingkat jabatan)</small></h5>
            <div class="text-right">

              <div class="btn-toolbar text-center">
                <div class="btn-group btn-group-lg btn-group-solid margin-bottom-10">
                  <button type="button" style="font-size: 11px;" class="btn btn-info">Pilih Bulan</button>
                  <?php for ($i = 1; $i <= 12; $i++) { ?>
                    <a href="<?php print site_url(); ?>administrator/index/<?php print $i; ?>" type="button" style="font-size: 11px;" class="btn btn-primary"><?php print getBulan($i); ?></a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-sm-9 ">
          <div id="chartdiv" class="demo-placeholder"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>

</div>
<?php } ?>

</div>