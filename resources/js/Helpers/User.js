import Token from "./Token";
import AppStorage from "./AppStorage";

class User{
    responseAfterLogin(res) {
        const access_token = res.data.access_token
        const user = res.data.user_name

        if (Token.isValid(access_token)) {
            AppStorage.store(user, access_token)
            window.location='/home'
        }
        return false;
    }
    hasToken(){
        const storedToken = AppStorage.getToken()
        if(storedToken){
            return Token.isValid(storedToken)
        }
        return false
    }
    loggedIn(){
        return this.hasToken()
    }
    logOut(){
        AppStorage.clear();
        window.location='/'
    }
    name(){
        if(this.loggedIn()){
            return AppStorage.getUser()
        }
    }
    user_id(){
        if(this.loggedIn()){
            const payload = Token.payload(AppStorage.getToken())
            return payload.sub
        }
    }

}
export default User = new User()
