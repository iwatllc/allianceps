
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
            <label for="cf1">Show Name?:</label>
            <input type="checkbox" name="showname" checked>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">Show Logo?:</label>
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
            <label for="cf1">CF1 Enabled?:</label>
            <input type="checkbox" name="cf1enabled">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF1 Required?:</label>
            <input type="checkbox" name="cf1required">
        </div>
    </div>

    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF2 Enabled?:</label>
            <input type="checkbox" name="cf2enabled">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF2 Required?:</label>
            <input type="checkbox" name="cf2required">
        </div>
    </div>

    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF3 Enabled?:</label>
            <input type="checkbox" name="cf3enabled">
        </div>
    </div>
    <div class="col-xs-2">
        <div class="form-group well">
            <label for="cf1">CF3 Required?:</label>
            <input type="checkbox" name="cf3required">
        </div>
    </div>
</div>

<hr/>

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