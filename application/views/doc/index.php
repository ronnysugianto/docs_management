
<? if($this->session->flashdata('confirmation')){
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'],$confirmation['message']);
} ?>
<h2>Document List</h2>
<hr/>
<div class="filterDiv well">
    <form id="form-input" name="forminput"  class="filter-form" method="post" accept-charset="utf-8" action="<?= site_url('docc/filter'); ?>" class="form-horizontal">
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group">
                    <label class="control-label pull-left">Ref. ID</label>
                    <div class="controls">
                        <input type="text" id="ref_id" name="ref_id" value="<?= $filter['ref_id']; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label pull-left" >Status</label>
                    <div class="controls">
                        <?= form_dropdown('status',$doc_status,$filter['status']); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label pull-left" >Status Date</label>
                    <div class="controls">
                        <input type="text" id="status_date" name="status_date" value="<?= $filter['status_date']; ?>">
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label pull-left" >Type</label>
                    <div class="controls">
                        <?= form_dropdown('type', $doc_types,$filter['type']); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label pull-left">Created By</label>
                    <div class="controls">
                        <?= form_dropdown('created_by', $created_by_list,$filter['created_by']); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label pull-left" >Created For</label>
                    <?= form_dropdown('created_for', $created_for_list,$filter['created_for']); ?>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <label class="control-label pull-left">Priority</label>
                    <div class="control-group">
                        <?= form_dropdown('priority',$priority_list,$filter['priority']); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label pull-left">Sorted By</label>
                    <div class="control-group">
                        <?= form_dropdown('sorted_by',$sorted_list,$filter['sorted_by']); ?>
                    </div>
                </div>
            </div>

            <div class="span10">
                <button class="btn btn-success btn-large" >Filter Result</button>
            </div>
        </div>
    </form>
</div>
<div class='filterDiv well'>
    <div class="row">
        <div class="span2">
            <button class="btn btn-primary btn-medium" onclick="location.href='<?= site_url('docc/add'); ?>'">Add New Document</button>
        </div>
        <div class="span6">
            <form class="form-inline" action="<?= base_url().'index.php/docc/bulk_action/' ?>" method="post" onsubmit="return validate()">
                <div class="control-group">
                    <label class="control-label pull-left" style="width:80px;">Bulk Action</label>
                    <div class="control-group">
                        <?= form_dropdown('bulk_action',$bulk_action_list); ?>
                        <button class="btn btn-primary btn-medium" onclick="set_selected_row()">Apply to Selected</button>
                    </div>
                    <input type="hidden" id="selected_row_id" name="selected_row_id" />
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="listItem">
        <?= $doctable; ?>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#status_date').datepicker({ format:'yyyy-mm-dd' });
    });
    function set_selected_row(){
        $('#selected_row_id').val(getSelectedCheckboxes('doctable_check[]',true));
    }
    function validate(){
        if(!isFilled($('#selected_row_id').val())){
            return false;
        }
        return true;
    }
    </script>