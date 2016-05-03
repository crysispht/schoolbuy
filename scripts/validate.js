/**
 * Created by 81061 on 2016/4/5 0005.
 */
$(document).ready(function () {
    //此标志用于标志是否提交，防止多次提交
    var flag = false;

    //监测是否提交
    $('#btn_login').click(function (e) {
        //阻止表单的自动提交
        e.preventDefault();
        if (flag) return false;
        flag = true;
        //通过Ajax发送数据
        $.post('app/validate.php?act=login', $('#loginform').serialize(), function (msg) {
            //$("#btn_login").removeAttr('disabled');
            flag = false;
            if (msg) {
                $("#password").val('');
                //$("p.keeplogin").remove($("#loginerror"));
                $("p.keeplogin").append('<span id="loginerror" style="color: red;float: right">' + msg + '</span>');
                //$("#btn_login").attr('disabled', 'true');
            } else {
                //alert('dasdsad');
                $('#loginform').attr('action','app/doAction.php?act=login');
                $('#loginform').submit();
            }
        });
    });
    $('#password').focus(function () {
        $('#loginerror').html('');
    });
    $("#username").focus(function () {
        $('#loginerror').html('');
    });

    $('#usernamesignup').focusout(function (e) {
        var usernamesignup = $('#usernamesignup').val();
        //阻止表单的自动提交
        e.preventDefault();
        if (flag) return false;
        flag = true;
        //通过Ajax发送数据
        $.post('app/validate.php?act=reg', {'usernamesignup': usernamesignup}, function (msg) {
            flag = false;
            if (usernamesignup.length <= 0) {
                $("#registererror").html('');
            } else {
                $("#registerusername").append('<span id="registererror" style="color: red;float: right"></span>');
                if (msg) {
                    $("#registererror").html(msg);
                    $("#btn_register").attr('disabled', 'true');
                } else {
                    $("#registererror").html('恭喜您，该用户名无人使用');
                    $("#btn_register").removeAttr('disabled');
                }
            }
        });
    });
});