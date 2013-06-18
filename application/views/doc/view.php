<form id="form-input" method="post" accept-charset="utf-8" action="<?= site_url('docc/change_status/'); ?>" class="form-horizontal">
<? if($this->session->flashdata('confirmation')){
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'],$confirmation['message']);
} ?>
<? if(isset($doc->iddocument)){ ?>

    <div class='row'>
        <div class="span5">
            <h2>Document Ref. ID : <?= $doc->iddocument; ?> </h2>
        </div>
        <div class="span7">
            <div class="span10 pull-right" style="text-align: right">
                <? if(isset($status_code) && $status_code == '0'){ ?>
                <input type="submit" class="btn btn-primary btn-large" id="prev_btn" onclick="select_method('prev')" value="Prev"/>
                <input type="submit" class="btn btn-success btn-large" value="Mark as Approved" onclick="select_status('1')"/>
                <input type="submit" class="btn btn-danger btn-large" value="Mark as Rejected" onclick="select_status('-1')"/>
                <input type="submit" class="btn btn-primary btn-large" id="next_btn" onclick="select_method('next')" value="Next"/>
                <? }else{ ?>
                    <input type="button" class="btn btn-primary btn-large" id="archive_btn" onclick="select_status('3')" value="Mark As Archived"/>
                    <input type="button" class="btn btn-warning btn-large" id="cancel_btn" onclick="history.go(-1)" value="Cancel"/>
                <? } ?>
            </div>
        </div>
    </div>
    <div class="row well">
        <div class="span12">
            <div class="span4">
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

    <div class="span12" >
        <img src="<?= $imgpath.$doc->image; ?>" id="img" name="img" class="img-polaroid" width="1024px" />
            <input type="hidden" name="action" id="action" value="null" />
    <input type="hidden" name="iddocument" id="iddocument" value="<?= $doc->iddocument; ?>" />
    <input type="hidden" name="status_selected" id="status_selected" value="" />
    </div>
</div>
<? }else{
    echo "<h2>No more document found</h2>";
    if(isset($action_btn)){
        $script_text = '';
        if($action_btn == "next")
            $script_text = "$('#next_btn').attr('disabled','disabled');";
        else if($action_btn == "prev")
            $script_text = "$('#prev_btn').attr('disabled','disabled');";
        echo "<script type='text/javascript'>$(document).ready(function(){".$script_text."});</script>";
    }
} ?>
</form>
<script type="text/javascript">
    function select_status(status){
        $('#status_selected').val(status);
    }
    function select_method(method){
        $('#action').val(method);
    }
    function go_to_list(prev_page){
        location.href = "<?= base_url().'index.php/docc/'; ?>" + prev_page;
    }

</script>