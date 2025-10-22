const cache = {};
async function imageExists(image_url, el) {
  if (!!cache[image_url]) return el.src = image_url;
  const image = new Image();
  image.onload = () => { el.src = image_url; }
  image.src = image_url;
  cache[image_url] = image;
}

function loadPreview() {
  const cells = document.querySelectorAll('#server_list_table > tbody > tr > td.map_cell');
  if (cells) {
    cells.forEach((a, b) => {
      let map = a.innerHTML.trim();
      if (map !== '--') {
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