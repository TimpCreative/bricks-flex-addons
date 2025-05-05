/* Flex Modal JS – uses CSS var for duration */

const openClass = 'bfa-modal--open';

document.addEventListener('click', (e) => {

  // open
  if (e.target.matches('.bfa-modal-trigger')) {
    const m = document.getElementById(e.target.dataset.target);
    if (m) m.classList.add(openClass);
  }

  // close by X button or icon inside it
  const closeBtn = e.target.closest('.bfa-modal__close');
  if ( closeBtn ) {
    closeBtn.closest('.bfa-modal')?.classList.remove(openClass);
  }

  // close by backdrop
  if (e.target.matches(`.bfa-modal.${openClass}`) &&
      !document.body.classList.contains('bricks-is-builder')) {
    // only close on front‑end, not inside Builder preview
    e.target.classList.remove(openClass);
  }

});

// close by Esc
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    document.querySelectorAll(`.${openClass}`).forEach(m => m.classList.remove(openClass));
  }
});