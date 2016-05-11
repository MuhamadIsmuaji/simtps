<li class="panel panel-default dropdown">
    <a data-toggle="collapse" href="#dropdown-lecturer">
        <span class="icon fa fa-user"></span><span class="title">Dosen</span>
    </a>
    <!-- Dropdown level 1 -->
    <div id="dropdown-lecturer" class="panel-collapse collapse">
        <div class="panel-body">
            <ul class="nav navbar-nav">
                <li><a href="<?= base_url('lecturer/dashboard') ?>">Dashboard</a>
                </li>
                <li><a href="<?= base_url('lecturer/data/group') ?>">Daftar Kelompok</a>
                </li>
                <li><a href="<?= base_url('lecturer/data/review') ?>">Review Sidang</a>
                </li>
            </ul>
        </div>
    </div>
</li>
