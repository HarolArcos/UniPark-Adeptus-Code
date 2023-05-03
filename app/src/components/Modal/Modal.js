//import React, { useState, useEffect } from "react";
import { Modal as BootstrapModal } from "react-bootstrap"; // importacion Button quitada

const Modal = ({ mostrarModal ,hide,title,contend,asunto}) => {

  return (
    <BootstrapModal 
    show = {mostrarModal}  
    onHide={hide}
    size="xl"
    aria-labelledby="contained-modal-title-vcenter" 
    fullscreen =' md-down'
    >
      <BootstrapModal.Header closeButton>
        <BootstrapModal.Title >{title}</BootstrapModal.Title>
      </BootstrapModal.Header>
      <BootstrapModal.Body>
        {contend}
      </BootstrapModal.Body>
      {/* <BootstrapModal.Footer>
      <Button variant="secondary" onClick={hide}>
            Cancelar
          </Button>
          <Button variant="primary" >
            {asunto}
          </Button>
      </BootstrapModal.Footer> */}
    </BootstrapModal>
  );
};

export default Modal;
