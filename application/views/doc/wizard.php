<h2>Document Ref. ID : <?= $doc->iddocument; ?> </h2>
<hr/>
<form id="form-input" method="post" accept-charset="utf-8" action="<?= site_url('docc/document_wizard_view/'.$doc->iddocument); ?>" class="form-horizontal">
	<div class='row well'>
	    <div class="span6" style="border-right:2px solid silver;">
	        <div class="control-group">
	            <label class="control-label" >Ref. ID</label>
	            <div class="controls">
	                <span><?= $doc->iddocument; ?></span>
	            </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" >Type</label>
	            <div class="controls">
	                <?= $doc->type; ?>
	            </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" >Status</label>
	            <div class="controls">
	                <?= $doc->status; ?>
	            </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" >Created For</label>
	            <div class="controls">
	                <?= $doc->created_for_name; ?>
	            </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" >Priority</label>
	            <div class="controls">
	                <?= $doc->priority; ?>
	            </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" >Created By</label>
	            <div class="controls">
	                <?= $doc->created_by_name; ?>
	            </div>
	        </div>
	        <div class="control-group">
	            <label class="control-label" >Description</label>
	            <div class="controls">
	                <textarea id="doc_desc_area" name="doc_desc_area"><?= html_entity_decode($doc->description,ENT_QUOTES)?></textarea>
	            </div>
	        </div>
	    </div>
	    <div class="span3">
	        <img src="<?= $imgpath.$doc->image; ?>" id="img" name="img" class="img-polaroid" width="250px" height="250px"/>
	    </div>
	    <input type="hidden" name="action" id="action" value="null" />
	    <div class="span10"></div>
	    <div class="span15 pull-right">
	    	<input type="button" class="btn btn-primary btn-large" onclick="go_to_list('prev')" value="Prev"/>
	        <input type="submit" class="btn btn-success btn-large" value="Mark as Approved" onclick="select_status('1')"/>
	        <input type="submit" class="btn btn-danger btn-large" value="Mark as Rejected" onclick="select_status('-1')"/>
	        <input type="button" class="btn btn-primary btn-large" onclick="go_to_list('next')" value="Next"/>
	    </div>
	</div>
</form>
<script type="text/javascript">
    function select_status(status){
        $('#status_selected').val(status);
    }
    function select_status(value_select){
    	$('#action').val(value_select);
    }
    function go_to_list(method){
        location.href = "<?= base_url().'index.php/docc/'; ?>";
    }
</script>