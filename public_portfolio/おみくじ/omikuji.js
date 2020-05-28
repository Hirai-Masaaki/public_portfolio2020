


    // const results = ['大吉', '中吉', '凶', '末吉'];
    // const results = ['大吉','大吉','大吉','大吉','凶'];
    // const n = Math.floor(Math.random() * results.length);
    // btn.textContent = results[n];
    // btn.textContent = results[Math.floor(Math.random() * results.length)];
    // btn.textContent = n;

    // switch (n) {
    //   case 0:
    //     btn.textContent = '大吉';
    //     break;
    //   case 1:
    //     btn.textContent = '中吉';
    //     break;
    //   case 2:
    //     btn.textContent = '凶';
    //     break;
    // }
'use strict';//厳密なエラーチェック

{
  const btn = document.getElementById('btn');

  btn.addEventListener('click', () => {
    const n = Math.random();
    const btn_color = document.getElementById('btn');
    const background = document.querySelector('body');
    const color = ["red", "orange", "skyblue", "0 10px 0 rgb(180, 0, 36)", "0 10px 0 rgb(194, 126, 0)", "0 10px 0 rgb(95, 146, 167)", "rgb(255, 213, 220)", "rgb(255, 255, 181)", "rgb(212, 212, 255)"];
    const style = (fortune,x,y,z) => {
      btn.textContent = `${fortune}`;
      btn_color.style.background = color[`${x}`];
      btn_color.style.boxShadow = color[`${y}`];
      background.style.background = color[`${z}`];
    }
    if(n < 0.2) {//20%
      style("大吉",0,3,6);
      // btn_color.className = 'btn_red:active';
    } else if (n < 0.5) {//30%
      style("中吉",1,4,7);
      // btn_color.className = 'btn_orange:active';
    } else {
      style("凶",2,5,8);//50%
      // btn_color.className = 'btn_skyblue:active';
    }
  });
}