class AppStorage{
    setToken(token){
        localStorage.setItem('token',token);
    }
    setUser(user){
        localStorage.setItem('user',user);
    }
    store(user,token){
        this.setUser(user)
        this.setToken(token)
    }
    clear(){
        localStorage.removeItem('user')
        localStorage.removeItem('token')
    }
    getToken(){
        return localStorage.getItem('token')
    }
    getUser(){
        return localStorage.getItem('user')
    }
}
export default AppStorage = new AppStorage()
