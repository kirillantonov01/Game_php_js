import { start} from './Controller.js';

start();

export function print(array){
    let html = "<table border=1 bgcolor='white' style='margin: auto'>";
    html += "<tr>";
    html += "<th>Player Mark</th>";
    html += "<th>Turn</th>";
    for(let i = 0; i < array.length - 2; i++) {
        var temp_array = array[i].split("|").slice(0, 2);
        html += "<tr>";
        for(let j = 0; j < temp_array.length; j++) {
            html += "<td>"+ temp_array[j] + "</td>";
        }
    }
    html += "</table>";
    if(array.length > 1) {
        listElem.innerHTML = html;
    } else {
        alert("Game not found");
    }
}