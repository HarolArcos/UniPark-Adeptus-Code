import React, { useState, useEffect } from "react";
import { useFetch } from "../../hooks/HookFetchListData";
import { Document, Page, Text, View, StyleSheet, PDFDownloadLink } from "@react-pdf/renderer";
import { Button, Table } from "react-bootstrap";
import Header from "../Header/Header";
import Aside from "../Aside/Aside";
import Footer from "../Footer/Footer";

export default function ListaPag() {
  return (
    <div>
      <Header />
      <Aside />
      <ListaPa />
      <Footer />
    </div>
  );
}

function ListaPa() {
  const [fileName, setFileName] = useState("lista_pagos_total.pdf");
  const { data, loading, error } = useFetch(
    "http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiHistoryPay/apiHistoryPay.php/listHistoryPay"
  );
  const [Selec, setSelec] = useState("Total");
  const {
    data: MesD,
    loading: MesL,
    error: MesE,
  } = useFetch(
    "http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiHistoryPay/apiHistoryPay.php/listHistoryPayMonth"
  );
  const {
    data: SemD,
    loading: SemL,
    error: SemE,
  } = useFetch(
    "http://adeptuscode.tis.cs.umss.edu.bo//UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiHistoryPay/apiHistoryPay.php/listHistoryPayWeek"
  );
  const [DatosLeidos, setDatosLeidos] = useState([]);
  const [montopagado, setmontopagado] = useState(0);

  useEffect(() => {
    let totalMonto = 0;
    if (DatosLeidos.length > 0&&!DatosLeidos.desError) {
      totalMonto = DatosLeidos.reduce(
        (total, reclamoPersona) =>
          total + parseInt(reclamoPersona.historial_pago_monto),
        0
      );
    }
    setmontopagado(totalMonto);
  }, [DatosLeidos]);

  const handleSelectChange = (event) => {
    setSelec(event.target.value);
    setmontopagado(0);
    switch (event.target.value) {
      case "Total":
        setDatosLeidos(data);
        setFileName("lista_pagos_total.pdf"); // Cambiar el nombre del archivo
        break;
      case "Mes":
        setDatosLeidos(MesD);
        setFileName("lista_pagos_mes.pdf"); // Cambiar el nombre del archivo
        break;
      case "Semana":
        setDatosLeidos(SemD);
        setFileName("lista_pagos_semana.pdf"); // Cambiar el nombre del archivo
        break;
      default:
        setDatosLeidos(data);
        setFileName("lista_pagos.pdf"); // Cambiar el nombre del archivo
    }
  };

  if (!loading && !MesL && !SemL) {
    if (DatosLeidos.length === 0) {
      setDatosLeidos(data);
    }

    const styles = StyleSheet.create({
      page: {
        fontFamily: "Helvetica",
        fontSize: 12,
        padding: "1cm",
      },
      title: {
        fontSize: 18,
        marginBottom: 10,
        textAlign: "center",
      },
      subtitle: {
        fontSize: 14,
        marginBottom: 10,
      },
      table: {
        display: "table",
        width: "auto",
        marginTop: 10,
        borderStyle: "solid",
        borderWidth: 1,
        borderColor: "#000",
      },
      tableRow: {
        flexDirection: "row",
      },
      tableCell: {
        borderStyle: "solid",
        borderWidth: 1,
        borderColor: "#000",
        padding: 5,
      },
      totalRow: {
        fontWeight: "bold",
      },
    });
   
      const PDFDocument = () => (
        <Document>
          <Page size="A4" style={styles.page}>
            <View>
              <Text style={styles.title}>Lista de Pagos</Text>
              <Text style={styles.subtitle}>Seleccionado: {Selec}</Text>
            </View>
            <View style={styles.table}>
              <View style={styles.tableRow}>
                <Text style={styles.tableCell}>Cliente</Text>
                <Text style={styles.tableCell}>Fecha</Text>
                <Text style={styles.tableCell}>Monto</Text>
                <Text style={styles.tableCell}>Parqueo</Text>
              </View>
              {DatosLeidos.map((reclamoPersona) => (
                <View style={styles.tableRow} key={reclamoPersona.historial_pago_id}>
                  <Text style={styles.tableCell}>{reclamoPersona.cliente}</Text>
                  <Text style={styles.tableCell}>{reclamoPersona.historial_pago_fecha}</Text>
                  <Text style={styles.tableCell}>{reclamoPersona.historial_pago_monto} Bs.</Text>
                  <Text style={styles.tableCell}>{reclamoPersona.suscripcion_numero_parqueo}</Text>
                </View>
              ))}
              <View style={[styles.tableRow, styles.totalRow]}>
                <Text style={[styles.tableCell, { colspan: 3 }]}>El Monto Pagado {Selec} es:</Text>
                <Text style={styles.tableCell}>{montopagado} Bs.</Text>
              </View>
            </View>
          </Page>
        </Document>
      );
    
    
              
    return (
      <div className="content-wrapper contenteSites-body" style={{minHeight: '100vh'}} >
        <label>Lista de Pagos</label>
       
        <div className="buttonSection">
        {!DatosLeidos.desError?(<PDFDownloadLink document={<PDFDocument />} fileName={fileName}>
            {({ blob, url, loading, error }) =>
              loading ? "Preparando PDF" : <Button variant="success">Descargar PDF</Button>
            }
          </PDFDownloadLink>):null}
          
          <select
            style={{ borderRadius: "5px" }}
            value={Selec}
            onChange={handleSelectChange}
            type="text"
          >
            <option value="Total">Total</option>
            <option value="Mes">Mensual</option>
            <option value="Semana">Semanal</option>
          </select>
        </div>
        <Table striped bordered hover>
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Fecha</th>
              <th>Monto</th>
              <th>Parqueo</th>
            </tr>
          </thead>
          
            {!DatosLeidos.desError?(<tbody>
            {DatosLeidos.map((reclamoPersona) => (
              <tr key={reclamoPersona.historial_pago_id}>
                <td>{reclamoPersona.cliente}</td>
                <td>{reclamoPersona.historial_pago_fecha}</td>
                <td>{reclamoPersona.historial_pago_monto} Bs.</td>
                <td>{reclamoPersona.suscripcion_numero_parqueo}</td>
              </tr>
            ))}
        
            
            <tr className="totalRow">
              <td colSpan="3">El Monto Pagado {Selec} es:</td>
              <td>{montopagado} Bs.</td>
            </tr></tbody>):(<tbody><tr className="totalRow">
            <td colSpan="4">No eiste pagos en {Selec}</td>              
          </tr></tbody>)}
        </Table>
        <br/><br/>
      </div>
    );
  } else {
    return null; // Mostrar un componente de carga o mensaje de error mientras se obtienen los datos
  }
}
