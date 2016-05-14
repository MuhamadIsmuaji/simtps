<li class="panel panel-default dropdown">
    <a data-toggle="collapse" href="#dropdown-admin">
        <span class="icon fa fa-lock"></span><span class="title">Admin</span>
    </a>
    <!-- Dropdown level 1 -->
    <div id="dropdown-admin" class="panel-collapse collapse">
        <div class="panel-body">
            <ul class="nav navbar-nav">
                <li><a href="<?= base_url('admin/setting/system') ?>">Pengaturan Sistem</a>
                </li>
                <li><a href="<?= base_url('admin/data/lecturer') ?>">Dosen</a>
                </li>
                <li><a href="<?= base_url('admin/data/news') ?>">Pengumuman</a>
                </li>
                <li><a href="<?= base_url('admin/data/participant') ?>">Peserta</a>
                </li>
                <li><a href="<?= base_url('admin/data/group') ?>">Kelompok</a>
                </li>
                <li><a href="<?= base_url('admin/data/loa') ?>">Surat Tugas</a>
                </li>
                <li><a href="<?= base_url('admin/data/schedule/hearingSchedule') ?>">Jadwal Sidang</a>
                </li>
                <li><a href="<?= base_url('admin/data/point') ?>">Daftar Nilai</a>
                </li>
            </ul>
        </div>
    </div>
</li>
