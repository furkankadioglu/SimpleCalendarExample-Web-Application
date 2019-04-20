export function registerUser(credentials){
    return new Promise((res,rej)=>{
        axios.post('/api/auth/register', credentials)
        .then(response => {
            res(response.data);
        })
        .catch(err => {
            rej('An error occured.. try again later.')
        })
    })
}

export function login(credentials){
    return new Promise((res,rej)=>{
        axios.post('/api/auth/login', credentials)
        .then(response => {
            res(response.data);
        })
        .catch(err => {
            rej('Wrong Email/Password combination.')
        })
    })
}

export function getLoggedinUser(){
    const userStr = localStorage.getItem('user');

    if(!userStr){
        return null
    }

    return JSON.parse(userStr);
}

export function isJwtExpired(storeData) {
    // JWT Check expire.
    if(storeData.state.currentUser)
    {
        if(Date.now() > (storeData.state.currentUser.date - 50000))
        {
            return true;
        }
    }
    return false;
}