async function obtenerPromociones() {
    const respuesta = await fetch('./data/promociones.json');
    const data = await respuesta.json();
    return data;
  }
  