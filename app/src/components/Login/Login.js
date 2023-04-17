import React from 'react'


export default function Login() {

    return (
        <div className="d-flex justify-content-center " style={{ margin: 'auto' }} >
            <div className="login-box">
                {/* /.login-logo */}
                <div className="card card-outline card-primary">
                    <div className="card-header text-center">
                        <a href="/main" className="h1"><b>Inicio de Sesion </b>Eggeling Armored</a>
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
                            <div className="row">
                                <div className="col-8">
                                    <div className="icheck-primary">
                                        <input type="checkbox" id="remember" />
                                        <label htmlFor="remember">
                                            Recordarme
                                        </label>
                                    </div>
                                </div>
                                {/* /.col */}
                                <div className="col-4">
                                    <button
                                        type='submit'
                                        className="btn btn-primary btn-block"
                                    >
                                        Iniciar
                                    </button>
                                </div>
                                {/* /.col */}
                            </div>
                        </form>
                        <p className="mb-1">
                            <a href="forgot-password.html">Olvide mi contraseña</a>
                        </p>
                        <p className="mb-0">
                            <a href="register.html" className="text-center">Registrate</a>
                        </p>
                    </div>
                    {/* /.card-body */}
                </div>
                {/* /.card */}
            </div>
        </div>
    )
}
