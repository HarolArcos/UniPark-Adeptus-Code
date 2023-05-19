
export default function Comprueva (navigate,datos) {
    
        
    
    
    
   
    
    if (datos.desError) {
        return datos.desError
    } else {
        
        //setUserglobal(datos.persona[0])
        localStorage.setItem("use",JSON.stringify(datos.persona[0]))
        localStorage.setItem("options",JSON.stringify(datos.opciones))
        navigate("/main")
    }
    
    
}

