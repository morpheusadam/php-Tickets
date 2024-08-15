/*
 *  social login buttons functions
 */

// facebook button
function facebook_login(elm) {
    var url = $(elm).data('ajaxurl');
    $.ajaxSetup({cache: true});
    $.fblogin({
        fbId: $('body').attr('data-facebook-app-key'),
        permissions: 'public_profile,email',
        fields: 'id,name,email,gender,bio',
        success: function (data) {
            console.log('Basic public user data returned by Facebook', data);
            $(elm).attr('disabled', 'disabled').find('b').css({"display": "inline-block"});
            $.post(url, {fb_login: 'true', id: data.id, name: data.name, email: data.email, gender: data.gender, bio: data.bio}, function (data) {
                if (data) {
                    $(elm).parent().parent().after(data);
                } else {
                    window.location.reload();
                }
            });
        }
    });
//    $.getScript('http://connect.facebook.net/en_US/sdk.js', function () {
//        FB.init({
//            appId: $('body').attr('data-facebook-app-key'),
//            version: 'v2.5' // or v2.5, v2.6, v2.7
//        });
//        FB.getLoginStatus(function (response) {
//            if (response.status === 'connected') {
//                FB.login(function () {
//                    FB.api('/me', function (data) {
//                        
//                    });
//                }, {scope: 'public_profile,email'});
//            }
//        });
//    });
}

// linkedin button
var getProfileData = function (url, elm) { // Use the API call wrapper to request the member's basic profile data
    IN.API.Profile("me").fields("id,firstName,lastName,email-address,picture-urls::(original),public-profile-url,location:(name)").result(function (me) {
        var profile = me.values[0];
        $.post(url, {linked_login: 'true', id: profile.id, name: profile.firstName + ' ' + profile.lastName, email: profile.emailAddress}, function (data) {
            if (data) {
                $(elm).parent().parent().after(data);
            } else {
                window.location.reload();
            }
        });
    });
};
function linkedin_login(elm) {
    var url = $(elm).data('ajaxurl');
    IN.UI.Authorize().params({"scope": ["r_basicprofile", "r_emailaddress"]}).place();
    IN.Event.on(IN, 'auth', function () {
        $(elm).attr('disabled', 'disabled').find('b').css({"display": "inline-block"});
        getProfileData(url, elm);
    });
}

// google button
//310537112746-v6dbs90o1a26g4cr7a0aqidrt44etdaq
//AIzaSyB_dn7BuKDJ1HKNrnz1Cg7ebL9p0-Sn9WA
function google_login() {
    $('.g-signin2 .abcRioButton ').click();
}
function google_auth_post(elm, data) {
    $(elm).on('click', function () {
        var url = $(elm).data('ajaxurl');
        $(elm).attr('disabled', 'disabled').find('b').css({"display": "inline-block"});
        $.post(url, data, function (data) {
            if (data) {
                $(elm).parent().parent().after(data);
            } else {
                window.location.reload();
            }
        });
    });
}
function onSignIn(googleUser) {
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    //console.log("Image URL: " + profile.getImageUrl());
    google_auth_post('.social-login .btn-google-plus', {google_login: 'true', id: profile.getId(), name: profile.getName(), email: profile.getEmail()});
    // The ID token you need to pass to your backend:
    //var id_token = googleUser.getAuthResponse().id_token;
    //console.log("ID Token: " + id_token);
}
