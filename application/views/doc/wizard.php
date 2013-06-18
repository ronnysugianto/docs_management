<form id="form-input" method="post" accept-charset="utf-8" action="<?= site_url('docc/document_wizard_view/'); ?>" class="form-horizontal">
<? if($this->session->flashdata('confirmation')){
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'],$confirmation['message']);
} ?>
<div class='row-fluid'>
    <div class='row'>
        <? $script_text = ''; ?>
        <? if($has_document){  ?>
        <div class="span5">
            <h2>Document Ref. ID : <?= $doc->iddocument; ?> </h2>
        </div>
        <? } ?>
        <div class="span7 pull-right" style="text-align: right">
            <input type="submit" class="btn btn-primary btn-large" id="prev_btn" onclick="select_method('prev')" value="Prev"/>
            <input type="submit" class="btn btn-success btn-large" value="Mark as Approved" onclick="select_status('1')" id="approve_btn"/>
            <input type="submit" class="btn btn-danger btn-large" value="Mark as Rejected" onclick="select_status('-1')" id="reject_btn"/>
            <input type="submit" class="btn btn-primary btn-large" id="next_btn" onclick="select_method('next')" value="Next"/>
        </div>
    </div>
    <? if($has_document){ ?>
    <div class="row well">
        <div class="span12">
    <div class="span5">
        <div class="control-group">
            <label class="control-label" >Ref. ID</label>
            <div class="controls">
                <input type="text" value="<?= $doc->iddocument; ?>" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Type</label>
            <div class="controls">
                <input type="text" value="<?= $doc->type; ?>" disabled />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Status</label>
            <div class="controls">
                <input type="text" value="<?= $doc->status; ?>" disabled />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Created Date</label>
            <div class="controls">
                <input type="text" value="<?= $doc->created_date; ?>" disabled />
            </div>
        </div>
       <div class="control-group">
            <label class="control-label" >Created For</label>
            <div class="controls">
                <input type="text" value="<?= $doc->created_for_name; ?>" disabled/>
            </div>
        </div>
    </div>
    <div class="span7">
         <div class="control-group">
            <label class="control-label" >Priority</label>
            <div class="controls">
                <input type="text" value="<?= $doc->priority; ?>" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Created By</label>
            <div class="controls">
                <input type="text" value="<?= $doc->created_by_name; ?>" disabled/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Description</label>
            <div class="controls" style="padding-top:5px;">
                <?= html_entity_decode($doc->description,ENT_QUOTES)?>
            </div>
        </div>
    </div>
</div>
</div>
    <div class="span10" style="text-align: center">
        <img src="<?= $imgpath.$doc->image; ?>" id="img" name="img" class="img-polaroid" width="1024px"/>
    </div>
</div>
<? }else{
	echo "<h2>No more document found</h2>";
	$script_text = "$('#approve_btn').attr('disabled','disabled');$('#reject_btn').attr('disabled','disabled');";

    echo '<input type="hidden" name="iddocument" id="iddocument" value="<?= $current_id; ?>" />';
} ?>

<?
    if($has_next == FALSE)
        $script_text .= "$('#next_btn').attr('disabled','disabled');";
    if($has_prev == FALSE)
        $script_text .= "$('#prev_btn').attr('disabled','disabled');";

    echo "<script type='text/javascript'>$(document).ready(function(){".$script_text."});</script>";
?>
    <input type="hidden" name="action" id="action" value="null" />
    <input type="hidden" name="iddocument" id="iddocument" value="<?= $current_id; ?>" />
    <input type="hidden" name="status_selected" id="status_selected" value="" />
</form>
<script type="text/javascript">
    function select_status(status){
        $('#status_selected').val(status);
    }
    function select_method(method){
    	$('#action').val(method);
    }

</script>