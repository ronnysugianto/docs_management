<div class="hero-unit">
    <div class="row">
        <div class="span2">
            <img src="<?= $logourl; ?>" alt="MyMe.Technology"/>
        </div>
        <div class="span8">
            <h1>Document Management</h1>
            <p>Administrator Page</p>
            <form id="formLogin" action="<?= site_url('loginc/doLogin/'); ?>" method="post" class="form-inline">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input name="username" class="input-medium" placeholder="Username" type="text" id="nickname" value="ron" />
                </div>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input name="password" class="input-medium" placeholder="Password" type="password" id="password" value="haha"/>
                </div>
                <input type="submit" name="submit" value="Login" class="btn btn-primary btn-medium" />
        </div>
        <div id="login_response"></div>
    </div>
</div>
