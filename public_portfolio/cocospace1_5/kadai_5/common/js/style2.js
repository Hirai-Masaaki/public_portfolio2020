'use strict';
const form = document.getElementById("form");
function dial(elem) {
  form.textContent = form.textContent + elem.textContent;
}
function call() {
  const display = document.getElementById("display");
  display.textContent = form.textContent;
  display.style.color = 'black';
}