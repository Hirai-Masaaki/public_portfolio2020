'use strict';

{
  const images = [
    'image/sashimiSushi_6.jpg',
    'image/sashimiSushi_11_res.jpg',
    'image/sashimiSushi_10_res.jpg',
    'image/sashimiSushi_4.jpg',
    'image/sashimiSushi_1_res.jpg',
  ];
  let currentIndex = 0;

  const slideImage = document.getElementById('slide2');
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
      const thumbnail = document.querySelectorAll('.thumbnail2 > li');
      thumbnail[currentIndex].classList.remove('current');
      currentIndex = index;
      thumbnail[currentIndex].classList.add('current');
    });
    li.appendChild(img);
    document.querySelector('.thumbnail2').appendChild(li);
  });

  const next = document.getElementById('next2');
  next.addEventListener('click', () => {
    let target = currentIndex + 1;
    if (target === images.length) {
      target = 0;
    }
    document.querySelectorAll('.thumbnail2 > li')[target].click();
  });

  const prev = document.getElementById('prev2');
  prev.addEventListener('click', () => {
    let target = currentIndex - 1;
    if (target < 0) {
      target = images.length -1;
    }
    document.querySelectorAll('.thumbnail2 > li')[target].click();
  });
}