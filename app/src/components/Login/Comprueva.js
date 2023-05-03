//import CryptoJS from 'crypto-js';

import { useContext } from "react"
import {  DataUser } from "../context/UserContext"

//import { useFetch } from '../../hooks/HookFetch';


export default function Comprueva (usuario,contraseña,data,setUserglobal) {
    //const {setUserglobal} = useContext(DataUser)
    
    
    
    console.log(data)
    let [user] = data.filter((us)=>us.persona_nickname===usuario)
    
        if (!user) {
           return "El correo o contraseña es incorrecto"
        } else {
            console.log(user)
            if(user.persona_contraseña!==contraseña)
             {return "El correo o contraseña es incorrecto"}
             else{setUserglobal(user)
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