<?
if ($this->session->flashdata('confirmation')) {
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'], $confirmation['message']);
}
?>

<h2><?= $page_title; ?></h2>
<hr/>
<form id="form-input" method="post" accept-charset="utf-8" action="<?= site_url('docc/addItem'); ?>" class="form-horizontal" enctype="multipart/form-data">
    <div class="span6" style="border-right:2px solid silver">
        <div class="control-group" >
            <label class="control-label" >Type</label>
            <div class="controls">
                <?= form_dropdown('type',$doc_types); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Created For</label>
            <div class="controls">
                <?= form_dropdown('created_for', $created_for_list); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Priority</label>
            <div class="controls">
                <?= form_dropdown('priority', $priority_list); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" >Description</label>
            <div class="controls">
                <textarea id="doc_desc_area" name="doc_desc_area"></textarea>
            </div>
        </div>
    </div>
    <div class="span4">
        <img src="<?= $imgpath.'no_image.jpg'; ?>" class="img-polaroid" width="250px" height="250px"/>
        <div>
            <input type="file" id="userfile" name="userfile" />
        </div>
    </div>
    <div class="span10">
        <div class="control-group">
            <label class="control-label" ></label>
            <div class="controls">
                <button class="btn btn-primary btn-large" name="submit" id='submit'>Save Changes</button>
                <input type="button" class="btn btn-warning btn-large" onclick="history.go(-1)" value="Cancel"/>
            </div>
        </div>
    </div>
    <input type="hidden" name="doc_desc" id="doc_desc"/>
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('#submit').click(function(){
            fillTinyText('doc_desc',tinyMCE.get('doc_desc_area').getContent());
        });
    });
</script>