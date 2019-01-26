$(document).ready(
    function() {
	console.log("start script");
        $('#enter-enter-button').on('click', enterAction);
        $('#enter-registration-button').on('click', showRegistrationForm);
        $('#registration-enter-button').on('click', registrationBackToEnterForm);
        $('#registration-registration-button').on('click', registrationAction);
        $('#forgot-password-button').on('click', showForgotPasswordForm);
        $('#forgot-password-enter-button').on('click', forgotPasswordBackToEnterForm);
        $('#remember-password-button').on('click', rememberPasswordAction);
//Я добавил
        $('.enter-form').submit(function (e) {
            e.preventDefault();
            var data_review = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "authorisation/checkAuth.php",
                data: data_review,
                async: false,
                success: function ($result) {
                    console.log($result);
                    window.location.href='/';
                },
                error: function () {
                    console.log("check authorisation is crashed");
                }
            });
        });
//Конец я добавил

        function enterAction() {
            console.log("Success! You've just entered!");
        }

        function showRegistrationForm() {
            $('#enter-form').hide();
            console.log("Enter form is hidden...");
            $('#registration-form').show();
            console.log("Registration form is shown...");
        }

        function registrationBackToEnterForm() {
            $('#registration-form').hide();
            console.log("Registration form is hidden...");
            $('#enter-form').show();
            console.log("Enter form is shown...");
        }

        function registrationAction() {
            console.log("Success! You've just registered!");            
        }

        function showForgotPasswordForm() {
            $('#enter-form').hide();
            console.log("Enter form is hidden...");
            $('#forgot-password-form').show();
            console.log("Forgot password form is shown...");
        }

        function forgotPasswordBackToEnterForm() {
            $('#forgot-password-form').hide();
            console.log("Forgot password form is hidden...");
            $('#enter-form').show();
            console.log("Enter form is shown...");
        }

        function rememberPasswordAction() {
            console.log("Success! You're going to memorize your password somehow!");  
        }
    });
