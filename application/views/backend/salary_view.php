<?php
$this->load->view('backend/header');
?>
<?php
$this->load->view('backend/sidebar');
?>
<div class="page-wrapper">
  <div class="message">
  </div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor"><i class="fa fa-money"></i> Payroll View
      </h3>
    </div>
    <div class="col-md-7 align-self-center">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">Home
          </a>
        </li>
        <li class="breadcrumb-item active">Payroll View
        </li>
      </ol>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row m-b-10"> 
      <div class="col-12"><!-- 
        <button type="button" class="btn btn-info">
          <i class="fa fa-plus">
          </i>
          <a data-toggle="modal" data-target="#salaryModal" data-whatever="@getbootstrap" class="text-white salaryModal">
            <i class="" aria-hidden="true">
            </i> Add Payroll 
          </a>
        </button> -->
        <button type="button" class="btn btn-primary">
          <i class="fa fa-bars">
          </i>
          <a href="<?php
                   echo base_url();
                   ?>Payroll/Salary_Type" class="text-white">
            <i class="" aria-hidden="true">
            </i>   Payroll List
          </a>
        </button>
      </div>
    </div> 
    <div class="row">
      <div class="col-12">
        <div class="card card-outline-info">
          <div class="card-header">
            <h4 class="m-b-0 text-white"> Monthly Payroll List
            </h4>
          </div>
          <div class="card-body">
            <!--Savd vdgff gdfg dfg dfgdfg df  gd gdd gfd-->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="" id="salaryform" class="form-material row">
                  <div class="form-group col-md-4">
                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="depid" name="depid" style="margin-top: 21px;" required>
                      <option value="#">Department
                      </option>
                      <?php foreach ($department as $value): ?>
                      <option value="<?php echo $value->id; ?>">
                        <?php echo $value->dep_name; ?>
                      </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label>
                    </label>
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class='input-group date' id=''>
                          <input type='text' name="datetime" class="form-control mydatetimepicker" placeholder="Month"/>
                        </div>
                      </div>
                    </div>
                  </div> 
                    <div class="form-group col-md-3">
                    <button style="float:left;margin-top:23px" type="submit" id="BtnSubmit" class="btn btn-primary">Submit</button>          
                     </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>            
            <!--Savd vdgff gdfg dfg dfgdfg df  gd gdd gfd-->
            <div class="table-responsive ">
              <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>PIN 
                    </th>
                    <th>Full name
                    </th>
                    <th>Total salary
                    </th>
                    <th>Action
                    </th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>PIN 
                    </th>
                    <th>Full name
                    </th>
                    <th>Total salary
                    </th>
                    <th>Action
                    </th>
                  </tr>
                </tfoot>
                <tbody class="payroll">
                </tbody>
              </table>
            </div>                                
          </div>
        </div>
      </div>
    </div>


    <script>
        // Populate the payroll table to generate the payroll for each individual
      $("#BtnSubmit").on("click", function(event){
        event.preventDefault();
        var depid = $('#depid').val();
        var datetime = $('.mydatetimepicker').val();
        
        $.ajax({
          url: "load_employee_by_deptID_for_pay?date_time="+datetime+"&dep_id="+depid,
          type:"GET",
          dataType:'',
          data:'data',          
          success: function(response) {
            // console.log(response);
            $('.payroll').html(response);
          },
          error: function(response) {
            
          }
        });
      });
    </script>

    <div class="modal fade" id="generatePayrollModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Salary Setup</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="pay_salary_add_record" id="generatePayrollForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group row">
            <label class="control-label text-left col-md-3">Employee</label>
            <div class="col-md-9">
              <select class="form-control custom-select" data-placeholder="Choose a Category" id="emid" tabindex="1" name="emid" required>
                <option value="#">Select Here</option>
                <?php foreach ($employee as $value): ?>
                <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.' '.$value->last_name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label text-left col-md-3">Month</label>
            <div class="col-md-9">
              <input type="hidden" name="year">
              <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="month" id="salaryMonth" required>
                <option value="#">Select Here</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>
          </div>
          <div class="row well">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Basic Salary</label>
                <div class="col-md-7">
                  <input type="text" name="basic" class="form-control basic" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Working hours</label>
                <div class="col-md-7">
                  <input type="text" name="month_work_hours" class="form-control thour" value="" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Hours worked</label>
                <div class="col-md-7">
                  <input type="text" name="hours_worked" class="form-control hours_worked" value="">
                  <span>Difference in Hours:</span><span class="wpay"></span> <span>hrs</span>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Hourly Rate</label>
                <div class="col-md-7">
                  <input type="text" name="hrate" class="form-control hrate" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Addition</label>
                <div class="col-md-7">
                  <input type="text" name="addition" class="form-control addition" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Pay Date</label>
                <div class="col-md-7">
                  <input type="text" name="paydate" class="form-control mydatetimepickerFull" value="" required>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Hourly Surcharge</label>
                <div class="col-md-7">
                  <input type="text" name="surcharge" class="form-control surcharge" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Deduction</label>
                <div class="col-md-7">
                  <input type="text" name="diduction" class="form-control diduction" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Loan</label>
                <div class="col-md-7">
                  <input type="text" name="loan" class="form-control loan" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Status</label>
                <div class="col-md-7">
                  <input name="status" type="radio" id="radio_1" data-value="Paid" class="duration" value="Paid" checked="checked">
                  <label for="radio_1">Paid</label>
                  <input name="status" type="radio" id="radio_2" data-value="Process" class="type" value="Process">
                  <label for="radio_2">Process</label>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label text-left col-md-5">Paid Type</label>
                <div class="col-md-7">
                  <input name="paid_type" type="radio" id="radio_3" data-value="Hand Cash" value="Hand Cash" checked="checked">
                  <label for="radio_3" style="margin-left: 30px">Hand Cash</label>
                  <input name="paid_type" type="radio" id="radio_4" data-value="Bank" value="Bank">
                  <label for="radio_4" style="margin-left: 130px">Bank</label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label text-left col-md-3">Final Salary</label>
            <div class="col-md-9">
              <input type="text" name="total_paid" class="form-control total_paid" id="" value="" required style="font-size: 1.5em;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="action" value="add" class="form-control" id="formAction">
          <input type="hidden" name="loan_id" value="" class="form-control" id="loanID">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

    <script type="text/javascript">
      $(document).ready(function () {
        function updateFinalSalary() {
          var basic = parseFloat($('.basic').val()) || 0;
          var hrate = parseFloat($('.hrate').val()) || 0;
          var loan = parseFloat($('.loan').val()) || 0;
          var hwork = parseFloat($('.hours_worked').val()) || 0;
          var thour = parseFloat($('.thour').val()) || 0;
          var sr = parseFloat($('.surcharge').val()) || 0;
          var addition = parseFloat($('.addition').val()) || 0;
          var surcharge = sr * hwork;
          var finalSalary = (hwork * hrate) - loan - surcharge;
          $(".total_paid").val(finalSalary.toFixed(2));

          var totalHours = thour - hwork;
          var deduction =  loan + surcharge;
          var addition = totalHours * hrate;
          if (deduction > 0) {
            $(".diduction").val(deduction.toFixed(2));
          } else {
            $(".addition").val(Math.abs(deduction).toFixed(2));
            $(".diduction").val(0);
          }
          if(totalHours < 0)
          {
            $(".addition").val(Math.abs(finalSalary - basic).toFixed(2));
          }
          
          $(".wpay").html(totalHours.toFixed(2));
        }
          
          $(document).on('keyup','.hours_worked',function() {
            updateFinalSalary();
          });

          $(document).on('keyup','.surcharge',function() {
            updateFinalSalary();
        });
        
      $(document).on('click', ".salaryGenerateModal", function (e) {
        e.preventDefault();

        $('#generatePayrollModal').modal('show');

        var emid = $(this).data('id');
        var month = $(this).data('month');
        var year = $(this).data('year');
        var has_loan = $(this).data('has_loan');

        $('#generatePayrollForm').find('[name="emid"]').val(emid).attr('readonly', true).end();
        $('#generatePayrollForm').find('[name="month"]').val(Math.abs(month)).attr('readonly', true).end();

        $.ajax({
          url: 'generate_payroll_for_each_employee',
          method: 'GET',
          data: { month: month, year: year, employeeID: emid },
          dataType: 'json',
        }).done(function (response) {
          $('#generatePayrollForm').find('[name="basic"]').val(response.basic_salary).attr('readonly', false).end();
          $('#generatePayrollForm').find('[name="month_work_hours"]').val(response.total_work_hours).attr('readonly', false).end();
          $('#generatePayrollForm').find('[name="hours_worked"]').val(response.employee_actually_worked).end();
          $('#generatePayrollForm').find('[name="addition"]').val(response.addition).end();
          $('#generatePayrollForm').find('[name="diduction"]').val(response.diduction).end();
          $('.wpay').html(response.wpay).end();
          $('#generatePayrollForm').find('[name="loan"]').val(response.loan_amount).prop('readonly', true).end();
          $('#generatePayrollForm').find('[name="loan_id"]').val(response.loan_id).end();
          $('#generatePayrollForm').find('[name="total_paid"]').val(response.final_salary).end();
          $('#generatePayrollForm').find('[name="year"]').val(year).end();
          $('#generatePayrollForm').find('[name="hrate"]').val(response.rate).end();
          updateFinalSalary();
        });
      });

      $('#salaryMonth').on('change', function() {
      var emid = $('#generatePayrollForm').find('[name="emid"]').val();
      var month = $(this).val();
      var year = $('#generatePayrollForm').find('[name="year"]').val();
      console.log(month);
      console.log(year);
      if (emid && month && year) {
        $.ajax({
          url: 'generate_payroll_for_each_employee',
          method: 'GET',
          data: { month: month, year: year, employeeID: emid },
          dataType: 'json',
        }).done(function (response) {
          console.log(response);
          $('#generatePayrollForm').find('[name="basic"]').val(response.basic_salary).attr('readonly', false).end();
          $('#generatePayrollForm').find('[name="month_work_hours"]').val(response.total_work_hours).attr('readonly', false).end();
          $('#generatePayrollForm').find('[name="hours_worked"]').val(response.employee_actually_worked).end();
          $('#generatePayrollForm').find('[name="addition"]').val(response.addition).end();
          $('#generatePayrollForm').find('[name="diduction"]').val(response.diduction).end();
          $('.wpay').html(response.wpay).end();
          $('#generatePayrollForm').find('[name="loan"]').val(response.loan_amount).prop('readonly', true).end();
          $('#generatePayrollForm').find('[name="loan_id"]').val(response.loan_id).end();
          $('#generatePayrollForm').find('[name="total_paid"]').val(response.final_salary).end();
          $('#generatePayrollForm').find('[name="hrate"]').val(response.rate).end();
        });
      }
    });
      
    });
</script>                           
    <?php
$this->load->view('backend/footer');
?>