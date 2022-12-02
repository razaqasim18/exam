<div class="content-wrapper">
    <?php

    $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
    );

    $dept_id = null;
    $class_id = null;
    $exam_name = null;
    $semester = '';
    $term = '';
    if (isset($filter)) {
        $dept_id = $filter['department'];
        $class_id = $filter['class_id'];
        $exam_name = $filter['exam_name'];
        $semester = $filter['semistar'];
        $term = $filter['term'];
    }

    $department_list = getDepartment('department', $dept_id);
    $class_list  = getClassForFilter($class_id);
    $exam_list  = getExam($exam_name, false, null);

    ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8 title-bar">
                <h1>
                    <i class="fa fa-file-text-o"></i> Exam Form Entries
                </h1>
            </div>

            <div class="col-xs-12 col-md-4 text-right">
                <a class="btn btn-primary" onclick="exportToExcel()" href="javascript:void(0)"><i class="fa fa-send"></i></i> Export to Excel</a>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Filter Entries </h3>
                    </div><!-- /.box-header -->

                    <!-- filter box -->
                    <div class="box-header">

                        <form action="<?php echo base_url() . ADMIN_ALIAS; ?>/exams/form_entries/list" method="GET" id="searchList">

                            <div class="row">
                                <div class="col-md-2">
                                    <?php echo $department_list ?>
                                </div>

                                <div class="col-md-2">
                                    <?php echo $class_list ?>
                                </div>

                                <div class="col-md-2">
                                    <?php echo $exam_list ?>
                                </div>

                                <div class="col-md-2">
                                    <select name="semistar" id="semester" class="form-control">
                                        <option value="" selected=""> Select semester</option>
                                        <?php

                                        for ($i = 1; $i <= 8; $i++)
                                            if ($semester == $i) {
                                        ?>
                                            <option value=<?= $i ?> selected> <?= $i ?></option>
                                        <?php } else { ?>
                                            <option value=<?= $i ?>> <?= $i ?></option>
                                        <?php
                                            } ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="term" id="term" class="form-control">
                                        <option value="" selected=""> Select Term</option>
                                        <option value="MS" <?= ($term == 'MS') ? 'selected' : '' ?>> MS </option>
                                        <option value="ES" <?= ($term == 'ES') ? 'checked' : '' ?>> ES </option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button name="submit" id="filter" class="btn btn btn-info searchList">Filter</button>
                                    <a href="<?php echo base_url() . ADMIN_ALIAS; ?>/exams/form_entries/list" class="btn btn btn-default">Clear Filter</a>
                                </div>

                            </div>


                            <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                        </form>

                    </div><!-- /.filter-box -->
                    <br><br>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Student Name</th>
                                <th>Department</th>
                                <th>Class</th>
                                <th>Exam</th>
                                <th>Semester</th>
                                <th>Term</th>
                                <th>Date</th>
                                <th>Fee</th>
                                <th>Payment Status</th>

                            </tr>
                            <?php if (!empty($form_entries)) {
                                foreach ($form_entries as $record) { ?>
                                    <tr>
                                        <td><?= $record->student_name ?></td>
                                        <td><?= $record->department ?></td>
                                        <td><?= $record->class ?></td>
                                        <td><?= $record->exam ?></td>
                                        <td><?= $record->semistar ?></td>
                                        <td><?= $record->term ?></td>
                                        <td><?= date('d-m-Y', strtotime($record->date)) ?></td>
                                        <td>
                                            <?php
                                            if ($record->late_fee > 0) {
                                                $total = $record->form_fee + $record->late_fee;
                                                $total = number_format((float)$total, 2, '.', '');
                                                $total_fee = $total . " [ Form Fee(" . $record->form_fee . ") + Late Fee(" . $record->late_fee . ") ]";
                                            } else {
                                                $total_fee = $record->form_fee;
                                            }
                                            echo $total_fee;
                                            ?>
                                        </td>
                                        <td><?= $record->payment_status ?></td>

                                    </tr>
                            <?php }
                            } else {
                                echo "<td colspan='10' style='text-align:center'>No Form Entries</td>";
                            }

                            ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    $("#department").on("change", function() {
        $.ajax({
            url: '<?php echo base_url() . ADMIN_ALIAS . '/exams/loadclasses'; ?>',
            data: {
                department_id: $("#department").val()
            },
            success: function(html) {
                $("#class_id").html(html);
            },
        });
    });

    $("#class_id").on("change", function() {
        $.ajax({
            url: '<?php echo base_url() . ADMIN_ALIAS . '/exams/loadexams'; ?>',
            data: {
                class_id: $("#class_id").val()
            },
            success: function(html) {
                $("#exam").html(html);
            },
        });
    });


    function exportToExcel() {
        var exportURL = '<?php echo base_url() . ADMIN_ALIAS; ?>' + '/exams/form_entries/export';
        var listURL = $("#searchList").attr("action");
        
        $("#searchList").attr("action", exportURL);
        $("#filter").trigger("click");
        $("#searchList").attr("action", listURL);
    }
</script>