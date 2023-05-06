import { useState, useEffect } from 'react';

export function useFetchSendData(url) {
  const [data, setData] = useState(null);
  const [error, setError] = useState(null);
 
    async function fetchData(info) {
      console.log('entro al fetchData');
      try {
        if (info!= null) {
          const requestOptions = {
            method: 'POST',
            body: JSON.stringify(info)
          };
          const response = await fetch(url,requestOptions);
          const datos = await response.json();
          
          setData(datos);
          
        }
       } catch (error) {
        setError(error);
        console.log(error)
      } 
    }

    useEffect(() => {
      fetchData(null);
    }, []);


  return { data, fetchData,error };
}
