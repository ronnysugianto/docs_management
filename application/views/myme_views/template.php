<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= $page_title ?></title>
        <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
        <meta content="utf-8" http-equiv="encoding">

        <script type="text/javascript">
            var base_url = "<?php print base_url(); ?>";
        </script>
        <?=
            /**
             * Basic Import : Twitter Bootstrap, JQuery, marshable.js
             */
                link_tag($this->config->item('css_bootstrap')).
                link_tag($this->config->item('css_bootstrap_responsive')).
                link_tag($this->config->item('css_myme')).
                link_tag($this->config->item('css_formvalidation')).
                script_tag($this->config->item('script_jquery')).
                script_tag($this->config->item('script_bootstrap')).
                script_tag($this->config->item('script_marshable')).
                script_tag($this->config->item('script_formvalidation_en')).
                script_tag($this->config->item('script_formvalidation'));
        ?>


        <? if(!empty($baseimport)) echo $baseimport; ?>
    </head>
    <body>
    <div class="container">
        <header>
            <? $this->load->view('myme_views/header'); ?>
        </header>

        <section style="margin-top:80px;margin-bottom: 150px;">
            <div class="container">
                <? $this->load->view($view); ?>
            </div>
        </section>

        <footer>
                <? $this->load->view('myme_views/footer'); ?>
        </footer>
    </div>
    </body>
</html>