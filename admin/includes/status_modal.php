<!-- Edit -->
<div class="modal fade" id="editStatus">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Edit Status</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="status_edit.php">
                <input type="hidden" class="catid" id="order_id" name="id">
                <div class="form-group">
                    <label for="status" class="col-sm-3 control-label">Status</label>

                    <div class="col-sm-9">
                      <select class="form-control" name="order_status" id="status">
                      </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
              </form>
            </div>
        </div>
    </div>
</div>