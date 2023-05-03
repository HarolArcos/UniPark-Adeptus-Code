import { useFetch } from "../../../hooks/HookFetch";
import { useContext } from "react"
import { DataUser } from "../../context/UserContext";
const parse = require("html-react-parser");

export default function Opcions() {
  const {userglobal} = useContext(DataUser)  
  let { data, loading, error } = useFetch(
    "http://localhost:3000/Opcions.json"
  );
    
 
  if (!loading) {
    data=data.opcionesuser    
    let primarylist = data.filter((padres) => padres.padre === "");
    return primarylist.map((register) => {
      let string = "";
      let secontlist1 = data.filter(
        (secontlist) => secontlist.padre === register.orden
      );
      secontlist1.map((secont) => (string = string + secont.componente));
  
      string = register.componente.replace("</ul>", string + "</ul>");
      
      if ("3"===register.orden+"") {
        
        return parse(string); //trasfoma string a html
      } else {
        
        return 
      }
  
     
    });
  
  }
    


  
  
  

  if (error!==null) {
    console.log(error);
  }
  
  

  
}

//let secontlist = bdopcion.filter((hijo) => hijo.padre !== "");
/*
primarylist.sort(function (registera, registerb) {
  if (registera.orden > registerb.orden) {
    return 1;
  }
  if (registera.orden < registerb.orden) {
    return -1;
  }
  // a must be equal to b
  return 0;
});
secontlist.sort(function (registera, registerb) {
  if (registera.padre > registerb.padre) {
    return 1;
  }
  if (registera.padre < registerb.padre) {
    return -1;
  }
  // a must be equal to b
  return 0;
});

secontlist.sort(function (registera, registerb) {
  if (registera.orden > registerb.orden && registera.padre === registerb.padre) {
    return 1;
  }
  if (registera.orden < registerb.orden && registera.padre === registerb.padre) {
    return -1;
  }
  // a must be equal to b
  return 0;
});
*/
