<?
if ($this->session->flashdata('confirmation')) {
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'], $confirmation['message']);
}
?>

<h2><?= $page_title; ?></h2>
<hr/>
<form id="form-input" method="post" accept-charset="utf-8" action="<?= site_url('userc/addItem'); ?>" class="form-horizontal" onsubmit="return validate()">
    <div class="control-group">
        <label class="control-label" >Username</label>
        <div class="controls">
            <input type="text" id="username" name="username" placeholder="Username" value="" class="validate[required]" />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Role</label>
        <div class="controls">
            <?= form_dropdown('user_role', $user_roles); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >E-mail</label>
        <div class="controls">
            <input type="text" id="email" name="email" placeholder="E-mail" value=""  class="validate[required,custom[email]]"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Password</label>
        <div class="controls">
            <input type="password" id="password" name="password" placeholder="Password" value=""  class="validate[required]"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Confirm Password</label>
        <div class="controls">
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" value="" />
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
        var pass = trim($('#password').val());
        var conf = trim($('#confirmpassword').val());

        $('form-input').validationEngine('hideAll');

        if (pass !== conf) {
<?= show_validate_prompt('confirmpassword', 'Password not match'); ?>
            return false;
        }

        return true;
    }
</script>