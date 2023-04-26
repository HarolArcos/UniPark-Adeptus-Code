/*import {   useState } from 'react';

  export const optenerDatos  = (url) => {
    const [dato, setDato] = useState([])
  
    
      setTimeout(() => {

          fetch(url)
          .then(perca => perca.json())
          .then(osa => {
            setDato(osa)
          })
        
      }, 2000);








  return dato
  
}*/


import { useState, useEffect } from 'react';

export function useFetch(url) {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    async function fetchData() {
      try {
        const response = await fetch(url);
        const data = await response.json();
        setData(data);
        setLoading(false);
      } catch (error) {
        setError(error);
        setLoading(false);
      }
    }
    fetchData();
  }, [url]);

  return { data, loading, error };
}

