function hideElement(element) {
  element.style.transitionDuration = "2s";
  setTimeout(() => {
    element.style.opacity = 0;
  }, 2000);
  setTimeout(() => {
    element.style.display = "none";
  }, 3000);
}