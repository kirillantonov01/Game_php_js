import { game } from './Controller.js';

export var winIn = [];
export let name = prompt('Enter your name (Default name - "Guest")')
export let size = prompt('Enter board size (Minimum - 3 Maximum - 10)');

export function start_game() {

    if (size === null || size === '') {
        size = 3;
    }

    if (name === null || name === '') {
        name = "Guest";
    }

    var increment = 0;
    for (let i = 0; i <= (size-1); i++) {
        winIn[i] = [];	
        for (let j = 0; j <= (size-1); j++) {
            winIn[i][j] = increment;
            increment++;        
        }
    }

    increment = 0;
    var increment2 = 0;
    for (let i = parseInt(size); i < (parseInt(size)+parseInt(size)); i++) {
        winIn[i] = [];	
        for (let j = 0; j <= (parseInt(size)-1); j++) {
            winIn[i][j] = increment2;
            increment2 = increment2 + parseInt(size);        
        }
        increment++;
        increment2 = increment;
    }

    increment = 0;
    for (let i = parseInt(size)+parseInt(size); i < (parseInt(size)+parseInt(size)+1); i++) {
        winIn[i] = [];	
        for (let j = 0; j <= (parseInt(size)-1); j++) {
            winIn[i][j] = increment;
            increment = increment + parseInt(size) + 1;        
        }
    }

    increment = parseInt(size)-1;
    for (let i = (parseInt(size)+parseInt(size)+1); i < (parseInt(size)+parseInt(size)+2); i++) {
        winIn[i] = [];	
        for (let j = 0; j <= (parseInt(size)-1); j++) {
            winIn[i][j] = increment;
            increment = increment + parseInt(size)-1;        
        }
    }
}

game();