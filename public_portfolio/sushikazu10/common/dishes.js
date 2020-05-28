'use strict';

{
  const images = [
    'image/dishes_2_res.jpg',
    'image/dishes_1_res.jpg',
    'image/dishes_3.jpg',
    'image/dishes2.jpg',
    'image/dishes_4.jpg',
  ];
  let currentIndex = 0;

  const slideImage = document.getElementById('slide3');
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
      const thumbnail = document.querySelectorAll('.thumbnail3 > li');
      thumbnail[currentIndex].classList.remove('current');
      currentIndex = index;
      thumbnail[currentIndex].classList.add('current');
    });
    li.appendChild(img);
    document.querySelector('.thumbnail3').appendChild(li);
  });

  const next = document.getElementById('next3');
  next.addEventListener('click', () => {
    let target = currentIndex + 1;
    if (target === images.length) {
      target = 0;
    }
    document.querySelectorAll('.thumbnail3 > li')[target].click();
  });

  const prev = document.getElementById('prev3');
  prev.addEventListener('click', () => {
    let target = currentIndex - 1;
    if (target < 0) {
      target = images.length -1;
    }
    document.querySelectorAll('.thumbnail3 > li')[target].click();
  });
}