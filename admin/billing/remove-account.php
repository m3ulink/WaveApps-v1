<?php
require_once($_SERVER['DOCUMENT_ROOT']."/assets/func/sqlQu.php");
$login->login_redir();
?>
<div id="info"></div>
<div class="box box-solid">
  <div class="box-body">
    <div class="box-group" id="accordion">
      <div class="panel box box-warning">
        <div class="box-header">
          <h4 class="box-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed text-yellow">
              Remove Account Data
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
          <div class="box-body">
            <div class="input-group input-group-sm">
              <select class="select2 form-control" id="select-remove" style="width: 100%;">
                <option value=""></option>
                <option>Bank Account</option>
                <option>Phone</option>
                <option>Bank URL</option>
                <option>Description</option>
              </select>
              <span class="input-group-btn">
                <button type="button" class="btn btn-danger btn-flat" id="remove-data">Remove</button>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="panel box box-danger">
        <div class="box-header">
          <h4 class="box-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed text-red" aria-expanded="false">
              Completely Remove Account
            </a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
          <div class="box-body">
            <div class="pretty p-default p-round p-thick  margin">
              <input type="checkbox" id="agree"/>
              <div class="state p-primary-o">
                <label>I understand. Continue to remove account!</label>
              </div>
            </div>
            <button id="remove-account" class="btn btn-block btn-danger btn-lg" disabled>
              <i class="fas fa-ban"></i> Remove Account
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>

<div class="debug-only">
  <hr>
  <p class="text-muted well debug"></p>
  <button type="button" name="button" class="btn clear debug">Clear Debug Result</button>
  <button type="button" name="button" class="btn random debug">Random Input Data</button>
</div>

<script type="text/javascript">
$('.select2').select2({
  placeholder: 'Select data to remove',
  allowClear: true
});

var count = table.rows( { selected: true } ).count();
$('#modal-footer-default').text(+count+" account selected.");

$('input#agree').on('click', function() {
  if ($("#agree").is(':checked')) {
    $("#remove-account").attr("disabled", false);
  } else {
    $("#remove-account").attr("disabled", true);
  }
});

$('#remove-account').on('click', function() {
  rowData = table.rows({selected:  true}).data().toArray();
  var newarray=[];
  for (var i=0; i < rowData.length ;i++){
    newarray.push(rowData[i][0]);
  }
  var accountid = newarray;

  $.post("billing/sql-proc.php?r=account", {
    id: accountid
  },
  function(data) {
    $('.well.debug').append(data+"<br>");
    var json = JSON.parse(data);
    var status = json['status'];
    if (status != "success") {
      $(".modal-header,.modal-footer").removeClass("error warning success").addClass("error");
      $("#info").load( "../include/alert.php #callout-danger", function() {
        $("#callout-title-danger").html("Account still has balance!");
      });
    } else {
      $(".modal-header,.modal-footer").removeClass("error warning success").addClass("success");;
      $("#info").load( "../include/alert.php #callout-success", function() {
        $('#callout-title-success').html("Success Remove "+json[0]['count']+" Account!");
      });
    }
  });
})

$('#remove-data').on('click', function() {
  rowData = table.rows({selected:  true}).data().toArray();
  var newarray=[];
  for (var i=0; i < rowData.length ;i++){
    newarray.push(rowData[i][0]);
  }
  var accountid = newarray;

  $.post("billing/sql-proc.php?r=account-data", {
    id: accountid,
    data: $("#select-remove").val()
  },
  function(data) {
    $('.well.debug').append(data+"<br>");
    var json = JSON.parse(data);
    var status = json['status'];
    if (status == "success") {
      $(".modal-header,.modal-footer").removeClass("error warning success").addClass("success");;
      $("#info").load( "../include/alert.php #callout-success", function() {
        $('#callout-title-success').html(json[0]['data']);
      });
    }
  });
})
</script>
