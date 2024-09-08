function Entrar(event) {
    event.preventDefault();
  
    const usuario = document.getElementById('userName').value;
    const clave = document.getElementById('Clave').value;
  
    if (usuario === "Administrador" && clave === "Mugumis2024") {
      mostrarToast("Inicio de sesión exitoso", "success");
      setTimeout(() => {
        window.location.href = "p_GestionCatalogo.php";
      }, 2000);
    } else {
      mostrarToast("Usuario o contraseña incorrecto", "error");
    }
  }
  
  function mostrarToast(mensaje, tipo) {
    const toast = document.getElementById('toast-notification');
    const toastMessage = toast.querySelector('.toast-message');
    const toastIcon = toast.querySelector('.toast-icon');
  
    if (tipo === "success") {
      toast.style.backgroundColor = "#28a745"; // Color verde para éxito
      toastIcon.textContent = "✔️";
    } else {
      toast.style.backgroundColor = "#dc3545"; // Color rojo para error
      toastIcon.textContent = "❌";
    }
  
    toastMessage.textContent = mensaje;
    toast.classList.add('show');
  
    setTimeout(() => {
      toast.classList.remove('show');
    }, 1500);
  }
  