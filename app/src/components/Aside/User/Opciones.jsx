//import StringToReact from "string-to-react";
let bdopcion = require("./Opcions.json").opcionesuser;
let primarylist = bdopcion.filter((padres) => padres.padre === "");
let secontlist = bdopcion.filter((hijo) => hijo.padre !== "");

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

export default function Opcions() {
  return primarylist.map((registera) => {
    let string = "";
    secontlist.map((register) => {
      if (registera.orden === register.padre) {
        string = string + register.componente;
      }
    });

    string = registera.componente.replace(
      "</ul>",
      string+"</ul>"
    );
      return <li dangerouslySetInnerHTML={{__html: string}}/>//trasfoma string a html
    //return StringToReact(hijitos); trasforma string a jsx
  });
}
