
<? if($this->session->flashdata('confirmation')){
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'],$confirmation['message']);
} ?>
<h2>Pending Documents</h2>
<hr/>
<div class="filterDiv well">
    <form id="form-input" name="forminput"  class="filter-form" method="post" accept-charset="utf-8" action="<?= site_url('docc/pending_filter'); ?>" class="form-horizontal">
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label pull-left">Ref. ID</label>
                    <div class="controls">
                        <input type="text" id="ref_id" name="ref_id" value="<?= $filter['ref_id']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label pull-left" >Type</label>
                    <div class="controls">
                        <?= form_dropdown('type', $doc_types,$filter['type']); ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label pull-left">Created By</label>
                    <div class="controls">
                        <?= form_dropdown('created_by', $created_by_list,$filter['created_by']); ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <button class="btn btn-success btn-large" >Filter Result</button>
            </div>
        </div>
    </form>
</div>
<div class="well">
    <form action="<?= base_url().'index.php/docc/document_wizard_view'; ?>">
        <button class="btn btn-warning btn-large">Change to Wizard View</button>
    </form>
</div>
<div class="listItem">
    <?= $doctable; ?>
</div>