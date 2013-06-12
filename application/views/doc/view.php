<?
if ($this->session->flashdata('confirmation')) {
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'], $confirmation['message']);
}
?>

<h2><?= $page_title; ?></h2>
<hr/>
<form id="form-input" method="post" accept-charset="utf-8" action="<?= site_url('docc/change_status/'.$iditem); ?>" class="form-horizontal">
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
        <div class="span10"></div>
        <div class="span15 pull-right">
        <input type="submit" class="btn btn-success btn-large" value="Mark as Approved" onclick="select_status('1')"/>
        <input type="submit" class="btn btn-danger btn-large" value="Mark as Rejected" onclick="select_status('-1')"/>
        <input type="button" class="btn btn-warning btn-large" onclick="go_to_list()" value="Go Back"/>
        </div>
        <input type="hidden" name="status_selected" id="status_selected"/></div>
</form>
<script type="text/javascript">
    function select_status(status){
        $('#status_selected').val(status);
    }
    function go_to_list(){
        location.href = "<?= base_url().'index.php/docc/'; ?>";
    }
</script>