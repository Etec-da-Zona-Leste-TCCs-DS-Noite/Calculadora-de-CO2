const hamburger = document.getElementById('hamburger');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

// toggle menu
function openMenu() {
  hamburger.classList.add('active');
  hamburger.setAttribute('aria-expanded', 'true');
  sidebar.classList.add('open');
  sidebar.setAttribute('aria-hidden', 'false');
  overlay.classList.add('visible');
}

function closeMenu() {
  hamburger.classList.remove('active');
  hamburger.setAttribute('aria-expanded', 'false');
  sidebar.classList.remove('open');
  sidebar.setAttribute('aria-hidden', 'true');
  overlay.classList.remove('visible');
}

hamburger.addEventListener('click', () => {
  const isOpen = sidebar.classList.contains('open');
  if (isOpen) closeMenu();
  else openMenu();
});

// fechar clicando no overlay
overlay.addEventListener('click', closeMenu);

// fechar com ESC
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeMenu();
});