<?php 
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);
?>
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
                        <h1 class="user-page-title"><i class="fa fa-check-square"></i> <?php echo getlang('site_exam', 'data'); ?> </h1>
                    </div>
                </div>
            </div>

            <hr>

            <div class="box-body table-responsive no-padding">

                <table class="admin-table" id="attendance-table">
                    <tr>
                        <th>EXAM TITLE</th>
                        <th>SEMESTER</th>
                        <th>TERM</th>
                        <th>EXAM TYPE</th>
                        <th>EXAM DATE</th>
                        <th>FILLUP FORM BETWEEN</th>
                        <th>FORM FEE</th>
                        <th>LATE FEE</th>
                        <th></th>
                    </tr>
                    <?php if (count($exams) > 0) {
                        foreach ($exams as $exam) {
                            echo "<tr>";
                            echo "<td>" . $exam['name'] . "</td>";
                            echo "<td>" . $exam['semistar'] . "</td>";
                            echo "<td>" . $exam['term'] . "</td>";
                            echo "<td>" . $exam['type'] . "</td>";
                            echo "<td>" . date('d-m-Y', strtotime($exam['exam_date'])) . "</td>";
                            echo "<td>" . date('d-m-Y', strtotime($exam['form_fillup_start_date'])) . ' to ' . date('d-m-Y', strtotime($exam['form_fillup_last_date'])) . "</td>";;
                            echo "<td>" . $exam['form_fee'] . "</td>";
                            echo "<td>" . $exam['late_fee'] . "</td>";
                    ?>
                            <td style="padding: 10px">
                            <?php if(formFilledUpForExam($exam['id'])){ ?>
                                <span><i class="fa fa-check-square"></i>Form already filled up</span>
                            <?php  } else { ?>
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exam-<?= $exam['id'] ?>">
                                    Fillup Form
                                </button>
                            <?php } ?>
                            </td>
                            <div class="modal fade" id="exam-<?= $exam['id'] ?>" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Fillup Exam Form</h4>
                                        </div>
                                        <form action="<?php echo base_url('user/exam/submit_form'); ?>" method="post" class="form-horizontal">
                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                            <input type="hidden" name="student_id" value="<?= $this->uid ?>" />
                                            <input type="hidden" name="department_id" value="<?= $dept ?>" />
                                            <input type="hidden" name="class_id" value="<?= $classid ?>" />
                                            <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>" />
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label for="student_name" class="col-sm-3 col-form-label text-right">Student Name:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="student_name" name="student_name" value="<?= $this->name  ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="department" class="col-sm-3 col-form-label text-right">Department:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="department" name="department" value="<?= getNameById($dept, 'departments')  ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="class" class="col-sm-3 col-form-label text-right">Class:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="class" name="class" value="<?= getNameById($classid, 'class')  ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="exam" class="col-sm-3 col-form-label text-right">Exam:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="exam" name="exam" value="<?= $exam['name'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="semistar" class="col-sm-3 col-form-label text-right">Semester:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="semistar" name="semistar" value="<?= $exam['semistar'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="term" class="col-sm-3 col-form-label text-right">Term:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="term" name="term" value="<?= $exam['term'] ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="term" class="col-sm-3 col-form-label text-right">Date:</label>
                                                    <div class="col-sm-9">
                                                        <p><?= date('d-m-Y') ?></p>
                                                        <input type="hidden" name="date" value="<?= date('d-m-Y') ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="term" class="col-sm-3 col-form-label text-right">Fee:</label>
                                                    <div class="col-sm-9">
                                                        <?php
                                                        if (date('Y-m-d') > $exam['form_fillup_last_date']) {
                                                            $total = $exam['form_fee'] + $exam['late_fee'];
                                                            $total = number_format((float)$total, 2, '.', '');
                                                            $total_fee = $total." [ Form Fee(".$exam['form_fee'].") + Late Fee(".$exam['late_fee'].") ]";
                                                            echo '<input type="hidden" name="late_fee" value="'.$exam['late_fee'].'">';
                                                        } else {
                                                            $total_fee = $exam['form_fee'];
                                                        }
                                                        ?>
                                                        <p><?= $total_fee ?></p>
                                                        <input type="hidden" name="form_fee" value="<?= $exam['form_fee'] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>

                    <?php
                            echo "</tr>";
                        }
                    } else {
                        echo "<td colspan='9' style='text-align:center'>No Exams</td>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>