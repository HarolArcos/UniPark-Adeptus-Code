import { useContext } from "react"

import { DataUser } from '../../context/UserContext';
const parse = require("html-react-parser");

let bdopcion = require("./Options.json").opcionesuser;


export default function Opcions() {
  const {userglobal} = useContext(DataUser)
  let primarylist = bdopcion.filter((padres) => padres.padre === ""&& padres.tipo>=userglobal.persona_tipo);

  return primarylist.map((register) => {
    let string = "";

    let secontlist1 = bdopcion.filter(
      (secontlist) => secontlist.padre === register.orden && secontlist.tipo>=userglobal.persona_tipo
    );
    secontlist1.map((secont) => (string = string + secont.componente));

    string = register.componente.replace("</ul>", string + "</ul>");

    return parse(string); //trasfoma string a html
  });
}
