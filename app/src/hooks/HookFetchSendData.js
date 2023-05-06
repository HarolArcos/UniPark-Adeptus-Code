// import { useState, useEffect } from 'react';

// export function useFetchSendData(url) {
//   const [data, setData] = useState({});
//   const [error, setError] = useState(null);
 
//     async function fetchData(info) {
//       console.log('entro al fetchData');
//       console.log(info);
//       try {
//         if (info!= null) {
//           const requestOptions = {
//             method: 'POST',
//             body: JSON.stringify(info)
//           };
//           const response = await fetch(url,requestOptions);
//           const datos = await response.json();
          
//           setData(datos);
//           console.log(data);
//         }
//        } catch (error) {
//         setError(error);
//         console.log(error)
//       } 
//     }

//     useEffect(() => {
//       fetchData(null);
//     }, []);


//   return { data, fetchData,error };
// }



import { useState, useEffect } from 'react';

export function useFetchSendData(url) {
  const [data, setData] = useState({});
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);

  async function fetchData(info) {
    try {
      if (info != null && typeof info === 'object') {
        const requestOptions = {
          method: 'POST',
          body: JSON.stringify(info)
        };
        const response = await fetch(url, requestOptions);
        const datos = await response.json();
        
        typeof datos === 'object' && setData(datos);
        // console.log('Data actualizada:', datos);
      }
    } catch (error) {
      setError(error);
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    fetchData(null);
  }, []);

  return { data, fetchData, error, setLoading };
}