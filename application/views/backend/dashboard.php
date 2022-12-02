
<?php 
	$y            =date("Y");
    $total_income = getIncome($y);
    $link_income  = base_url().ADMIN_ALIAS.'/incomes';
?>

<link href="<?php echo base_url(); ?>assets/backend/adminlte/plugins/morris/morris.css" rel="stylesheet" type="text/css" />

<div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i><?php echo getlang('title_dashboard', 'sys_data'); ?>
        <small><?php echo getlang('sub_title_dashboard', 'sys_data'); ?></small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
	                <div class="inner">
	                  <h3><?php echo getTotalStudent(); ?></h3>
	                  <p><?php echo getlang('students', 'sys_data'); ?></p>
	                </div>
	                <div class="icon">
	                  <i class="ion-ios-people"></i>
	                </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
	                <div class="inner">
	                  <h3><?php echo getTotalTeacher(); ?></h3>
                      <p><?php echo getlang('teachers', 'sys_data'); ?></p>	                  
	                </div>
	                <div class="icon">
	                  <i class="ion-ios-people"></i>
	                </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
	                <div class="inner">
	                  <h3><?php echo getTotalParent(); ?></h3>
                      <p><?php echo getlang('parents', 'sys_data'); ?></p>
	                </div>
	                <div class="icon">
	                  <i class="ion-ios-people"></i>
	                </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
	                <div class="inner">
	                  <h3><?php echo getTotalAdminUser(); ?></h3>
                      <p><?php echo getlang('users', 'sys_data'); ?></p>
	                </div>
	                <div class="icon">
	                  <i class="ion-ios-people"></i>
	                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-body">
                        <h1 style="text-align: center;font-size: 14px;color: #666;"><?php echo getlang('total_income', 'sys_data'); ?> <?php echo $y; ?> </h1>
                        <div class="chart" id="line-chart" style="height: 260px;"></div>
                        <hr>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <i class="fa fa-bar-chart fa-5x"></i>
                                </div>
                                <div class="col-md-8 text-right">
                                    <h3><?php echo getCurrency($total_income); ?></h3>
                                    <div><b><?php echo getlang('total_income', 'sys_data'); ?><b></div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?php echo $link_income; ?>">
                                        <div class="">
                                            <span class="pull-left"><?php echo getlang('view_details', 'sys_data'); ?></span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
    </section>

</div>




    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/adminlte/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var months = [
        '<?php echo getlang('month_jan', 'sys_data');?>', 
        '<?php echo getlang('month_feb', 'sys_data'); ?>', 
        '<?php echo getlang('month_mar', 'sys_data'); ?>', 
        '<?php echo getlang('month_apr', 'sys_data'); ?>', 
        '<?php echo getlang('month_may', 'sys_data'); ?>', 
        '<?php echo getlang('month_jun', 'sys_data'); ?>', 
        '<?php echo getlang('month_jul', 'sys_data'); ?>', 
        '<?php echo getlang('month_aug', 'sys_data'); ?>', 
        '<?php echo getlang('month_sep', 'sys_data'); ?>', 
        '<?php echo getlang('month_oct', 'sys_data'); ?>', 
        '<?php echo getlang('month_nov', 'sys_data'); ?>', 
        '<?php echo getlang('month_dec', 'sys_data'); ?>'];
      $(function () {
        "use strict";

        // LINE CHART
        var line = new Morris.Line({
          element: 'line-chart',
          resize: true,
          data: [
            {m: '<?php echo $y; ?>-01', value: <?php echo getTotalIncomebyMonth('1',$y); ?>},
            {m: '<?php echo $y; ?>-02', value: <?php echo getTotalIncomebyMonth('2',$y); ?>},
            {m: '<?php echo $y; ?>-03', value: <?php echo getTotalIncomebyMonth('3',$y); ?>},
            {m: '<?php echo $y; ?>-04', value: <?php echo getTotalIncomebyMonth('4',$y); ?>},
            {m: '<?php echo $y; ?>-05', value: <?php echo getTotalIncomebyMonth('5',$y); ?>},
            {m: '<?php echo $y; ?>-06', value: <?php echo getTotalIncomebyMonth('6',$y); ?>},
            {m: '<?php echo $y; ?>-07', value: <?php echo getTotalIncomebyMonth('7',$y); ?>},
            {m: '<?php echo $y; ?>-08', value: <?php echo getTotalIncomebyMonth('8',$y); ?>},
            {m: '<?php echo $y; ?>-09', value: <?php echo getTotalIncomebyMonth('9',$y); ?>},
            {m: '<?php echo $y; ?>-10', value: <?php echo getTotalIncomebyMonth('10',$y); ?>},
            {m: '<?php echo $y; ?>-11', value: <?php echo getTotalIncomebyMonth('11',$y); ?>},
            {m: '<?php echo $y; ?>-12', value: <?php echo getTotalIncomebyMonth('12',$y); ?>}
          ],
          
          xkey: 'm',
          ykeys: ['value'],
          labels: ['Income'],
          xLabelFormat: function (x) { return months[x.getMonth()]; }
        });

        
       
      });
    </script>



