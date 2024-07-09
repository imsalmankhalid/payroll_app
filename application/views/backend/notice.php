<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Notice Board</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Notice Board</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row m-b-10"> 
            <div class="col-12">
                <button type="button" class="btn btn-info">
                    <i class="fa fa-plus"></i>
                    <a data-toggle="modal" data-target="#noticemodel" data-whatever="@getbootstrap" class="text-white">
                        <i class="" aria-hidden="true"></i> Add Notice 
                    </a>
                </button>
            </div>
        </div> 
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Notice</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Title</th>
                                        <th>Text</th>
                                        <th>File</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Title</th>
                                        <th>Text</th>
                                        <th>File</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach($notice as $value): ?>
                                    <tr>
                                        <td><?php echo $value->id; ?></td>
                                        <td><?php echo $value->title; ?></td>
                                        <td><?php echo $value->text; ?></td>
                                        <td><a href="<?php echo base_url(); ?>assets/images/notice/<?php echo $value->file_url; ?>" target="_blank"><?php echo $value->file_url; ?></a></td>
                                        <td><?php echo $value->date; ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" data-id="<?php echo $value->id; ?>" data-title="<?php echo $value->title; ?>" data-text="<?php echo $value->text; ?>" data-file="<?php echo $value->file_url; ?>" data-date="<?php echo $value->date; ?>">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteNotice(<?php echo $value->id; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Notice Modal -->
        <div class="modal fade" id="noticemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Notice Board</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form role="form" method="post" action="Published_Notice" id="btnSubmit" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Notice Title</label>
                                <textarea class="form-control" name="title" id="message-text1" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="notice-text" class="control-label">Notice Text</label>
                                <textarea class="form-control large-textarea" name="text" id="notice-text" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Document (Optional)</label>
                                <input type="file" name="file_url" class="form-control" id="file-url">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Published Date</label>
                                <input type="date" name="nodate" class="form-control" id="recipient-name1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Notice Modal -->
        <div class="modal fade " id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editModalLabel">Edit Notice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form id="editForm" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit-id">
                            <div class="form-group">
                                <label for="edit-title" class="control-label">Notice Title</label>
                                <textarea class="form-control" name="title" id="edit-title" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit-text" class="control-label">Notice Text</label>
                                <textarea class="form-control" name="text" id="edit-text" ></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Document</label>
                                <input type="file" name="file_url" class="form-control" id="edit-file">
                            </div>
                            <div class="form-group">
                                <label for="edit-date" class="control-label">Published Date</label>
                                <input type="date" name="nodate" class="form-control" id="edit-date" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal -->
    </div>
<?php $this->load->view('backend/footer'); ?>

<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var title = button.data('title');
        var text = button.data('text');
        var file = button.data('file');
        var date = button.data('date');

        var modal = $(this);
        modal.find('#edit-id').val(id);
        modal.find('#edit-title').val(title);
        modal.find('#edit-text').val(text);
        modal.find('#edit-date').val(date);
    });

    function deleteNotice(id) {
        if (confirm("Are you sure you want to delete this notice?")) {
            window.location.href = "<?php echo base_url(); ?>Notice/Delete_Notice/" + id;
        }
    }

    $('#editForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>Notice/Update_Notice",
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(data) {
                alert("Notice updated successfully");
                location.reload();
            },
            error: function() {
                alert("An error occurred while updating the notice.");
            }
        });
    });
</script>
<style>
    .large-textarea {
        width: 100%;
        min-height: 200px;
    }
</style>