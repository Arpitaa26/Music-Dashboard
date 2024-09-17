<?php
$label = "Edit";
$icon = "<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";

?>

<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>TASK <?= $label ?>
				</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url() ?>">TASK Templates</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('general_settings') ?>">TASK Templates</a></li>
					<li class="breadcrumb-item active"><?= $label ?></li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- Content Wrapper. Contains page content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="template-alert-block"></div>
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title font-weight-bold">
							<?= $icon ?>
						</h3>
						<div class="float-sm-right">


							<div id="add-task"><button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#task-modal"><i class="fa fa-plus"></i></button></div>


						</div>
					</div>
					<!-- Message -->

					<div class="card-body append_place">
						<div class="row">
							<div class="col-md-3">
								<table class="table table-bordered table-hover templates-table text-center">
									<thead>
										<tr>
											<th>Task Templates</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($templates as $row) : ?>
											<tr>
												<td class="btn-template-link" data-type="<?= $row['id'] ?>">
													<span class="btn-template-link" data-type="<?= $row['id'] ?>"><?= $row['title'] ?></span>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
							<div class="col-md-9 template-wrapper">
								<div class="template-body empty-template text-center">
									<p>Select a Template</p>
								</div>
								<!-- form start -->
								<?php echo validation_errors(); ?>
								<?php echo form_open(base_url('general_settings/task_templates'), 'class="form-horizontal template-form"');  ?>
								<div class="template-body non-empty-template hidden ">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="col-md-12">
													<input type="text" name="title" class="form-control" placeholder="Email Subject">
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12">
													<textarea name="content" class="textarea form-control" rows="10"></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12">
													<label>Category</label>
													<input type="text" name="category" class="form-control" placeholder="Template's Variables" disabled>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12">
													<input type="hidden" name="template_id">
													<input type="submit" name="submit" value="Save Template" class="btn btn-success pull-right ml-5">
													<input type="button" value="Preview" class="btn btn-warning pull-right" id="btn_preview_email">
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php echo form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->

<div id="task-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal">×</a>

			</div>
			<form id="taskForm" class="task-add" name="add-task" role="form">
				<div class="modal-body">
					<div class="form-group">
						<label for="Title">Title</label>
						<input type="text" name="title" class="form-control">
					</div>

					<div class="form-group">
						<label for="assign_name" class="col-form-label-sm">Category</label>

						<?php $category_error = set_form_error('category', false); ?>
						<?= form_dropdown('category', ['' => 'Select', 'CLASS_CREATE' => 'CLASS_CREATE', 'LOGIN' => 'LOGIN', 'REGISTER' => 'REGISTER', 'CLASS_START' => 'CLASS_START'], null, "class='custom-select custom-select-sm'") ?>

					</div>
					<div class="form-group">
						<label for="Task_body">Task Body</label>
						<textarea name="description" class="form-control"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" class="btn btn-success" id="submit">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
	$(function() {
		// bootstrap WYSIHTML5 - text editor
		$('.textarea').wysihtml5({
			toolbar: {
				fa: true
			}
		});

		//  get email template content
		$('.btn-template-link').on('click', function() {
			$this = $(this);
			$('.empty-template').addClass('hidden');
			$('.non-empty-template').removeClass('hidden');

			$.post('<?= base_url("general_settings/get_task_template_content_by_id") ?>', {

					template_id: $this.data('type'),
				},
				function(data) {
					obj = JSON.parse(data);
					template = obj['template'];


					$('input[name=title]').val(template.title);
					$('input[name=template_id]').val(template.id);
					$('input[name=category]').val(template.category);
					$('iframe').contents().find('.wysihtml5-editor').html(template.description);
				});
		});
		// 

		//  update task template content
		$('.template-form').on('submit', function() {
			event.preventDefault();
			$.post('<?= base_url("general_settings/task_templates") ?>', {

					id: $('input[name=template_id]').val(),
					title: $('input[name=title]').val(),
					category: $('input[name=category]').val(),
					description: $('iframe').contents().find('.wysihtml5-editor').html(),
				},
				function(data) {
					$('.template-alert-block').html('<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>\
                  Template Updated Successfully</div>');
					$('.template-alert-block').removeClass('hidden');
					//window.location.reload();

				});
		});
		// 

		// Preview Email
		$('#btn_preview_email').on('click', function() {
			$.post('<?= base_url("general_settings/task_preview") ?>', {

					head: $('input[name=title]').val(),
					content: $('.textarea').val(),
				},
				function(data) {
					var w = window.open();
					w.document.open();
					w.document.write(data);
					w.document.close();
				});
		});
	})
</script>
<script>
	$("#setting").addClass('active');


	$(function() {

		$('#submit').on('click', function(e) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: '<?= base_url("general_settings/task_save") ?>',
				data: $('form.task-add').serialize(),
				success: function(response) {
					//alert(response['response']);
				},
				error: function() {
					alert('Error');
				}
			});
			return false;
		});
	});
</script>