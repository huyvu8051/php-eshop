<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order
      </h1>
    </section>
    <?php
      include 'includes/show_error.php'
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Id</th>
                  <th>Date</th>
                  <th>Buyer Name</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th>Full Details</th>
                  <th>Edit Status</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT *, orders.id AS order_id, orders.status AS order_status FROM orders LEFT JOIN users ON users.id=orders.user_id ORDER BY create_date DESC");
                      $stmt->execute();
                      foreach($stmt as $row){
                        echo "
                          <tr>
                            <td>".$row['order_id']."</td>
                            <td>".date('M d, Y', strtotime($row['create_date']))."</td>
                            <td>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>".$row['address']."</td>
                            <td>".$row['order_status']."</td>
                            <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='".$row['order_id']."' onclick='getOrderDetails(".$row['order_id'].")'><i class='fa fa-search'></i> View</button></td>
                            <td><button type='button' class='btn btn-info btn-sm btn-flat edit' data-id='".$row['order_id']."' data-status='".$row['order_status']."' onclick='getOrderDetails(".$row['order_id'].")'><i class='fa fa-edit'></i> Edit</button></td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                    $pdo->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
  	<?php include 'includes/footer.php'; ?>
    <?php include '../includes/profile_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>
<?php include 'includes/status_modal.php'; ?>
<script>
$(function(){
  $(document).on('click', '.transact', function(e){
    e.preventDefault();
    $('#transaction').modal('show');
    var id = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: 'transact.php',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        $('#date').html(response.date);
        $('#transid').html(response.transaction);
        $('#detail').prepend(response.list);
        $('#total').html(response.total);
      }
    });
  });

  $("#transaction").on("hidden.bs.modal", function () {
      $('.prepend_items').remove();
  });
});

$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#editStatus').modal('show');
    var id = $(this).data('id');
    $('#order_id').val(id);
    var status = $(this).data('status');
    var option = '';
    ['done', 'progress', 'reject'].forEach(element => {
      if (element === status) {
        option += '<option value="' + element + '" selected>' + element + '</option>'
      } else {
        option += '<option value="' + element + '">' + element + '</option>'
      }
    });
    $('#status').html(option);
  });
});
</script>
</body>
</html>
