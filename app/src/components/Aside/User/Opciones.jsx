const parse = require("html-react-parser");




export default function Opcions() {

  const options =(JSON.parse(localStorage.getItem("options")))
  
  
  let primarylist = options.filter((padres) => padres.opcion_padre==="0");
  
  

  return primarylist.map((register) => {
    let string = "";

    let secontlist1 = options.filter(
      (secontlist) => secontlist.opcion_padre === register.opcion_orden 
    );
    
    secontlist1.map((secont) => (string = string + secont.opcion_componente));
      
      
    string = register.opcion_componente.replace("&lt;/ul&gt;", string + "&lt;/ul&gt;");
      
    return parse(parse(string)); //trasfoma string a html
  });
}