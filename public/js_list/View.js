import { list1, games } from './Model.js';

list1();

export function print(array){

    let html = "<table border=1 bgcolor='white' style='margin: auto'>";
    html += "<tr>";
    html += "<th>id Game</th>";
    html += "<th>Date</th>";
    html += "<th>Time</th>";
    html += "<th>Name</th>";
    html += "<th>Size</th>";
    html += "<th>Result</th>";
    
    for(let i = 0; i < array.length; i++) {
        let temp_array = array[i].split("|");
        html += "<tr>";
        for(let j = 0; j < temp_array.length; j++) {
                html += "<td>" + temp_array[j] + "</td>";
            
        }
    }
    html += "</table>";
    listElem.innerHTML = html;
}

export function print_err(){
    listElem.innerHTML = '<li id="list">Сыгранных партий пока нет</li>'
}