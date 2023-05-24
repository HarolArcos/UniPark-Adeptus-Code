
export default function Comprueba (navigate, datos,setUserglobal) {
    
    if (datos.desError) {
        return datos.desError
    } else {
        
        setUserglobal(datos.persona[0])
        localStorage.setItem("user",JSON.stringify(datos.persona[0]))
        localStorage.setItem("options",JSON.stringify(datos.opciones))
        navigate("/main")
    }
    
    
}
