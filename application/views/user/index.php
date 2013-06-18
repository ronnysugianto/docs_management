
<? if($this->session->flashdata('confirmation')){
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'],$confirmation['message']);
} ?>
<h2>Admin User List</h2>
<hr/>
<button class="btn btn-primary btn-large" onclick="location.href='<?= site_url('userc/add'); ?>'">Add New User</button>
<div class="listItem">
    <?= $usertable; ?>
</div>