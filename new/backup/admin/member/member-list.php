<?php require '../../config/syscek.php'; ?>
<script src="../assets/js/mytable/table1.js"></script>
<script src="../assets/js/menu-content.js"></script>

<section class="content-header">
  <h1>
	  <i class=""></i>
    <span></span>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= $weburl ?>"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
  </ol>
</section>

<section class="content">
  <nav class="navbar navbar-inverse nav-fixed">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="#" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" role="button">
          <i class="fas fa-bars"></i>
        </a>
        <a class="navbar-brand text-blue" href="<?= $weburl ?>"><span class="fas fa-home"></span></a>
      </div>
      <form class="navbar-form navbar-left">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search Table" id="tableSearch">
          <div class="input-group-btn">
            <button class="btn btn-default clearinput" type="button">
              <i class="fas fa-eraser"></i>
            </button>
          </div>
        </div>
      </form>
      <ul class="nav navbar-nav nav-menu">
        <li class="dropdown">
          <button type="button" class="navbar-btn btn btn-default btn-block disabled" data-toggle="dropdown">
            <span>Action</span>
          </button>
          <ul class="dropdown-menu role="menu"">
            <li><a class="selected-edit pointer">
              <i class="fas fa-edit text-green icoinput"></i> Edit
            </a></li>
            <li><a class="selected-status pointer">
              <i class="fas fa-user-slash text-yellow icoinput"></i> Change Status
            </a></li>
            <li><a class="selected-remove pointer">
              <i class="fas fa-trash-alt text-red icoinput"></i> Remove
            </a></li>
          </ul>
        </li>
      </ul>

      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <li url="member/sql-proc.php?q=all" class="menu-nav info active"><a href="#">All</a></li>
          <li url="member/sql-proc.php?q=admin"class="menu-nav danger" ><a href="#">Admin</a></li>
          <li url="member/sql-proc.php?q=customer" class="menu-nav warning"><a href="#">Customer</a></li>
          <li url="member/sql-proc.php?q=partner" class="menu-nav success"><a href="#">Partner</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <button class="btn btn-success navbar-btn btn-block btn-new">New Member</button>
        </ul>
      </div>
    </div>
  </nav>
  <div class="row container-data">
    <div class="col-md-12">
      <div id="alert"></div>
      <div class="box box-info">
        <div class="box-header" data-widget="collapse">
          <div class="btn-group">
            <a class="btn btn-default dropdown-toggle fas fa-sort-numeric-down" data-toggle="dropdown"></a>
            <ul class="dropdown-menu" role="menu">
              <li class="table-length" value="10"><a href="#">10 Entries</a></li>
              <li class="table-length" value="20"><a href="#">20 Entries</a></li>
              <li class="table-length" value="50"><a href="#">50 Entries</a></li>
              <li class="table-length" value="100"><a href="#">100 Entries</a></li>
              <li class="divider"></li>
              <li class="table-length" value="-1"><a href="#">Show All</a></li>
            </ul>
          </div>
          <div class="box-tools pull-right btn-table">
          </div>
        </div>
        <div class="box-body">
          <table id="table1" class="table table-bordered table-striped" style="width:100%">
            <thead>
              <tr>
                <th><input type="checkbox" class="selectAll"></th>
                <th>User ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Date Added</th>
                <th>Status</th>
                <th>Username</th>
                <th>Email</th>
                <th>Longitude</th>
                <th>Latitude </th>
                <th>Address</th>
                <th>Notes</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
  Table1Gen("member/sql-proc.php?q=all",
  function ( row, data, index ) {
    if ( data[5] == "active") {
      $('td', row).eq(5).html("<span class='label label-success'>Active</span>");
      // $('td', row).eq(5).attr("data-order","active");
      // table.cell( row, 5 ).data("<span class='label label-success'>Active</span>");
    } else {
      $('td', row).eq(5).html("<span class='label label-danger'>Inactive</span>");
      // $('td', row).eq(5).attr("data-order","inactive");
      // table.column(5).cell( row, 5 ).data("<span class='label label-danger'>Inactive</span>");
    };
    var img = $('td', row).eq(0).text();
    if (img == "" || img == undefined || img == null) {
      img = "https://api.adorable.io/avatars/20/"+data[1];
    } else {
      img = "../image/userimg/"+img;
    }
    $('td', row).eq(0).html("<img class='img-circle' height=20 width=20 src='"+img+"'>");
    $('td', row).eq(4).html(moment(data[4]).format('LL'));
    $('td', row).eq(1).html("<a class='pointer'>"+data[1]+"</a>");
    $('td', row).eq(1).find('a').on( 'click', function () {
      $.get('member?p=profile&id='+data[1], function(link) {
        $('.content-container').html(link);
      });
    });
  });

  for ( i=6 ; i<11 ; i++ ) {
    table.column( i ).visible( false );
  }

  $('.selected-edit').on('click', function() {
    $('#modal-default').modal('show');
    $('#modal-title-default').text("Edit Selected Member");
    $('#modal-body-default').load("member/edit-member.php");
  });
  $('.selected-status').on('click', function() {
    $('#modal-default').modal('show');
    $(".modal-dialog").removeClass("modal-lg");
    $('#modal-title-default').text("Change Member Status");
    $('#modal-body-default').load("member/change-status.php");
  });
  $('.selected-remove').on('click', function() {
    $('#modal-default').modal('show');
    $(".modal-header,.modal-footer").removeClass("error warning success").addClass("warning");
    $(".modal-dialog").removeClass("modal-lg");
    $('#modal-title-default').text("Remove Member");
    $('#modal-body-default').load("member/remove-member.php");
  });

  $('.btn-new').on('click', function() {
    $('#modal-default').modal('show');
    $('#modal-title-default').text("Add New Member");
    $('#modal-body-default').load("member/new-member.php");
  });
</script>
