function imageExists(image_url){
	var http = new XMLHttpRequest();
	http.open('HEAD', image_url, false);
	http.send();
	return http.status != 404;
}

var types = document.querySelectorAll("#server_list_table > tbody > tr > td.status_cell > a > img");
document.querySelectorAll('#server_list_table > tbody > tr > td.map_cell').forEach((a, b)=>{
	let map = a.innerHTML.trim();
	if(map != '--'){
		let el = document.createElement('img');
		let type = types[b].title.match(/Type: [\w]*/)[0].slice(6);
		let game = types[b].title.match(/Game: [\w]*/)[0].slice(6);
		let pathes = [
			'lgsl_files/maps/' + type + '/' + game + '.jpg',
			'lgsl_files/maps/' + type + '/' + game + '.png',
			'lgsl_files/maps/' + type + '/' + game + '/' + map + '.jpg',
			'lgsl_files/maps/' + type + '/' + game + '/' + map + '.png'
		]
		path = 'lgsl_files/other/map_no_image.jpg';
		pathes.forEach(a => {
			if(imageExists(a)){
				path = a;
			}
		})
		el.src = path;
		el.style.width = '250px';
		el.style.height = '188px';
		el.style.display = 'none';
		el.style.position = 'absolute';
		el.className = 'mapImage' + b;
		a.appendChild(el);

		a.onmouseover = function(){document.querySelector('.mapImage'+b).style.display = 'inherit';}
		a.onmouseout = function(){document.querySelector('.mapImage'+b).style.display = 'none';}
	}
})