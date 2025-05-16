document.addEventListener('DOMContentLoaded', async () => {
    const data = await obtenerPromociones();
    cargarPromociones(data, 'productos');
  
    document.querySelectorAll('.boton-categoria').forEach(boton => {
      boton.addEventListener('click', () => {
        const categoria = boton.dataset.categoria;
        cargarPromociones(data, categoria);
      });
    });
  });
  
  function cargarPromociones(data, categoria) {
    const contenedor = document.getElementById('promociones-container');
    contenedor.innerHTML = '';
  
    data[categoria].forEach(item => {
      const card = document.createElement('div');
      card.className = 'promo-card';
      card.innerHTML = `
        <img src="${item.imagen}" alt="promo" class="promo-img">
        <div class="promo-content">
          <h3>${item.titulo}</h3>
          <p>${item.descripcion}</p>
        </div>
      `;
      contenedor.appendChild(card);
    });
  }
  