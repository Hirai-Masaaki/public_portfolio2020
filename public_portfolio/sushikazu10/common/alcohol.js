'use strict';

{
  const images = [
    'image/alcohol1_res.jpg',
    'image/alcohol_1.jpg',
    'image/alcohol_2.jpg',
    'image/alcohol_3.jpg',
  ];
  let currentIndex = 0;

  const slideImage = document.getElementById('slide4');
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
      const thumbnail = document.querySelectorAll('.thumbnail4 > li');
      thumbnail[currentIndex].classList.remove('current');
      currentIndex = index;
      thumbnail[currentIndex].classList.add('current');
    });
    li.appendChild(img);
    document.querySelector('.thumbnail4').appendChild(li);
  });

  const next = document.getElementById('next4');
  next.addEventListener('click', () => {
    let target = currentIndex + 1;
    if (target === images.length) {
      target = 0;
    }
    document.querySelectorAll('.thumbnail4 > li')[target].click();
  });

  const prev = document.getElementById('prev4');
  prev.addEventListener('click', () => {
    let target = currentIndex - 1;
    if (target < 0) {
      target = images.length -1;
    }
    document.querySelectorAll('.thumbnail4 > li')[target].click();
  });
}