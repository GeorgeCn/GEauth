//以下为修改jQuery Validation插件兼容Bootstrap的方法，没有直接写在插件中是为了便于插件升级
        $.validator.setDefaults({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function (element) {
                element.closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: "span",
            errorPlacement: function (error, element) {
                if (element.is(":radio") || element.is(":checkbox")) {
                    error.appendTo(element.parent().parent().parent());
                } else {
                    error.appendTo(element.parent());
                }
            },
            errorClass: "help-block m-b-none",
            validClass: "help-block m-b-none",

        });

        //以下为官方示例
        $().ready(function () {
            // validate the comment form when it is submitted
            $("#commentForm").validate();

            // validate signup form on keyup and submit
            var icon = "<i class='fa fa-times-circle'></i> ";
            $("#signupForm").validate({
                rules: {
                    firstname: "required",
                    mobile: {
                        required:true,
                        minlength:11,
                        isMobile:true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages: {
                    firstname: icon + "请输入你的用户登录名",
                    mobile: {
                        required:icon + "请输入您的手机",
                        minlength:icon + "请输入正确的手机号",
                        isMobile:icon + "请输入正确的手机号",
                    }
                    },
                    email: icon + "请输入您的E-mail",
            });

            // propose username by combining first- and lastname
            $("#username").focus(function () {
                var firstname = $("#firstname").val();
                var mobile = $("#mobile").val();
                if (firstname && mobile && !this.value) {
                    this.value = firstname + "." + mobile;
                }
            });
        });
