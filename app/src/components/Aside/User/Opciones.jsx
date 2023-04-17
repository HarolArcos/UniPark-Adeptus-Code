let opcions=require("./Opcions.json").opcionesuser

export default function Opcions () {
    return (
    opcions.map((value)=>{
      return (<li className="nav-item">
              <a href={value.link} className="nav-link">
              <i className="far fa-circle nav-icon" />
              <p>{value.titulo}</p>


              </a>



      </li>





      )
    }
    
    
    
    
    )


    
    
    )}