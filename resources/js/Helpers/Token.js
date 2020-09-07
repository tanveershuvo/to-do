class Token{

    isValid(token){
        const payload = this.payload(token);
       //console.log(payload.iss);
         if(payload){
             return payload.iss == "http://todo.test/api/v1/auth/login" ? true : false
         }
         return false;
    }
    payload(token){
        const payload = token.split('.')[1];
        return this.decode(payload);
    }
    decode(payload){
        return JSON.parse(atob(payload));
    }

}
export default Token = new Token()
