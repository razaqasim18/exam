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
                        <h1 class="user-page-title"><i class="fa fa-check-square"></i> <?php echo getlang('site_subject_title', 'data'); ?> </h1>
                    </div>
                </div>
            </div>

            <hr>

            <div class="box-body table-responsive no-padding">

                <?php
                $compulsorySubjects = [];
                if (isset($subjects['compulsory'])) {
                    foreach ($subjects['compulsory'] as $compulsory) {
                        $compulsorySubjects[] = getNameById($compulsory, 'subjects');
                    }
                }

                if (!empty($compulsorySubjects)) {
                    $compulsorySubjects = implode(", ", $compulsorySubjects);
                } else {
                    $compulsorySubjects = '';
                }

                $optionalSubjects = [];
                if (isset($subjects['optional'])) {
                    foreach ($subjects['optional'] as $optional) {
                        $optionalSubjects[] = getNameById($optional, 'subjects');
                    }
                }

                if (!empty($optionalSubjects)) {
                    $optionalSubjects = implode(", ", $optionalSubjects);
                } else {
                    $optionalSubjects = '';
                }

                $honorsSubjects = [];
                if (isset($subjects['honors'])) {
                    foreach ($subjects['honors'] as $honors) {
                        $honorsSubjects[] = getNameById($honors, 'subjects');
                    }
                }

                if (!empty($honorsSubjects)) {
                    $honorsSubjects = implode(", ", $honorsSubjects);
                } else {
                    $honorsSubjects = '';
                }

                ?>


                <table cellpadding="0" cellspacing="0" class="admin-table attendance-report" id="attendance-table" style="width: 100%;margin-top: 0px;margin-bottom: 20px;" align="center">
                    <tr>
                        <th>Compulsory Subjects</th>
                        <td><?= $compulsorySubjects ?></td>
                    </tr>
                    <tr>
                        <th>Optional Subjects</th>
                        <td><?= $optionalSubjects ?></td>

                    </tr>
                    <tr>
                        <th>Honors Subjects</th>                
                        <td><?= $honorsSubjects ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
