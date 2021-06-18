function cl(){
  let vars = document.querySelectorAll(".details_info .details_info_srow .details_info_ceil:nth-child(2)");
  if(vars){
    refreshData(vars[4].innerText, vars[1].innerText, vars[2].innerText, vars[3].innerText);
  }
}
async function refreshData(type = 'source', ip, c_port, q_port){
  let response = await fetch('lgsl_files/lgsl_feed.php?type='+type+'&ip='+ip+'&c_port='+c_port+'&q_port='+q_port+'&request=s&format=3');
  if (response.ok) {
    let status = await response.text();
    status = JSON.parse(atob(status.slice(4, -4)));
    let details = document.querySelectorAll(".details_info .details_info_srow .details_info_ceil:nth-child(2)");
    // reload main info
    details[0].innerText = (status.b.status == "1"
                          ? (status.s.password == "1"
                              ? "ONLINE WITH PASSWORD"
                              : "ONLINE")
                          : "OFFLINE");
    details[6].innerText = status.s.map;
    details[7].innerText = status.s.players + " / " + status.s.playersmax;
    document.querySelector('[id^=servername]').innerText = status.s.name;
    document.querySelector(".details_info_row:last-child").innerText = "Last update: " + (new Date()).toUTCString() + "\nServer last query: " + (new Date(Number(status.s.cache_time + '000'))).toUTCString() + " ";
    // reload chart if it exists
    if(document.querySelector('#chart'))
      document.querySelector('#chart').src = document.querySelector('#chart').src;
    a.appendChild(el);
  }
  else {
    alert("HTTP Error: " + response.status);
  }
}

let a = document.querySelector(".details_info_row:last-child");
let el = document.createElement("a");
if(a) {
  el.onclick = () => {
    cl();
  }
  a.appendChild(el);
  el.innerText = "🔃";
  let st = document.createElement("style");
  st.innerText = `
  .details_info_row:last-child a {
    display: inline-block;
    color: aliceblue;
    transition-duration: 1s;
    animation: loader 1.1s infinite linear;
    font-size: 14px;
  }
  .details_info_row:last-child a:hover {
    color: crimson;
    cursor: pointer;
  }
  
  @keyframes loader {
    0%   {transform:rotate(45deg)}
    25%  {transform:rotate(90deg)}
    50%  {transform:rotate(135deg)}
    75%  {transform:rotate(180deg)}
    100% {transform:rotate(225deg)}
  }`;
  document.body.appendChild(st);
}