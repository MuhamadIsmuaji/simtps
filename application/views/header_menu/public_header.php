<!--<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-comments-o"></i></a>
    <ul class="dropdown-menu animated fadeInDown">
        <li class="title">
            Notification <span class="badge pull-right">0</span>
        </li>
        <li class="message">
            No new notification
        </li>
    </ul>
</li>
<li class="dropdown danger">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-star-half-o"></i> 4</a>
    <ul class="dropdown-menu danger  animated fadeInDown">
        <li class="title">
            Notification <span class="badge pull-right">4</span>
        </li>
        <li>
            <ul class="list-group notifications">
                <a href="#">
                    <li class="list-group-item">
                        <span class="badge">1</span> <i class="fa fa-exclamation-circle icon"></i> new registration
                    </li>
                </a>
                <a href="#">
                    <li class="list-group-item">
                        <span class="badge success">1</span> <i class="fa fa-check icon"></i> new orders
                    </li>
                </a>
                <a href="#">
                    <li class="list-group-item">
                        <span class="badge danger">2</span> <i class="fa fa-comments icon"></i> customers messages
                    </li>
                </a>
                <a href="#">
                    <li class="list-group-item message">
                        view all
                    </li>
                </a>
            </ul>
        </li>
    </ul>
</li>-->

<li class="dropdown profile">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="icon fa fa-key"></span>&nbsp;Login Here <span class="caret"></span></a>
    <ul class="dropdown-menu animated fadeInDown">
        <li>
            <div class="profile-info">  
                <form id="formLogin">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" onkeypress="return numbersonly(this,event)" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="form-group">
                        <p class="help-block">Gunakan NPM / NPP sebagai Username</p>
                        <p class="help-block">
                            Untuk peserta gunakan NPM sebagai password untuk pertama kali login
                        </p>
                    </div>
                    <div class="form-group">
                        <p class="help-block" id="alertfailed"></p>
                    </div>
                    <button type="submit" id="btnLogin" class="btn btn-block btn-primary">Login</button>
                </form>
            </div>
        </li>
    </ul>
</li>


<script type="text/javascript">
    $(function(){
        login();

    });

    function login() {
        $('#formLogin').on('submit',function(e){
            e.preventDefault();
            $('#btnLogin').prop('disabled',1);
            $('#btnLogin').html('Processing...');

            var formData = $(this).serialize();
            $.ajax({
                url     : "<?= base_url('login/loginProcess')?>",
                method  : 'post',
                data    : formData,
                success : function(msg){
                    if (msg == 0) {
                        $('#alertfailed').html('<i style="color: red">Username or Password unvalid</i>');
                    } else if (msg == 1) {
                        $('#alertfailed').html('<i style="color: red">Your account is not active </i>');
                    } else if (msg == 2) {
                        window.location.href = "<?= base_url('lecturer/home') ?>";
                        //$('#alertfailed').html('<i style="color: red">You Login As Lecturer </i>');
                    } else if (msg == 3) {
                        window.location.href = "<?= base_url('admin/home') ?>";
                        //$('#alertfailed').html('<i style="color: red">You Login As Admin</i>');
                    } else{
                        window.location.href = "<?= base_url('participant/confirmation') ?>";
                        //$('#alertfailed').html('<i style="color: red">Konfirmasi Email</i>');
                    }
                    //console.log(msg);
                    $('#btnLogin').prop('disabled',0);
                    $('#btnLogin').html('Login');
                },
                error: function (jqXHR, textStatus, errorThrown){
                    //alert('ur invalid!');
                }
            });
        });
    }
</script>