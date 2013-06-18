
<?
if ($this->session->flashdata('confirmation')) {
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'], $confirmation['message']);
}
?>
<h2><?= $page_title; ?></h2>
<hr/>
<form id="form-input" method="post" accept-charset="utf-8" action="<?= site_url('userc/editItem/' . $idedit); ?>" class="form-horizontal">
    <div class="control-group">
        <label class="control-label" >Username</label>
        <div class="controls">
            <input type="text" id="username" name="username" placeholder="" value="<?= html_entity_decode($user->username, ENT_QUOTES); ?>" disabled />
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Role</label>
        <div class="controls">
            <?= form_dropdown('user_role', $user_roles, $user->role); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >E-mail</label>
        <div class="controls">
            <input type="text" id="email" name="email" placeholder="" value="<?= $user->email; ?>" class="validate[required,custom[email]]"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" >Status</label>
        <div class="controls">
            <?= form_dropdown('user_status', $user_status, $user->status); ?>
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
</script>