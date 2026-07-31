/* ==========================================================================
   OIIon Custom Toast Controller
   ========================================================================== */

function showOiionToast(message, type = 'info', duration = 4000) {
  let container = document.getElementById('oiion-toast-container');
  
  if (!container) {
    container = document.createElement('div');
    container.id = 'oiion-toast-container';
    document.body.appendChild(container);
  }

  const icons = {
    success: 'fas fa-check-circle',
    error: 'fas fa-exclamation-circle',
    warning: 'fas fa-exclamation-triangle',
    info: 'fas fa-info-circle'
  };

  const toast = document.createElement('div');
  toast.className = `oiion-toast oiion-toast-${type}`;
  
  toast.innerHTML = `
    <div class="d-flex align-items-center gap-2">
      <i class="${icons[type] || icons.info} toast-icon mr-2"></i>
      <span>${message}</span>
    </div>
    <button class="oiion-toast-close" onclick="closeOiionToast(this.parentElement)">&times;</button>
  `;

  container.appendChild(toast);

  // Animación de entrada
  setTimeout(() => toast.classList.add('show'), 10);

  // Auto destruir
  const autoClose = setTimeout(() => {
    closeOiionToast(toast);
  }, duration);

  toast.dataset.autoClose = autoClose;
}

function closeOiionToast(toast) {
  if (!toast) return;
  
  if (toast.dataset.autoClose) {
    clearTimeout(toast.dataset.autoClose);
  }

  toast.classList.remove('show');
  
  setTimeout(() => {
    if (toast.parentElement) {
      toast.parentElement.removeChild(toast);
    }
  }, 300);
}