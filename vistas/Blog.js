document.querySelectorAll('.details').forEach(function(button) {
    button.addEventListener('click', function() {
      const target = button.getAttribute('data-target');
      const popup = document.getElementById(target);
  
      if (popup) {
        popup.style.display = 'block';
      }
    });
  });
  
  // JavaScript para cerrar la ventana emergente
  document.querySelectorAll('.close').forEach(function(closeButton) {
    closeButton.addEventListener('click', function() {
      const popup = closeButton.closest('.popup');
      if (popup) {
        popup.style.display = 'none';
      }
    });
  });
  


