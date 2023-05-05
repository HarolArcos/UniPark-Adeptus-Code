import { useFetch } from "../../../hooks/HookFetch";
const parse = require("html-react-parser");

let bdopcion = require("./Opcions.json").opcionesuser;

let primarylist = bdopcion.filter((padres) => padres.padre === "");

export default function Opcions() {
  const { loading, error } = useFetch(  //data removed inside {data,}
    "https://jsonplaceholder.typicode.com/posts"
  );

  if (loading) {
    console.log("cargando");
  }
  

  if (error) {
    console.log(error);
  }

  return primarylist.map((register) => {
    let string = "";

    let secontlist1 = bdopcion.filter(
      (secontlist) => secontlist.padre === register.orden
    );
    secontlist1.map((secont) => (string = string + secont.componente));

    string = register.componente.replace("</ul>", string + "</ul>");

    return parse(string); //trasfoma string a html
  });
}

