<li class="dropdown profile">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        <?php 
            $var = $this->session->userdata('nama');
            $say = substr($var,0,15);
        ?>
        <?= $say.'...' ?>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu animated fadeInDown">
        <li>
            <div class="profile-info">
                <h5 class="username"><?= $this->session->userdata('npp') ?></h5>
                <p><?= $this->session->userdata('nama') ?></p>
                <div class="btn-group margin-bottom-2x" role="group">
                    <a href="<?= base_url('lecturer/setting/profile') ?>" class="btn btn-default"><i class="fa fa-user"></i> Profile</a>
                    <a href="<?= base_url('login/logout') ?>" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>
        </li>
    </ul>
</li>