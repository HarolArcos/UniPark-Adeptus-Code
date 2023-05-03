//import CryptoJS from 'crypto-js';






export default function Comprueva (usuario,contraseña,data,setUserglobal) {
    
    
    
    
    console.log(data)
    let [user] = data.filter((us)=>us.persona_nickname===usuario)
    
        if (!user) {
           return "El correo o contraseña es incorrecto"
        } else {
            
            if(user.persona_contraseña!==contraseña)
             {return "El correo o contraseña es incorrecto"}
             else{setUserglobal(user)
                localStorage.setItem("use",JSON.stringify(user))
              
                
                return "/main"}
            
        }  
        
        
    



    /* if(user.password===contraseña)
    {return ""}
    else
    {return "El correo o contraseña es incorrecto"}
     */
    
    
    /* data.map((user)=>{console.log(user)
        console.log(user.password)
        const hashedText = CryptoJS.SHA512(user.password).toString();
        console.log(hashedText);}) */
    




    






}