//import StringToReact from "string-to-react";
let opcions = require("./Opcions.json").opcionesuser;
let pa = opcions.filter((padres) => padres.padre === "");
let hi = opcions.filter((hijo) => hijo.padre !== "");

pa.sort(function (a, b) {
  if (a.orden > b.orden) {
    return 1;
  }
  if (a.orden < b.orden) {
    return -1;
  }
  // a must be equal to b
  return 0;
});
hi.sort(function (a, b) {
  if (a.padre > b.padre) {
    return 1;
  }
  if (a.padre < b.padre) {
    return -1;
  }
  // a must be equal to b
  return 0;
});

hi.sort(function (a, b) {
  if (a.orden > b.orden && a.padre === b.padre) {
    return 1;
  }
  if (a.orden < b.orden && a.padre === b.padre) {
    return -1;
  }
  // a must be equal to b
  return 0;
});

export default function Opcions() {
  return pa.map((padre) => {
    let hijitos = "<ul className='nav nav-treeview'>";
    hi.map((hijo) => {
      if (padre.orden === hijo.padre) {
        hijitos = hijitos + hijo.componente;
      }
    });

    hijitos = padre.componente.replace(
      "<ul className='nav nav-treeview'>",
      hijitos
    );
      return <div dangerouslySetInnerHTML={{__html: hijitos}}/>//trasfoma string a html
    //return StringToReact(hijitos); trasforma string a jsx
  });
}
