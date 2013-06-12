
<? if($this->session->flashdata('confirmation')){
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'],$confirmation['message']);
} ?>
<h2>Pending Documents</h2>
<hr/>

<div class="listItem">
    <?= $doctable; ?>
</div>