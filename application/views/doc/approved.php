
<? if($this->session->flashdata('confirmation')){
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'],$confirmation['message']);
} ?>
<h2>Approved Documents</h2>
<hr/>
<div class="well">
    <form action="<?= base_url().'index.php/docc/document_wizard_view'; ?>">
        <button class="btn btn-warning btn-large">Change to Wizard View</button>
    </form>
</div>
<div class="listItem">
    <?= $doctable; ?>
</div>