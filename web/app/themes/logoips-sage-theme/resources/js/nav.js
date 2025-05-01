/* 
  Script to implement navigation bar dynamic
*/

/*=============== SHOW MENU ===============*/
const showMenu = (toggleId, navId) => {
  const toggle = document.getElementById(toggleId),
        nav = document.getElementById(navId),
        arrows = nav.querySelectorAll('.dropdown__arrow');

  toggle.addEventListener('click', () => {
    // Показ/скрытие меню
    nav.classList.toggle('show-menu');
    toggle.classList.toggle('show-icon');

    // Делаем все стрелки видимыми после открытия
    arrows.forEach(arrow => arrow.classList.remove('hidden'));
  });
};

showMenu('nav-toggle', 'nav-menu');

/*=============== SHOW DROPDOWN MENU ===============*/
const dropdownItems = document.querySelectorAll('.dropdown__item');

dropdownItems.forEach(item => {
  const button = item.querySelector('.dropdown__button');

  button.addEventListener('click', () => {
    const currentlyOpen = document.querySelector('.show-dropdown');

    toggleItem(item);

    if (currentlyOpen && currentlyOpen !== item) {
      toggleItem(currentlyOpen);
    }
  });
});

function toggleItem(item) {
  const container = item.querySelector('.dropdown__container'),
        arrow = item.querySelector('.dropdown__arrow');

  if (item.classList.contains('show-dropdown')) {
    container.removeAttribute('style');
    item.classList.remove('show-dropdown');
  } else {
    container.style.height = container.scrollHeight + 'px';
    item.classList.add('show-dropdown');
  }
}

/*=============== DELETE DROPDOWN STYLES ON RESIZE ===============*/
const mediaQuery = matchMedia('(min-width: 1118px)');

function removeStyles() {
  if (mediaQuery.matches) {
    document.querySelectorAll('.dropdown__container').forEach(c => c.removeAttribute('style'));
    document.querySelectorAll('.dropdown__item.show-dropdown').forEach(i => i.classList.remove('show-dropdown'));
    document.querySelectorAll('.dropdown__arrow').forEach(a => a.classList.add('hidden'));
  }
}

addEventListener('resize', removeStyles);
