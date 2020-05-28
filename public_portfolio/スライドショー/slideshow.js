'use strict';

{
  const images = [//定数imagesに画像の配列を入れる
    'image/img1.png',
    'image/img2.png',
    'image/img3.png',
    'image/img4.png',
    'image/img5.png',
    'image/img6.png',
  ];
  let currentIndex = 0;//変数currentIndexの初期値0

  const mainImage = document.getElementById('main');//定数mainImageに#mainを取得
  mainImage.src = images[currentIndex];//#mainに0番目の画像を入れる

  images.forEach((image, index) => {//画像をループ
    const img = document.createElement('img');//定数imgにimg要素を取得
    img.src = image;//img要素にimageを入れる

    const li = document.createElement('li');//定数liにliを作成
    if (index === currentIndex) {//index = 0なら、
      li.classList.add('current');//li要素にclass="current"を追加
    }
    li.addEventListener('click', () => {//li要素をクリックしたとき
      mainImage.src = image;//#mainにimageを入れる
      const thumbnail = document.querySelectorAll('.thumbnail > li');//定数thumbnailにclass="thumbnail"直下のliを取得
      thumbnail[currentIndex].classList.remove('current');//.thumbnailのliの0番目に.currentがついてるなら外す
      currentIndex = index;//初期値0にindexを入れる
      thumbnail[currentIndex].classList.add('current');//.thumbnailのliのindex番目に.currentを追加する
    });
    li.appendChild(img);//li要素の子要素にimage追加
    document.querySelector('.thumbnail').appendChild(li);//.thumbnailを取得し、子要素にli要素を追加
  });

  const next = document.getElementById('next');//定数nextに#nextを取得
  next.addEventListener('click', () => {//#nextがクリックされたとき
    let target = currentIndex + 1;//変数targetに初期値0+1
    if (target === images.length) {//もしtargetが画像の数とイコールなら、
      target = 0;//targetを0にする
    }
    document.querySelectorAll('.thumbnail > li')[target].click();//.thumbnail直下のli要素のtarget番目をクリック
  });

  const prev = document.getElementById('prev');//定数prevに#prevを取得
  prev.addEventListener('click', () => {//#prevがクリックされたら
    let target = currentIndex - 1;//変数targetに初期値0-1
    if (target < 0) {//もしtargetが0より小さいなら
      target = images.length -1;//targetに画像の数-1
    }
    document.querySelectorAll('.thumbnail > li')[target].click();//.thumbnail直下のli要素のtarget番目をクリック
  });

  let timeoutId;//変数timeoutID(空)

  function playSlideshow() {//関数playSlideshowを宣言
    timeoutId = setTimeout(() => {//timeoutIdに6000msで勝手に定数nextの動きをさせる
      next.click();
      playSlideshow();
    }, 6000);
  }

  let isPlaying = false;//変数isPlayingは偽

  const play = document.getElementById('play');//定数playに#playを取得
  play.addEventListener('click', () => {//#playがクリックされたとき
    if (isPlaying === false) {//もしisPlayingが偽なら、
      playSlideshow();//timeoutIdに6000msで勝手に定数nextの動きをさせる
      play.textContent = 'Pause';//playのテキストをPauseに変更
    } else {//isPlayingが偽でないなら、
      clearTimeout(timeoutId);//timeoutIdの動作をやめる
      play.textContent = 'Play';//playのテキストをPlayに変更
    }
    isPlaying = !isPlaying;//isPlayingは真になる
  });
}