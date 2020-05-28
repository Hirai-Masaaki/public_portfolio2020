'use strict';

const calc_form = document.getElementById("calc_form");

function calc(elem) {
  switch(true) {
    case /^0$/.test(calc_form.textContent):
      calc_form.textContent = elem.textContent;
      break;
    default:
      calc_form.textContent = calc_form.textContent + elem.textContent;
      break;
  }
}

function only_zero() {
  switch(true) {
    case /^\-?\d+\.?\d*[\+\-\*\/]$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent + '0';
      break;
  }
}

function zero(elem) {
  switch(true) {
    case /^\-?[1-9]+\d*$/.test(calc_form.textContent):
    case /^\-?\d+\.\d*$/.test(calc_form.textContent):
    case /^\-?\d+\.?\d*[\+\-\*\/]\-?[1-9]+\d*$/.test(calc_form.textContent):
    case /^\-?\d+\.?\d*[\+\-\*\/]\-?\d+\.\d*$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent + elem.textContent;
      break;
  }
}

function dot() {
  switch(true) {
    case /^\-?\d+$/.test(calc_form.textContent):
    case /^\-?\d+\.?\d*[\+\-\*\/]\-?\d+$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent + '.';
      break;
  }
}

function minus() {
  switch(true) {
    case /^0$/.test(calc_form.textContent):
      calc_form.textContent = '-';
      break;
    case /^$/.test(calc_form.textContent):
    case /^\-?\d+\.?\d*[\+\-\*\/]$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent + '-';
      break;
  }
}

function plus() {
  switch(true) {
    case /^\-$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent.replace(/\-$/, '0');
      break;
    case /^\-?\d+\.?\d*[\+\-\*\/]\-$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent.replace(/\-$/, '');
      break;
  }
}

function edit(elem) {
  var num = calc_form.textContent.split(/[\+\-\*\/]/);
  var calc1 = Number(num[0]);
  var calc2 = Number(num[1]);
  switch(true) {
    case /^\-?\d+\.?\d*$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent + elem.textContent;
      break;
    case /^\-?\d+\.?\d*[\+\-\*\/]$/.test(calc_form.textContent):
      calc_form.textContent = calc_form.textContent.replace(/[\+\-\*\/]$/, elem.textContent);
      break;
    case /^\-?\d+\.?\d*[\+\-\*\/]\-?\d+\.?\d*$/.test(calc_form.textContent):
      switch(true) {
        case /^\d+\.?\d*\+\d+\.?\d*$/.test(calc_form.textContent):
          calc_form.textContent = calc1 + calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\d+\.?\d*\-\d+\.?\d*$/.test(calc_form.textContent):
          calc_form.textContent = calc1 - calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\d+\.?\d*\*\d+\.?\d*$/.test(calc_form.textContent):
          calc_form.textContent = calc1 * calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\d+\.?\d*\/\d+\.?\d*$/.test(calc_form.textContent):
          calc_form.textContent = calc1 / calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\d+\.?\d*\+\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[0]);
          var calc2 = Number(num[2]);
          calc_form.textContent = calc1 + -calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\d+\.?\d*\-\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[0]);
          var calc2 = Number(num[2]);
          calc_form.textContent = calc1 - -calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
          case /^\d+\.?\d*\*\-\d+\.?\d*$/.test(calc_form.textContent):
            var calc1 = Number(num[0]);
            var calc2 = Number(num[2]);
            calc_form.textContent = calc1 * -calc2;
            calc_form.textContent = calc_form.textContent + elem.textContent;
            break;
            case /^\d+\.?\d*\/\-\d+\.?\d*$/.test(calc_form.textContent):
              var calc1 = Number(num[0]);
              var calc2 = Number(num[2]);
          calc_form.textContent = calc1 / -calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\+\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[2]);
          calc_form.textContent = -calc1 + calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[2]);
          calc_form.textContent = -calc1 - calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\*\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[2]);
          calc_form.textContent = -calc1 * calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\/\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[2]);
          calc_form.textContent = -calc1 / calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\+\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[3]);
          calc_form.textContent = -calc1 + -calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\-\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[3]);
          calc_form.textContent = -calc1 - -calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\*\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[3]);
          calc_form.textContent = -calc1 * -calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
        case /^\-\d+\.?\d*\/\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[1]);
          var calc2 = Number(num[3]);
          calc_form.textContent = -calc1 / -calc2;
          calc_form.textContent = calc_form.textContent + elem.textContent;
          break;
      }
      break;
  }
}

function equal() {
  var num = calc_form.textContent.split(/[\+\-\*\/]/);
  var calc1 = Number(num[0]);
  var calc2 = Number(num[1]);
  switch(true) {
    case /^\d+\.?\d*\+\d+\.?\d*$/.test(calc_form.textContent):
      calc_form.textContent = calc1 + calc2;
      calc_form.textContent = calc_form.textContent + elem.textContent;
      break;
    case /^\d+\.?\d*\-\d+\.?\d*$/.test(calc_form.textContent):
      calc_form.textContent = calc1 - calc2;
      break;
    case /^\d+\.?\d*\*\d+\.?\d*$/.test(calc_form.textContent):
      calc_form.textContent = calc1 * calc2;
      break;
    case /^\d+\.?\d*\/\d+\.?\d*$/.test(calc_form.textContent):
      calc_form.textContent = calc1 / calc2;
      break;
    case /^\d+\.?\d*\+\-\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[0]);
      var calc2 = Number(num[2]);
      calc_form.textContent = calc1 + -calc2;
      break;
    case /^\d+\.?\d*\-\-\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[0]);
      var calc2 = Number(num[2]);
      calc_form.textContent = calc1 - -calc2;
      break;
      case /^\d+\.?\d*\*\-\d+\.?\d*$/.test(calc_form.textContent):
        var calc1 = Number(num[0]);
        var calc2 = Number(num[2]);
        calc_form.textContent = calc1 * -calc2;
        break;
        case /^\d+\.?\d*\/\-\d+\.?\d*$/.test(calc_form.textContent):
          var calc1 = Number(num[0]);
          var calc2 = Number(num[2]);
      calc_form.textContent = calc1 / -calc2;
      break;
    case /^\-\d+\.?\d*\+\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[2]);
      calc_form.textContent = -calc1 + calc2;
      break;
    case /^\-\d+\.?\d*\-\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[2]);
      calc_form.textContent = -calc1 - calc2;
      break;
    case /^\-\d+\.?\d*\*\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[2]);
      calc_form.textContent = -calc1 * calc2;
      break;
    case /^\-\d+\.?\d*\/\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[2]);
      calc_form.textContent = -calc1 / calc2;
      break;
    case /^\-\d+\.?\d*\+\-\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[3]);
      calc_form.textContent = -calc1 + -calc2;
      break;
    case /^\-\d+\.?\d*\-\-\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[3]);
      calc_form.textContent = -calc1 - -calc2;
      break;
    case /^\-\d+\.?\d*\*\-\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[3]);
      calc_form.textContent = -calc1 * -calc2;
      break;
    case /^\-\d+\.?\d*\/\-\d+\.?\d*$/.test(calc_form.textContent):
      var calc1 = Number(num[1]);
      var calc2 = Number(num[3]);
      calc_form.textContent = -calc1 / -calc2;
      break;
  }
}