<div class="container">

    <div class="row">
        <div class="col-md-12">
            <?php echo getSystemMessage(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 left-sidebar"> <?php echo getUserPanel($role, $uid); ?></div>
        <div class="col-xs-12 col-sm-9 col-md-9 front-end-details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 pl-0">
                        <h1 class="user-page-title"><i class="fa fa-check-square"></i> <?php echo getlang('site_exam_card_title', 'data'); ?> </h1>
                    </div>
                </div>
            </div>

            <hr>

            <div class="box-body table-responsive no-padding">

                <table cellpadding="0" cellspacing="0" class="admin-table attendance-report" id="attendance-table" style="width: 100%;margin-top: 0px;margin-bottom: 20px;">
                    <tr>
                        <th>NAME OF THE STUDENT</th>
                        <td colspan="10">
                        <?php echo $this->name  ?>
                        </td>
                    </tr>
                    <tr>
                        <th>DEPARTMENT</th>
                        <td colspan="10">
                            <?php echo  getNameById($dept, 'departments');  ?>
                        </td>
                    </tr>
                    <tr>
                        <th>CLASS</th>
                        <td colspan="10">
                            <?php echo  getNameById($classid, 'class');  ?>
                        </td>
                    </tr>
                    <tr>
                        <th>EXAM ROLL NUMBER</th>
                        <td colspan="10">
                            <?php echo $rollno  ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th>SEMESTER</th>
                        <th colspan="10">PAPER</th>
                    </tr>
                    <?php

                    foreach ($results as $result) {
                        $papers = explode(",", $result['paper']);
                    ?>
                        <tr>
                            <td>Sem-<?= $result['semistar'] ?></td>

                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                                <td>
                                    <?php if (in_array($i, $papers)) {
                                        echo "P-" . $result['semistar'] . "." . $i;
                                    } else {
                                        echo '--';
                                    } ?>
                                </td>

                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
