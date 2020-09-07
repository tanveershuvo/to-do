import Token from "./Token";
import AppStorage from "./AppStorage";

class User{
    responseAfterLogin(res) {
        const access_token = res.data.access_token;
        const user = res.data.user_name;
        let a;
        if (Token.isValid(access_token)) {
            return AppStorage.store(user, access_token)
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
