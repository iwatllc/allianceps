<input type="hidden" name="customerid" value="<?php echo $customer->id; ?>">
<div class="row">
    <div class="col-xs-4">
          <div class="form-group well" id="customername-field">
            <label for="customername">Customer Name:&nbsp;</label><span class="label label-danger">Required</span>
            <input type="text" class="form-control" maxlength="50" name="customername" value="<?php echo $customer->customername; ?>">
            <span class="help-block" id="customername-err"></span>
          </div>
    </div>
    <div class="col-xs-4">
      <div class="form-group well" id="slug-field">
        <label for="slug">Slug:&nbsp;</label><span class="label label-danger">Required</span>
        <input type="text" class="form-control" maxlength="50" name="slug" value="<?php echo $customer->slugname; ?>">
        <span class="help-block" id="slug-err"></span>
      </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="showname">Show Name?:</label>
            <input type="checkbox" name="showname" <?php if($customer->showname == '1') {echo 'checked';} ?>>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="showlogo">Show Logo?:</label>
            <input type="checkbox" name="showlogo" <?php if($customer->showlogo == '1') {echo 'checked';} ?>>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-4">
        <div class="form-group well" id="cf1-field">
            <label for="cf1">Custom Field 1:</label>
            <br/>
            <input type="text" maxlength="50" class="form-control" name="cf1name" value="<?php echo $customer->cf1name; ?>">
            <span class="help-block" id="cf1-err"></span>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group well" id="cf2-field">
            <label for="cf2">Custom Field 2:</label>
            <br/>
            <input type="text" maxlength="50" class="form-control" name="cf2name" value="<?php echo $customer->cf2name; ?>">
            <span class="help-block" id="cf2-err"></span>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group well" id="cf3-field">
            <label for="cf3">Custom Field 3:</label>
            <br/>
            <input type="text" maxlength="50" class="form-control" name="cf3name" value="<?php echo $customer->cf3name; ?>">
            <span class="help-block" id="cf3-err"></span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF1 Enabled?:</label>
            <input type="checkbox" name="cf1enabled" <?php if($customer->cf1enabled == 1) {echo 'checked';} ?>>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF1 Required?:</label>
            <input type="checkbox" name="cf1required" <?php if($customer->cf1required == 1) {echo 'checked';} ?>>
        </div>
    </div>

    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF2 Enabled?:</label>
            <input type="checkbox" name="cf2enabled" <?php if($customer->cf2enabled == 1) {echo 'checked';} ?>>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF2 Required?:</label>
            <input type="checkbox" name="cf2required" <?php if($customer->cf2required == 1) {echo 'checked';} ?>>
        </div>
    </div>

    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF3 Enabled?:</label>
            <input type="checkbox" name="cf3enabled" <?php if($customer->cf3enabled == 1) {echo 'checked';} ?>>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF3 Required?:</label>
            <input type="checkbox" name="cf3required" <?php if($customer->cf3required == 1) {echo 'checked';} ?>>
        </div>
    </div>
</div>

<hr/>

<div class="btns">
    <button type="button" class="btn btn-primary btn-lg editcustomer-submit"><span class="glyphicon glyphicon-pencil"></span> Update Customer</button>
    <span class="space"></span>
    <button type="button" class="btn btn-warning btn-lg editcustomer-cancel"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
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