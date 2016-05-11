<li class="dropdown danger">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        <i class="fa fa-exclamation-circle"></i>
        <span id="notifReqSign"><strong></strong></span>
    </a>
    <ul class="dropdown-menu danger  animated fadeInDown">
        <li class="title">
            Pemberitahuan
        </li>
        <li>
            <ul class="list-group notifications">
                <a href="<?= base_url('participant/request') ?>">
                    <li class="list-group-item">
                        <span class="badge" id="badgeNotifReqGroup">0</span>
                        <i class="fa fa-users icon"></i>
                        Permintaan gabung kelompok
                    </li>
                </a>
            </ul>
        </li>
    </ul>
</li>
<li class="dropdown profile">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= $this->session->userdata('nama') ?><span class="caret"></span></a>
    <ul class="dropdown-menu animated fadeInDown">
        <li>
            <div class="profile-info">
                <h5 class="username"><?= $this->session->userdata('nbi') ?></h5>
                <p><?= $this->session->userdata('nama') ?></p>
                <div class="btn-group margin-bottom-2x" role="group">
                    <a href="<?= base_url('participant/profile') ?>" class="btn btn-default"><i class="fa fa-user"></i> Profile</a>
                    <a href="<?= base_url('login/logout') ?>" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>
        </li>
    </ul>
</li>