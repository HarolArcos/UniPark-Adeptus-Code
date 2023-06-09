import { Button, Table,Modal, ModalBody,Form } from "react-bootstrap";
import { useFetch } from "../../hooks/HookFetchListData";
import React, { useEffect, useState } from "react";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
export default function ResRec() {
  const { data:listap, loading, error:errorp }= useFetch("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson")
  const [reclamoset, setreclamoset] = useState([]);
  const {data,fetchData,error} = useFetchSendData(
    );
  const [solucion, setsolucion] = useState(null);
  const [show, setShow] = useState(false);
  const [noticias, setnoticias] = useState([]);
  const [busqueda, setBusqueda] = useState("");
  const [ser, setser] = useState([])
  const [filtroEstado, setFiltroEstado] = useState("todos");
  

  useEffect(() => {
    fetchConfiguraciones();
  }, []);

  const fetchConfiguraciones = async () => {
    try {
      const response = await fetch(
        "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiComplaint/apiComplaint.php/listComplaint"
      );
      const data = await response.json();
      setnoticias(data);
      setBusqueda(data);
      setser(data)
    } catch (error) {
      console.log(error);
    }
  };
  const handleSearch = (valor) => {
    // Filtrar las noticias en función de los términos de búsqueda
    
    if (valor === "") {
      
      setser(busqueda)
    } else {
      const noticiasFiltradas = busqueda.filter(
        (noticia) =>
          noticia.reclamo_persona.toLowerCase().includes(valor.toLowerCase()) ||
          noticia.reclamo_texto.toLowerCase().includes(valor.toLowerCase()) ||
          noticia.reclamo_asunto.toLowerCase().includes(valor.toLowerCase()) 
      );
      setser(noticiasFiltradas)
      
      
      
    }
    
    console.log(filtroEstado);
    
    
      
    
  };
  useEffect(() => {
    handleEstadoFilter(filtroEstado)
  }, [ser, filtroEstado])
  const handleEstadoFilter = (estado) => {
    setFiltroEstado(estado);
    if (estado === "todos") {
      setnoticias(ser);
      
    } else {
      const noticiasFiltradas = ser.filter(
        (noticia) => noticia.reclamoestado.toLowerCase() === estado.toLowerCase()
      );
      setnoticias(noticiasFiltradas);
    }
    
  };







  const handleClose = () => setShow(false);
  
  function Cambiosol() {
    const [mipersona] = listap.filter((per)=> per.persona_id===reclamoset.persona_id)
    let myData = { "idComplaint" : reclamoset.reclamo_id,
    "complaintSolution" : solucion}; // datos a enviar en la primera llamada
    fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiComplaint/apiComplaint.php/changeSolutionComplaint',myData);
    myData = {
      "idComplaint" : reclamoset.reclamo_id,
      "complaintStatus" :  21
}
    fetchData("http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiComplaint/apiComplaint.php/changeStateComplaint",myData)
    window.open("https://api.whatsapp.com/send?phone=591"+mipersona.persona_telefono +"&text=<" + "AVISO"+">%0ALa respuesta de el Reclamo:"+reclamoset.reclamo_asunto+" %0A%0Aes:"+solucion)
   alert(`Se actualizo los la acción tomada`);

            window.location.reload()
    setShow(false);
    
  }
    
  function ClikComprovar(dato){
    
    setreclamoset(dato)
    setShow(true);
    


  }
  console.log(noticias);
  const [datoFiltro, setdatoFiltro] = useState([])
    
    
  if (!loading ) {
   
    if (datoFiltro.length===0) {
      setdatoFiltro(noticias)
    }
    return(
      <div className="content-wrapper contenteSites-body" >
        <div style={{ color: "red" }}>
                                    {error!=="" ? <span>{error}</span> : <span></span> }
                                    </div>
            {noticias.desError ? <span>{noticias.desError}</span>:
            <>
            <div className="buttonSection">
          
          <Form.Group>
            <Form.Control
              type="text"
              
              placeholder="Buscar por título o texto de la noticia"
              onChange={(e) => handleSearch(e.target.value)}
            />
          </Form.Group>
          <Form.Group>
            <Form.Control
              as="select"
              value={filtroEstado}
              onChange={(e) => handleEstadoFilter(e.target.value)}
            >
              <option value="todos">Todos</option>
              <option value="activo">Atendido</option>
              <option value="inactivo">No Atentido</option>
            </Form.Control>
          </Form.Group>
        </div>
            <Table striped bordered hover className="table">
                <thead>
                    <tr>
                    <th>Nombre </th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th> Reclamo </th>
                    <th> Accion Tomada </th>
                    <th>    </th>
                    </tr>
                </thead>
                <tbody>
                  
                  
                    {noticias.map((reclamoPersona) => (
                        <tr key={reclamoPersona.reclamo_id}>
                            <td>{reclamoPersona.reclamo_persona}</td>
                            <td>{reclamoPersona.reclamo_asunto}</td>
                            <td>{reclamoPersona.reclamo_fecha}</td>
                            <td>{reclamoPersona.reclamo_texto}</td>
                            <td>{reclamoPersona.reclamo_solucion}</td>
                            <td><Button
                                                variant="success"
                                                onClick={()=>ClikComprovar(reclamoPersona)}
                                                type='submit'
                                                className="btn btn-primary btn-block  "
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fillRule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                
                                                </svg>
                                            </Button></td>
                        </tr>
                    ) )}
                      
                </tbody>
                
            </Table>
           
           
            </>} 



            <Modal show={show} onHide={handleClose} centered >
                    <ModalBody className='modal-body' >
                        <h1 className='forgot-password-modal'> Editar Accion</h1>
                        <Form  className="container" >
                        
                        <Form.Label className="text-left"style={{ display: 'flex', justifyContent: 'flex-start' }}>Nombre: {reclamoset.reclamo_persona }</Form.Label>
                        <Form.Label className="text-left"style={{ display: 'flex', justifyContent: 'flex-start' }}>Asunto: {reclamoset.reclamo_asunto }</Form.Label>
                        <Form.Label className="text-left"style={{ display: 'flex', justifyContent: 'flex-start' }}>Fecha: {reclamoset.reclamo_fecha }</Form.Label>
                        <Form.Label className="text-left"style={{ display: 'flex', justifyContent: 'flex-start' }}>Reclamo: {reclamoset.reclamo_texto }</Form.Label>
                        <div></div>
                        <Form.Label className="text-left"style={{ display: 'flex', justifyContent: 'flex-start' }}>Accion Tomada: </Form.Label>
                        <div></div>
                        <textarea placeholder={reclamoset.reclamo_solucion} onChange={(e)=>setsolucion(e.target.value)}></textarea>


                        




                        </Form>
                        
                        
                        <div><Button variant="success" className='modal-button' onClick={Cambiosol} >
                            Aceptar
                        </Button>
                        </div>
                    </ModalBody>
                </Modal>
            </div>

            



    )
    

    
    
  }
}
