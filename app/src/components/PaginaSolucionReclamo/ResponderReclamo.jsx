import { Button, Table,Modal, ModalBody } from "react-bootstrap";
import { useFetch } from "../../hooks/HookFetchListData";
import React, { useState } from "react";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
export default function ResRec() {
  const [reclamoset, setreclamoset] = useState(null);
  const {data,fetchData,error} = useFetchSendData(
    'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiComplaint/apiComplaint.php/changeSolutionComplaint');
  const [solucion, setsolucion] = useState(null);
  const [show, setShow] = useState(false);
  const { data:datosr, loading:loadingr,  } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiComplaint/apiComplaint.php/listComplaint"
  );
  const handleClose = () => setShow(false);
  
  function Cambiosol() {
    const myData = { "idComplaint" : reclamoset,
    "complaintSolution" : solucion}; // datos a enviar en la primera llamada
    fetchData(myData);
    
    setShow(false);
    
  }
    
  function ClikComprovar(dato){
    
    setreclamoset(dato)
    setShow(true);
    


  }

  if (!loadingr ) {
    return(
      <div className="content-wrapper contenteSites-body" >
        <div style={{ color: "red" }}>
                                    {error!=="" ? <span>{error}</span> : <span></span> }
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
                    {datosr.map((reclamoPersona) => (
                        <tr key={reclamoPersona.reclamo_id}>
                            <td>{reclamoPersona.reclamo_persona}</td>
                            <td>{reclamoPersona.reclamo_asunto}</td>
                            <td>{reclamoPersona.reclamo_fecha}</td>
                            <td>{reclamoPersona.reclamo_texto}</td>
                            <td>{reclamoPersona.reclamo_solucion}</td>
                            <td><button
                                                onClick={()=>ClikComprovar(reclamoPersona.reclamo_id)}
                                                type='submit'
                                                className="btn btn-primary btn-block "
                                            >
                                                Editar Solucion
                                            </button></td>
                        </tr>
                    ) )}   
                </tbody>
            </Table>




            <Modal show={show} onHide={handleClose} centered >
                    <ModalBody className='modal-body' >
                        <h1 className='forgot-password-modal'> Escriba la accion que se debera tomar</h1>
                        <textarea placeholder="Escriba aqui" onChange={(e)=>setsolucion(e.target.value)}></textarea>
                        
                        <div><Button className='modal-button' onClick={Cambiosol} >
                            Aceptar
                        </Button>
                        </div>
                    </ModalBody>
                </Modal>
            </div>

            



    )
    

    
    
  }
}
