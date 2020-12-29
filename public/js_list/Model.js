import { print, print_err } from './View.js';

export var db;
export var games;

export async function list1()
{
    let response = await fetch('/games', {
        method: 'GET'
    });
    let json = await response.json();
    let jsonArray = json.split(";");
    print(jsonArray);
}