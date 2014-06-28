var appID = '273389062833254';

/*
 * load face book SDK
 */
   
window.fbAsyncInit = function() {
  FB.init({
    appId      : appID,
    xfbml      : true,
    version    : 'v2.0'
  });
};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));

/*
 * check if logged in, if not then call FB.login()
 */
function checkLogginStatus(){
  FB.getLoginStatus(function(response){
    loginCallBack(response);
  }
  );
}
// login status callback
function loginCallBack(response){

}
