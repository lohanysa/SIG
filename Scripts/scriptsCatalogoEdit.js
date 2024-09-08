// Obtener todos los botones de "Editar"
const buttons = document.querySelectorAll('button.editar');

// Iterar sobre cada botón y agregar un evento clic
buttons.forEach(button => {
    button.addEventListener('click', function() {
        // Obtener información del artículo
        console.log("Entrado en script");
        const article = this.closest('article');
        const idAmigurumis = article.querySelector('.id-amigurumis').value;
        const nombre = article.querySelector('.nombre').textContent;
        const descripcion = article.querySelector('.descripcion').textContent;

        // Obtener el precio y la cantidad, eliminando los caracteres no numéricos
        const precioText = article.querySelector('.precio').textContent;
        const cantidadText = article.querySelector('.cantidad-disponible').textContent;

        // Usar expresiones regulares para extraer solo los números
        const precio = parseFloat(precioText.replace(/[^\d.]/g, ''));
        const cantidadDisponible = parseInt(cantidadText.replace(/[^\d]/g, ''), 10);

        const imagenSrc = article.querySelector('img').src;

        console.log({
            idAmigurumis,
            nombre,
            descripcion,
            precio,
            cantidadDisponible,
            imagenSrc
        });

        // Guardar la información en localStorage
        localStorage.setItem('editAmigurumi', JSON.stringify({
            idAmigurumis,
            nombre,
            descripcion,
            precio,
            cantidadDisponible,
            imagenSrc
        }));

        // Redirigir a p_Product.html
        window.location.href = 'P_Producto.html';
    });
});
