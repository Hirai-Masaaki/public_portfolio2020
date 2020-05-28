'use strict';

// {
  // document.getElementsByClassName('btn_A').addEventListener('click', () => {
    // }
  const null_alert = '転記するテキストを入力してください。';
  const conf = 'この内容で転記しますか？';
  const h3 = document.querySelector('h3');
  function A() {
    const A = document.getElementById("A");
    const B = document.getElementById("B");
    if (A.value == false) {
      alert(null_alert);
    } else {
      if (confirm(conf)) {
        B.value = document.getElementById("A").value;
        B.style.backgroundColor = 'pink';
        B.style.color = 'white';
        h3.textContent = 'Aの値をBに転記！';
        h3.style.color = 'gray';
      } 
    }
  }
  function B() {
    const B = document.getElementById("B");
    const C = document.getElementById("C");
    if (B.value == false) {
      alert(null_alert);
    } else {
      if (confirm(conf)) {
        C.value = document.getElementById("B").value;
        C.style.backgroundColor = 'skyblue';
        C.style.color = 'white';
        h3.textContent = 'Bの値をCに転記！';
        h3.style.color = 'pink';
      }
    }
  }
  function C() {
    const C = document.getElementById("C");
    const D = document.getElementById("D");
    if (C.value == false) {
      alert(null_alert);
    } else {
      if (confirm(conf)) {
        D.value = document.getElementById("C").value;
        D.style.backgroundColor = 'yellowgreen';
        D.style.color = 'white';
        h3.textContent = 'Cの値をDに転記！';
        h3.style.color = 'skyblue';
      }
    }
  }
  function D() {
    const D = document.getElementById("D");
    const E = document.getElementById("E");
    if (D.value == false) {
      alert(null_alert);
    } else {
      if (confirm(conf)) {
        E.value = document.getElementById("D").value;
        E.style.backgroundColor = 'purple';
        E.style.color = 'white';
        h3.textContent = 'Dの値をEに転記！';
        h3.style.color = 'yellowgreen';
      }
    }
  }
  function E() {
    const E = document.getElementById("E");
    const F = document.getElementById("F");
    if (E.value == false) {
      alert(null_alert);
    } else {
      if (confirm(conf)) {
        F.value = document.getElementById("E").value;
        F.style.backgroundColor = 'orange';
        F.style.color = 'white';
        h3.textContent = 'Eの値をFに転記！';
        h3.style.color = 'purple';
      }
    }
  }
  function F() {
    const F = document.getElementById("F");
    const G = document.getElementById("G");
    if (F.value == false) {
      alert(null_alert);
    } else {
      if (confirm(conf)) {
        G.value = document.getElementById("F").value;
        G.style.backgroundColor = 'magenta';
        G.style.color = 'white';
        h3.textContent = 'Fの値をGに転記！';
        h3.style.color = 'orange';
      }
    }
  }
  function G() {
    const G = document.getElementById("G");
    const A = document.getElementById("A");
    if (G.value == false) {
      alert(null_alert);
    } else {
      if (confirm(conf)) {
        A.value = document.getElementById("G").value;
        A.style.backgroundColor = 'gray';
        A.style.color = 'white';
        h3.textContent = 'Gの値をAに転記！';
        h3.style.color = 'magenta';
      }
    }
  }
  // });
// }