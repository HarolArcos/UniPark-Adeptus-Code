import  { useFetch }    from "../../../hooks/HookFetch"
const parse = require('html-react-parser');


console.log("hola mudoi")
let bdopcion = require("./Opcions.json").opcionesuser;


let primarylist = bdopcion.filter((padres) => padres.padre === "");

export default function Opcions() {
  const { data, loading, error } = useFetch('https://jsonplaceholder.typicode.com/posts');


      
      if (loading===false){ console.log(data)      
        console.log(data[0].title)  }
        else{
          setTimeout(() => {      
       
            console.log("cargando")      
            
            
          }, 1000);
        }

      
      
    
 
  
  






  return primarylist.map((register,index) => {
    let string = "";
    
        let secontlist1 = bdopcion.filter((secontlist) => secontlist.padre===register.orden);
        secontlist1.map((secont) =>  string = string + secont.componente  );
     
   
    string = register.componente.replace(
      "</ul>",
      string+"</ul>"
    );

      return parse(string);//trasfoma string a html
      
  });
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