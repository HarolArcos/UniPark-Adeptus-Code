
export default function Comprueba (navigate, datos,setUserglobal) {
    
    if (datos.desError) {
        return datos.desError
    } else {
        
        
        
        fetch("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiSubscription/apiSubscription.php/listSubscription")
        .then((response) => response.json())
        .then((per)=>{let [p] = per.filter((p)=>p.persona_id===datos.persona[0].persona_id)
        const fsub= new Date(p.suscripcion_expiracion)
        const factu=new Date()
        if (fsub>=factu&&p) {
           localStorage.setItem("sus","Su subcripcion termina en "+p.suscripcion_expiracion.slice(0, 10))
           
        } else {
            localStorage.setItem("mora","Usted esta en Mora, su subscripcion termino en "+p.suscripcion_expiracion.slice(0, 10))
        }
        setUserglobal(datos.persona[0])
        localStorage.setItem("user",JSON.stringify(datos.persona[0]))
        localStorage.setItem("options",JSON.stringify(datos.opciones))
        navigate("/main")
            })

            
    }
    
    
}
