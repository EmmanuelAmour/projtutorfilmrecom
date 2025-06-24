function showNotification() {
  const container = document.getElementById('notificationContainer');
  
  const notif = document.createElement('div');
  notif.classList.add('notification');

  notif.innerHTML = `
    <strong>Nouvelle notification</strong><br>
    Ceci est un message d'information.
    <button class="close-btn" onclick="closeNotification(this)">&times;</button>
  `;

  container.appendChild(notif);

  // Supprimer automatiquement après 5 secondes
  setTimeout(() => {
    notif.classList.add('hide');
    setTimeout(() => notif.remove(), 500); // attendre l'animation
  }, 5000);
}

function closeNotification(button) {
  const notif = button.parentElement;
  notif.classList.add('hide');
  setTimeout(() => notif.remove(), 500);
}
