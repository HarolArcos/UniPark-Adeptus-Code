
export default function Comprueba (navigate, datos, setUserglobal) {
    
    if (datos.desError) {
        return datos.desError
    } else {
        console.log(datos);
        
        console.log(datos.opciones);
        //setUserglobal(datos.persona[0])
        localStorage.setItem("use",JSON.stringify(datos.persona[0]))
        localStorage.setItem("options",JSON.stringify(datos.opciones))
        navigate("/main")
    }
    
    /* if (error) {
        return "El correo o contraseña es incorrecto"
    } else {
        setUserglobal(user);
        localStorage.setItem("use",JSON.stringify(user))
        navigate("/main")
        return "/main"
        
    } */

} 



