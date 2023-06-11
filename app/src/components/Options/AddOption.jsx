// import React from "react";
// import { Form, Button, ListGroup, Row, Col, Alert } from 'react-bootstrap';
// import { useState, useEffect } from "react";
// import ComboboxRoles from "./ComboboxRol";
// import { useFetchSendData } from "../../hooks/HookFetchSendData";

// export default function AddOptions(){

//     //const [rols, setRols]= useState([]);
//     const [showAlert, setShowAlert] = useState(false);

//     const [selectedRolId, setSelectedRolId] = useState(null);
//     const { fetchData } = useFetchSendData();
    
//     const handleRolIdChange = (personaId) => {
//         setSelectedRolId(personaId);
//     };
    
//     const [options, setOptions] = useState([]);
//     const [selectedOptions, setSelectedOptions] = useState([]);

//     useEffect(() => {
//         fetch('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiOption/apiOption.php/listOption')
//             .then(response => response.json())
//             .then(data => {
//             // Ordenar las opciones según opcion_orden
//             const sortedOptions = data.sort((a, b) => a.opcion_orden - b.opcion_orden);
//             console.log("sorted", sortedOptions);
//             // Filtrar solo las opciones padre (opcion_padre = "0")
//             const parentOptions = sortedOptions.filter(option => option.opcion_padre === "0");
//             setOptions(parentOptions);
//             console.log("parentoptions", parentOptions);
//         })
//         .catch(error => console.log(error));
//       }, []);

//     const getChildrenOptions = (opcion_id) => {
//         return options.filter(option => option.opcion_padre === opcion_id);
//     };
    
//     const handleOptionChange = (optionId) => {
//         const selectedOption = options.find(option => option.opcion_id === optionId);
      
//             if (selectedOption.opcion_padre !== "0") {
//             const parentOption = options.find(option => option.opcion_id === selectedOption.opcion_padre);
//             const isParentSelected = selectedOptions.includes(parentOption.opcion_id);
        
//             if (!isParentSelected) {
//                 setSelectedOptions([...selectedOptions, parentOption.opcion_id]);
//             }
//             }
        
//             const isSelected = selectedOptions.includes(optionId);
//             if (isSelected) {
//             setSelectedOptions(selectedOptions.filter(id => id !== optionId));
//             } else {
//             setSelectedOptions([...selectedOptions, optionId]);
//             }
//     };

//     // const handleOptionChange = (optionId) => {
//     //     const isSelected = selectedOptions.includes(optionId);
//     // const selectedOption = options.find(option => option.opcion_id === optionId);

//     // if (isSelected) {
//     //     setSelectedOptions(selectedOptions.filter(id => id !== optionId));
//     //     if (selectedOption.opcion_padre !== '0') {
//     //     setSelectedOptions(selectedOptions.filter(id => id !== selectedOption.opcion_padre));
//     //     }
//     // } else {
//     //     setSelectedOptions([...selectedOptions, optionId]);
        
//     //     if (selectedOption.opcion_padre !== '0' && !selectedOptions.includes(selectedOption.opcion_padre)) {
//     //     setSelectedOptions([...selectedOptions, selectedOption.opcion_padre]);
//     //     }
//     // }
//     // };
      
//     // // Función para ordenar las opciones según los criterios
//     // const ordenarOpciones = (opciones) => {
//     //     const ordenadas = [];
    
//     //     // Filtrar las opciones padres
//     //     const opcionesPadre = opciones.filter(opcion => opcion.opcion_padre === "0");
    
//     //     // Ordenar las opciones padres según su opción_orden
//     //     opcionesPadre.sort((a, b) => parseInt(a.opcion_orden) - parseInt(b.opcion_orden));
    
//     //     // Recorrer las opciones padres
//     //     opcionesPadre.forEach(opcionPadre => {
//     //     // Agregar la opción padre al arreglo ordenadas
//     //     ordenadas.push(opcionPadre);
    
//     //     // Filtrar y ordenar las opciones hijas de la opción padre actual
//     //     const opcionesHijas = opciones.filter(opcion => opcion.opcion_padre === opcionPadre.opcion_id);
//     //     opcionesHijas.sort((a, b) => parseInt(a.opcion_orden) - parseInt(b.opcion_orden));
    
//     //     // Agregar las opciones hijas al arreglo ordenadas
//     //     ordenadas.push(...opcionesHijas);
//     //     });
    
//     //     return ordenadas;
//     // };
    
//     // // Llamar a la función para obtener el arreglo ordenado
//     // const opcionesOrdenadas = ordenarOpciones(options);
    
//     // // Imprimir el arreglo ordenado
//     // console.log("las opciones ordenas son:",opcionesOrdenadas);

//     const handleSaveOptions = () => {
//         const selectedOptionsWithChildren = selectedOptions.flatMap(optionId => {
//           const option = options.find(option => option.opcion_id === optionId);
//           const childrenOptions = getChildrenOptions(option.opcion_orden);
//           return [option, ...childrenOptions];
//         });
      
//         selectedOptionsWithChildren.forEach(option => {
//           const data = {
//             idRol: selectedRolId,
//             idOption: option.opcion_id
//           };
//           fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/insertRolHasOption', data);
//         });
      
//         setShowAlert(true);
//       };

//     // const handleSaveOptions = () => {
//     //     console.log("Opcionees seleccionadas",selectedOptions);
//     //     selectedOptions.forEach(optionId => {
//     //     const data = {
//     //         idRol: selectedRolId,
//     //         idOption: optionId
//     //     };
//     //     console.log(data);
//     //     fetchData('http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/insertRolHasOption', data);
//     //     });
//     //     setShowAlert(true);
//     // };


//     return(
//         <div>
//             {showAlert && (
//             <Alert variant="success" onClose={() => setShowAlert(false)} dismissible>
//             Opciones asignadas con éxito
//             </Alert>
//         )}
//         <Row>
//             <Col>
//                 <Form.Group className="comboboxRol">
//                 <Form.Label><h3>Roles</h3> </Form.Label>
//                 <ComboboxRoles 
//                     id={"roles"}
//                     onRolIdChange={handleRolIdChange}
//                 />
//             </Form.Group>
//             <h3 className="titleOptions">Opciones</h3>
//             <Form>
//                 <Form.Group>
//                 {options.map(option => (
//                     <Form.Check
//                     key={option.opcion_id}
//                     type="checkbox"
//                     id={option.opcion_id}
//                     label={option.opcion_nombre}
//                     checked={selectedOptions.includes(option.opcion_id)}
//                     onChange={() => handleOptionChange(option.opcion_id)}
//                     />
//                 ))}
//                 </Form.Group>
//             </Form>
//             </Col>
//             <Col>            
//                 <h3>Opciones seleccionadas:</h3>
//                 <ListGroup>
//                     {selectedOptions.map(optionId => (
//                     <ListGroup.Item key={optionId}>
//                         {options.find(option => option.opcion_id === optionId)?.opcion_nombre}
//                     </ListGroup.Item>
//                     ))}
//                 </ListGroup>
//                 <Button onClick={handleSaveOptions}>Guardar opciones</Button>
//             </Col>
//         </Row>
//         </div>
//     )
// }

import React, { useState, useEffect } from "react";
import { Form, Button, ListGroup, Row, Col, Alert } from "react-bootstrap";
import { useFetchSendData } from "../../hooks/HookFetchSendData";
import ComboboxRoles from "./ComboboxRol";

export default function AddOptions() {
    const { fetchData } = useFetchSendData();
    const [showAlert, setShowAlert] = useState(false);
    const [selectedRolId, setSelectedRolId] = useState(null);
    const [options, setOptions] = useState([]);
    const [selectedOptions, setSelectedOptions] = useState([]);

    const handleRolIdChange = (personaId) => {
        setSelectedRolId(personaId);
    };

    useEffect(() => {
        fetchOptions();
    }, []);

    const fetchOptions = async () => {
        try {
        const response = await fetch(
            "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiOption/apiOption.php/listOption"
        );
        const data = await response.json();
        setOptions(data);
        } catch (error) {
        console.log(error);
        }
    };

    const handleOptionChange = (optionId) => {
        const selectedOption = options.find((option) => option.opcion_id === optionId);

        if (selectedOption.opcion_padre !== "0") {
        const parentOption = options.find(
            (option) => option.opcion_id === selectedOption.opcion_padre
        );

        const isParentSelected = selectedOptions.includes(parentOption.opcion_id);

        if (!isParentSelected) {
            setSelectedOptions([...selectedOptions, parentOption.opcion_id]);
        }
        }

        const isSelected = selectedOptions.includes(optionId);
        if (isSelected) {
        setSelectedOptions(selectedOptions.filter((id) => id !== optionId));
        } else {
        setSelectedOptions([...selectedOptions, optionId]);
        }
    };

    const handleSaveOptions = () => {
        console.log("Opciones seleccionadas", selectedOptions);
        console.log(selectedRolId);
        selectedOptions.forEach((optionId) => {
        const data = {
            idRol: selectedRolId,
            idOption: optionId,
        };
        console.log(data);
        fetchData(
            "http://localhost/UniPark-Adeptus-Code/ADEPTUSCODE-BackEnd/app/apiRolHasOption/apiRolHasOption.php/insertRolHasOption",
            data
        );
        });
        setShowAlert(true);
    };

    const getOrderedOptions = () => {
        const orderedOptions = [];

        const parentOptions = options.filter((option) => option.opcion_padre === "0");
        parentOptions.sort((a, b) => parseInt(a.opcion_orden) - parseInt(b.opcion_orden));

        parentOptions.forEach((parentOption) => {
        orderedOptions.push(parentOption);

        const childrenOptions = options.filter(
            (option) => option.opcion_padre === parentOption.opcion_orden
        );
        childrenOptions.sort((a, b) => parseInt(a.opcion_orden) - parseInt(b.opcion_orden));
        orderedOptions.push(...childrenOptions);
        });

        return orderedOptions;
    };

    return (
        <div>
        {showAlert && (
            <Alert variant="success" onClose={() => setShowAlert(false)} dismissible>
            Opciones asignadas con éxito
            </Alert>
        )}
        <Row>
            <Col>
            <Form.Group className="comboboxRol">
                <Form.Label>
                <h3>Roles</h3>
                </Form.Label>
                <ComboboxRoles 
                     id={"roles"}
                     onRolIdChange={handleRolIdChange}
                 />
            </Form.Group>
            <h3 className="titleOptions">Opciones</h3>
            <span className="aviso"> Por favor seleccione la opción padre respectiva de la opcion que desea seleccionar </span>
            <Form>
                <Form.Group>
                {getOrderedOptions().map((option) => (
                    option.opcion_padre === "0"? (
                        <div className="opcionPadre">
                            <Form.Check
                            key={option.opcion_id}
                            type="checkbox"
                            id={option.opcion_id}
                            label={option.opcion_nombre}
                            checked={selectedOptions.includes(option.opcion_id)}
                            onChange={() => handleOptionChange(option.opcion_id)}
                        />
                        </div>
                    ):(
                        <Form.Check
                            className="opcionHija"
                            key={option.opcion_id}
                            type="checkbox"
                            id={option.opcion_id}
                            label={option.opcion_nombre}
                            checked={selectedOptions.includes(option.opcion_id)}
                            onChange={() => handleOptionChange(option.opcion_id)}
                        />
                    )
                ))}
                <br/>
                <br/>
                </Form.Group>
            </Form>
            </Col>
            <Col>
            <h3>Opciones seleccionadas:</h3>
            <ListGroup>
                {selectedOptions.map((optionId) => (
                    <ListGroup.Item key={optionId}>
                        {options.find((option) => option.opcion_id === optionId)?.opcion_nombre}
                    </ListGroup.Item>
                ))}
            </ListGroup>
            <Button onClick={handleSaveOptions}>Guardar opciones</Button>
            </Col>
            <br/>
        </Row>
        </div>
  );
}
