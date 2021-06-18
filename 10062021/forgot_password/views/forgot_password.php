<style>
    .top-search-holder,
    .top-cart-row-container {
        display: none;
    }
</style>
<main id="authentication" class="inner-bottom-md">
    <!-- <div class="container" > -->
    <div class="container container-row container-content" style="margin-top:6em;">
        <div class="card-content" style="padding: 35px 200px;">
            <h3 class="font-weight-bold">Lupa Password</h3>
            <h6 class="text-muted">Kembalikan Password Anda</h6>
            <?php if($this->session->flashdata("result")){ ?>
            <div
                style="border: 1px solid #999999; background: none repeat scroll 0% 0% tomato; padding: 4px 4px 0px; margin-bottom: 6px;">
                <label><?php echo $this->session->flashdata("result"); ?></label>
            </div>
            <?php } ?>
            <form role="form" name="contact_form" class="login-form cf-style-1"
                action="<?php echo base_url();?>forgot_password/save" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                    value="<?php echo $this->security->get_csrf_hash(); ?>">

                <hr style="margin:10px 0px">
                <h6 class="text-muted mb-2">Masukan Email dan Nomor kTP anda yang telah terdaftar oleh perhutani.
                    <br>Kami akan mengkonfirmasi melalui email terdaftar</h6>
                <div class="border-frame">
                    <label class="required font-12 text-muted">Masukan Email Anda</label>
                    <input class="input form-control mb-2 no-border-input" type="text" name="email" id="email"
                        placeholder="Email">
                    <label class="required font-12 text-muted">Masukkan Nomor KTP Anda</label>
                    <input class="input form-control mb-2 no-border-input" type="text" name="no_ktp" jd="no_ktp"
                        placeholder="Nomor KTP">
                    <label class="required font-12 text-muted">Kode Keamanan</label>
                    <!--6LcKp-4UAAAAAK_-88mPl0l_RQFpIIu1hbWmb275-->
                    <div class="g-recaptcha" data-sitekey="6LdXfuYUAAAAAC2J8Hfrxue7hQ-0SIc7w8aaXa0s"
                        style="margin-left:1px;"></div>
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn btn-main">Kirim</button>

                    </div>
            </form>
        </div>

    </div>
    </div>
    <!-- </div> -->
    <!-- /.container -->
</main><!-- /.authentication -->


<!-- datepicker -->
<script type='text/javascript' src='<?php echo base_url();?>assets/js/jquery/jquery-ui-1.10.1.custom.min.js'></script>
<link href="<?php echo base_url();?>assets/css/ui.css" rel="stylesheet" type="text/css" />
<!-- jQuery -->
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>

<style type="text/css">
    .tasks-list-item {
        -moz-user-select: none;
        cursor: pointer;
        display: block;
        font-weight: normal;
        padding: 4px 0px;
    }

    .tasks-list-cb {
        display: none;
    }

    .tasks-list-mark {
        border: 2px solid #C4CBD2;
        border-radius: 30px;
        display: inline-block;
        height: 30px;
        margin-right: 2px;
        position: relative;
        vertical-align: top;
        width: 30px;
        padding: 3px 0px 0px 26px;
        color: #333333;
        font-weight: normal;
    }

    .tasks-list-mark:before {
        content: "\2714";
        display: none;
        height: 4px;
        left: 50%;
        color: #FF0000;
        margin: -10px 0px 0px -5px;
        position: absolute;
        top: 50%;
        width: 8px;
    }

    .tasks-list-cb:checked~.tasks-list-mark {
        border-color: #39CA74;
    }

    .tasks-list-cb:checked~.tasks-list-mark:before {
        display: block;
    }

    .tasks-list-desc {
        color: #8A9A9B;
        /*font-weight: bold; */
    }

    .tasks-list-cb:checked~.tasks-list-desc {
        color: #34BF6E;
    }
</style>


<script type="text/javascript">
    function getkey(e) {
        if (window.event)
            return window.event.keyCode;
        else if (e)
            return e.which;
        else
            return null;
    }

    function goodchars(e, goods, field) {
        var key, keychar;
        key = getkey(e);
        if (key == null) return true;

        keychar = String.fromCharCode(key);
        keychar = keychar.toLowerCase();
        goods = goods.toLowerCase();

        // check goodkeys
        if (goods.indexOf(keychar) != -1)
            return true;
        // control keys
        if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
            return true;

        if (key == 13) {
            var i;
            for (i = 0; i < field.form.elements.length; i++)
                if (field == field.form.elements[i])
                    break;
            i = (i + 1) % field.form.elements.length;
            field.form.elements[i].focus();
            return false;
        };
        // else return false
        return false;
    }
</script>
<style type="text/css">
    .ui-datepicker-year {
        color: black;
    }

    .mytable {
        margin: 0 auto;
        padding: 20px;
        border: 2px dashed #17A3F7;
    }

    .success {
        color: #009900;
    }

    .error {
        color: #F33C21;
    }

    .talign_right {
        text-align: right;
    }

    .username_avail_result {
        display: block;
        width: 180px;
    }

    .password_strength {
        display: block;
        width: 180px;
        padding: 3px;
        text-align: center;
        color: #333;
        font-size: 12px;
        backface-visibility: #FFF;
        font-weight: bold;
    }

    /* Password strength indicator classes weak, normal, strong, verystrong*/
    .password_strength.weak {
        background: #e84c3d;
    }

    .password_strength.normal {
        background: #f1c40f;
    }

    .password_strength.strong {
        background: #27ae61;
    }

    .password_strength.verystrong {
        background: #2dcc70;
        color: #FFF;
    }
</style>

<link href="<?php echo base_url(); ?>assets/css/jquery.validate.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validation.functions.js" type="text/javascript"></script>
<script type="text/javascript">
    /* <![CDATA[ */

    jQuery(function () {

        jQuery("#username").validate({
            expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
            message: "Format email yang Anda masukkan salah, harus email yang valid"
        });

        jQuery("#user_pass1").validate({
            expression: "if (VAL.length > 5 && VAL) return true; else return false;",
            message: "Password harus lebih dari dari 5 karakter"
        });
        jQuery("#user_pass2").validate({
            expression: "if (VAL.length > 5 && VAL) return true; else return false;",
            message: "Password harus lebih dari dari 5 karakter"
        });

    });
    /* ]]> */
</script>