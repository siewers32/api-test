function toggleOutput(what) {
  out = document.querySelector(`#${CSS.escape(what)} + .output`);
  if (out.style.display == 'none'|| out.style.display == '') {
    out.style.display = 'block'
  } else {
    out.style.display = 'none'
  }
}