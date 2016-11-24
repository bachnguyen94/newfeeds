/**
 * Created by huong on 22/07/2015.
 */
var Facebook = {
    init: function(){
        $('.hw-fb-login').click(function(e){
            e.preventDefault();
            Facebook.logInWithFacebook($(this));
        })
    },

    logInWithFacebook: function(loginBtn) {
        FB.login(function(response) {
            console.log(response);
            if (response.authResponse) {
                // Now you can redirect the user or do an AJAX request to
                // a PHP script that grabs the signed request from the cookie.
                location.href = loginBtn.attr('href');
            } else {
                console.log('User cancelled login or did not fully authorize.');
            }
        });
        return false;
    }
}
$(document).ready(function(){
    window.fbAsyncInit = function() {
        FB.init({
            appId: FB_APP_ID,
            cookie: true, // This is important, it's not enabled by default
            version: 'v2.2'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    Facebook.init();
});

