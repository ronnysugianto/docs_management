
<?
if ($this->session->flashdata('confirmation')) {
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'], $confirmation['message']);
}
?>
<h2><?= $page_title; ?></h2>
<hr/>
<form id="form-input" name="form-input" method="post" accept-charset="utf-8" action="<?= site_url('userc/changePass/' . $idedit); ?>" class="form-horizontal" onsubmit="return validate();">
    <div class="control-group">
        <label class="control-label" >Old Password</label>
        <div class="controls">
            <input type="password" id="old_pass" name="old_pass" placeholder="" value="" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >New Password</label>
        <div class="controls">
            <input type="password" id="new_pass" name="new_pass" placeholder="" value=""  />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Confirm Password</label>
        <div class="controls">
            <input type="password" id="conf_pass" name="conf_pass" placeholder="" value=""  />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" ></label>
        <div class="controls">
            <button class="btn btn-primary btn-large" name="submit" id='submit'>Save Changes</button>
            <input type="button" class="btn btn-warning btn-large" onclick="history.go(-1)" value="Cancel"/>
        </div>
    </div>
</form>
<script type="text/javascript">
<?= init_validation('form-input'); ?>

    function validate() {
        var pass = trim($('#new_pass').val());
        var conf = trim($('#conf_pass').val());

        $('form-input').validationEngine('hideAll');

        if(pass === ''){
            <?= show_validate_prompt('conf_pass', 'Password can not be empty'); ?>
            return false;
        }
        if (pass !== conf) {
<?= show_validate_prompt('conf_pass', 'Password not match'); ?>
            return false;
        }

        return true;
    }
</script>
