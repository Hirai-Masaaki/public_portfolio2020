'use strict';

{
  const images = [
    'image/second4_res.jpg',
    'image/setMenu2_res.jpg',
    'image/setMenu3_res.jpg',
  ];
  let currentIndex = 0;

  const slideImage = document.getElementById('slide1');
  slideImage.src = images[currentIndex];
  
  images.forEach((image, index) => {
    const img = document.createElement('img');
    img.src = image;
    
    const li = document.createElement('li');
    if (index === currentIndex) {
      li.classList.add('current');
    }
    li.addEventListener('click', () => {
      slideImage.src = image;
      const thumbnail = document.querySelectorAll('.thumbnail1 > li');
      thumbnail[currentIndex].classList.remove('current');
      currentIndex = index;
      thumbnail[currentIndex].classList.add('current');
    });
    li.appendChild(img);
    document.querySelector('.thumbnail1').appendChild(li);
  });
  
  const next = document.getElementById('next1');
  next.addEventListener('click', () => {
    let target = currentIndex + 1;
    if (target === images.length) {
      target = 0;
    }
    document.querySelectorAll('.thumbnail1 > li')[target].click();
  });

  const prev = document.getElementById('prev1');
  prev.addEventListener('click', () => {
    let target = currentIndex - 1;
    if (target < 0) {
      target = images.length -1;
    }
    document.querySelectorAll('.thumbnail1 > li')[target].click();
  });
}