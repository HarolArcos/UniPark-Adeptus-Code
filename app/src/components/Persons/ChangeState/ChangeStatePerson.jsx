import React from "react";
import Header from "../../Header/Header";
import Aside from "../../Aside/Aside";
import Footer from "../../Footer/Footer";
import { Form } from "react-bootstrap";
import { useState } from "react";
import { useFetch } from "../../../hooks/HookFetchListData";
import PersonTable from './TableRow'

export default function DeletePerson(){

    const [searchTerm, setSearchTerm] = useState('');

    const {data} = useFetch(
        'http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiPerson/apiPerson.php/listPerson'
    )

    const handleSearch = (event) => {
        setSearchTerm(event.target.value);
    };

    return(
        <>
            <Header></Header>
            <Aside></Aside>

            <div className="content-wrapper">
            <div className="bodyItems">
                <div className="buttonSection">
                    <Form.Control 
                        className="searchBar"
                        type="text"
                        placeholder="Buscar..."
                        value={searchTerm}
                        onChange={handleSearch}
                    />
                </div>
                    <PersonTable data={data} ></PersonTable>
                </div>
            </div>

            <Footer></Footer>
        </>
    )
}