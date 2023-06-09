
import { Link } from "react-router-dom";



export default function Opcions() {
  const optionsPadre = JSON.parse(localStorage.getItem("optionsPadre"));
  const optionsHijo = JSON.parse(localStorage.getItem("optionsHijo"));
  


  return (
    optionsPadre.map((padre)=>
      
    <li className={`nav-item menu-close`} key={padre.opcion_id}>
      <Link  className="nav-link active">
        <p>
          {padre.opcion_nombre}<i className="right fas fa-angle-left"></i>
        </p>
      </Link><ul className="nav nav-treeview" >
      {optionsHijo.map((hijo)=>
      
      {if (hijo.opcion_padre===padre.opcion_orden) {
        return(
        <li className="nav-item" key={hijo.opcion_id}>
          <Link  to={hijo.opcion_componente} className="nav-link">
            <i className="far fa-circle nav-icon"></i>
            <p>{hijo.opcion_nombre}</p>
          </Link >
        </li>)}
      }
      )}
      
        
      </ul>
    </li>     
      
      ) 

    
    //trasfoma string a html
  );
}
