<?
if ($this->session->flashdata('confirmation')) {
    $confirmation = $this->session->flashdata('confirmation');
    echo display_confirmation($confirmation['type'], $confirmation['message']);
}
?>

<h2>Document Statistic </h2>
<hr/>
<div class="filterDiv well">
    <? if($statistic->unemailed !== NULL && $statistic->unemailed > 0){ ?>
    <form action="<?= base_url().'index.php/docc/send_statistic/'?>" method="post">
        <input type="submit" id="email_button" class="btn btn-success btn-large" value="Send Statistic Report via Email"/>
    </form>
    <? }else echo "<h4>No Pending Emails</h4>" ?>
</div>
<div class="row-fluid" style="text-align:center">
    <div class="span6 well" style="background:#0064CC; color:white;">
        <h1>
            <? if($statistic->emailed !== NULL) echo $statistic->emailed;
               else echo '0';
            ?>
        </h1>
        <strong>Document(s) Emailed</strong>
    </div>
    <div class="span6 well" style="background:#51A351; color:white;">
        <h1>
            <? if($statistic->unemailed !== NULL) echo $statistic->unemailed;
               else echo '0';
            ?>
        </h1>
        <strong>Document(s) Not Yet Emailed</strong>
    </div>
</div>