<?php
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash(),
);
?>
<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo getSystemMessage(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-md-8 title-bar">
                <h1>
                    <i class="fa fa-users"></i>
                    <?php echo $result = (getlang('title_course_inquiry', 'sys_data') != "") ? getlang('title_course_inquiry', 'sys_data') : "Course Inquiry"; ?>
                </h1>
            </div>

        </div>


        <div class="row">
            <div class="col-xs-12 rms-data-table">
                <div class="box">
                    <div class="box-header">
                        <form action="<?php echo base_url() . ADMIN_ALIAS; ?>/course/inquiry" method="POST"
                            id="searchList">
                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-sm-3" style="margin:0; padding: 0;">
                                        <h3 style="margin:0; padding: 0;">Course Inquiry List </h3>
                                    </div>
                                    <div class="col-sm-1" style="padding: 0;"></div>
                                    <div class="col-sm-2"> <button id="btnExport" onclick="exportReportToExcel(this)"
                                            style="float: right;">EXPORT REPORT</button> </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="status"
                                                class="col-sm-6 control-label m-0 p-0"><?php echo getlang('show_status', 'sys_data'); ?></label>
                                            <div class="col-sm-6" style="padding-right: 0;">
                                                <select name="status_value" onchange="this.form.submit()"
                                                    class="form-control input-sm">
                                                    <option value="">Select</option>
                                                    <option value="0"
                                                        <?php echo $selected = ($status_value == "0") ? "selected" : ""; ?>>
                                                        Inquiry</option>
                                                    <option value="1"
                                                        <?php echo $selected = ($status_value == "1") ? "selected" : ""; ?>>
                                                        Shortlisted</option>
                                                    <option value="2"
                                                        <?php echo $selected = ($status_value == "2") ? "selected" : ""; ?>>
                                                        Entrance given</option>
                                                    <option value="3"
                                                        <?php echo $selected = ($status_value == "3") ? "selected" : ""; ?>>
                                                        Admitted</option>
                                                    <option value="4"
                                                        <?php echo $selected = ($status_value == "4") ? "selected" : ""; ?>>
                                                        Rejected</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" name="searchText" value="<?php echo $searchText; ?>"
                                                class="form-control input-sm pull-right"
                                                placeholder="<?php echo getlang('search', 'sys_data'); ?>" />
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-default searchList"><i
                                                        class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>



                                    <!--<div class="col-sm-3">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label for="verified" class=" col-sm-6 control-label"><?php echo getlang('show_verified', 'sys_data'); ?></label>-->
                                    <!--        <div class="col-sm-6" style="padding-right: 0;">-->
                                    <!--            <select name="verified_value"  onchange="this.form.submit()"  class="form-control">-->
                                    <!--                <option value="0" ><?php echo getlang('select', 'sys_data'); ?></option>-->
                                    <!--                <option value="verified" <?php if ($verified_value == 'verified') {echo 'selected="selected"';}?> ><?php echo getlang('verified', 'sys_data'); ?></option>-->
                                    <!--                <option value="unverified" <?php if ($verified_value == 'unverified') {echo 'selected="selected"';}?> ><?php echo getlang('unverified', 'sys_data'); ?></option>-->
                                    <!--            </select> -->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->

                                </div>
                            </div>

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        </form>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover parent-table" id="table">
                            <tr>
                                <th><?php echo getlang('name', 'sys_data'); ?></th>
                                <th><?php echo getlang('email', 'sys_data'); ?></th>
                                <th>Mobile</th>
                                <th>Nationality</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Program</th>
                                <th>Qualification</th>
                                <th>Gender</th>
                                <th>Caste</th>

                                <th class="text-center" width="120px"><?php echo getlang('action', 'sys_data'); ?></th>
                            </tr>
                            <?php
if (!empty($courseRecords)) {
    foreach ($courseRecords as $record) {
        ?>
                            <tr>
                                <td><?php echo $record->name; ?></td>
                                <td><?php echo $record->email; ?></td>
                                <td><?php echo $record->mobile; ?></td>
                                <td><?php echo $record->nationality; ?></td>
                                <td><?php echo $record->state; ?></td>
                                <td><?php echo $record->city; ?></td>
                                <td><?php echo $record->program; ?></td>
                                <td><?php echo $record->qualification; ?></td>
                                <td><?php echo $record->gender; ?></td>
                                <td><?php echo $record->caste; ?></td>

                                <td class="text-center" style="display:flex">
                                    <!--<a class="btn btn-sm btn-primary" href="<?=base_url() . ADMIN_ALIAS . '/parents/view/' . $record->id;?>" title="<?php echo getlang('profile_view', 'sys_data'); ?>"><i class="fa fa-eye"></i></a> -->
                                    <!--<a class="btn btn-sm btn-info" href="<?php echo base_url() . ADMIN_ALIAS . '/parents/add/' . $record->id; ?>" title="<?php echo getlang('edit', 'sys_data'); ?>"><i class="fa fa-pencil"></i></a>-->
                                    <select name="courseStatus" class="courseStatus" id="courseStatus"
                                        data-id="<?php echo $record->id; ?>">
                                        <option value="0"
                                            <?php echo $selected = ($record->status == 0) ? "selected" : ""; ?>>Inquiry
                                        </option>
                                        <option value="1"
                                            <?php echo $selected = ($record->status == 1) ? "selected" : ""; ?>>
                                            Shortlisted</option>
                                        <option value="2"
                                            <?php echo $selected = ($record->status == 2) ? "selected" : ""; ?>>Entrance
                                            given</option>
                                        <option value="3"
                                            <?php echo $selected = ($record->status == 3) ? "selected" : ""; ?>>Admitted
                                        </option>
                                        <option value="4"
                                            <?php echo $selected = ($record->status == 4) ? "selected" : ""; ?>>Rejected
                                        </option>
                                    </select>

                                    &nbsp;&nbsp;
                                    <a class="btn btn-sm btn-danger deleteCourse" data-id="<?php echo $record->id; ?>"
                                        id="deleteCourse" href="#"
                                        title="<?php echo getlang('delete', 'sys_data'); ?>"><i
                                            class="fa fa-trash"></i></a>

                                </td>

                            </tr>
                            <?php
}
}
?>
                        </table>

                        <!--for exprt-->
                        <table class="table table-hover parent-table" style="display:none" id="expttable">
                            <tr>
                                <th><?php echo getlang('name', 'sys_data'); ?></th>
                                <th><?php echo getlang('email', 'sys_data'); ?></th>
                                <th>Mobile</th>
                                <th>Nationality</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Program</th>
                                <th>Qualification</th>
                                <th>Gender</th>
                                <th>Caste</th>
                                <th>Status</th>
                            </tr>
                            <?php
if (!empty($courseRecords)) {
    foreach ($courseRecords as $record) {
        ?>
                            <tr>
                                <td><?php echo $record->name; ?></td>
                                <td><?php echo $record->email; ?></td>
                                <td><?php echo $record->mobile; ?></td>
                                <td><?php echo $record->nationality; ?></td>
                                <td><?php echo $record->state; ?></td>
                                <td><?php echo $record->city; ?></td>
                                <td><?php echo $record->program; ?></td>
                                <td><?php echo $record->qualification; ?></td>
                                <td><?php echo $record->gender; ?></td>
                                <td><?php echo $record->caste; ?></td>

                                <td>
                                    <?php
switch ($record->status) {
            case "1":
                echo "Shortlisted";
                break;
            case "2":
                echo "Entrance given";
                break;
            case "3":
                echo "Admitted";
                break;
            case "4":
                echo "Rejected";
                break;
            default:
                echo "Inquiry";
        }
        ?>
                                </td>
                            </tr>
                            <?php
}
}
?>
                        </table>
                        <!--for exprt-->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>



<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>-->
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<script type="text/javascript">
function exportReportToExcel() {
    event.preventDefault();
    let table = document.getElementById("expttable");
    console.log(table);
    TableToExcel.convert(table, {
        name: `file.xlsx`,
        sheet: {
            name: 'Sheet 1'
        }
    });
}
jQuery(document).ready(function() {



    /**
     ** Call Pagination
     **/
    jQuery('ul.pagination li a').click(function(e) {
        e.preventDefault();
        var link = jQuery(this).get(0).href;
        var value = link.substring(link.lastIndexOf('/') + 1);
        jQuery("#searchList").attr("action", baseURL + "<?php echo ADMIN_ALIAS; ?>/course/inquiry/" +
            value);
        jQuery("#searchList").submit();
    });


    /**
     ** Call Delete
     **/

    jQuery(document).on("click", "a#deleteCourse", function() {
        var Id = $(this).data("id"),
            hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/course/inquiry/delete";
        currentRow = $(this);

        var confirmation = confirm("<?php echo getlang('system_confirm_delete_msg', 'sys_data'); ?>");

        if (confirmation) {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: {
                    Id: Id,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                }
            }).done(function(data) {
                console.log(data);
                currentRow.parents('tr').remove();
                if (data.status = true) {
                    alert("<?php echo getlang('system_data_delete_success', 'sys_data'); ?>");
                } else if (data.status = false) {
                    alert("<?php echo getlang('system_data_delete_failed', 'sys_data') ?>");
                } else {
                    alert("<?php echo getlang('system_access_denied', 'sys_data'); ?>");
                }
                location.reload();
            });
        }

    });


    jQuery(document).on("change", "select.courseStatus", function() {
        var Id = $(this).data("id");
        var hitURL = baseURL + "<?php echo ADMIN_ALIAS; ?>/course/inquiry/status";
        // currentRow = $(this);
        // var status= $("select.courseStatus option:selected").val();
        var status = $(this).val();
        // console.log(status);return false;
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: hitURL,
            data: {
                "Id": Id,
                "status": status,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
            }
        }).done(function(data) {
            // console.log(data);
            // currentRow.parents('tr').remove();
            if (data.status = true) {
                alert("<?php echo getlang('system_course_delete_success', 'sys_data'); ?>");
            } else if (data.status = false) {
                alert("<?php echo getlang('system_course_delete_failed', 'sys_data') ?>");
            } else {
                alert("<?php echo getlang('system_access_denied', 'sys_data'); ?>");
            }
            location.reload();
        });
    });


});
</script>