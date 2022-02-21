function reImage(country) {
  if (country == "XX") {
    country = "US";
  }
  return `https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/${country.toLowerCase()}.svg`;
}

function loadIcons() {
  let details_location_image = document.querySelector(".details_location_image"); // details page
  if (details_location_image) {
    let co = details_location_image.style.backgroundImage.slice(-8).slice(0, -6);
    details_location_image.style.backgroundImage = `url('${reImage(co)}')`;
  }
  
  document.querySelectorAll(".contry_icon").forEach(item => { // server list
    let co = item.src.slice(-6).slice(0, -4);
    item.src = reImage(co);
  });
}

document.addEventListener("DOMContentLoaded", loadIcons);