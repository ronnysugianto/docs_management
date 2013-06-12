<?
if ($this->session->flashdata('confirmation')) {
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'], $confirmation['message']);
}
?>

<h2>Document Statistic </h2>
<hr/>
<div class="filterDiv well">
    <form action="<?= base_url().'index.php/docc/send_statistic/'?>" method="post">
        <input type="submit" id="email_button" class="btn btn-success btn-large" value="Email All Pending Documents"/>
    </form>
</div>
<div class="row-fluid" style="text-align:center">
    <div class="span3 well" style="background:#0064CC; color:white;">
        <h1>
            <? if($statistic->emailed !== NULL) echo $statistic->emailed;
               else echo '0';
            ?>
        </h1>
        <strong>Document(s) Emailed</strong>
    </div>
    <div class="span3 well" style="background:#51A351; color:white;">
        <h1>
            <? if($statistic->unemailed !== NULL) echo $statistic->unemailed;
               else echo '0';
            ?>
        </h1>
        <strong>Document(s) Not Yet Emailed</strong>
    </div>
    <div class="span3 well" style="background:#F89406; color:white;">
        <h1>
            <? if($statistic->archived !== NULL) echo $statistic->archived;
               else echo '0';
            ?>
        </h1>
        <strong>Document(s) Archived</strong>
    </div>
    <div class="span3 well" style="background:#9B5A00; color:white;">
        <h1>
            <? if($statistic->unarchived !== NULL) echo $statistic->unarchived;
               else echo '0';
            ?>
        </h1>
        <strong>Document(s) Not Yet Archived</strong>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#email_button').click(function(){
            location.href=""+<?= base_url().'index.php/docc/send_all_statistic'; ?>;
        });
    });
</script>