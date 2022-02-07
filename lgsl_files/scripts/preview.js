async function imageExists(image_url, el){
	var http = new XMLHttpRequest();
	http.open('HEAD', `lgsl_files/maps/${image_url}`, true);
  http.onload = function () {
    if (http.status != 404)
      el.src = `lgsl_files/maps/${image_url}`;
  };
	http.send();
}

function loadPreview(){
  if(document.querySelector('#server_list_table > tbody > tr > td.map_cell')){
    var types = document.querySelectorAll("#server_list_table > tbody > tr > td.status_cell > a > img");
    document.querySelectorAll('#server_list_table > tbody > tr > td.map_cell').forEach((a, b)=>{
      let map = a.innerHTML.trim();
      if(map != '-' && map != '--'){
        let el = document.createElement('img');
        let arr = types[b].title.match(/(\w{1,} \])/i);
        let type = arr[0].slice(0, -2);
        let game = arr[1].slice(0, -2);
        map = map.replace(' ', '_').toLowerCase();
        let pathes = [
          `${type}/${game}.jpg`,
          `${type}/${game}.png`,
          `${type}/${game}/${map}.jpg`,
          `${type}/${game}/${map}.png`
        ];
        path = '/lgsl_files/other/map_no_image.jpg';
        pathes.forEach(a => {
          imageExists(a, el);
        })
        el.src = path;
        el.style.width = '250px';
        el.style.height = '188px';
        el.style.display = 'none';
        el.style.position = 'absolute';
        el.style.marginTop = '5px';
        el.style.zIndex = '11';
        el.className = `mapImage${b}`;
        a.appendChild(el);

        a.onmouseover = function(){document.querySelector(`.mapImage${b}`).style.display = 'inherit';}
        a.onmouseout = function(){document.querySelector(`.mapImage${b}`).style.display = 'none';}
      }
    })
  }
}

document.addEventListener("DOMContentLoaded", loadPreview);