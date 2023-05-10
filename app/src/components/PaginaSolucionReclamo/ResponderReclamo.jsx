import { Button, Table,Modal, ModalBody,Form } from "react-bootstrap";
import { useFetch } from "../../hooks/HookFetchListData";
import React, { useState } from "react";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
export default function ResRec() {
  const [reclamoset, setreclamoset] = useState([]);
  const {data,fetchData,error} = useFetchSendData(
    'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiComplaint/apiComplaint.php/changeSolutionComplaint');
  const [solucion, setsolucion] = useState(null);
  const [show, setShow] = useState(false);
  const { data:datosr, loading:loadingr,  } = useFetch(
    "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiComplaint/apiComplaint.php/listComplaint"
  );
  const handleClose = () => setShow(false);
  
  function Cambiosol() {
    const myData = { "idComplaint" : reclamoset.reclamo_id,
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
                            <td><Button
                                                variant="success"
                                                onClick={()=>ClikComprovar(reclamoPersona)}
                                                type='submit'
                                                className="btn btn-primary btn-block "
                                            >
                                                Editar Solucion
                                            </Button></td>
                        </tr>
                    ) )}   
                </tbody>
            </Table>




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
