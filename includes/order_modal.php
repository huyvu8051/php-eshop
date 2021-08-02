
<!-- Edit Profile -->
<div class="modal fade" id="order">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><b>Order</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="order.php">
                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Shipping Address</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="address" name="address">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Order</button>
              </form>
            </div>
        </div>
    </div>
</div>