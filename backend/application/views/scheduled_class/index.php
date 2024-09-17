            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Scheduled Class</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active">Scheduled Class</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title font-weight-bold"><i class="fa fa-tasks"></i>&nbsp; Scheduled Class</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <form action="<?= base_url('scheduled_class'); ?>" method="GET">
                                            <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="course" class="col-form-label-sm">From</label>
                                                    <input type="date" name="from" id="from" value="<?= set_value('from', $from) ?>" class="form-control form-control-sm ">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="course_level" class="col-form-label-sm">To</label>
                                                    <input type="date" name="to" id="to" value="<?= set_value('to', $to) ?>" class="form-control form-control-sm ">
                                                </div>
                                            </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="course" class="col-form-label-sm">Batch</label>
                                                        <?php $batch_error = set_form_error('batch_id', false);
                                                        $batches_options = ["" => "Select"];
                                                        if ($batches) {
                                                            $batches_options = array_reduce($batches, function ($s, $d) {
                                                                return ($s + [$d->id => $d->code]);
                                                            }, $batches_options);
                                                        }
                                                        ?>
                                                        <?= form_dropdown('batch_id', $batches_options, set_value('batch_id', $batch_id), "class='custom-select custom-select-sm {$batch_error}' id='batch_id'") ?>
                                                        <?= set_form_error('batch_id'); ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="status" class="col-form-label-sm">Status</label>
                                                        <?php $status_error = set_form_error('status', false);
                                                        $scheduled_classes_options = ["" => "Select"];
                                                        if ($scheduled_classes) {
                                                            $scheduled_classes_options = array_reduce($scheduled_classes, function ($s, $d) {
                                                                return ($s + [$d->status => $d->status]);
                                                            }, $scheduled_classes_options);
                                                        }
                                                        ?>
                                                        <?= form_dropdown('status', $scheduled_classes_options, set_value('status', $status), "class='custom-select custom-select-sm {$status_error}' id='status'") ?>
                                                        <?= set_form_error('status'); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="course_level" class="col-form-label-sm">&nbsp;</label>
                                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                                    </div>
                                                </div>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <div class="card-body table-responsive p-2">
                                    <table class="table text-center" id="schedule_table">
                                        <thead>
                                            <tr>
                                                <th>Batch Code</th>
                                                <th>Session</th>
                                                <th>Module</th>
                                                <th>Status</th>
                                                <th>Start Time</th>
                                                <th>End Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
                <a href="<?= base_url('scheduled_class/save') ?>" class="btn btn-danger pop_fix_btn" title="New Module"><i class="fa fa-plus"></i></a>
            </section>
            <!-- /.content -->


            <script>
                $(document).ready(function() {
                    function convert_digit(n) {
                        n = String(n)
                        n.length > 1 ? n = n : n = '0' + n;
                        return n
                    }
                    const now = new Date();
                    const year = now.getFullYear();
                    const month = String(now.getMonth() + 1).padStart(2, '0');
                    const day = String(now.getDate()).padStart(2, '0');
                    const todayStart = `${year}-${month}-${day} 00:00:00`;
                    const todayEnd = `${year}-${month}-${31} 23:59:00`;

                    var schedule_table = $("#schedule_table").DataTable({
                        responsive: true,
                        autoWidth: false,
                        serverSide: false,
                        processing: true,
                        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                        ajax: {
                            url: `<?= base_url("api/scheduled_class/get_all"); ?>`,
                           // url: `<?= base_url("api/scheduled_class/get_all?from="); ?>${todayStart}&to=${todayEnd}`,
                            type: 'GET',
                            data: function(d) {
                                d.batch_id = $("#batch_id").val();
                                d.status = $("#status").val();
                                d.from = $("#from").val();
                                d.to = $("#to").val();
                            },
                            dataSrc: function(d) {
                                if (d.code == 200) {
                                    return d.data.map((v, i) => {

                                        const sd = new Date(v.start_time);
                                        const ed = new Date(v.end_time);

                                        var sh = sd.getHours(),
                                            sm = sd.getMinutes();
                                        var start_time = (sh > 12) ? (sh - 12 + ':' + convert_digit(sm) + ' PM') : (sh + ':' + sm + ' AM');

                                        var eh = ed.getHours(),
                                            em = ed.getMinutes();
                                        var end_time = (eh > 12) ? (eh - 12 + ':' + convert_digit(em) + ' PM') : (eh + ':' + em + ' AM');
                                        let course_nrollment = `<a href="<?= base_url("course_enrollment?") ?>batch_id=${v.batch_id}" name="batch_id" class="btn btn-xs btn-success" title="Course Enrollment " data-toggle="tooltip">CE</a>`;
                                        let del_btn = true ? `<a href="<?= base_url("scheduled_class/delete/") ?>${v.id}" onclick="return confirm('Are you sure?')" class="btn btn-xs btn-danger" title="Delete" data-toggle="tooltip"><i class="fa fa-trash"></i></a>` : '';
                                        let action = course_nrollment + '&nbsp' + del_btn;
                                        return [
                                            `<a href="<?= base_url("scheduled_class/save/") ?>${v.id}">${v.batch_code}</a>`,
                                            v.session_type,
                                            v.module_name,
                                            v.status,
                                            `${sd.getDate()}/${sd.getMonth() + 1}/${sd.getFullYear()}<br>${start_time}`,
                                            `${ed.getDate()}/${ed.getMonth() + 1}/${ed.getFullYear()}<br>${end_time}`,
                                            action
                                        ];
                                    });
                                } else if (d.code == 203) {

                                }
                                return [];
                            }
                        },
                    });
                });
            </script>