
export default function Comprueva (usuario,contraseña,data,setUserglobal) {
    
    
    
    
   
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
        
        
    



    




    






}