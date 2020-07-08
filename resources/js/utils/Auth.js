import vueCookie from 'vue-cookie';

function auth(role){

    if(!vueCookie.get('user-contacts')){
        window.location.href = "/"
    }
}

export default auth;
