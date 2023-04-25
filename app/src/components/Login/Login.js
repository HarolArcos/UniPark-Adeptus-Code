import React, { useState } from 'react'
import './Login.css'
//import { Alert } from 'react-bootstrap'
import { Button, Modal, ModalBody } from 'react-bootstrap'
import { Link } from 'react-router-dom';

export default function Login() {

    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    return (
        <div className="login" >
            <div className="d-flex justify-content-center align-items-center"  >
                <div className="login-box">
                    {/* /.login-logo */}
                    <div className="card card-outline card-primary">
                        <div className="card-header text-center">
                            <a href="/main" className="h1"><b>Inicio de Sesion </b><br/>UniPark</a>
                            
                        </div>
                        <div className="card-body">
                            <p className="login-box-msg">Ingrese sus credenciales para iniciar sesion</p>
                            <form action="/main">
                                <div className="input-group mb-3">
                                    <input type="email" className="form-control" placeholder="Correo electronico" />
                                    <div className="input-group-append">
                                        <div className="input-group-text">
                                            <span className="fas fa-envelope" />
                                        </div>
                                    </div>
                                </div>
                                <div className="input-group mb-3">
                                    <input type="password" className="form-control" placeholder="Contraseña" />
                                    <div className="input-group-append">
                                        <div className="input-group-text">
                                            <span className="fas fa-lock" />
                                        </div>
                                    </div>
                                </div>
                                <div className="rowx">
                                    {/* <div className="col-4">
                                        <div className="icheck-primary">
                                            <input type="checkbox" id="remember" />
                                            <label htmlFor="remember">
                                                Recordarme
                                            </label>
                                        </div>
                                    </div> */}
                                    {/* /.col */}
                                    <div className="col-12 iniciar-button">
                                        <Link to={'/main'} >
                                            <button
                                                type='submit'
                                                className="btn btn-primary btn-block "
                                            >
                                                Iniciar
                                            </button>
                                        </Link>
                                    </div>
                                    {/* /.col */}
                                </div>
                            </form>
                            <p className="mb-1 forgot-password" onClick={handleShow} >
                                {/* <a href='/login' onClick={handleShow} >Olvide mi contraseña</a> */}
                                Olvide mi contraseña
                            </p>
                            <p className="mb-0">
                                {/* <a href="register.html" className="text-center">Registrate</a> */}
                            </p>
                        </div>
                        {/* /.card-body */}
                    </div>
                    {/* /.card */}
                </div>
            
                <Modal show={show} onHide={handleClose} centered >
                    <ModalBody className='modal-body' >
                        <h1 className='forgot-password-modal'> Consulte con el administrador del sistema</h1>
                        <Button className='modal-button' onClick={handleClose} >
                            Aceptar
                        </Button>
                    </ModalBody>
                </Modal>

            </div>
            
        </div>
    )
}
