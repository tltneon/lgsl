async function imageExists(image_url, el) {
	var http = new XMLHttpRequest();
	http.open('HEAD', image_url, true);
  http.onload = () => {
    if (http.status !== 404)
      el.src = image_url;
  };
	http.send();
}

function loadPreview() {
  const cells = document.querySelectorAll('#server_list_table > tbody > tr > td.map_cell');
  if (cells) {
    cells.forEach((a, b) => {
      let map = a.innerHTML.trim();
      if(map !== '-' && map !== '--'){
        let el = document.createElement('img');
        imageExists(a.getAttribute('data-path'), el);
        el.style.width = '250px';
        el.style.height = '188px';
        el.style.display = 'none';
        el.style.position = 'absolute';
        el.style.marginTop = '5px';
        el.style.transform = 'translate(-25%, 0%)';
        el.style.borderRadius = '6px';
        el.style.zIndex = '11';
        el.className = `mapImage${b}`;
        a.appendChild(el);

        a.onmouseover = () => document.querySelector(`.mapImage${b}`).style.display = 'block';
        a.onmouseout = () => document.querySelector(`.mapImage${b}`).style.display = 'none';
      }
    })
  }
}

document.addEventListener("DOMContentLoaded", loadPreview);