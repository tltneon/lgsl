function reImage(country) {
  if (country === "XX") {
    country = "US";
  }
  return `https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/${country.toLowerCase()}.svg`;
}

function loadIcons() {
  let details_location_image = document.querySelector(".details_location_image"); // details page
  if (details_location_image) {
    let co = details_location_image.classList[2].slice(1);
    details_location_image.style.backgroundImage = `url('${reImage(co)}')`;
  }
  
  document.querySelectorAll(".contry_icon").forEach(item => { // server list
		item.style.backgroundImage = `url('${reImage(item.classList[2].slice(1))}')`;
		item.style.backgroundPosition = "inherit";
    item.style.backgroundSize = "cover";
  });
}

document.addEventListener("DOMContentLoaded", loadIcons);