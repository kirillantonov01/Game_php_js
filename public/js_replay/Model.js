import { print} from './View.js';
import { id} from './Controller.js';


export async function list1()
{
    let response = await fetch('/games/' + id, {
        method: 'GET'
    });
    let json = await response.json();
    let jsonArray = json.split(";");
    console.log(jsonArray);
    print(jsonArray);
}