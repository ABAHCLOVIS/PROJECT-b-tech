// Sidebar toggle for mobile
const hamburger = document.getElementById('hamburger');
const sidebar = document.querySelector('.sidebar');
hamburger && hamburger.addEventListener('click', function() {
  sidebar.classList.toggle('open');
  const expanded = sidebar.classList.contains('open');
  hamburger.setAttribute('aria-expanded', expanded);
});
