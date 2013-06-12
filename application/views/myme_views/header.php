<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
<!--            <a class="brand" href="--><?//= site_url('login/index'); ?><!--">Ottimmo International</a>-->
            <?php
            if (!empty($current_user)){
                ?>
                <ul class="nav">

                    <?$userlogin = $this->session->userdata('userlogin'); ?>

                    <? if($userlogin['role'] === "ADMIN" || $userlogin['role'] === "SUPERUSER") { ?>
                        <li><a href="<?= site_url('userc/index'); ?>">User</a></li>
                    <? } ?>
                    <li><a href="<?= site_url('docc/index'); ?>">Document</a></li>

                    <? //if($userlogin['role'] === "SECRETARY") { ?>
                        <li><a href="<?= site_url('docc/approved'); ?>">Approved</a></li>
                        <li><a href="<?= site_url('docc/pending'); ?>">Pending</a></li>
                        <li><a href="<?= site_url('docc/statistic'); ?>">Statistic</a></li>
                    <? //} ?>
                </ul>

                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Hi, <?= $current_user['username'] ?> <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url('userc/profile/'.$userlogin['iduser']); ?>">My Profile</a></li>
                            <li><a href="<?= site_url('loginc/logout'); ?>">Logout</a></li>
                        </ul>
                    </li>

                </ul>
                <?php
            } else {
                ?>
                <ul class="nav pull-right">
                    <li><a href="<?= site_url('loginc/index'); ?>">Login</a></li>
                </ul>
                <?php } ?>
        </div>
    </div>
</div>