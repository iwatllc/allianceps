
<div class="row">
    <div class="col-xs-4">
          <div class="form-group well" id="customername-field">
            <label for="customername">Customer Name:&nbsp;</label><span class="label label-danger">Required</span>
            <input type="text" class="form-control" maxlength="50" name="customername">
            <span class="help-block" id="customername-err"></span>
          </div>
    </div>
    <div class="col-xs-4">
      <div class="form-group well" id="slug-field">
        <label for="slug">Slug:&nbsp;</label><span class="label label-danger">Required</span>
        <input type="text" class="form-control" maxlength="50" name="slug">
        <span class="help-block" id="slug-err"></span>
      </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">Show Name:</label>
            <input type="checkbox" name="showname" checked>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">Show Logo:</label>
            <input type="checkbox" name="showlogo" checked>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-4">
        <div class="form-group well" id="cf1-field">
            <label for="cf1">Custom Field 1:</label>
            <br/>
            <input type="text" maxlength="50" class="form-control" name="cf1name">
            <span class="help-block" id="cf1-err"></span>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group well" id="cf2-field">
            <label for="cf2">Custom Field 2:</label>
            <br/>
            <input type="text" maxlength="50" class="form-control" name="cf2name">
            <span class="help-block" id="cf2-err"></span>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group well" id="cf3-field">
            <label for="cf3">Custom Field 3:</label>
            <br/>
            <input type="text" maxlength="50" class="form-control" name="cf3name">
            <span class="help-block" id="cf3-err"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF1 Enabled:</label>
            <input type="checkbox" name="cf1enabled">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF1 Required:</label>
            <input type="checkbox" name="cf1required">
        </div>
    </div>

    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF2 Enabled:</label>
            <input type="checkbox" name="cf2enabled">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF2 Required:</label>
            <input type="checkbox" name="cf2required">
        </div>
    </div>

    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF3 Enabled:</label>
            <input type="checkbox" name="cf3enabled">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF3 Required:</label>
            <input type="checkbox" name="cf3required">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-2">
        <div class="form-group well" id="allowach-field">
            <label for="showname">Allow ACH:</label>
            <input type="checkbox" name="allowach" checked>
            <span class="help-block" id="allowach-err"></span>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well" id="allowcc-field">
            <label for="allowcc">Allow CC:</label>
            <input type="checkbox" name="allowcc" checked>
            <span class="help-block" id="allowcc-err"></span>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="emailcustomer">Send email receipt to Customer:</label>
            <input type="checkbox" name="emailcustomer" checked>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="emailmerchant">Send email reciept to Merchant:</label>
            <input type="checkbox" name="emailmerchant" checked>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group well" id="emails-field">
            <label for="emails">Email Addresses:</label>
            <br/>
            <input type="text" maxlength="50" class="form-control" name="emails" data-role="tagsinput">
            <span class="help-block" id="emails-err"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <div class="form-group well" id="tid-field">
            <label for="tid">Merchant TID:&nbsp;</label><span class="label label-danger">Required</span>
            <br/>
            <input type="text" maxlength="12" class="form-control" name="tid">
            <span class="help-block" id="tid-err"></span>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group well" id="key-field">
            <label for="key">Key:&nbsp;</label><span class="label label-danger">Required</span>
            <br/>
            <input type="text" maxlength="24" class="form-control" name="key">
            <span class="help-block" id="key-err"></span>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group well" id="token-field">
            <label for="token">Token:&nbsp;</label><span class="label label-danger">Required</span>
            <br/>
            <input type="text" maxlength="72" class="form-control" name="token">
            <span class="help-block" id="token-err"></span>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="form-group well" id="cfpercentage-field">
            <label for="conveniencefee">Convenience Fee:</label>
            <br/>
            <span class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" name="conveniencefee" />
                </span>
                    <input type="text" class="form-control cfp" name="cfpercentage" maxlength="5"><span class="input-group-addon cfp">%</span>
                <span class="help-block" id="cfpercentage-err"></span>
            </span>
        </div>
    </div>
</div>

<div class="btns">
    <button type="button" class="btn btn-primary btn-lg addcustomer-submit"><span class="glyphicon glyphicon-plus"></span> Add Customer</button>
    <span class="space"></span>
    <button type="button" class="btn btn-warning btn-lg addcustomer-cancel"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
</div>
<br/>&nbsp;

<style type="text/css">
    label {
        font-size: 150%;
    }
    .label {
        font-size:100%;
    }
    div.btns {
        padding-left: 1cm;
    }
    span.space {
        padding-left:2em;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $("input[name=emails").tagit();
//        $(".cfp").hide();

        $( "input[name=cfpercentage]" ).keydown(function(event) {
            if (event.shiftKey == true) {
                event.preventDefault();
            }
            if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                (event.keyCode >= 96 && event.keyCode <= 105) ||
                event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
                event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {
            } else {
                event.preventDefault();
            }
            if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
                event.preventDefault();
            //if a decimal has been added, disable the "."-button
        });

        $( "input[name=cfpercentage]" ).keyup(function(event) {
            if (this.value < 0) this.value = 0;
            if (this.value > 100) this.value = 100;
        });

//        $('input[type="checkbox"][name=conveniencefee').click(function(){
//            if ($(this).is(":checked"))
//                $(".cfp").show();
//            else
//                $(".cfp").hide();
//        });
    });
</script>